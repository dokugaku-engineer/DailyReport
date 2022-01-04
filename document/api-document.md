# APIドキュメント

## API一覧

| リソース  | 機能                                | コントローラ/メソッド                     |   メソッド        |      URI                                      |
| :------: | :--------------------------------: | :------------------------------------: | :------------: | :---------------------------------------------:|
| ログイン   | セッション作成                       | devise_token_auth/sessions#create      | POST           | /v1.0.0/auth/sign_in                           |
|          | セッション削除                       | devise_token_auth/sessions#destroy      | DELETE         | /v1.0.0/auth/sign_out                          |
| 日報      | slackで投稿された日報の保存           | slack_posts#create                      | POST           | /v1.0.0/slack_posts                            |
|          | slackで投稿された日報更新             | slack_posts#update                      | PATCH          | /v1.0.0/slack_posts                            |
|          | slackで投稿された日報削除             | slack_posts#destroy                     | DELETE         | /v1.0.0/slack_posts                            |
| 投稿先    | ユーザーによる日報の個別投稿先作成      | slack_to_spreadsheets#create             | POST           | /v1.0.0/slack_to_spreadsheets                 |
|          | ユーザーによる日報の個別投稿先更新      | slack_to_spreadsheets#update            | PATCH           | /v1.0.0/slack_to_spreadsheets/:id              |
|          | ユーザーによる日報の個別投稿先削除      | slack_to_spreadsheets#destroy            | DELETE        | /v1.0.0/slack_to_spreadsheets/:id               |
|          | 組織管理者による日報の組織別投稿先作成   | org_admin/slack_to_spreadsheets#create   | POST          | /v1.0.0/org_admin/org_id/slack_to_spreadsheets |
|          | 組織管理者による日報の組織別投稿先更新   | org_admin/slack_to_spreadsheets#update   | PATCH         | /v1.0.0/org_admin/slack_to_spreadsheets/org_id |
|          | 組織管理者による日報の組織別投稿先削除   | org_admin/slack_to_spreadsheets#destroy  | DELETE        | /v1.0.0/org_admin/slack_to_spreadsheets/org_id |
| 組織      | 組織作成                            | organizations#create                     | POST          | /v1.0.0/organizations                          |
|          | 組織更新                            | organizations#update                     | PATCH        | /v1.0.0/organizations/org_id                          |
|          | 組織削除                            | organizations#destroy                    | DELETE        | /v1.0.0/organizations/org_id                   |
| ユーザー  | ユーザー新規登録                      | devise_token_auth/registrations#create   | POST          | /v1.0.0/auth                                   |
|          | ユーザー更新                         | devise_token_auth/registrations#update   | PATCH         | /v1.0.0/auth                                   |
|          | ユーザー削除                         | devise_token_auth/registrations#destroy  | DELETE        | /v1.0.0/auth                                   |

## ログイン

### 機能概要
- devise_token_authで認証し、セッションを構築する

### リクエスト
POST /v1.0.0/auth/sign_in

### パラメータ（代表的なもの）
- email
- password

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
DELETE /v1.0.0/auth/sign_out

