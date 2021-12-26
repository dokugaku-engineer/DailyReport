# CircleCIの設定

- こちらを設定することによりECSの自動デプロイが可能になる

## 1.CircleCIのファイルを作成する

- 以下のようにCircleCIのファイル(.circleciのファルダに中にconfig.ymlファイル)を作成
- 今回はcircleciの自動デプロイを任意ブランチ(今回はmain)に設定

```:.circleci/config.yml
version: 2.1
orbs:
  aws-ecr: circleci/aws-ecr@6.15
  aws-ecs: circleci/aws-ecs@2.0.0
workflows:
  nginx-deploy:
    jobs:
      - aws-ecr/build-and-push-image:
          account-url: AWS_ECR_ACCOUNT_URL
          region: AWS_REGION
          aws-access-key-id: AWS_ACCESS_KEY_ID
          aws-secret-access-key: AWS_SECRET_ACCESS_KEY
          create-repo: true
          path: 'nginx/'
          repo: daily_report_nginx
          tag: "${CIRCLE_SHA1}"
          filters:
            branches:
              only: main
      - aws-ecs/deploy-service-update:
          requires:
            - aws-ecr/build-and-push-image
          family: 'daily_report_task'
          cluster-name: 'daily-report-cluster'
          service-name: 'daily-report-alb-service'
          container-image-name-updates: "container=nginx,tag=${CIRCLE_SHA1}"
  rails-deploy:
    jobs:
      - aws-ecr/build-and-push-image:
          account-url: AWS_ECR_ACCOUNT_URL
          region: AWS_REGION
          aws-access-key-id: AWS_ACCESS_KEY_ID
          aws-secret-access-key: AWS_SECRET_ACCESS_KEY
          create-repo: true
          path: './'
          repo: daily_report_rails_api
          tag: "${CIRCLE_SHA1}"
          filters:
            branches:
              only: main
      - aws-ecs/deploy-service-update:
          requires:
            - aws-ecr/build-and-push-image
          family: 'daily_report_task'
          cluster-name: 'daily-report-cluster'
          service-name: 'daily-report-alb-service'
          container-image-name-updates: "container=rails,tag=${CIRCLE_SHA1}"
```

## 2.CircleCIに登録する

- 「CircleCI」で検索
- 「Githubでログイン」をクリック

![circle-login.png](https://qiita-image-store.s3.ap-northeast-1.amazonaws.com/0/1863296/abcb57fa-7f1b-60cd-ecad-69244c1b534f.png)

- パスワードの入力し、初期設定を行う
- 「DailyReport」の「Set Up Project」をクリック

## 3.CircleCIの環境変数を設定

- 「Project Settings」をクリック
- 「Environment Variables」をクリック
- 環境変数に以下を設定

![envir.png](https://qiita-image-store.s3.ap-northeast-1.amazonaws.com/0/1863296/64c94d9a-604c-80fb-1e70-aa6249f2abb1.png)

| キー | 値 |
| ---- | ---- |
| AWS_ACCESS_KEY_ID | IAMのアクセスキーID |
| AWS_DEFAULT_REGION | ap-northeast-1 |
| AWS_ECR_ACCOUNT_URL | {IAMのアカウントID(数字だけのやつ)}.dkr.ecr.{IAMのリージョン}.amazonaws.com |
| AWS_REGION | ECR・ECSを作成したリージョン(ap-northeast-1) |
| AWS_SECRET_ACCESS_KEY | IAMのシークレットアクセスキー |

![env1.png](https://qiita-image-store.s3.ap-northeast-1.amazonaws.com/0/1863296/ec62d94b-3797-cac8-5365-a9e4ad2641f7.png)

- 任意ブランチにマージされたあと、CircleCIのダッシュボードに行き自動デプロイがSuccessになっているのを確認

![circle-ok.png](https://qiita-image-store.s3.ap-northeast-1.amazonaws.com/0/1863296/40dd5d89-cfaf-e4dc-5d32-ccd8711a9529.png)

- ECRに新しいイメージが作成されていることを確認

![ecr-cir.jpg](https://qiita-image-store.s3.ap-northeast-1.amazonaws.com/0/1863296/d128716a-2ad7-4fff-e85e-a4c99fa6f5a3.jpeg)

- 新しいタスクが追加されていることを確認

![new-servi.png](https://qiita-image-store.s3.ap-northeast-1.amazonaws.com/0/1863296/183d059b-3278-57d5-236b-694254e28d58.png)
