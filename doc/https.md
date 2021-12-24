# HTTP化(ACMとALBの設定)

- SSL/TLS サーバー証明書を取得し、HTTPS化を行う

## 1.ACMの設定

- AWS の画面左上の「サービス」を開き、検索欄に「acm」と入力し、「Certificate Manager」を選択
- 「証明書をリクエスト」をクリック

![request.png](https://qiita-image-store.s3.ap-northeast-1.amazonaws.com/0/1863296/e1efbc1d-a654-a16c-bafc-ce12bb444618.png)

- 「パブリック証明書をリクエスト」を選択した状態で「次へ」をクリック

![public.png](https://qiita-image-store.s3.ap-northeast-1.amazonaws.com/0/1863296/3ec43a31-53f6-b70d-a386-b3ce065d570e.png)

- 「この証明書に別の名前を追加」をクリック
- 取得した「ドメイン名」と「*.ドメイン名」を入力

| タグ名 | 値 |
| ---- | ---- |
| Name | daily_report_acm |

![public_request.png](https://qiita-image-store.s3.ap-northeast-1.amazonaws.com/0/1863296/01ea81c9-0e28-6454-a66d-dbf025d456f8.png)

- 「DNS の検証」を選択した状態で「リクエスト」ボタンをクリック
- 「ステータス」が「発行済み」になるのを待つ

## 2.ACMにCNAMEレコードを追加

- 「Route53でレコードを作成」ボタンをクリック

| キー | 値 |
| ---- | ---- |
| レコード名 | コピーしたレコード名のドメイン名より前の部分 |
| レコードタイプ | CNAME |
| 値 | コピーしたレコードバリュー |

- 「作成」ボタンをクリック

## 3.ALB 用のセキュリティグループの作成

- 「VPC」から「セキュリティグループ」を選択し、「セキュリティグループの作成」をクリック

| キー | 値 |
| ---- | ---- |
| セキュリティグループ名 | daily_report_alb_security_group |
| 説明 | daily_report_alb_security_group |
| VPC | daily_report_vpc |

- 「インバウンドルール」の「ルールを追加」をクリック

| キー | 値 |
| ---- | ---- |
| タイプ | HTTP |
| 説明 | 任意の場所 |

| キー | 値 |
| ---- | ---- |
| タイプ | HTTPS |
| 説明 | 任意の場所 |

![sec-group.png](https://qiita-image-store.s3.ap-northeast-1.amazonaws.com/0/1863296/9d7e710a-f79f-b843-2a70-13f80d4cac37.png)

- アウトバウンドルールはECSのセキュリティグループへのみ通信を制御するようにデフォルトの設定を削除して以下の設定を追加

| キー | 値 |
| ---- | ---- |
| タイプ | HTTP |
| ソース | daily_report_ecs_security |

![aout.png](https://qiita-image-store.s3.ap-northeast-1.amazonaws.com/0/1863296/9ed4abb8-c1ed-dcff-598c-4877132a9fd0.png)

- 「セキュリティグループを作成」をクリック

## 4.ロードバランサーの設定

- メニューバーの「ロードバランサー」を選択

![load.png](https://qiita-image-store.s3.ap-northeast-1.amazonaws.com/0/1863296/3fe56022-ece7-3f4b-0ae5-52a2ed0f14a6.png)

- 「ロードバランサーの作成」をクリック

![http.png](https://qiita-image-store.s3.ap-northeast-1.amazonaws.com/0/1863296/64cd0db6-5b71-c2b2-0271-162499822cbe.png)

- 「HTTP, HTTPS」の方の「作成」をクリック
- ロードバランサーは以下のように設定

| キー | 値 |
| ---- | ---- |
| 名前 | daily-report-alb |
| リスナー | HTTP, HTTPS |
| アベイラビリティーゾーン | 「ap-northeast-1a」を選択し「dailry_report_public_1a_subnet」を選択 |
| アベイラビリティーゾーン | 「ap-northeast-1c」を選択し「dailry_report_public_1c_subnet」を選択 |

![load-setting.png](https://qiita-image-store.s3.ap-northeast-1.amazonaws.com/0/1863296/811ec811-1dea-e71b-03eb-5c89ba8b0685.png)

- 「次の手順:セキュリティ設定の構成」をクリック
- セキュリティ設定の構成は以下のように設定

| キー | 値 |
| ---- | ---- |
| 証明書タイプ | ACMから証明書を選択する |
| 証明書の名前 | 発行した証明書 |
| セキュリティポリシー | ELBSecurityPolicy-2016-08 |

![sec-setting_LI.jpg](https://qiita-image-store.s3.ap-northeast-1.amazonaws.com/0/1863296/9b7c1651-a90e-9bda-78ee-59d5222e66ab.jpeg)

- 「次の手順:セキュリティグループの設定」をクリック

![sec-alb.png](https://qiita-image-store.s3.ap-northeast-1.amazonaws.com/0/1863296/15b51fca-29a0-35f2-869b-1de7cfe1d6c3.png)

- 「daily_report_alb_security_group」を選択し，「次の手順: ルーティングの設定」をクリック

| キー | 値 |
| ---- | ---- |
| ターゲットグループ | 新しいターゲットグループ |
| 名前 | daily-report-target-group |
| ターゲットの種類 | IP |
| プロトコル | HTTP |
| ポート | 80 |
| プロトコルバージョン | HTTP1 |

![root-setting.png](https://qiita-image-store.s3.ap-northeast-1.amazonaws.com/0/1863296/f31249e1-527b-de55-07c6-bd987f293811.png)

- 「次の手順: ターゲットの登録」をクリック
- ターゲットは登録せずに確認をして作成

![load-conf_LI.jpg](https://qiita-image-store.s3.ap-northeast-1.amazonaws.com/0/1863296/bdac91fb-1914-eec0-3852-6451f7cd2212.jpeg)

## 5.ALBを含めたECSのサービスの作成

- 「ECS」の「クラスタ」から「daily-report-cluster」を選択
- 以前作成したdaily-report-serviceを削除して新しいサービスを作成。daily-report-serviceを削除した後、「サービス」の「作成」を選択

| キー | 値 |
| ---- | ---- |
| 起動タイプ | FARGATE |
| タスク定義 ファミリー | Linux |
| タスク定義 リビジョン | latest(値は変わる) |
| クラスター | daily-report-cluster |
| サービス名 | daily-report-alb-service |
| タスクの数 | 2 |

![service-setting.png](https://qiita-image-store.s3.ap-northeast-1.amazonaws.com/0/1863296/eb7089dd-16b2-8503-bd1a-753d502e1a02.png)

![setting.png](https://qiita-image-store.s3.ap-northeast-1.amazonaws.com/0/1863296/f641fb67-18f1-fe82-b96f-c0b12294356e.png)

- 「次のステップ」をクリック

- ネットワーク構成は以下のように設定

| キー | 値 |
| ---- | ---- |
| クラスターVPC | daily_report_vpc |
| サブネット | daily_report_public_1a_subnet |
| セキュリティグループ | daily_report_ecs_security |
| パブリック IP の自動割り当て | ENABLED |

![network-set.png](https://qiita-image-store.s3.ap-northeast-1.amazonaws.com/0/1863296/caa50c5d-3884-d593-489b-78ab054df473.png)

- ロードバランサーの設定も加える

| キー | 値 |
| ---- | ---- |
| ロードバランシング | Application Load Balancer |
| ロードバランサー名 | daily-report-alb |

![loadnginx.png](https://qiita-image-store.s3.ap-northeast-1.amazonaws.com/0/1863296/cb9749bd-b537-6ff1-dc61-27c2133cf00c.png)

- ロードバランス用コンテナにnginxが選択されているので「ロードバランサーに追加」をクリック

![nginx-set.png](https://qiita-image-store.s3.ap-northeast-1.amazonaws.com/0/1863296/37f11a31-d710-9064-cd81-bcdd13e7ccf2.png)

- ターゲットグループ名をdaily-report-target-groupとして「次のステップ」をクリック
- Auto Scalingの設定は今回はしないので「次のステップ」をクリック
- 確認をして、「サービス作成」をクリック

## 6.Route 53の設定を修正

- 「Route 53」を選択
- 「ホストゾーン」をクリック
- アプリで使用するドメインをクリック

![ddomain-host_LI.jpg](https://qiita-image-store.s3.ap-northeast-1.amazonaws.com/0/1863296/b9afdb72-63f8-9bd3-6ba6-fa2fc60dfc03.jpeg)

- 「タイプA」の「ドメイン名」のレコードをクリックし，右上に現れた「レコードを編集」をクリック

| キー | 値 |
| ---- | ---- |
| レコード名 | 空 |
| レコードタイプ | A |
| トラフィックのルーティング先 | エイリアスON→Application Loadbalancer→ap-northeast-1→daily-report-alb |

![load-A_LI.jpg](https://qiita-image-store.s3.ap-northeast-1.amazonaws.com/0/1863296/951d298c-1fff-4aa3-a1b5-ed483033a8fe.jpeg)

- 「保存」ボタンをクリック

## 7.ルーティングの整備

- http通信があると暗号化されない通信に間違ってアクセスしてしまう可能性があるので、http通信を遮断する
- ALBの「セキュリティグループ」のdaily_report_alb_security_group
にアクセスし、「インバウンドルールの編集」を選択

![in-delete.png](https://qiita-image-store.s3.ap-northeast-1.amazonaws.com/0/1863296/1c380709-8385-de24-5d45-ec84eef294bd.png)

- HTTPを削除
- 「ルールを保存」をクリック
