# APIドキュメント

## URL
http:api.daily-report.com/v1

## API一覧

| リソース | 機能                       | コントローラ/メソッド      | HTTPメソッド | URI                     | 
| :------: | :------------------------: | :------------------------: | :------: | :---------------------: | 
| ログイン | セッション作成             | sessions#create            | POST     | /login                  | 
|          | セッション削除             | sessions#destroy           | DELETE   | /logout                 | 
| 日報     | 日報保存                   | posts#create               | POST     | /posts                  | 
|          | 日報更新                   | post#update                | PATCH    | /posts                  | 
|          | 日報削除                   | post#destroy               | DELETE   | /posts                  | 
| 組織     | 管理者による組織作成       | admin/organizations#create | POST     | /admin/organizations    | 
|          | 管理者による組織削除       | admin/organization#destroy | DELETE   | /admin/organization/:id | 
| ユーザー | ユーザーによるユーザー作成 | users#create               | POST   | /users               | 
|          | ユーザーによるユーザー削除 | user#destroy               | DELETE   | /user/:id               | 
|          | 管理者によるユーザー削除   | admin/user#destroy         | DELETE   | /admin/user/:id         | 

## ログイン

#### 機能概要
- SlackのOpenID Connectでログインし、セッションを構築する
- 初ログインならPOST /user/:idを叩いてユーザーデータベースに登録する

#### リクエスト
POST /login

#### パラメータ（代表的なもの）
- access_token
- name

#### 成功時レスポンス
{
"result": true,
"status": 200,
"message": "Success"
}

#### 失敗時レスポンス
{
"result": false,
"status": 400,
"message": "Bad Request",
}

{
"result": false,
"status": 401,
"message": "Unauthorized",
}

## ログアウト

#### 機能概要
ログインし、セッションを破棄する

#### リクエスト
DELETE /logout   

#### 成功時レスポンス
{
"result": true,
"status": 200,
"message": "Success"
}

#### 失敗時レスポンス
{
"result": false,
"status": 400,
"message": "Bad Request"
}

{
"result": false,
"status": 401,
"message": "Unauthorized"
}

## 日報保存

#### 機能概要
- slackなどの外部のアプリケーションから投稿された日報を、投稿したユーザーがユーザーデータベースに含まれているか検証してからデータベースやSpreadSheetなどに保存する

#### リクエスト
POST /posts

#### パラメータ（代表的なもの）
【Slack】
- token（トークン）
- team_id（ワークスペースのID）
- authorizations（認可情報）
- type（Event APIメソッド）
- channel（チャンネル）
- user（ユーザー）
- text（投稿文）
- ts（タイムスタンプ）

#### 成功時レスポンス
{
"result": true,
"status": 200,
"message": "Success"
}

{
"result": true,
"status": 201,
"message": "created"
}

#### 失敗時レスポンス
{
"result": false,
"status": 401,
"message": "Unauthorized"
}

## 日報更新

#### 機能概要
- slackなどの外部のアプリケーションで更新された日報について、どのユーザーのどの投稿かを検証してからデータベースやSpreadSheetなどを更新する

#### リクエスト
PATCH /posts

#### パラメータ（代表的なもの）
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

#### 成功時レスポンス
{
"result": true,
"status": 200,
"message": "Success"
}

#### 失敗時レスポンス
{
"result": false,
"status": 401,
"message": "Unauthorized"
}

## 日報削除

#### 機能概要
slackなどの外部のアプリケーションで削除された日報を、どのユーザーのどの投稿かを検証してからデータベースやSpreadSheetなどから削除する

#### リクエスト
DELTE /posts

#### パラメータ（代表的なもの）
【Slack】
- token（トークン）
- team_id（ワークスペースのID）
- authorizations（認可情報）
- type（Event APIメソッド）
- subtype（同メソッドのサブタイプ）
- channel（チャンネル）
- ts（タイムスタンプ）
- deleted_ts（削除時のタイムスタンプ）

#### 成功時レスポンス
{
"result": true,
"status": 200,
"message": "Success"
}

#### 失敗時レスポンス
{
"result": false,
"status": 401,
"message": "Unauthorized"
}

## 組織作成

#### 機能概要
組織（会社など任意の団体）を作成する（管理人のみ可能）

#### リクエスト
POST /admin/organizations

#### 成功時レスポンス
{
"result": true,
"status": 200,
"message": "Success"
}

#### 失敗時レスポンス
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

## 組織削除

#### 機能概要
組織（会社など任意の団体）を削除する（管理人のみ可能）

#### リクエスト
DELETE /admin/organizations

#### 成功時レスポンス
{
"result": true,
"status": 200,
"message": "Success"
}

#### 失敗時レスポンス
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

## ユーザー削除

#### 機能概要
各ユーザーが自分自身のみ削除できる

#### リクエスト
DELETE /user/:id

#### 成功時レスポンス
{
"result": true,
"status": 200,
"message": "Success"
}

#### 失敗時レスポンス
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

## ユーザー削除

#### 機能概要
どのユーザーをも削除できる（管理人のみ可能）

#### リクエスト
DELETE /admin/user/:id

#### 成功時レスポンス
{
"result": true,
"status": 200,
"message": "Success"
}

#### 失敗時レスポンス
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
