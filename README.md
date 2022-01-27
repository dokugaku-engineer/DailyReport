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

## Dockerコンテナのデプロイ  
前提:  
・EC2構築済み  
・ECR構築済み

### Dockerコンテナの環境変数を設定(.envファイル)  
- 開発環境、本番環境それぞれで、プロジェクトフォルダ直下に.envファイルを作成
- 各環境の.envファイルを以下のように記載  

**開発環境**  
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

**開発環境**  
```
WEB_IMAGE=[Repository/Image]
APP_IMAGE=[Repository/Image]
```  
|         項目          |  説明   | 
| :-------------------: | :---: |   
| WEB_IMAGE | ECRのリポジトリにプッシュしたイメージURI |   
| APP_IMAGE | ECRのリポジトリにプッシュしたイメージURI |

※AWSコンソール：AmazonECR＞リポジトリ＞「ECR構築」で作成したリポジトリ＞「URIのコピー」でコピーしたURIを指定  

### コンテナ起動
- プロジェクトディレクトリに移動し、以下のコマンドを実行 
```
#本番環境
docker-compose -f docker-compose-prod.yml up -d   

#開発環境
docker-compose -f docker-compose-dev.yml up -d   
```
※Dockerコンテナ操作の際は-f <ファイル名.yml>を含むようにしてください。
※本番環境にて上記操作を行う際は事前に以下のコマンドでEC2からECRへログインしてください。

```
aws ecr get-login-password --region ap-northeast-1 | docker login --username AWS --password-stdin <作成したリポジトリURL>
```

## GitHub上のソースコードを本番環境へ反映
前提：
・EC2構築済み  
・ECR構築済み

- プロジェクトディレクトリに移動し、以下のコマンドを実行
```
git fetch <RemoteRepository>/<Branch>
git merge <RemoteRepository> <Branch>
```  

## Laravel初期設定
前提：  
・EC2構築済み  
・ECR構築済み  

### Laravel環境設定ファイルの作成(.envファイル)  
- プロジェクトディレクトリ/src直下に.envファイルを作成  
※.env.sampleをコピーし、.envにリネーム
- 開発環境、本番環境それぞれで以下の値を設定

**開発環境**  
``` 
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=[Dockerコンテナの環境変数設定(.env)で指定した値]
DB_USERNAME=root
DB_PASSWORD=[Dockerコンテナの環境変数設定(.env)で指定した値]
```

**本番環境**  
```
DB_CONNECTION=mysql
DB_HOST=[RDS構築で作成したインスタンスのエンドポイント]※
DB_PORT=3306
DB_DATABASE=daily_report_01
DB_USERNAME=admin
DB_PASSWORD=[RDS構築で設定したパスワード]
```
※AWSコンソール：RDS>データベース>作成したインスタンス名>エンドポイント に記載

### アプリケーションキーの作成
前提：
・Laravelインストールディレクトリ移動  

- Laravelインストールディレクトリにて以下のコマンドを実行し、アプリケーションキーを.envに登録
```
php artisan key:generate  
```
※.envファイルの「APP_KEY」に記載されていることを確認  

### ライブラリのインストール
前提:  
・composerインストール済み
・Laravelインストールディレクトリ移動  

- Laravelインストールディレクトリにて以下のコマンドを実行し、vendorディレクトリ下にライブラリをインストール
```
composer install
```
※vendor下にライブラリがインストールされていることを確認

### マイグレーションの実行  
前提：
・Laravelインストールディレクトリ移動  

- 以下のコマンドを実行し、データベースにテーブルを作成
```
php artisan migrate
```

## ライセンス

Copyright (c) Youble, Inc. All rights reserved.

Licensed under the [MIT](LICENSE.txt) license.
