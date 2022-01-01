# DailyReport

日報のAPIサービスです。投稿された日報を保管し、共有します。

## 現在対応中のサービス

* Slackに日報を投稿 → SpreadSheetに共有

## 貢献

1. フォークします
2. 各自の名前のブランチに対してプルリクします

## RailsAPIアプリの開発環境

### -Version-

Ruby 3.0.3

Rails 6.1.4

MySQL8.0

## 開発環境の環境変数
dbの接続情報を開発環境に合わせて「sample-development.envファイル」を参考に「write_your_password」を独自のパスワードに変更してください。

「sample-development.env」のファイル名は「development.env」に変更し、プロジェクトファイル直下に置かないと動作しません。

ex)development.env
```
MYSQL_ROOT_PASSWORD=write_your_password
```

## 開発環境でのコマンド例

Dockerイメージの構築・再構築
```
$ docker-compose -f docker-compose.development.yml build
```
Railsコマンドの実行
```
$ docker-compose -f docker-compose.development.yml run web railsコマンド
```

サーバーの起動
```
$ docker-compose -f docker-compose.development.yml up -d
```

## 本番環境の構築手順

[構築手順](/document/production.md)\
**環境変数**
```
# pruduction MySQL DATABASE_PASSWORD

APP_DATABASE=write_database
APP_DATABASE_USERNAME=write_database_username
APP_DATABASE_PASSWORD=write_database_password
APP_DATABASE_HOST=write_database_host
APP_DATABASE_PORT=write_database_port
```

## ライセンス

Copyright (c) Youble, Inc. All rights reserved.

Licensed under the [MIT](LICENSE.txt) license.
