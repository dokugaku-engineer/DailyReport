# RDSの設定

- こちらを使用することにより、データベースを簡単にセットアップできる。
- 今回はMySQLの構築手順について記載する。

## 1.RDS用サブネットグループの作成

- 「サブネットグループ」を選択し、「DB サブネットグループを作成」ボタンをクリック

| キー | 値 |
| ---- | ---- |
| 名前 | daily_report_rds_subnet_group |
| VPC | daily_report_vpc |

![subnet-group.png](https://qiita-image-store.s3.ap-northeast-1.amazonaws.com/0/1863296/85502026-de11-7753-dac5-6f767654e889.png)

- サブネットを追加

| キー | 値 |
| ---- | ---- |
| アベイラビリティーゾーン | ap-northeast-1a, ap-northeast-1c |
| VPC | 10.0.10.0/24, 10.0.11.0/24 の2つを選択 |

![subnet-add.png](https://qiita-image-store.s3.ap-northeast-1.amazonaws.com/0/1863296/329be5ee-e44d-d91c-589b-6f528f067a84.png)

- 「作成」をクリック

## 2.DBインスタンスの作成

- 「データベース」を選択し、「データベースを作成」ボタンをクリック
- 「標準作成」を選択

| キー | 値 |
| ---- | ---- |
| エンジンのタイプ | MySQL |
| バージョン | MySQL 8.0.23 |

- 「無料利用枠」を選択

| キー | 値 |
| ---- | ---- |
| DB インスタンス識別子 | daily-report-db |
| マスターユーザー名 | root |
| マスターパスワード | 任意 |
| DBインスタンスサイズ | db.t2.micro(無料枠) |

![rds-settimg.png](https://qiita-image-store.s3.ap-northeast-1.amazonaws.com/0/1863296/7b79567a-884a-44d7-8c49-148872136267.png)

| キー | 値 |
| ---- | ---- |
| DB インスタンスサイズ | db.t2.micro(デフォルト) |

| キー | 値 |
| ---- | ---- |
| ストレージタイプ | 汎用(SSD) |
| ストレージ割り当て | 20 |
| ストレージの自動スケーリング | 有効 |
| 最大ストレージしきい値 | 1000 |

![rds-setteing2.png](https://qiita-image-store.s3.ap-northeast-1.amazonaws.com/0/1863296/d4a9f3d4-3a94-cde3-f24f-cee0d599ade3.png)

| キー | 値 |
| ---- | ---- |
| VPC | daily_report_vpc |
| サブネットグループ | daily_report_rds_subnet_group |
| パブリックアクセス可能 | なし |
| VPCセキュリティグループ | 既存の選択 |
| 既存のVPCセキュリティグループ	 | 有効 |
| アベイラビリティゾーン | ap-northeast-1a |

![rds-setting3.png](https://qiita-image-store.s3.ap-northeast-1.amazonaws.com/0/1863296/00f4c610-e233-d1e7-370d-d295c49e81cb.png)

- データベース認証以降はデフォルト設定
- 「データベースの作成」ボタンをクリック
