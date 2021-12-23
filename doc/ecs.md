# ECSの設定

- こちらを設定することで、コンテナの実行、停止、管理を簡単に行うことができる

## 1.タスクの作成

- 「タスク定義」を選択し、「新しいタスク定義の作成」をクリック

| キー | 値 |
| ---- | ---- |
| 起動タイプ | FARGATE |
| タスク定義名 | daily_report_task |
| タスクロール | ecsTaskExecutionRole |
| ネットワークモード | awsvpc |
| オペレーティングシステムファミリー | Linux |

![task_ecs.png](https://qiita-image-store.s3.ap-northeast-1.amazonaws.com/0/1863296/c2d02c28-5f03-ce58-a051-389b200dbb30.png)

![task.png](https://qiita-image-store.s3.ap-northeast-1.amazonaws.com/0/1863296/015312ef-331a-f674-9afc-84a1cfffe6d5.png)

| キー | 値 |
| ---- | ---- |
| タスク実行ロール | ecsTaskExecutionRole |
| タスクメモリ | 0.5GB |
| タスクCPU | 0.25vCPU |

![task-iam.png](https://qiita-image-store.s3.ap-northeast-1.amazonaws.com/0/1863296/02e0c669-e7d5-2c2b-6ead-3bce6890f14a.png)

- 「コンテナの追加」をクリック

### Railsコンテナ

| キー | 値 |
| ---- | ---- |
| 名前 | rails |
| イメージ | ECRの作成の際メモしたrailsのリポジトリURI |
| ポートマッピング | 3000 |
| 環境変数 | docker-compose.ymlや.envに設定している環境変数 |
| ログ設定 | ON |

![rails-con.png](https://qiita-image-store.s3.ap-northeast-1.amazonaws.com/0/1863296/c2248527-f767-eaff-9d5a-fd235e9934e7.png)

![log.png](https://qiita-image-store.s3.ap-northeast-1.amazonaws.com/0/1863296/6d525f24-763c-99a3-9d1a-72ed9d7938f3.png)

- 「追加」をクリック

### Nginxコンテナ

- 「コンテナの追加」をクリック

| キー | 値 |
| ---- | ---- |
| 名前 | nginx |
| イメージ | ECRの作成の際メモしたnginxのリポジトリURI |
| ポートマッピング | 80 |
| ボリュームソース | rails |
| ログ設定 | ON |

![nginx-con.png](https://qiita-image-store.s3.ap-northeast-1.amazonaws.com/0/1863296/950a1735-82a6-f6a9-66de-084ddf1856f7.png)

![nginx-log.png](https://qiita-image-store.s3.ap-northeast-1.amazonaws.com/0/1863296/16c2919c-3841-fefe-066f-81f6f09ede8c.png)

- 「追加」をクリック

![tasks.png](https://qiita-image-store.s3.ap-northeast-1.amazonaws.com/0/1863296/d261fd6d-05d8-10d6-0511-92566edf257d.png)

- 「作成」をクリック
- ステータスが「ACTIVE」になっていることを確認する

![task-d.png](https://qiita-image-store.s3.ap-northeast-1.amazonaws.com/0/1863296/9f0b6d53-35b6-eae4-63d6-98b1c9f88ecd.png)

## 2.クラスターの作成

- 「クラスター」を選択し、「クラスターの作成」をクリック
- 「ネットワーキングのみ」を選択
- 「次のステップ」をクリック

| キー | 値 |
| ---- | ---- |
| クラスター名 | daily-report-cluster |
| VPCの作成 | チェックしない |
| タグ | Name: daily-report-cluster |
| CloudWatch Container Insights | チェックしない |

- 「作成」をクリック

## 3.サービスの作成

- クラスターが作成できたらサービスを選択し、「作成」をクリック

![service.jpg](https://qiita-image-store.s3.ap-northeast-1.amazonaws.com/0/1863296/bb5df58c-8cf9-2a74-2c03-6a2470d5b41b.jpeg)

| キー | 値 |
| ---- | ---- |
| 起動タイプ | FARGATE |
| タスク定義 ファミリー | daily_report_task |
| タスク定義 リビジョン | 1(latest) |
| クラスター | 	daily-report-cluster |
| サービス名 | daily-report-service |
| タスクの数 | 2 |

![service-setting.png](https://qiita-image-store.s3.ap-northeast-1.amazonaws.com/0/1863296/80752135-b8c0-f258-8b74-6d357a116a51.png)

- 他はデフォルト

![deploy.png](https://qiita-image-store.s3.ap-northeast-1.amazonaws.com/0/1863296/35c384e8-8f73-4ad3-28e0-c542b4e39ef7.png)

- 「次のステップ」をクリック

| キー | 値 |
| ---- | ---- |
| クラスター VPC | daily_report_vpc |
| サブネット | daily_report_public_1a_subnet |
| セキュリティグループ | daily_report_ecs_security |
| パブリック IP の自動割り当て | ENABLED |

![network.png](https://qiita-image-store.s3.ap-northeast-1.amazonaws.com/0/1863296/c34b1557-4b68-1830-ceb7-27eb049389d3.png)

- まだ(独自ドメインを取っていないため)ALBを設定していないので今回はロードバランサー無しで「次のステップ」をクリック

![load.png](https://qiita-image-store.s3.ap-northeast-1.amazonaws.com/0/1863296/4fe9cd9d-259c-53c9-5366-6749995ea2ce.png)

- 今回、Auto Scaling (オプション)は調整しない設定にする

![scalling.png](https://qiita-image-store.s3.ap-northeast-1.amazonaws.com/0/1863296/cd4ea0ac-edf6-c8c9-7ed1-e15885e1d456.png)

- 「次のステップ」をクリック
- 確認画面で、内容を確認したら「サービスの作成」をクリック

![confirm.png](https://qiita-image-store.s3.ap-northeast-1.amazonaws.com/0/1863296/a6cf6bba-12bd-02ad-fcee-f5d86b909175.png)
