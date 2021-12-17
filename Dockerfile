FROM ruby:2.7

# 必要なパッケージのインストール（Rails6からWebpackerがいるので、yarnをインストールする）
RUN curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | apt-key add - \
        && echo "deb https://dl.yarnpkg.com/debian/ stable main" | tee /etc/apt/sources.list.d/yarn.list \
        && apt-get update -qq \
        && apt-get install -y build-essential libpq-dev nodejs yarn

# rails用のディレクトリを作成
RUN mkdir /myapp
# 作業ディレクトリを指定
WORKDIR /myapp
# ローカルからコンテナの中にファイルをコピー
COPY Gemfile /myapp/Gemfile
COPY Gemfile.lock /myapp/Gemfile.lock
# Gemfileのbundle install
RUN bundle install
COPY . /myapp
# コンテナが起動するたびに実行されるスクリプトを追加
COPY entrypoint.sh /usr/bin/
RUN chmod +x /usr/bin/entrypoint.sh
ENTRYPOINT ["entrypoint.sh"]
EXPOSE 3000

CMD ["rails", "server", "-b", "0.0.0.0"]