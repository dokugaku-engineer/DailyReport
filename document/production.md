# Heroku：本番環境構築手順

## (sample)アプリ名 rails-dailyreport

### 1.herokuアカウントの作成
### 2.HerokuCLIの導入
https://devcenter.heroku.com/ja/articles/heroku-cli

### 3.herokuとheroku:containerにログイン

```bash
# herokuにログイン
$ heroku login
# Container Registryにログイン
$ heroku container:login
```
### 4.heroku上でアプリ作成
```bash
$ heroku create rails-dailyreport(任意のアプリ名)
```

### 5.MySQLの導入

heroku addonでheroku上にデータベースを作成する

mysql8.0はjawsDBMySQLを選択、下記コマンドを実行

```bash
$ heroku addons:create jawsdb:kitefin -a rails-dailyreport --version=8.0
```
ダッシュボード画面でattachされたか確認

https://dashboard.heroku.com/apps/アプリ名/resources

### 6.DB接続情報の設定
こちらからDBを選択すると、DBの接続情報が判明するので、herokuの環境変数に設定します\
https://dashboard.heroku.com/apps/アプリ名
```bash
# heroku上に環境変数を設定する
$ heroku config:add APP_DATABASE="database" -a rails-docker-dailyreport
$ heroku config:add APP_DATABASE_USERNAME="username" -a rails-docker-dailyreport
$ heroku config:add APP_DATABASE_PASSWORD="password" -a rails-docker-dailyreport
$ heroku config:add APP_DATABASE_HOST="host" -a rails-docker-dailyreport

# 設定状況の確認コマンド
$ heroku config -a rails-dailyreport
```
### 7.環境変数にmaster.keyの値を設定
railsアプリの/confg/master.keyの値を環境変数に設定
```bash
$ heroku config:add RAILS_MASTER_KEY="master.keyの値" -a rails-dailyreport
```
### 8.環境変数にRAILS_ENVの値を設定
以下のコマンドを実行して環境変数を設定します。
```bash
$ heroku config:add RAILS_ENV="production" -a rails-dailyreport
```
### 9.dockerイメージのherokuへのpushとrelease

```bash
# herokuへpush
$ heroku container:push web -a rails-dailyreport
# herokuへrelease
$ heroku container:release web -a rails-dailyreport
```

マイグレーションファイルの更新作業(動作確認のため)

```bash
$ heroku run bundle exec rails db:migrate -a rails-dailyreport
```
