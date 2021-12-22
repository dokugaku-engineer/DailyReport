# VPCの設定

- この設定を行うことで、AWSアカウント内に仮想ネットワークを構築することができる。
- VPC、サブネット、インターネットゲートウェイ、ルートテーブル、セキュリティグループの作成手順について記載。

## 1.VPCを作成

- 「VPCの作成」をクリック

| キー | 値 |
| ---- | ---- |
| 名前タグ | daily_report_vpc |
| CIDRブロック | 10.0.0.0/16 |

- 他はデフォルトのままで「VPCを作成」ボタンをクリック

![vpc.png](https://qiita-image-store.s3.ap-northeast-1.amazonaws.com/0/1863296/38eee301-7f48-eeb4-ddb5-c8b6fb1275ce.png)

## 2.サブネットを作成

### ECS用のサブネット

- 「サブネットの作成」ボタンをクリック

| キー | 値 |
| ---- | ---- |
| VPC | daily_report_vpc |

| キー | 値 |
| ---- | ---- |
| 名前 | daily_report_public_1a_subnet |
| アベイラビリティーゾーン | ap-northeast-1a |
| CIDRブロック | 10.0.0.0/24 |

- 「新しいサブネットを追加」ボタンをクリック

| キー | 値 |
| ---- | ---- |
| 名前 | daily_report_public_1c_subnet |
| アベイラビリティーゾーン | ap-northeast-1c |
| CIDRブロック | 10.0.1.0/24 |

### RDS用のサブネット

| キー | 値 |
| ---- | ---- |
| 名前 | daily_report_private_1a_subnet |
| アベイラビリティーゾーン | ap-northeast-1a |
| CIDRブロック | 10.0.10.0/24 |

- 「新しいサブネットを追加」ボタンをクリック

| キー | 値 |
| ---- | ---- |
| 名前 | daily_report_private_1c_subnet |
| アベイラビリティーゾーン | ap-northeast-1c |
| CIDRブロック | 10.0.11.0/24 |

- 「サブネットを作成」ボタンをクリック
- 下図の状態になっていることを確認

![subnet.png](https://qiita-image-store.s3.ap-northeast-1.amazonaws.com/0/1863296/1a21cc26-a770-dd12-b544-3bbef9c39971.png)

## 3.インターネットゲートウェイの作成

- 「インターネットゲートウェイ」を選択
- 「インターネットゲートウェイの作成」ボタンをクリック

| キー | 値 |
| ---- | ---- |
| 名前 | daily_report_gateway |

![gateway.png](https://qiita-image-store.s3.ap-northeast-1.amazonaws.com/0/1863296/78ebd499-3bd8-f583-34cb-b7151ff087b9.png)

- 他はデフォルトのままで「インターネットゲートウェイの作成」ボタンをクリック
- 「VPCへアタッチ」をクリック

| キー | 値 |
| ---- | ---- |
| 使用可能なVPC | daily_report_vpc |

![vpc-attach.png](https://qiita-image-store.s3.ap-northeast-1.amazonaws.com/0/1863296/0f7fb9aa-36c1-98bb-6276-7acc1cc15bfe.png)

- 「インターネットゲートウェイのアタッチ」ボタンをクリック

## 4.ルートテーブルの作成

- 「ルートテーブル」を選択
- 「ルートテーブルの作成」ボタンをクリック

| キー | 値 |
| ---- | ---- |
| 名前タグ | daily_report_table |
| VPC | daily_report_vpc |

![route_table.png](https://qiita-image-store.s3.ap-northeast-1.amazonaws.com/0/1863296/0f80a3af-711d-3c92-fdad-e313a7699fed.png)

- 「ルートテーブルを作成」ボタンをクリック
-  作成したルートテーブルを選択し，「アクション」ボタンをクリックし，「ルートを編集」を選択

![route_edit.jpg](https://qiita-image-store.s3.ap-northeast-1.amazonaws.com/0/1863296/2de545d5-5647-95cf-6f94-41ffdf4b4ccf.jpeg)

- 「ルートの追加」ボタンをクリック

| キー | 値 |
| ---- | ---- |
| 送信先 | 0.0.0.0/0 |
| ターゲット | 「インターネットゲートウェイ」を選択し，先ほど作成した「daily_report_gateway」を選択 |

![route_edit2.png](https://qiita-image-store.s3.ap-northeast-1.amazonaws.com/0/1863296/50ba388a-2dc1-2e2e-c9b5-8929410bc9e2.png)

- 「変更を保存」をクリック
-  （作成したルートテーブルを選択したまま）「アクション」ボタンをクリックし，「サブネットの関連付けの編集」を選択
- 「daily_report_public_1a_subnet」「daily_report_public_1c_subnet」のみを選択し，「関連付けを保存」ボタンをクリック

![subnet-connect.png](https://qiita-image-store.s3.ap-northeast-1.amazonaws.com/0/1863296/bdbf3e6b-387a-26f1-39d3-2dbe44d2cb9e.png)

## 5.セキュリティグループ の作成

### ECS用のセキュリティグループ

- 「セキュリティグループ」を選択

| キー | 値 |
| ---- | ---- |
| セキュリティグループ名 | daily_report_ecs_security |
| VPC | daily_report_vpc |

![security-group.png](https://qiita-image-store.s3.ap-northeast-1.amazonaws.com/0/1863296/18d0dfa2-34bd-6562-1210-833e523e980a.png)

- 「インバウンドルール」の「ルールを追加」をクリック

| キー | 値 |
| ---- | ---- |
| タイプ | HTTP |
| ソース | 任意の場所  |

![ecs-inbound.png](https://qiita-image-store.s3.ap-northeast-1.amazonaws.com/0/1863296/4e2f9a15-f852-0799-3886-d4ce7adb4a3b.png)

- アウトバウンドルールは変更なし
- 「セキュリティーグループを作成」ボタンをクリック

### RDS用のセキュリティグループ

- 「セキュリティグループ」を選択し，「セキュリティグループを作成」ボタンをクリック

| キー | 値 |
| ---- | ---- |
| セキュリティグループ名 | daily_report_rds_security |
| VPC | daily_report_vpc |

![rds-security-group.png](https://qiita-image-store.s3.ap-northeast-1.amazonaws.com/0/1863296/6bec979a-fb63-1759-678d-f9a057e7a269.png)

- 「インバウンドルール」の「ルールを追加」をクリック

| キー | 値 |
| ---- | ---- |
| タイプ | MySQL/Aurora |
| ソース | daily_report_ecs_security |

![rds-inbound.jpg](https://qiita-image-store.s3.ap-northeast-1.amazonaws.com/0/1863296/01b831ba-3f9e-d7df-a5c6-6baa822fe0ef.jpeg)

- アウトバウンドルールは変更なし
- 「セキュリティーグループを作成」ボタンをクリック
