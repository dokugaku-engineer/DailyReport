# APIドキュメント

## API一覧

| リソース | 機能                       | コントローラ/メソッド      | メソッド | URI                     |
| :------: | :------------------------: | :------------------------: | :------: | :---------------------: |
| ログイン | セッション作成             | sessions#create            | POST     | /login                  |
|          | セッション削除             | sessions#destroy           | DELETE   | /logout                 |
| 日報     | slackで投稿された日報の保存                   | slack_posts#create               | POST     | /slack_posts                  |
|          | slackで投稿された日報更新                   | slack_posts#update                | PATCH    | /slack_posts                  |
|          | slackで投稿された日報削除                   | slack_posts#destroy               | DELETE   | /slack_posts                  |
| 投稿先         | ユーザーによる日報の個別投稿先作成   | slack_to_spreadsheets#create        | POST  | /slack_to_spreadsheets        |
|         | ユーザーによる日報の個別投稿先更新   | slack_to_spreadsheets#update        | POST  | /slack_to_spreadsheets        |
|          | ユーザーによる日報の個別投稿先削除   | slack_to_spreadsheets#destroy         | DELETE   | /slack_to_spreadsheets/:id         |
|          | 組織管理者による日報の組織別投稿先作成   | org_admin/slack_to_spreadsheets#create    | POST  | /org_admin/slack_to_spreadsheets        |
|          | 組織管理者による日報の組織別投稿先更新   | org_admin/slack_to_spreadsheets#update | PATCH | /org_admin/slack_to_spreadsheets/:id         |
|          | 組織管理者による日報の組織別投稿先削除   | org_admin/slack_to_spreadsheets#destroy | DELETE | /org_admin/slack_to_spreadsheets/:id         |
| 組織     | 組織作成       | organizations#create | POST     | /organizations    |
|      | 組織更新       | organizations#update | PATCH     | /organizations    |
|          | 組織削除       | organizations#destroy | DELETE   | /organizations/:id |
| ユーザー  | ユーザー新規登録 | users#create               | POST   | /users               |
|          | ユーザー更新 | users#update               | PATCH   | /users/:id               |
|          | ユーザー削除 | users#destroy               | DELETE   | /users/:id               |

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
"status": 200,
"message": "Success"
}

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
- token
- team_id
- authorizations
- type
- subtype
- channel
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
POST /endpoints

### パラメータ
- user
- spreadsheet_url
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

## ユーザーによる日報の個別投稿先指定削除

### 機能概要
指定したスプレッドシートの投稿先を更新する

### リクエスト
PATCH /endpoints/:id

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
POST admin/endpoints

### パラメータ
- name
- spreadsheet_url
- sheet_number

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
組織メンバーの日報の投稿先をスプレッドシート単位、シート単位で更新する

### リクエスト
PATCH /org_admin/slack_to_spreadsheets/{org_id}

### パラメータ
- name
- spreadsheet_url
- sheet_number
- org_id

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
DELETE /org_admin/slack_to_spreadsheets/{org_id}

### パラメータ
- name
- spreadsheet_url
- sheet_number
- org_id

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
POST /organizations

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
PATCH /organizations

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

## API管理者による組織削除

### 機能概要
API管理者が組織（会社など任意の団体）を削除する

### リクエスト
DELETE /admin/organizations

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
POST /users

### パラメータ
- name
- email
- admin_org

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
POST /users

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

## ユーザー削除

### 機能概要
各ユーザーが自分自身のみ削除できる

### リクエスト
DELETE /user/:id

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

## 組織管理者によるユーザー削除

### 機能概要
組織内であればどのユーザーをも削除できる（組織管理者のみ可能）

### リクエスト
DELETE /admin/user/:id

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

## API管理者によるユーザー削除

### 機能概要
どのユーザーをも削除できる（API管理者のみ可能）

### リクエスト
DELETE /admin/user/:id

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
