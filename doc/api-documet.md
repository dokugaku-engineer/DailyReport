# APIドキュメント

## API一覧

| リソース | 機能                       | コントローラ/メソッド      | メソッド | URI                     | 
| :------: | :------------------------: | :------------------------: | :------: | :---------------------: | 
| ログイン | セッション作成             | sessions#create            | POST     | /login                  | 
|          | セッション削除             | sessions#destroy           | DELETE   | /logout                 | 
| 日報     | slackで投稿された日報の保存                   | posts#create               | POST     | /posts                  | 
|          | slackで投稿された日報更新                   | post#update                | PATCH    | /posts                  | 
|          | slackで投稿された日報削除                   | post#destroy               | DELETE   | /posts                  | 
| 投稿先         | スプレッドシートへの日報の投稿先指定   | endpoints#create        | POST  | /endpoints        | 
|          | スプレッドシートへの日報の投稿先指定解除   | endpoint#destroy         | DELETE   | /endpoint/:id         | 
|          | 管理者による日報の投稿先指定   | admin/endpoints#create        | POST  | admin/endpoints        | 
|          | 管理者による日報の投稿先指定解除   | admin/endpoint#destroy         | DELETE   | admin/endpoint/:id         | 
| 組織     | 管理者による組織作成       | admin/organizations#create | POST     | /admin/organizations    | 
|          | 管理者による組織削除       | admin/organization#destroy | DELETE   | /admin/organization/:id | 
| ユーザー  | ユーザーによるユーザー作成 | users#create               | POST   | /users               |
|          | ユーザーによるユーザー削除 | user#destroy               | DELETE   | /user/:id               | 
|          | 管理者によるユーザー削除   | admin/user#destroy         | DELETE   | /admin/user/:id         | 

## ログイン

### 機能概要
- SlackのOpenID Connectで認証し、セッションを構築する

### リクエスト
POST /login

### パラメータ（代表的なもの）
- access_token
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
"message": "Bad Request",
}
```

Unauthorized
```
{
"result": false,
"status": 401,
"message": "Unauthorized",
}
```

## ログアウト

### 機能概要
ログインし、セッションを破棄する

### リクエスト
DELETE /logout   

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
"message": "Bad Request",
}
```

Unauthorized
```
{
"result": false,
"status": 401,
"message": "Unauthorized",
}
```

## slackで投稿された日報の保存

### 機能概要
- slackで投稿された日報を、投稿したユーザーがユーザーデータベースに含まれているか検証してから、データベースやSpreadSheetなどに保存する

### リクエスト
POST /posts

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
```
{
"result": true,
"status": 200,
"message": "Success"
}
```

### 失敗時レスポンス
Unauthorized
```
{
"result": false,
"status": 401,
"message": "Unauthorized",
}
```

## slackで投稿された日報の更新

### 機能概要
- slackで投稿された日報について、どのユーザーのどの投稿かを検証してからデータベースやSpreadSheetなどを更新する

### リクエスト
PATCH /posts

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
```
{
"result": true,
"status": 200,
"message": "Success"
}
```

### 失敗時レスポンス
Unauthorized
```
{
"result": false,
"status": 401,
"message": "Unauthorized",
}
```
## slackで投稿された日報の削除

### 機能概要
slackで投稿された日報を、どのユーザーのどの投稿かを検証してからデータベースやSpreadSheetなどから削除する

### リクエスト
DELTE /posts

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
```
{
"result": true,
"status": 200,
"message": "Success"
}
```

### 失敗時レスポンス
Unauthorized
```
{
"result": false,
"status": 401,
"message": "Unauthorized",
}
```

## スプレッドシートへの日報の投稿先指定

### 機能概要
スプレッドシート単位、シート単位で日報の投稿先を指定する

### リクエスト
POST /endpoints

### パラメータ
- user（ユーザー名）
- spreadsheet_url（スプレッドシートURL）
- sheet_numebr（シート番号）

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
"message": "Bad Request",
}
```

Forbidden
```
{
"result": false,
"status": 401,
"message": "Forbidden",
}
```

## スプレッドシートへの日報の投稿先削除

### 機能概要
指定したスプレッドシートの投稿先を削除する

### リクエスト
Delete /endpoint/:id

### パラメータ
- user（ユーザー名）

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
"message": "Bad Request",
}
```

Forbidden
```
{
"result": false,
"status": 401,
"message": "Forbidden",
}
```
## 管理者によるスプレッドシートへの日報の投稿先指定

### 機能概要
スプレッドシート単位、シート単位で日報の投稿先を指定する

### リクエスト
POST admin/endpoints   

### パラメータ
- user（ユーザー名）
- spreadsheet_url（スプレッドシートURL）
- sheet_numebr（シート番号）

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
"message": "Bad Request",
}
```

Forbidden
```
{
"result": false,
"status": 401,
"message": "Forbidden",
}
```

## 管理者によるスプレッドシートへの日報の投稿先削除

### 機能概要
指定したスプレッドシートの投稿先を削除する

### リクエスト
Delete admin/endpoint/:id

### パラメータ
- user（ユーザー名）

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
"message": "Bad Request",
}
```

Forbidden
```
{
"result": false,
"status": 401,
"message": "Forbidden",
}
```

## 組織作成

### 機能概要
組織（会社など任意の団体）を作成する（管理人のみ可能）

### リクエスト
POST /admin/organizations

### 成功時レスポンス
```
{
"result": true,
"status": 200,
"message": "Success"
}
```

### 失敗時レスポンス
```
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
```

## 組織削除

### 機能概要
組織（会社など任意の団体）を削除する（管理人のみ可能）

### リクエスト
DELETE /admin/organizations

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

## ユーザー登録

### 機能概要
- パラメーターを手動で入力して登録する

### リクエスト
POST /users

### パラメータ
- user（ユーザー名）
- email（メールアドレス）

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

## 管理人によるユーザー削除

### 機能概要
どのユーザーをも削除できる（管理人のみ可能）

### リクエスト
DELETE /admin/user/:id

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


