# VPC作成手順  

## 【概要】  

AWSにおけるプライベートネットワーク環境を構築する。

## 【目的】  

AWS上でサーバを稼働させるためには専用のプライベートネットワーク空間を設ける必要があるため。

## 【手順】  

### 前提：各手順で入力する値は手順内の表を参照すること。  

1. VPC作成  
    - [ ] 検索タブから「VPC」を検索し、画面遷移   
    
    - [ ] 左タブにて「VPC」を押下  
      ![146721083-ff29f89b-1d7d-47c5-bded-abff8aaf5876](https://user-images.githubusercontent.com/89679815/146721145-6733383c-f809-4d9b-8576-87e2069a789f.jpg)  
    
    - [ ] 画面右上の「VPCを作成」を押下
      ![WS000001](https://user-images.githubusercontent.com/89679815/146721509-7f44ea04-b205-435e-bb47-21aa6542c761.JPG)  
    
    - [ ] 以下の値を設定し「VPCを作成」を押下 

      - [ ] 【VPCの設定】

        |       項目       |           値           |
        | :--------------: | :--------------------: |
        |     名前タグ     |     dr-prod-vpc01      |
        | IPv4CIDRブロック | IPv4 CIDR manual input |
        |     IPv4CIDR     |     192.168.0.0/22     |
        |    テナンシー    |       デフォルト       |
      
      - [ ] 【タグ】  
            追記なし  
      ![WS000002](https://user-images.githubusercontent.com/89679815/146722028-2a64afc4-e17b-43fe-9bf5-4107a0830938.JPG)  
      ![WS000003](https://user-images.githubusercontent.com/89679815/146722038-a487fdcc-15d6-4084-b383-de18f7cbe045.JPG)  

   - [ ] VPCが正常に作成されていることを確認    
      ![WS000004](https://user-images.githubusercontent.com/89679815/146721729-143bbd9b-07c4-4494-bf07-19b047f71edd.JPG)  

2. サブネット作成  
    - [ ] 左タブにて「サブネット」を押下  
   
    - [ ] 画面右上の「サブネットを作成」を押下  
       ![WS000005](https://user-images.githubusercontent.com/89679815/146722854-bbe03cdd-b83b-4eee-8db3-9c8155b327c9.JPG)  
   
   - [ ] 以下の値を設定し、「サブネットを作成」を押下  
     ※下記パラメータテーブルを参照し、【新しいサブネットを追加】を押下し、作成するサブネット分手順を繰り返す  
      
      - [ ] サブネット1(dr-prod-public-subnet01)
        
        - [ ] 【VPC】  
            |  項目  |      値       |
            | :----: | :-----------: |
            | VPC ID | dr-prod-vpc01 |
        
        - [ ] 【サブネットの設定】  
            |          項目          |           値            |
            | :--------------------: | :---------------------: |
            |      サブネット名      | dr-prod-public-subnet01 |
            | アベイラビリティゾーン |     ap-northeast-1a     |
            |   IPv4 CIDR ブロック   |     192.168.0.0/24      |
            |          タグ          |        追記なし         |

      
      - [ ] サブネット2(dr-prod-public-subnet02)
        
        - [ ] 【VPC】  
            |  項目  |      値       |
            | :----: | :-----------: |
            | VPC ID | dr-prod-vpc01 |
        
        - [ ] 【サブネットの設定】  
            |          項目          |           値            |
            | :--------------------: | :---------------------: |
            |      サブネット名      | dr-prod-public-subnet02 |
            | アベイラビリティゾーン |     ap-northeast-1c     |
            |   IPv4 CIDR ブロック   |     192.168.1.0/24      |
            |          タグ          |        追記なし         |

      - [ ] サブネット3(dr-prod-private-subnet01)
        
        - [ ] 【VPC】  
            |  項目  |      値       |
            | :----: | :-----------: |
            | VPC ID | dr-prod-vpc01 |

        - [ ] 【サブネットの設定】  
            |          項目          |            値            |
            | :--------------------: | :----------------------: |
            |      サブネット名      | dr-prod-private-subnet01 |
            | アベイラビリティゾーン |     ap-northeast-1a      |
            |   IPv4 CIDR ブロック   |      192.168.2.0/24      |
            |          タグ          |         追記なし         |

      - [ ] サブネット4(dr-prod-private-subnet02)
        
        - [ ] 【VPC】  
            |  項目  |      値       |
            | :----: | :-----------: |
            | VPC ID | dr-prod-vpc01 |
        
        - [ ] 【サブネットの設定】  
            |          項目          |            値            |
            | :--------------------: | :----------------------: |
            |      サブネット名      | dr-prod-private-subnet02 |
            | アベイラビリティゾーン |     ap-northeast-1c      |
            |   IPv4 CIDR ブロック   |      192.168.3.0/24      |
            |          タグ          |         追記なし         |

      ![WS000006](https://user-images.githubusercontent.com/89679815/146723221-f81a32fb-4f97-4839-9e46-e554212bd718.JPG)  
      ![WS000007](https://user-images.githubusercontent.com/89679815/146723226-0aabf695-742c-47ee-85aa-23e11cf86b0b.JPG)  

   - [ ] サブネットが作成されていることを確認   
      ![WS000019](https://user-images.githubusercontent.com/89679815/146723257-f0c25aba-84eb-45a9-bf46-b90f68ffbf07.JPG)  

3. インターネットゲートウェイ作成  
   - [ ] 左タブの「インターネットゲートウェイ」を押下  
      ![WS000000](https://user-images.githubusercontent.com/89679815/146723561-47baf0ab-d7de-4446-80ee-e431357a589e.JPG)  
   
   - [ ] 「インターネットゲートウェイの作成」を押下  
      ![WS000001](https://user-images.githubusercontent.com/89679815/146723574-bd6d752e-357c-47af-8051-69e346222240.JPG)  

   - [ ] 以下の値を設定し、「インターネットゲートウェイの作成」を押下
     
     - [ ] 【インターネットゲートウェイの設定】  
        |   項目   |            値             |
        | :------: | :-----------------------: |
        | 名前タグ | dr-prod-internetGateway01 |
     
     - [ ] 【タグ】 
        | 項目  |    値    |
        | :---: | :------: |
        | タグ  | 追記なし |
      ![WS000002](https://user-images.githubusercontent.com/89679815/146723611-621a6d2e-e163-42df-b16b-a49e735f2b21.JPG)  

   - [ ] インターネットゲートウェイが作成されていることを確認
      ![WS000003](https://user-images.githubusercontent.com/89679815/146723632-e66d99cf-e92b-4b57-863d-018036cc6bae.JPG)  

   - [ ] 「アクション」タブを開き、「VPCへアタッチ」を押下
      ![WS000004](https://user-images.githubusercontent.com/89679815/146723648-90206abb-448c-4edf-b927-711d60a468f3.JPG)  

   - [ ] 以下の値を設定し、「インターネットゲートウェイのアタッチ」を押下
     
     - [ ] 【VPC】  
        |     項目      |      値       |
        | :-----------: | :-----------: |
        | 使用可能なVPC | dr-prod-vpc01 |
      ![WS000005](https://user-images.githubusercontent.com/89679815/146723683-fc6dc3cd-3d83-4f64-a203-046b6605d337.JPG)   
   
   - [ ] インターネットゲートウェイがVPCにアタッチされたことを確認 
      ![WS000007](https://user-images.githubusercontent.com/89679815/146723720-bf1cec1f-4e75-46c7-bbee-cd7095d1b8fa.JPG)  


4. ルートテーブル作成  
   
   - [ ] 左タブの「ルートテーブル」を押下  

   
   - [ ] 「ルートテーブルを作成」を押下  
      ![WS000001](https://user-images.githubusercontent.com/89679815/146724869-3d6c4603-9bf9-4a37-a96a-d250060bb744.JPG)  
   
   - [ ] 以下の値を設定し、「ルートテーブルを作成」を押下
   
     - [ ] ルートテーブル1 (dr-prod-private-rootTable01)
       
       - [ ] 【ルートテーブル設定】
          | 項目  |             値              |
          | :---: | :-------------------------: |
          | 名前  | dr-prod-private-rootTable01 |
          |  VPC  |        dr-prod-vpc01        |
       
       - [ ] タグ 
          | 項目  |    値    |
          | :---: | :------: |
          | タグ  | 追記なし |
        ![WS000011](https://user-images.githubusercontent.com/89679815/146725545-63cb42b6-fbf7-4376-915a-692fcb5e2061.JPG)  
     
     - [ ] ルートテーブル2 (dr-prod-public-rootTable01)
       
       - [ ] 【ルートテーブル設定】
          | 項目  |             値             |
          | :---: | :------------------------: |
          | 名前  | dr-prod-public-rootTable01 |
          |  VPC  |       dr-prod-vpc01        |
       
       - [ ] タグ 
          | 項目  |    値    |
          | :---: | :------: |
          | タグ  | 追記なし |
        ![WS000002](https://user-images.githubusercontent.com/89679815/146725840-d112dd37-2521-4093-8421-9015c7c4bd22.JPG)  

   - [ ] ルートテーブルが作成されていることを確認  
 
   - [ ] 以下の手順に沿ってルートテーブルの設定を行う  
     
     - [ ] ルートテーブル1 (dr-prod-private-rootTable01)  
       
       - [ ] 「サブネットの関連付け」タブの、【明示的なサブネットの関連付け】項目にある「サブネットの関連付けを編集」を押下  
          ![WS000013](https://user-images.githubusercontent.com/89679815/146726053-1440266d-fd39-41c4-bc6d-2c4ef9bf7d4c.JPG)  

       - [ ] 以下の値を選択し、「関連付けを保存」を押下  
         
         - [ ] 【利用可能なサブネット】  
            |           項目           |    値    |
            | :----------------------: | :------: |
            | dr-prod-private-subnet01 | チェック |
            | dr-prod-private-subnet02 | チェック |
        ![WS000014](https://user-images.githubusercontent.com/89679815/146726120-ea4b82dc-9a1d-48cd-b823-1948d0323925.JPG)  

        - [ ] サブネットの関連付けが更新されたことを確認    
            ![WS000015](https://user-images.githubusercontent.com/89679815/146726188-2c626024-ca31-4b6a-a707-665c9fb3b1f0.JPG)  

     - [ ] ルートテーブル2 (dr-prod-public-rootTable01)  
       
       - [ ] 「ルート」タブの、【ルート】項目にある「ルートを編集」を押下  
          ![WS000003](https://user-images.githubusercontent.com/89679815/146726301-1dd9e3a1-5e5e-41ea-8521-691ab10eb5fd.JPG)  

       - [ ] 「ルートを追加」を押下  
          ![WS000004](https://user-images.githubusercontent.com/89679815/146726513-ca329d09-94b8-4892-9d15-1794a02e4891.JPG)  

       - [ ] 以下の値を設定し、「変更を保存」を押下  
            |    項目    |                                       値                                       |
            | :--------: | :----------------------------------------------------------------------------: |
            |   送信先   |                                   0.0.0.0/0                                    |
            | ターゲット | igw-<3.インターネットゲートウェイの作成>で作成したインターネットゲートウェイID |
        ![WS000005](https://user-images.githubusercontent.com/89679815/146726560-af71f836-38bf-4faa-a859-be4ab1d3f500.JPG)

       - [ ] ルートが更新されていることを確認  
          ![WS000006](https://user-images.githubusercontent.com/89679815/146726631-314019ca-1639-44b3-801d-3b2199c6197c.JPG)  

       - [ ] 「サブネットの関連付け」タブの、【明示的なサブネットの関連付け】項目にある「サブネットの関連付けを編集」を押下  
          ![WS000007](https://user-images.githubusercontent.com/89679815/146726701-c3445773-19a7-4c16-b3de-4948204ea12b.JPG)  

       - [ ] 以下の値を選択し、「関連付けを保存」を押下  
         
         - [ ] 【利用可能なサブネット】  
            |          項目           |    値    |
            | :---------------------: | :------: |
            | dr-prod-public-subnet01 | チェック |
            | dr-prod-public-subnet02 | チェック |
          ![WS000008](https://user-images.githubusercontent.com/89679815/146726740-67fb5a64-ed4e-4d51-88a8-758fb2bfec77.JPG)  

        - [ ] サブネットの関連付けが更新されたことを確認       
           ![WS000009](https://user-images.githubusercontent.com/89679815/146726766-89d18a91-775f-40f9-a5cc-f6d4578365bb.JPG)  

5. セキュリティグループ作成  
        
    - [ ] 左タブの「セキュリティグループ」を押下  
    
    - [ ] 画面右上の「セキュリティグループを作成」を押下  
    
    - [ ] 以下の設定を、セキュリティグループごとにそれぞれ追加し、「セキュリティグループを作成」を押下  
      
      - [ ] セキュリティグループ1
        
        - [ ] 【基本的な詳細】
            |          項目          |        値        |
            | :--------------------: | :--------------: |
            | セキュリティグループ名 | dr-prod-alb-sg01 |
            |          説明          |    allow-alb     |
            |          VPC           |  dr-prod-vpc01   |

      - [ ] セキュリティグループ2
        
        - [ ] 【基本的な詳細】
            |          項目          |        値        |
            | :--------------------: | :--------------: |
            | セキュリティグループ名 | dr-prod-ecs-sg01 |
            |          説明          |    allow-ecs     |
            |          VPC           |  dr-prod-vpc01   |

      - [ ] セキュリティグループ3
        
        - [ ] 【基本的な詳細】
            |          項目          |        値        |
            | :--------------------: | :--------------: |
            | セキュリティグループ名 | dr-prod-rds-sg01 |
            |          説明          |    allow-rds     |
            |          VPC           |  dr-prod-vpc01   |
       ![WS000000](https://user-images.githubusercontent.com/89679815/146728572-879f1236-409f-4df0-b323-34e2f55b3527.JPG)
       ![WS000001](https://user-images.githubusercontent.com/89679815/146728427-bbcada67-546c-431a-8da6-87616f301a1d.JPG)  


    - [ ] セキュリティグループが作成されていることを確認  
        ![WS000007](https://user-images.githubusercontent.com/89679815/146728690-48d4881a-3df9-450c-924a-69baf0242636.JPG)

    - [ ] 作成したセキュリティグループごとにルールを追加  
        
        - [ ] セキュリティグループ1 (dr-prod-alb-sg01)
          
          - [ ] インバウンドルール  
            
            - [ ] 「インバウンドルールの編集」を押下  
            
            - [ ] 「ルールの追加」を押下し、以下の設定を追加の上「ルールの保存」を押下  
              
              - [ ] ルール1    
                |    項目    |         値         |
                | :--------: | :----------------: |
                |   タイプ   |       https        |
                | プロトコル |        TCP         |
                |   ソース   |     0.0.0.0/0      |
                |    説明    | http-from-internet |

          - [ ] アウトバウンドルール 
            
            - [ ] 「アウトバウンドルールの編集」を押下  
            
            - [ ] 「ルールの追加」を押下し、以下の設定を追加の上「ルールの保存」を押下  
              
              - [ ] ルール1  
                |    項目    |        値        |
                | :--------: | :--------------: |
                |   タイプ   |       http       |
                | プロトコル |       TCP        |
                |   送信先   | dr-prod-ecs-sg01 |
                |    説明    |   http-to-ecs    |

              - [ ] ルール2  
                |    項目    |        値        |
                | :--------: | :--------------: |
                |   タイプ   |      https       |
                | プロトコル |       TCP        |
                |   送信先   | dr-prod-ecs-sg01 |
                |    説明    |   http-to-ecs    |
              ![WS000009](https://user-images.githubusercontent.com/89679815/146729293-211bac26-c4f1-48d9-895e-4e0c3dd24945.JPG)

        - [ ] セキュリティグループ2 (dr-prod-ecs-sg01)
          
          - [ ] インバウンドルール
            
            - [ ] 「インバウンドルールの編集」を押下  
            
            - [ ] 「ルールの追加」を押下し、以下の設定を追加の上「ルールの保存」を押下  
              
              - [ ] ルール1    
                |    項目    |        値        |
                | :--------: | :--------------: |
                |   タイプ   |       http       |
                | プロトコル |       TCP        |
                |   ソース   | dr-prod-alb-sg01 |
                |    説明    |  http-from-alb   |

              - [ ] ルール2    
                |    項目    |        値        |
                | :--------: | :--------------: |
                |   タイプ   |      https       |
                | プロトコル |       TCP        |
                |   ソース   | dr-prod-alb-sg01 |
                |    説明    |  https-from-alb  |
            ![WS000015](https://user-images.githubusercontent.com/89679815/146729517-e0a405d4-e76a-4908-9c6e-fc0e295659e5.JPG)   

          - [ ] アウトバウンドルール 
            
            - [ ] 「アウトバウンドルールの編集」を押下  
            
            - [ ] 「ルールの追加」を押下し、以下の設定を追加の上「ルールの保存」を押下   
              
              - [ ] ルール1  
                |    項目    |        値        |
                | :--------: | :--------------: |
                |   タイプ   |   MySQL/Aurora   |
                | プロトコル |       TCP        |
                |   送信先   | dr-prod-rds-sg01 |
                |    説明    |      to-rds      |

              - [ ] ルール2  
                |    項目    |        値        |
                | :--------: | :--------------: |
                |   タイプ   |       http       |
                | プロトコル |       TCP        |
                |   送信先   | dr-prod-alb-sg01 |
                |    説明    |   http-to-alb    |

              - [ ] ルール3  
                |    項目    |        値        |
                | :--------: | :--------------: |
                |   タイプ   |      https       |
                | プロトコル |       TCP        |
                |   送信先   | dr-prod-alb-sg01 |
                |    説明    |   http-to-alb    |
              ![WS000030](https://user-images.githubusercontent.com/89679815/146729660-217f0552-e395-4a8b-aeae-2d3a498dabdf.JPG)



        - [ ] セキュリティグループ3 (dr-prod-rds-sg01)
          - [ ] インバウンドルール
            - [ ] 「インバウンドルールの編集」を押下  
            
            - [ ] 「ルールの追加」を押下し、以下の設定を追加の上「ルールの保存」を押下  
              
              - [ ] ルール1    
                |        項目        |        値        |
                | :----------------: | :--------------: |
                | タイプMySQL/Aurora |
                |     プロトコル     |       TCP        |
                |       ソース       | dr-prod-ecs-sg01 |
                |        説明        |     from-ecs     |
              ![WS000023](https://user-images.githubusercontent.com/89679815/146729804-f9ce4a7c-d202-443c-93b5-a0a9de6349f6.JPG)

          - [ ] アウトバウンドルール 
            
            - [ ] 「アウトバウンドルールの編集」を押下  
            
            - [ ] 「ルールの追加」を押下し、以下の設定を追加の上「ルールの保存」を押下   
              
              - [ ] ルール1  
                |    項目    |  値   |
                | :--------: | :---: |
                |   タイプ   | 全て  |
                | プロトコル | 全て  |
                |   送信先   |       |
                |    説明    |  all  |
              ![WS000025](https://user-images.githubusercontent.com/89679815/146729853-0773352f-52ba-4339-a9cf-8ed09261a440.JPG)

   - [ ] 作成したルールが登録されていることを確認  