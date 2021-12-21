# ロードバランサー構築手順  

## 【概要】  

ECSで稼働すると接続するロードバランサー（ALB）を構築する。


## 【目的】  

インターネット経由で送られてくる無数のリクエストに対し、負荷分散を行うため。

## 【手順】  

### 1.ターゲットグループ作成  

- 検索タブで「EC2」を入力し、画面遷移

- 左タブの「ターゲットグループ」を押下し、「Create target group」を押下  

![WS000001](https://user-images.githubusercontent.com/89679815/146847866-04a9f291-ea5b-4eb0-86be-4fb7f8747c27.JPG)

- 以下の値を設定し、「NEXT」を押下  

【Basic configuration】
|         項目         |            値             |
| :------------------: | :-----------------------: |
| Choose a target type |       IP addresses        |
|  Target group name   | dr-prod-elb-targetGroup01 |
|       Protocol       |           HTTPS           |
|         Port         |            443            |
|   IP address type    |           IPv4            |
|         VPC          |       dr-prod-vpc01       |
|   Protocol version   |           HTTP1           |

【Health checks】
|         項目          |  値   |
| :-------------------: | :---: |
| Health check protocol | HTTPS |
|   Health check path   |   /   |

※Advanced health check settingはデフォルトのまま

![WS000003](https://user-images.githubusercontent.com/89679815/146847870-3b1d68d7-a5c8-4ba5-a252-45b3eaf6b88d.JPG)

![WS000004](https://user-images.githubusercontent.com/89679815/146847874-47549693-879d-401c-a0a8-009c2db9a6e7.JPG)


- 以下の値を設定し、「Create target group」を押下  

【IP address】  

**Step1:Chose a network**

|  項目   |      値       |
| :-----: | :-----------: |
| Network | dr-prod-vpc01 |

**step2:Specify IPs and define ports** 

|       項目       |   値   |
| :--------------: | :----: |
| Add IPv4 address | <空白> |
|      Ports       |  443   |

【Review targets】

**Step3:Review IP targets include in your group**  

→空欄

![WS000005](https://user-images.githubusercontent.com/89679815/146847875-f42d97d4-537e-49ce-baf3-8b30cda77d78.JPG)

![WS000006](https://user-images.githubusercontent.com/89679815/146860659-6e0b4c5a-d458-47bb-9aec-eed8b8bebec4.JPG)


- ターゲットグループが作成されていることを確認 

![WS000007](https://user-images.githubusercontent.com/89679815/146847880-0819f6e3-15a0-4987-b413-b769a2786943.JPG)

### 2.ALB作成  

- 左タブの「ロードバランサー」を押下し、「ロードバランサーの作成」を押下

![WS000000](https://user-images.githubusercontent.com/89679815/146847910-739587bc-6b25-48fe-9085-3bf55a6a7081.JPG)

- 「Application Load Balancer」選択し、「Create」を押下

![WS000001](https://user-images.githubusercontent.com/89679815/146847915-b7bc08a2-bcc6-412d-bf11-63ddb28f2363.JPG)

- 以下の値を設定し、「Create load balancer」を押下

【Basic configuration】

|        項目        |       値        |
| :----------------: | :-------------: |
| Load balancer name |  dr-prod-alb01  |
|       Scheme       | Internet-facing |
|  IP address type   |      IPv4       |

![WS000002](https://user-images.githubusercontent.com/89679815/146861404-77dfa048-72c5-4b50-bd89-04fd753c06a0.JPG)


【Network mapping】
|   項目   |       値1       |           値2           |
| :------: | :-------------: | :---------------------: |
|   VPC    |  dr-prod-vpc01  |        <値なし>         |
| Mappings | ap-northeast-1a | dr-prod-public-subnet01 |
| Mappings | ap-northeast-1c | dr-prod-public-subnet02 |

![WS000003](https://user-images.githubusercontent.com/89679815/146861408-a1f8cf85-1117-4a05-b59f-aa5c6bfee196.JPG)

【Security groups】

|      項目       |        値        |
| :-------------: | :--------------: |
| Security groups | dr-prod-alb-sg01 |

【Listeners and routing】 
|      項目      |            値             |
| :------------: | :-----------------------: |
|    Protocol    |           HTTPS           |
|      Port      |            443            |
| Default action | dr-prod-elb-targetGroup01 |

![WS000004](https://user-images.githubusercontent.com/89679815/146861775-9096110e-b145-4f96-8a12-71bd1423b595.JPG)


【Secure listener settings】  
|          項目           |                  値                  |
| :---------------------: | :----------------------------------: |
|     Security policy     |      ELBSecurityPolicy-2016-08       |
| Default SSL certificate |               From ACM               |
|  Select a certificate   | 作成した証明書 (例:daily-report.xyz) |

【Add-on services】  
→デフォルト    

【Tags】   
→デフォルト 

![WS000005](https://user-images.githubusercontent.com/89679815/146861421-43323ae6-f9f3-4a34-b011-8bb51d1e37f1.JPG)
![WS000006](https://user-images.githubusercontent.com/89679815/146861425-92b60c86-ba3f-4293-b985-3c7a0ccb2cee.JPG)


- ロードバランサーが作成されていることを確認

![WS000007](https://user-images.githubusercontent.com/89679815/146847941-8c0bea43-2a3d-4232-b816-93f232e84b1f.JPG)

### 3.独自ドメインとALBドメインの関連付け  

- 作成したロードバランサーの「DNS名(Aレコード)」をメモ

![WS000009_LI](https://user-images.githubusercontent.com/89679815/146848021-24f6d8d4-68db-49d1-962b-11fde63a063b.jpg)

- 検索タブで「Route53」と入力し、画面遷移

- 「ダッシュボード」にある「ホストゾーン」を押下

![WS000010](https://user-images.githubusercontent.com/89679815/146848033-fa078908-0e74-445a-be9c-5636b8cee0c3.JPG)   

- 利用するドメイン名を押下

![image](https://user-images.githubusercontent.com/89679815/146858353-ed6f5997-26f7-401d-819b-0c6db94c6aa9.png)

- 「レコード」タブを開き、「レコードを作成」を押下

![WS000012_LI](https://user-images.githubusercontent.com/89679815/146848035-983500e7-c436-4ed3-b782-329ac5e32881.jpg)

- 以下の値を設定し、「レコードを作成」を押下  

【レコードのクイック作成】  
|              項目              |                                  値                                   |
| :----------------------------: | :-------------------------------------------------------------------: |
|           レコード名           |                             <デフォルト>                              |
|         レコードタイプ         | A-IPv4アドレスと一部のAWSリソースにトラフィックをルーティングします。 |
| トラフィックのルーティング先 1 |                         「エイリアス」を有効                          |
| トラフィックのルーティング先 2 |   Application Load BalancerとClassical Load Balancerへのエイリアス    |
| トラフィックのルーティング先 3 |              アジアパシフィック（東京）[ap-northeast-1]               |
| トラフィックのルーティング先 3 |                   <作成したロードバランサーを選択>                    |
|      ルーティングポリシー      |                         シンプルルーティング                          |
|    ターゲットのヘルスを評価    |                               「はい」                                |

![WS000013_LI](https://user-images.githubusercontent.com/89679815/146848044-f667e33f-9d5e-452c-a42a-ec88ea3d3616.jpg)


- レコードが作成されていいることを確認  

![WS000014_LI](https://user-images.githubusercontent.com/89679815/146859820-48675a8e-0a35-4243-bd77-16c396777706.jpg)   

- レコードの詳細にある値が控えたDNS名と一致していることを確認

![WS000015_LI - コピー](https://user-images.githubusercontent.com/89679815/146859822-18112e53-e55e-435a-897e-b421d2f20f98.jpg)