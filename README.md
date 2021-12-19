# DailyReport

日報のAPIサービスです。投稿された日報を保管し、共有します。

## 現在対応中のサービス

* Slackに日報を投稿 → SpreadSheetに共有

## 貢献

1. フォークします
2. 各自の名前のブランチに対してプルリクします

## RailsAPIアプリの開発環境について

## Version

Ruby 3.0.3

Rails 6.1.4

MySQL8.0

## 構築手順
codeをcloneしたら、dbの接続情報を開発環境に合わせて「sample-development.envファイル」を参考に「write_your_password」を必要なパスワードに変更してください。
なお、「sample-development.env」のファイル名は「development.env」に変更し、プロジェクトファイル直下に置かないと動作しないので気をつけてください。

ex)development.env
```
MYSQL_ROOT_PASSWORD=write_your_password
```

サーバーを起動する場合は開発環境のディレクトリで以下のコマンドを入力します。

```
$ docker-compose build
```

```
$ docker-compose up -d
```

こちらを実行するとrailsサーバが起動します。

## ライセンス

Copyright (c) Youble, Inc. All rights reserved.

Licensed under the [MIT](LICENSE.txt) license.
