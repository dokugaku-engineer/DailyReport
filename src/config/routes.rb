Rails.application.routes.draw do
  mount_devise_token_auth_for "User", at: "users"
  post "/slack_posts", to: "slack_posts#create"
end
