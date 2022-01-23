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

## dockerコンテナのデプロイ  
前提:  
・EC2構築済み  
・ECR構築済み

- プロジェクトディレクトリに移動し、以下のコマンドを実行 
```
#本番環境
docker-compose -f docker-compose-prod.yml up -d   

#検証環境
docker-compose -f docker-compose-prod.yml up -d   
```
※dockerコンテナ操作の際は-f <ファイル名.yml>を含むようにしてください。
※本番環境にて上記操作を行う際は事前に以下のコマンドでEC2からECRへログインしてください。

```
aws ecr get-login-password --region ap-northeast-1 | docker login --username AWS --password-stdin <作成したリポジトリURL>
```

## git hub上のソースコードを本番環境へ反映
前提：
・EC2構築済み  

- プロジェクトディレクトリに移動し、以下のコマンドを実行
```
git fetch <RemoteRepository>/<Branch>
git merge <RemoteRepository> <Branch>
```

## ライセンス

Copyright (c) Youble, Inc. All rights reserved.

Licensed under the [MIT](LICENSE.txt) license.
