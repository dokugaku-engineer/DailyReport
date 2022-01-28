# EC2構築手順

## 【概要】  

本番環境で稼働するEC2を構築する

## 【目的】  

APIを提供する実行環境を用意するため

## 【手順】  

### 1.キーペアの作成  

- 検索タブで「EC2」と入力し画面遷移  

- 左タブの「キーペア」を押下し「キーペアの作成」を押下

![WS000000](https://user-images.Githubusercontent.com/89679815/150628012-633469a0-eb52-4f6f-a5ac-a470ebdff6ba.JPG)

- 以下の値を入力し、「キーペアの作成」を押下  

|項目|値|  
|:--:|:--:|  
|名前|daily-report|  
|キーペアのタイプ|RSA|  
|プライベートキーファイル形式|.pem|    

### 2.インスタンスの作成  

- 「EC2ダッシュボード」にて「インスタンスを起動」を押下
![WS000000](https://user-images.Githubusercontent.com/89679815/150630648-2cf093d9-2fdc-4722-935d-7373ff2699cf.JPG)  

- 「Amazon Linux 2 AMI (HVM) - Kernel 5.10, SSD Volume Type」を選択  
![WS000001](https://user-images.Githubusercontent.com/89679815/150630650-cadbccd8-732e-49f3-940a-014b50bfe97d.JPG)

- 「ファミリ：t2」を選択し次へ
![WS000002](https://user-images.Githubusercontent.com/89679815/150630653-737d33bc-6ced-4d76-b91d-244dbe204687.JPG)

-  インスタンスの詳細設定にて以下の値を入力し「次へ」  

|         項目          |  値   |  
| :-------------------: | :---: |  
| ネットワーク | dr-prod-vpc-01 |  
| サブネット | dr-prod-public-subnet01 |  
| 自動割当パブリックIP | 有効 |  
| 終了保護の有効化 | 有効 |    
※これら以外はデフォルト  

![WS000003](https://user-images.Githubusercontent.com/89679815/150630654-9f267f38-37e7-42e8-bfed-1f458048a452.JPG)

- ストレージの追加にて以下の値を入力し「次へ」

|         項目          |  値   |  
| :-------------------: | :---: |  
| サイズ | 30 |     
※これら以外はデフォルト  

![WS000004](https://user-images.Githubusercontent.com/89679815/150630655-701469a3-be29-4560-a70e-4698ccb3e2b9.JPG)  

- タグの設定にて以下の値を入力し「次へ」

|         項目          |  値   |  
| :-------------------: | :---: |  
| Name | dr_prod_ec2_01 | 

- セキュリティグループの設定にて以下のセキュリティグループを選択し、「確認と作成」を押下 

|         項目          |  値   |  
| :-------------------: | :---: |  
| 名前 | dr-prod-ec2-sg01  |  

![WS000005](https://user-images.Githubusercontent.com/89679815/150630656-b7b21b4e-c676-4e1f-a136-807f478bd79c.JPG)  

- 設定項目を確認し、「起動」を押下

![WS000006](https://user-images.Githubusercontent.com/89679815/150630657-7b22c90e-47c7-4777-bacf-74c0debce09f.JPG)

- インスタンス一覧画面にて「dr_prod_ec2_01」を選択肢、「インスタンスの状態」>「開始」を押下  

- 任意のSSHクライアントツールを起動し、作成したインスタンスへSSH接続を実施  

|         項目          |  値   |  
| :-------------------: | :---: |  
| ユーザー名 | ec2-user  |  
| RSA鍵を使う | 作成したRSAk鍵を選択  |  

- 以下のコマンドを実行しパッケージを最新化
```
sudo yum update
```  

### 3.Dockerインストール  
- 以下のコマンドを順に実行する  

- dockerをインストール
```
sudo amazon-linux-extras install -y docker
```

- インストールの確認 
```
amazon-linux-extras | grep docker
```  
→「docker=latest enabled」であることを確認  

- dockerサービスを起動
```
sudo systemctl start docker
```
- サーバ起動時のdockerサービス起動を自動化
```
sudo systemctl enable docker
```

- dockerをec2-userグループに追加 
```
sudo usermod -a -G docker ec2-user
```  

### docker-composeインストール
- docker-composeをインストール 
```
sudo curl -L https://Github.com/docker/compose/releases/download/v2.2.1/docker-compose-linux-x86_64 -o /usr/local/bin/docker-compose
```

- docker-composeの実行権限を追加
```
sudo chmod +x /usr/local/bin/docker-compose
```

- シンボリックリンクを作成
```
sudo ln -s /usr/local/bin/docker-compose /usr/bin/docker-compose
```

- docker-composeコマンドを実行できることを確認
```
docker-compose --version
```

### 4.Gitインストール
- Gitをインストール
```
sudo yum install git
```

- インストールを確認 
```
git version
```  

### 5.GitHub連携  
前提：自分のリモートリポジトリに開発用リポジトリからfork済み

- プロジェクト用ディレクトリを作成 
```
mkdir -p /home/ec2-user/DailyReport
```  

- プロジェクトディレクトリに移動
```
cd /home/ec2-user/DailyReport
```  

- GitHubへSSH接続するための鍵を生成
```
sudo ssh-keygen -t rsa -b 4096
```  
※以下全てエンターを押下  
→Enter file in which to save the key (/home/ec2-user/.ssh/id_rsa):  
→Enter passphrase (empty for no passphrase):   
→Enter same passphrase again:   

- ディレクトリを移動
```
cd ../.ssh
```  

- 生成した公開鍵を開く
```
cat id_rsa.pub
```  
→表示されるハッシュ文字列を全てコピー 

- GitHubにログインし、画面右上の「ユーザーアイコン画像」＞「Settings」 を押下

- 左タブの「SSH and GPG keys」を押下し、「New SSH key」を押下

- 「SSH keys/ Add new」画面にて以下の値を入力し「Add SSH key」を押下

|         項目          |  値   |  
| :-------------------: | :---: |  
| Title | for DailyReportServer  |  
| Key | 作成したキーを貼り付け  |  

- GitHubへSSH接続できるかテスト
```
sudo ssh -T git@github.com
```  
→「Attempts to ssh to GitHub」と表示されることを確認 

- GitHubからプロジェクト用リポジトリをクローン
```
git clone git@github.com:dokugaku-engineer/DailyReport.git
``` 
- リモートリポジトリを登録  
```
git remote add origin https://github.com/dokugaku-engineer/DailyReport.git
```

### 6.MySQLクライアントインストール(任意)  
※RDS（MySQL）に保存したデータを確認するために利用  
- 以下のコマンドを実行し、MySQLクライアントをインストール
```
sudo yum install mysql-community-client
```
- 以下のコマンドを実行し、MySQLへ接続できることを確認
```
mysql -h <RDSエンドポイント> -P 3306 -u admin -p

Enter password: <RDS作成時に指定したパスワード>
```
