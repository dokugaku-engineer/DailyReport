# APIドキュメント

## API一覧

| リソース | 機能                       | コントローラ/メソッド      | メソッド | URI                     |
| :------: | :------------------------: | :------------------------: | :------: | :---------------------: |
| ログイン | セッション作成             | sessions#create            | POST     | /login                  |
|          | セッション削除             | sessions#destroy           | DELETE   | /logout                 |
| 日報     | slackで投稿された日報の保存                   | slack_posts#create               | POST     | /slack_posts                  |
|          | slackで投稿された日報更新                   | slack_post#update                | PATCH    | /slack_posts                  |
|          | slackで投稿された日報削除                   | slack_post#destroy               | DELETE   | /slack_posts                  |
| 投稿先         | ユーザーによる日報の個別投稿先指定   | endpoints#create        | POST  | /endpoints        |
|          | ユーザーによる日報の個別投稿先指定解除   | endpoint#destroy         | DELETE   | /endpoint/:id         |
|          | 組織管理者による日報の組織別投稿先指定   | organizer/endpoints#create        | POST  | organizer/endpoints        |
|          | 組織管理者による日報の組織別投稿先指定解除   | organizer/endpoint#destroy         | DELETE   | organizer/endpoint/:id         |
| 組織     | 組織管理者による組織作成       | organizations#create | POST     | /organizations    |
|      | 組織管理者による組織更新       | organizations#update | PATCH     | /organizations    |
|          | 組織管理者による組織削除       | organization#destroy | DELETE   | /organization/:id |
|          | API管理者による組織削除       | admin/organization#destroy | DELETE   | /admin/organization/:id |
| ユーザー  | ユーザー新規登録 | users#create               | POST   | /users               |
|          | ユーザーによるユーザー削除 | user#destroy               | DELETE   | /user/:id               |
|          | ユーザーによるユーザー更新 | user#destroy               | DELETE   | /user/:id               |
|          | 組織管理者によるユーザー削除   | organizer/user#destroy         | DELETE   | /organizer/user/:id         |
|          | API管理者によるユーザー削除   | admin/user#destroy         | DELETE   | /admin/user/:id         |


## ログイン

### 機能概要
- SlackのOpenID Connectで認証し、セッションを構築する

### リクエスト
POST /login

### パラメータ（代表的なもの）
- access_token
- name

### 成功時レスポンス
{
"result": true,
"status": 200,
"message": "Success"
}

### 失敗時レスポンス
Bad Request
{
"result": false,
"status": 400,
"message": "Bad Request",
}

Unauthorized
{
"result": false,
"status": 401,
"message": "Unauthorized",
}

## ログアウト

### 機能概要
ログインし、セッションを破棄する

### リクエスト
DELETE /logout

### 成功時レスポンス
{
"result": true,
"status": 200,
"message": "Success"
}

### 失敗時レスポンス
Bad Request
{
"result": false,
"status": 400,
"message": "Bad Request",
}

Unauthorized
{
"result": false,
"status": 401,
"message": "Unauthorized",
}

## slackで投稿された日報の保存

### 機能概要
- slackで投稿された日報を、投稿したユーザーがユーザーデータベースに含まれているか検証してから、データベースやSpreadSheetなどに保存する

### リクエスト
POST /slack_posts

### パラメータ（代表的なもの）
【Slack】
- token（トークン）
- team_id（ワークスペースのID）
- authorizations（認可情報）
- type（Event APIメソッド）
- channel（チャンネル）
- user（ユーザー）
- text（投稿文）
- ts（タイムスタンプ）

### 成功時レスポンス
{
"result": true,
"status": 200,
"message": "Success"
}

### 失敗時レスポンス
Bad Request
{
"result": false,
"status": 400,
"message": "Bad Request",
}

Unauthorized
{
"result": false,
"status": 401,
"message": "Unauthorized",
}

## slackで投稿された日報の更新

### 機能概要
- slackで投稿された日報について、どのユーザーのどの投稿かを検証してからデータベースやSpreadSheetなどを更新する

### リクエスト
PATCH /slack_posts

