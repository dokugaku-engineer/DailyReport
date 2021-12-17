# DailyReport

日報のAPIサービスです。投稿された日報を保管し、共有します。

## 現在対応中のサービス

* Slackに日報を投稿 → SpreadSheetに共有

## 貢献

1. フォークします
2. 各自の名前のブランチに対してプルリクします

## RailsAPIアプリの開発環境構築手順

## Version

Ruby 3.0.3

Rails 6.1.4

## 構築手順

codeをcloneしたら、開発環境のディレクトリで以下のコマンドを入力します。
```
$ docker image build -t 任意名:latest .
```

```
$ docker container run -p 3000:3000 -v ${PWD}/src:/app [docker-image名]
```
これで、ローカルのディレクトリとコンテナ内のディレクトリがリアルタイムで同期するので、ローカル環境で開発した内容がDockerfileに反映されます。

## ライセンス

Copyright (c) Youble, Inc. All rights reserved.

Licensed under the [MIT](LICENSE.txt) license.
