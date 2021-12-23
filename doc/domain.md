# 独自ドメインの取得

- 独自ドメインを使ってアクセスできるようになる

## 1.ドメインの取得

- 「お名前.com」にアクセス
 - https://www.onamae.com/
-  検索窓に取得したいドメイン名を入力し、「検索」ボタンをクリック
-  ドメインを選択し，「料金確認へ進む」ボタンをクリック

![money-confirm.png](https://qiita-image-store.s3.ap-northeast-1.amazonaws.com/0/1863296/04c95ca1-8ed8-6d9a-200d-3308a3769bad.png)

-  サーバーは「利用しない」をチェック
- 「Whois情報公開代行メール転送オプション」などは全てチェック不要
- 「お申し込みを受け付けました。」と表示されたら「ドメインの設定はこちら」をクリック

## 2.IPアドレスとドメインの関連付け(Route 53)

- 「Route 53」を選択
- 「ホストゾーンの作成」ボタンをクリック

![host.png](https://qiita-image-store.s3.ap-northeast-1.amazonaws.com/0/1863296/3c6c52b8-99e4-2472-2770-14434c3734df.png)

| キー | 値 |
| ---- | ---- |
| ドメイン名 | 取得したドメインを記載 |
| 説明 - オプション | daily_report_domain |
| タイプ | パブリックホストゾーン |

![host-zone.png](https://qiita-image-store.s3.ap-northeast-1.amazonaws.com/0/1863296/4075f1b4-5357-779b-9831-6d84bdd19890.png)

- 「ホストゾーンの作成」ボタンをクリック

※タイプが「NS」の方の「値/トラフィックのルーティング先」に表示されている4つを ネームサーバー としてメモしておく

![roothost.jpg](https://qiita-image-store.s3.ap-northeast-1.amazonaws.com/0/1863296/06207db5-ec01-520f-abc3-7629ad895a25.jpeg)

## 3.ネームサーバーの設定

- 「お名前.com」に移動
- 「ドメイン一覧」の中から取得した「ドメイン名」を選択
- 「ネームサーバー情報」の項目の「ネームサーバーの変更」をクリック

![name-server.png](https://qiita-image-store.s3.ap-northeast-1.amazonaws.com/0/1863296/87842e4d-d528-f631-0549-7f0552d2c0a6.png)

- 「その他」タブをクリックし，「その他のネームサーバーを使う」の方にチェックを入れ，先ほどメモした4つのネームサーバーを入れる

![nameserver.jpg](https://qiita-image-store.s3.ap-northeast-1.amazonaws.com/0/1863296/bd400a42-4963-5766-e95d-d3ab8616446b.jpeg)

- 「確認」をクリック

## 4.ドメインの適用

- AWS の Route 53 の先ほどの続きの画面から，「レコードを作成」をクリック

| キー | 値 |
| ---- | ---- |
| レコード名 | ※入力しない |
| 値 | IP |
| タイプ | A |

![record.png](https://qiita-image-store.s3.ap-northeast-1.amazonaws.com/0/1863296/2a5ecbab-0f38-a3d1-2772-cada4ae9ab1a.png)

- 「レコードを作成」をクリック