### パラメータ（代表的なもの）
【Slack】
- token（トークン）
- team_id（ワークスペースのID）
- authorizations（認可情報）
- type（Event APIメソッド）
- subtype（同メソッドのサブタイプ）
- channel（チャンネル）
- user（ユーザー）
- text（投稿文）
- ts（タイムスタンプ）

### 成功時レスポンス
{
"result": true,
"status": 200,
"message": "Success"
}

### 失敗時レスポンス
Bad Request
{
"result": false,
"status": 400,
"message": "Bad Request",
}

Unauthorized
{
"result": false,
"status": 401,
"message": "Unauthorized",
}
## slackで投稿された日報の削除

### 機能概要
slackで投稿された日報を、どのユーザーのどの投稿かを検証してからデータベースやSpreadSheetなどから削除する

### リクエスト
DELTE /slack_posts

### パラメータ（代表的なもの）
【Slack】
- token（トークン）
- team_id（ワークスペースのID）
- authorizations（認可情報）
- type（Event APIメソッド）
- subtype（同メソッドのサブタイプ）
- channel（チャンネル）
- ts（タイムスタンプ）
- deleted_ts（削除時のタイムスタンプ）

### 成功時レスポンス
{
"result": true,
"status": 200,
"message": "Success"
}

### 失敗時レスポンス
Bad Request
{
"result": false,
"status": 400,
"message": "Bad Request",
}

Unauthorized
{
"result": false,
"status": 401,
"message": "Unauthorized",
}

Not Found
{
"result": false,
"status": 404,
"message": "Not Found",
}

## ユーザーによる日報の個別投稿先指定

### 機能概要
各ユーザー個別のスプレッドシートに日報の投稿先を指定する

### リクエスト
POST /endpoints

### パラメータ
- user（ユーザー名）
- spreadsheet_url（スプレッドシートURL）

### 成功時レスポンス
{
"result": true,
"status": 200,
"message": "Success"
}

### 失敗時レスポンス
Bad Request
{
"result": false,
"status": 400,
"message": "Bad Request",
}

Forbidden
{
"result": false,
"status": 401,
"message": "Forbidden",
}

## ユーザーによる日報の個別投稿先指定削除

### 機能概要
指定したスプレッドシートの投稿先を削除する

### リクエスト
Delete /endpoint/:id

### パラメータ
- user（ユーザー名）

### 成功時レスポンス
{
"result": true,
"status": 200,
"message": "Success"
}

### 失敗時レスポンス
Bad Request
{
"result": false,
"status": 400,
"message": "Bad Request",
}

Forbidden
{
"result": false,
"status": 401,
"message": "Forbidden",
}

Not Found
{
"result": false,
"status": 404,
"message": "Not Found",
}

## 組織管理者によるスプレッドシートへの日報の投稿先指定

### 機能概要
- 組織メンバーの日報の投稿先をスプレッドシート単位、シート単位で指定する

### リクエスト
POST admin/endpoints

### パラメータ
- user（ユーザー名）
- spreadsheet_url（スプレッドシートURL）
- sheet_numebr（シート番号）
- workspace（slackのワークスペース）

### 成功時レスポンス
{
"result": true,
"status": 200,
"message": "Success"
}

### 失敗時レスポンス
Bad Request
{
"result": false,
"status": 400,
"message": "Bad Request",
}

Forbidden
{
"result": false,
"status": 401,
"message": "Forbidden",
}

## 組織管理者による日報の投稿先指定削除

### 機能概要
指定したスプレッドシートの投稿先を削除する

### リクエスト
Delete admin/endpoint/:id

### パラメータ
- user（ユーザー名）

### 成功時レスポンス
{
"result": true,
"status": 200,
"message": "Success"
}

### 失敗時レスポンス
Bad Request
{
"result": false,
"status": 400,
"message": "Bad Request",
}

Forbidden
{
"result": false,
"status": 401,
"message": "Forbidden",
}

Not Found
{
"result": false,
"status": 404,
"message": "Not Found",
}

## 組織管理者による組織作成

### 機能概要
組織（会社など任意の団体）を作成する（組織管理者のみ可能）

### リクエスト
POST /organizations

### パラメータ
- organization

### 成功時レスポンス
{
"result": true,
"status": 200,
"message": "Success"
}

