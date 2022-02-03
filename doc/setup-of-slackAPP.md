# Slackアプリの設定

## 【概要】  

SlackEventAPIを利用するためのSlackアプリを作成する。

## 【目的】  

Slackに送信されたメッセージを取得するため。

## 【手順】  

### 1.アプリの作成  
- [SlackAPI](https://api.slack.com/ ) >「Your apps」を押下  
- 「Create New App」を押下
- 「From scratch」を押下  
- 名前とワークスペースを指定  

|       項目       |                    値                    |  
| :--------------: | :--------------------------------------: |  
| アプリ名 | Slack_To_Spreadsheet|  
| ワークスペース | 「連携したいワークスペース」|  

### 2.スコープの指定  
- 「OAuth&Permissions」> 「Scopes」にて、以下を追加  

【BotTokenScopes】  
|       値       |   
| :--------------: |     
| channels:history |     
| group:history |   
| im:history |   
| mpim:history |   

【UserTokenScopes】  
|       値       | 
| :--------------: |   
| channels:history |  

### 3.ワークスペースにインストール  
- 「OAuth&Permissions」> 「OAuth Tokens for Your Workspace」 > 「Install to Workspace」にて以下設定

|       値       |   
| :--------------: |     
| 許可する |  

### 4.イベントサブスクリプション設定  
- 「EventSubscriptions」> 「Enable Events」を有効化  
- 「Request URL」に送信先を入力（以下例）

|       値       |   
| :--------------: |     
| https://daily-report.xyz/api/slak_posts |  
※ドメイン名は各自作成済みのものを指定  

- 「Subscribe to event on behalf of users」 >「Add Workspace Event」で以下の値を設定  

|       値       |   
| :--------------: |     
| message.channels |  
  

