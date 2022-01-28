# アプリケーション実行環境構築手順  

## 【概要】  

EC2にインストールしたDockerコンテナ上で稼働するアプリケーションの環境を構築する

## 【目的】  

アプリケーション実行環境を構築するため

## 【手順】  

### 前提：EC2、ECR構築済み  

### 1.Dockerコンテナの環境変数を設定(.envファイル)  
- プロジェクトフォルダ直下に.envファイルを作成
- .envファイルを以下のように記載  
```
WEB_IMAGE=[Repository/Image]
APP_IMAGE=[Repository/Image]
```  
|         項目          |  説明   | 
| :-------------------: | :---: |   
| WEB_IMAGE | ECRのリポジトリにプッシュしたイメージURI |   
| APP_IMAGE | ECRのリポジトリにプッシュしたイメージURI |

※AWSコンソール：AmazonECR＞リポジトリ＞「ECR構築」で作成したリポジトリ＞「URIのコピー」でコピーしたURIを指定  

### 2.コンテナ起動  
- プロジェクトディレクトリに移動し、以下のコマンドを実行 
```  
docker-compose -f docker-compose-prod.yml up -d    
```  
※Dockerコンテナ操作の際は-f <ファイル名.yml>を含むようにしてください。  
※上記操作を行う際は事前に以下のコマンドでEC2からECRへログインしてください。  
```
aws ecr get-login-password --region ap-northeast-1 | docker login --username AWS --password-stdin <作成したリポジトリURL>
```  

### 3.Laravel初期設定  
- プロジェクトディレクトリ/src直下に.envファイルを作成  
※.env.sampleをコピーし、.envにリネーム  

- 以下の値を設定
```
DB_CONNECTION=mysql
DB_HOST=[RDS構築で作成したインスタンスのエンドポイント]※
DB_PORT=3306
DB_DATABASE=daily_report_01
DB_USERNAME=admin
DB_PASSWORD=[RDS構築で設定したパスワード]
```
※AWSコンソール：RDS>データベース>作成したインスタンス名>エンドポイント に記載

### 4.アプリケーションキーの作成
- Laravelインストールディレクトリにて以下のコマンドを実行し、アプリケーションキーを.envに登録
```
php artisan key:generate  
```
※.envファイルの「APP_KEY」に記載されていることを確認  

### 5.ライブラリのインストール
- 以下のコマンドを実行し、vendorディレクトリ下にライブラリをインストール  
```  
composer install  
```  
※vendor下にライブラリがインストールされていることを確認  

### 6.マイグレーションの実行  
- 以下のコマンドを実行し、データベースにテーブルを作成  
```  
php artisan migrate  
```  
