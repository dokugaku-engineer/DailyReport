# DailyReport

日報のAPIサービスです。投稿された日報を保管し、共有します。

## 現在対応中のサービス

* Slackに日報を投稿 → SpreadSheetに共有

## 貢献

1. フォークします
2. 各自の名前のブランチに対してプルリクします  

## インフラ構築手順書  
- [VPC構築](/doc/setup-of-VPC.md)
- [独自ドメイン登録](/doc/setup-of-Route53.md)
- [TLS証明書作成](/doc/setup-of-ACM.md)
- [ロードバランサー構築](/doc/setup-of-ALB.md)
- [RDS構築](/doc/setup-of-RDS.md)  
- [ECR構築](/doc/setup-of-ECR.md)
- [EC2構築](/doc/setup-of-EC2.md)  
- [アプリケーション実行環境構築](/doc/setup-of-APP.md)  

## Slack各IDの確認  
### ユーザーID  
- ワークスペースを開き、ユーザーアイコンを押下  
- 「その他」> 「メンバーIDをコピー」記載のID（U~）

### チャンネルID
- チャンネルを開く
- 画面上部のチャンネル名タブを押下
- 「チャンネルID」記載のCから始まる文字列がチャンネルID（C~）

### チームID  
- ワークスペース名タブを押下 > 「設定と管理」 > 「ワークスペースの設定」でweb画面に遷移
- 左タブ「Slackに戻る」を押下
- URLの「T」から始まるパスパラメータがチームID

## Spreadsheet各IDの確認
### SpreadsheetID
- スプレッドシートを開く
- URLのd/～/edit#gid間の文字列がSpreadsheetID

### SheetID
- スプレッドシートを開く
- URLの「git=」以降がSheetID

![InkedWS000001_LI](https://user-images.githubusercontent.com/89679815/152363562-d620b494-4d85-484b-b099-87a725d35cd4.jpg)

## 開発環境初期設定
### Dockerコンテナの環境変数を設定(.envファイル)  
- プロジェクトフォルダ直下に.envファイルを作成
- .envファイルを以下のように記載  
```
##'webコンテナ用環境変数'##
#WEB_HOST_PORT=[OPTION]

##'db'コンテナ用環境変数##
#DB_HOST_PORT=[OPTION]
DB_ROOT_PASSWORD=[MUST]
DB_NAME=[MUST]
DB_USER=[MUST]
DB_PASSWORD=[MUST]
TIME_ZONE='Asia/Tokyo'
```  
※値が指定されていないものは以下を参考に入力
|         項目          |  説明   | 備考 |
| :-------------------: | :---: | :---: |  
| WEB_HOST_PORT | webサーバのローカル側ポート指定 | 任意、空欄可 |
| DB_HOST_PORT | DBサーバのローカル側ポート指定 | 任意、空欄可 |
| DB_ROOT_PASSWORD | rootユーザーでmysqlログイン時のパスワード | 任意、必須  |
| DB_NAME | データベース名を指定 | 任意、必須 |
| DB_USER | mysql一般ユーザーを指定 | 任意、必須 |
| DB_PASSWORD | mysql一般ユーザーのパスワードを指定 | 任意、必須 |
| TIME_ZONE | タイムゾーンを指定 | 必須 |

### コンテナ起動
- プロジェクトディレクトリに移動し、以下のコマンドを実行 
```
docker-compose -f docker-compose-dev.yml up -d   
```
※Dockerコンテナ操作の際は-f <ファイル名.yml>を含むようにしてください。

### Laravel環境設定ファイルの作成(.envファイル)  
- プロジェクトディレクトリ/src直下に.envファイルを作成  
※.env.sampleをコピーし、.envにリネーム
- 以下の値を設定
``` 
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=[Dockerコンテナの環境変数設定(.env)で指定した値]
DB_USERNAME=root
DB_PASSWORD=[Dockerコンテナの環境変数設定(.env)で指定した値]
```  

### アプリケーションキーの作成
- Laravelインストールディレクトリにて以下のコマンドを実行し、アプリケーションキーを.envに登録
```
php artisan key:generate  
```
※.envファイルの「APP_KEY」に記載されていることを確認  

### ライブラリのインストール
- Laravelインストールディレクトリにて以下のコマンドを実行し、vendorディレクトリ下にライブラリをインストール
```
composer install
```
※vendor下にライブラリがインストールされていることを確認

### マイグレーションの実行  
- 以下のコマンドを実行し、データベースにテーブルを作成
```
php artisan migrate
```

## ライセンス

Copyright (c) Youble, Inc. All rights reserved.

Licensed under the [MIT](LICENSE.txt) license.