### 失敗時レスポンス
{
"result": false,
"status": 400,
"message": "Bad Request"
}

{
"result": false,
"status": 403,
"message": "Forbidden"
}

## 組織管理者による組織更新

### 機能概要
組織（会社など任意の団体）を更新する（組織管理者のみ可能）

### リクエスト
PATCH /organizations

### パラメータ
- organization

### 成功時レスポンス
{
"result": true,
"status": 200,
"message": "Success"
}

### 失敗時レスポンス
{
"result": false,
"status": 400,
"message": "Bad Request"
}

{
"result": false,
"status": 403,
"message": "Forbidden"
}

## 組織管理者による組織削除

### 機能概要
組織（会社など任意の団体）を削除する（組織管理者のみ可能）

### リクエスト
DELETE /organizations

### 成功時レスポンス
{
"result": true,
"status": 200,
"message": "Success"
}

### 失敗時レスポンス
Bad Request
{
"result": false,
"status": 400,
"message": "Bad Request"
}

Forbidden
{
"result": false,
"status": 403,
"message": "Forbidden"
}

Not Found
{
"result": false,
"status": 404,
"message": "Not Found",
}

## API管理者による組織削除

### 機能概要
API管理者が組織（会社など任意の団体）を削除する

### リクエスト
DELETE /admin/organizations

### 成功時レスポンス
{
"result": true,
"status": 200,
"message": "Success"
}

### 失敗時レスポンス
Bad Request
{
"result": false,
"status": 400,
"message": "Bad Request"
}

Forbidden
{
"result": false,
"status": 403,
"message": "Forbidden"
}

Not Found
{
"result": false,
"status": 404,
"message": "Not Found",
}

## ユーザー新規登録

### 機能概要
- パラメーターを手動で入力して登録する
- 組織管理者になる登録もこちらで行う

### リクエスト
POST /users

### パラメータ
- user（ユーザー名）
- email（メールアドレス）
- organizer

### 成功時レスポンス
{
"result": true,
"status": 200,
"message": "Success"
}

### 失敗時レスポンス
Bad Request
{
"result": false,
"status": 400,
"message": "Bad Request"
}

## ユーザー更新

### 機能概要
- ユーザーの設定を変更する

### リクエスト
POST /users

### パラメータ
- user（ユーザー名）
- email（メールアドレス）
- organizer

### 成功時レスポンス
{
"result": true,
"status": 200,
"message": "Success"
}

### 失敗時レスポンス
Bad Request
{
"result": false,
"status": 400,
"message": "Bad Request"
}

## ユーザー削除

### 機能概要
各ユーザーが自分自身のみ削除できる

### リクエスト
DELETE /user/:id

### 成功時レスポンス
{
"result": true,
"status": 200,
"message": "Success"
}

### 失敗時レスポンス
Bad Request
{
"result": false,
"status": 400,
"message": "Bad Request"
}

Forbidden
{
"result": false,
"status": 403,
"message": "Forbidden"
}

Not Found
{
"result": false,
"status": 404,
"message": "Not Found",
}


## 組織管理者によるユーザー削除

### 機能概要
組織内であればどのユーザーをも削除できる（組織管理者のみ可能）

### リクエスト
DELETE /admin/user/:id

### 成功時レスポンス
{
"result": true,
"status": 200,
"message": "Success"
}

### 失敗時レスポンス
Bad Request
{
"result": false,
"status": 400,
"message": "Bad Request"
}

Forbidden
{
"result": false,
"status": 403,
"message": "Forbidden"
}

Not Found
{
"result": false,
"status": 404,
"message": "Not Found",
}

## API管理者によるユーザー削除

### 機能概要
どのユーザーをも削除できる（API管理者のみ可能）

### リクエスト
DELETE /admin/user/:id

### 成功時レスポンス
{
"result": true,
"status": 200,
"message": "Success"
}

### 失敗時レスポンス
Bad Request
{
"result": false,
"status": 400,
"message": "Bad Request"
}

Forbidden
{
"result": false,
"status": 403,
"message": "Forbidden"
}

Not Found
{
"result": false,
"status": 404,
"message": "Not Found",
}
