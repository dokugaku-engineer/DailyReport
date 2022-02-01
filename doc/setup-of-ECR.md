# ECR構築手順

## 【概要】  

日報APIシステムで利用するdockerイメージのリポジトリを作成する。

## 【目的】  

デプロイ環境を整備し、効率的に開発・運用を行うため。

## 【手順】  

### 1.リポジトリ作成

- 検索タブで「ECR」と入力し、画面遷移

- 「リポジトリの作成」を押下
- 以下の値を入力し、「リポジトリの作成」を押下  
  ※下記テーブル分だけ作業を実施
  
【webコンテナ用リポジトリ】
|項目|値|
|:--:|:--:|
|可視性設定|プライベート|    
|リポジトリ名|daily_report_web|
※上記以外はデフォルトのまま

【appコンテナ用リポジトリ】
|項目|値|
|:--:|:--:|
|可視性設定|プライベート|    
|リポジトリ名|daily_report_app|
※上記以外はデフォルトのまま

![WS000000](https://user-images.githubusercontent.com/89679815/148026143-a2ade8f0-9039-429e-9dbb-76e67cd76411.JPG)  

### 2.イメージのプッシュ

次の設定がされていることを前提に作業を行う  

1. AWS IAMにて「AdministratorAccess」ポリシーを有したユーザーを作成していること  
2. 作業利用のIAMユーザーの、アクセスキーを作成していること  
3. AWS CLIをローカル端末にインストールおよび、コンフィグ設定をしていること  
[参考1:AWS CLI での Amazon ECR の使用](https://docs.aws.amazon.com/ja_jp/AmazonECR/latest/userguide/getting-started-cli.html)  
[参考2:AWSCLIの設定](https://docs.aws.amazon.com/ja_jp/cli/latest/userguide/cli-configure-quickstart.html)  

- 作成したリポジトリ毎に入力する値は以下の通り  
【webコンテナ用リポジトリ】
|項目|値|  
|:--:|:--:|  
|イメージ名|daily_report_web|
  
【appコンテナ用リポジトリ】
|項目|値|  
|:--:|:--:|  
|イメージ名|daily_report_app|

- 以下のコマンドを実行し、前提条件を満たしたユーザーでECRへログイン  
```
aws ecr get-login-password --region ap-northeast-1 | docker login --username AWS --password-stdin <作成したリポジトリURL>
```

- 以下のコマンドを実行し、Dockerイメージを構築  
```  
docker build -t <イメージ名> .
```

- 以下のコマンドを実行し、作成したリポジトリにプッシュするためのタグ付けを実施  
```
docker tag <イメージ名>:latest <作成したリポジトリURL>/<イメージ名>:latest
```

- 以下のコマンドを実行し、作成したリポジトリにイメージをプッシュ  
```
docker push <作成したリポジトリURL>/<イメージ名>:latest
```

- イメージがリポジトリにプッシュされていることを確認