### 成功時レスポンス
{
"result": true,
"status": 204,
"message": "No Content"
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
- どの組織から、またはどのチャンネルから投稿されたのものか判定するためにパラメータにteam_id、channelの値を使用して判定する
### リクエスト
POST /slack_posts

### パラメータ（代表的なもの）
【Slack】
- token
- team_id
- authorizations
- type
- channel
- user
- text
- ts

### 成功時レスポンス
{
"result": true,
"status": 201,
"message": "Created"
"body": "something posted is displayed here"
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
- どの組織から、またはどのチャンネルから投稿されたのものか判定するためにパラメータにteam_id、channelの値を使用して判定する

### リクエスト
PATCH /slack_posts

### パラメータ（代表的なもの）
【Slack】
- token
- team_id
- authorizations
- type
- subtype
- channel
- user
- text
- ts

### 成功時レスポンス
{
"result": true,
"status": 200,
"message": "Success"
"body": "revised post is displayed here"
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
- slackで投稿された日報を、どのユーザーのどの投稿かを検証してからデータベースやSpreadSheetなどから削除する
- どの組織から、またはどのチャンネルから投稿されたのものか判定するためにパラメータにteam_id、slack_channelの値を使用して判定する
### リクエスト
DELTE /slack_posts

### パラメータ（代表的なもの）
【Slack】
- token
- team_id
- authorizations
- type
- subtype
- slack_channel
- ts
- deleted_ts

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
POST /v1.0.0/slack_to_spreadsheets

### パラメータ
- user
- spreadsheet_url
- sheet_number
- slack_workspace
- slack_channel

### 成功時レスポンス
{
"result": true,
"status": 201,
"message": "Created"
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

## ユーザーによる日報の個別投稿先更新

### 機能概要
指定したスプレッドシートの投稿先を更新する

### リクエスト
PATCH /v1.0.0/slack_to_spreadsheets/:id

### パラメータ
- user
- spreadsheet_url
- sheet_number
- slack_workspace
- slack_channel


### 成功時レスポンス
{
"result": true,
"status": 204,
"message": "No Content"
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

## ユーザーによる日報の個別投稿先指定削除

### 機能概要
指定したスプレッドシートの投稿先を削除する

### リクエスト
DELETE /v1.0.0/slack_to_spreadsheets/:id

### パラメータ
- user
- spreadsheet_url
- slack_workspace
- slack_channel

### 成功時レスポンス
{
"result": true,
"status": 204,
"message": "No Content"
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

## 組織管理者によるスプレッドシートへの日報の投稿先作成

### 機能概要
組織メンバーの日報の投稿先をスプレッドシート単位、シート単位で指定する

### リクエスト
POST /v1.0.0/org_admin/slack_to_spreadsheets

### パラメータ
- name
- spreadsheet_url
- sheet_number
- org_id
- slack_workspace
- slack_channel

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

## 組織管理者によるスプレッドシートへの日報の投稿先更新

### 機能概要
- 組織メンバーの日報の投稿先をスプレッドシート単位、シート単位で更新する
- グループ単位のスプレッドシートの更新はslack_channelをパラメータに指定する
### リクエスト
PATCH /v1.0.0/org_admin/slack_to_spreadsheets/org_id

### パラメータ
- name
- spreadsheet_url
- sheet_number
- org_id
- slack_channel
- slack_workspace

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
- 指定したスプレッドシートの投稿先を削除する
- グループ単位のスプレッドシートの削除はslack_channelをパラメータに指定する

### リクエスト
DELETE /v1.0.0/org_admin/slack_to_spreadsheets/org_id

### パラメータ
- name
- spreadsheet_url
- sheet_number
- org_id
- slack_channel
- slack_workspace

### 成功時レスポンス
{
"result": true,
"status": 204,
"message": "No Content"
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
POST /v1.0.0/organizations

### パラメータ
- name

### 成功時レスポンス
```
{
"result": true,
"status": 201,
"message": "Created"
}
```

### 失敗時レスポンス
Bad Request

```
{
"result": false,
"status": 400,
"message": "Bad Request"
}
```

Forbidden
```
{
"result": false,
"status": 403,
"message": "Forbidden"
}
```

## 組織管理者による組織更新

### 機能概要
組織（会社など任意の団体）を更新する（組織管理者のみ可能）

### リクエスト
PATCH /v1.0.0/organizations

### パラメータ
- name

### 成功時レスポンス
```
{
"result": true,
"status": 200,
"message": "Success"
}
```

### 失敗時レスポンス
Bad Request

```
{
"result": false,
"status": 400,
"message": "Bad Request"
}
```

Forbidden
```
{
"result": false,
"status": 403,
"message": "Forbidden"
}
```

## 組織管理者による組織削除

### 機能概要
組織（会社など任意の団体）を削除する（組織管理者のみ可能）

### リクエスト
DELETE /organizations

### パラメータ
- name

### 成功時レスポンス

```
{
"result": true,
"status": 204,
"message": "No Content"
}
```

### 失敗時レスポンス
Bad Request

```
{
"result": false,
"status": 400,
"message": "Bad Request"
}
```

Forbidden

```
{
"result": false,
"status": 403,
"message": "Forbidden"
}
```

Not Found

```
{
"result": false,
"status": 404,
"message": "Not Found",
}
```

## ユーザー新規登録

### 機能概要
- パラメーターを手動で入力して登録する
- 組織管理者になる登録もこちらで行う

### リクエスト
POST /v1.0.0/auth

### パラメータ
- name
- email
- org_admin
- password

### 成功時レスポンス

```
{
"result": true,
"status": 201,
"message": "Created"
}
```

### 失敗時レスポンス
Bad Request

```
{
"result": false,
"status": 400,
"message": "Bad Request"
}
```
## ユーザー更新

### 機能概要
- ユーザーの設定を変更する

### リクエスト
PATCH /v1.0.0/auth

### パラメータ
- name
- email
- org_admin
- password

### 成功時レスポンス
```
{
"result": true,
"status": 200,
"message": "Success"
}
```

### 失敗時レスポンス
Bad Request

```
{
"result": false,
"status": 400,
"message": "Bad Request"
}
```

## ユーザー削除

### 機能概要
- 各ユーザーが自分自身のみ削除できる
- 権利者権限の識別にはscopeを使って組織単位・グループ単位の削除を可能にする
### リクエスト
DELETE /v1.0.0/auth

### 成功時レスポンス

```
{
"result": true,
"status": 204,
"message": "No Content"
}
```

### 失敗時レスポンス
Bad Request

```
{
"result": false,
"status": 400,
"message": "Bad Request"
}
```

Forbidden

```
{
"result": false,
"status": 403,
"message": "Forbidden"
}
```

Not Found

```
{
"result": false,
"status": 404,
"message": "Not Found",
}
```
