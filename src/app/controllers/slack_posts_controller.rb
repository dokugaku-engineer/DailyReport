class SlackPostsController < ApplicationController
  before_action :require_user_is_registered, :require_post_is_daily_report, :verify_signature, only: %i[create]

  def create
    post = registered_user.slack_posts.build(post_params)
    if post.save
      render status: 201, json: {
        "result": true,
        "status": 201,
        "message": "Created",
        "data": {
          "text": "#{post.text}",
          "username": "#{registered_user.name}", 
          "created_at": "#{post.created_at}"
        }
      }
    else
      render status: 400, json: {
        "result": false,
        "status": 400,
        "message": "Bad Request"
      }
    end
  end

  private

  def post_params
    params.require(:event).permit(:text)
  end

  def fetch_username_from_slack
    user_id = params["event"]["user"]
    parameters = URI.encode_www_form({ user: user_id })

    uri = URI.parse("#{ENV["BASE_URL"]}/users.info?#{parameters}")

    request = Net::HTTP::Get.new(uri)
    request[:Authorization] = "Bearer #{ENV["USER_TOKEN"]}"

    response = Net::HTTP.start(uri.host, uri.port, use_ssl: true) do |http|
      http.request(request)
    end

    unless response.nil?
      result = JSON.parse(response.body)
      result["user"]["real_name"]
    end
  end

  def registered_user
    username = fetch_username_from_slack
    User.find_by(name: username)
  end

  def registered_user?
    !!registered_user
  end

  def require_user_is_registered
    unless registered_user?
      render status: 401, json: {
        "result": false,
        "status": 401,
        "message": "Unauthorized"
      }
    end
  end

  def daily_report?
    params["event"]["text"].match?("日報")
  end

  def require_post_is_daily_report
    unless daily_report?
      render status: 401, json: {
        "result": false,
        "status": 401,
        "message": "Unauthorized"
      }
    end
  end

  def verify_signature
    # リクエスト署名の比較対象となるハッシュを作成するための基本文字列を作成する
    request_body = request.body.read
    timestamp = request.headers["X-Slack-Request-Timestamp"]
    basestring = "v0:#{timestamp}:#{request_body}"

    # 反射攻撃（replay attack）を防止する
    five_minutes = 60 * 5
    return if (Time.now.to_i - timestamp.to_i) > five_minutes

    # Slackの共有シークレットをキーとして基本文字列からハッシュを作成し、リクエスト署名と比較する
    digest = OpenSSL::HMAC.hexdigest("SHA256", ENV["SLACK_SIGNING_SECRET"], basestring)
    my_signature = "v0=#{digest}"
    return if my_signature == request.headers["X-Slack-Signature"]

    render status: 403, json: {
      "result": false,
      "status": 403,
      "message": "Forbidden"
    }
  end
end
