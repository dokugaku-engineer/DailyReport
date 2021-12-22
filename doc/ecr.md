# ECRの設定

- この設定をすることで、AWS上でDockerイメージを保存ができるようになる
- また、ECRにDockerイメージを保存すると容易にAWS上にデプロイができる

※事前にAWS CLI をインストールしておく。また、「AdministratorAccess」の権限をもつIAM ユーザーを作成しておく

## 1.ECRのリポジトリの作成

- 「リポジトリの作成」をクリック

### Rails用のリポジトリ

| キー | 値 |
| ---- | ---- |
| 可視設定 | プライベート |
| リポジトリ名 | daily_report_rails_api |

![rails_ecr.png](https://qiita-image-store.s3.ap-northeast-1.amazonaws.com/0/1863296/b6f57da5-ea23-2390-b071-f72328931c6a.png)

- 他はデフォルト
- 「リポジトリを作成」をクリック

### Nginx用のリポジトリ

| キー | 値 |
| ---- | ---- |
| 可視設定 | プライベート |
| リポジトリ名 | daily_report_nginx |

![nginx-ecr.png](https://qiita-image-store.s3.ap-northeast-1.amazonaws.com/0/1863296/35e13f76-8f4f-9f3d-baf8-db13aaa479a1.png)

- 他はデフォルト
- 「リポジトリを作成」をクリック

## 2.ECRへのプッシュコマンドを表示

- 「daily_report_rails_api」を選択
- 「プッシュコマンドの表示」をクリック

![ecr-rails-push1.jpg](https://qiita-image-store.s3.ap-northeast-1.amazonaws.com/0/1863296/442471e4-f8fe-5fce-822c-660756a70eed.jpeg)

## 3.ECRへのプッシュ

- 表示されたコマンドをDockerfileのそれぞれのディレクトリで実施する

![3fc1ee0b9e48543401b23c6fdde2e137.png](https://qiita-image-store.s3.ap-northeast-1.amazonaws.com/0/1863296/05c8c8e5-fb3f-e5df-395f-8134f06a5a56.png)

- リポジトリへプッシュできたことが確認できたら、URIをそれぞれコピーして控えておく(ECSのタスク定義で使用)

![ecr-rails.png](https://qiita-image-store.s3.ap-northeast-1.amazonaws.com/0/1863296/3636c0b5-c1ea-5fd3-6f74-5e4c916591d1.png)

- 「daily_report_nginx」も同様に行う
