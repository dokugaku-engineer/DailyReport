# DailyReport

日報のAPIサービスです。投稿された日報を保管し、共有します。

## 現在対応中のサービス

* Slackに日報を投稿 → SpreadSheetに共有

## 貢献

1. フォークします
2. 各自の名前のブランチに対してプルリクします

## ライセンス

Copyright (c) Youble, Inc. All rights reserved.

Licensed under the [MIT](LICENSE.txt) license.

## 手順書

VPC
・VPCを作成をクリック
・名前 ⇨ Nippo-Api
・IPv4 CIDRブロック ⇨ 10.0.0.0/16

パブリックサブネット
・サブネットの作成をクリック
・VPC ID ⇨ Nippo-API
・サブネット名 ⇨ Nippo-Api-Public
・アベイラビリティーゾーン ⇨ ap-northeast-1a
・IPv4 CIDRブロック ⇨ 10.0.0.0/24

インターネットゲートウェイ
・インターネットゲートウェイを作成をクリック
・名前タグ ⇨ Nippo-API-InternetGateway
・VPCにアタッチ ⇨ Nippo-API

ルートテーブル
・ルートテーブルを作成をクリック
・名前 ⇨ Nippo-API-RouteTable
・VPC ⇨ Nippo-API

・ルートを編集をクリック
・ルートを追加をクリック
・送信先 ⇨ 0.0.0.0/0
・ターゲット ⇨ インターネットゲートウェイ Nippo-API-InternetGateway
・変更を保存
・VPCとの関連付け

パブリックサブネット
・Nippo-Api-Publicを選んで、ルートテーブルの関連付けを編集をクリック
・ルートテーブルID ⇨ Nippo-API-RouteTable
・保存

・サブネットの編集をクリック
・IPv4 の⾃動割り当てにチェックを入れ、保存

セキュリティグループ
・セキュリティーグループを作成をクリック
・セキュリティーグループ名 ⇨ Nippo-API-security
・VPC ⇨ Nippo-API
・インバウンドルール ⇨ http、https、ssh
・ソース ⇨ Anywhere IPv4

—------------------------------------------------------------------------------------------------------------------------
ECR
・リポジトリを作成をクリック
・可視性設定 ⇨ パブリック
・リポジトリ名 ⇨ nippo-api/rails-ap


クラスター
・仮のタスク定義（console-sample-app)
・クラスターの作成
・EC2 Linux + Networking (EC2 Linux + ネットワーク)
・クラスター名 ⇨ Nippo-Api-ECS-EC2
・設定⇨インスタンスタイプ、インスタンス数、キーペア
・ネットワーキング⇨VPC、サブネット、セキュリティグループ
・コンテナインスタンス IAM ロール⇨新しいロールの作成

サービス
・作成したクラスターを選択
・サービスタブで作成を選択
・サービスの設定セクションで、
　　起動タイプでEC2をクリック
　　タスク定義で仮に作成したonsole-sample-appを選択
　　作成したクラスターを選択
　　サービス名を入力
　　タスクの数に１
・次のステップ
・サービスの作成

