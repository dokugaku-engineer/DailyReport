# TLS証明書発行手順  

## 【概要】  

日報APIシステムにおいてHTTPS通信を実現するための証明書を発行する。

## 【目的】  

インターネット経由でユーザーデータへのアクセスが可能な環境であり、通信を暗号化する必要があるため。

## 【手順】  

### 1.証明書のリクエスト  

- 検索タブで「AWS Certificate Manager」と入力し、画面遷移

- 「証明書をリクエスト」を押下

![WS000000](https://user-images.githubusercontent.com/89679815/146778398-6024aa18-0142-4180-8a2a-e500952c2a34.JPG)

- 【証明書タイプ】で「パブリック証明書をリクエスト」を選択肢、「次へ」を押下

![WS000001](https://user-images.githubusercontent.com/89679815/146778408-57ef83bf-6570-488a-a575-46b44f4d39ed.JPG)

- 以下の設定を追加し、「リクエスト」を押下  

【ドメイン名】   
|       項目       |                    値                    |
| :--------------: | :--------------------------------------: |
| 完全修飾ドメイン | 利用するドメイン（例：daily-report.xyz） |

【検証方法を選択】
|      項目      |      値      |
| :------------: | :----------: |
| 検索方法を選択 | DNS検証-推奨 |

【タグ】
| 項目  |     値     |
| :---: | :--------: |
| タグ  | <追記なし> |

![WS000002](https://user-images.githubusercontent.com/89679815/146778411-d3e44671-f21b-47de-ab0f-80500739c364.JPG)

- 証明書がリクエストされたことを確認

![WS000003_LI](https://user-images.githubusercontent.com/89679815/146786053-025da071-7d38-43e1-bf8c-2bf6ab5ccb49.jpg)    

※リクエストした証明書が発行されるまで１２時間～24時間程かかるため、時間を開けて確認

![WS000099_LI](https://user-images.githubusercontent.com/89679815/146778475-a26c8f5d-b366-48b7-aa16-7211f0fb970c.jpg)

### 2.Route53でのレコード作成  

- リクエストした証明書画面にて「Route53でレコードを作成」を押下  

![WS000004_LI](https://user-images.githubusercontent.com/89679815/146778419-15c92b13-dd96-4365-a145-7c4309b2b5a2.jpg)

- 利用するドメイン名を選択し、「レコードを作成」を押下

![WS000005_LI](https://user-images.githubusercontent.com/89679815/146778426-cc609aea-7ec8-47a0-8841-16725e25b9d6.jpg)

- DNSレコードが正常に作成されることを確認

![WS000006_LI](https://user-images.githubusercontent.com/89679815/146778436-3f5917fd-d689-4633-b968-64190c35e6e8.jpg)

- Route53の「ホストゾーン」にて新しいCNAMEレコードが作成されていることを確認

![WS000007_LI](https://user-images.githubusercontent.com/89679815/146778450-b903e4b7-ac79-484f-8324-936c55a7b116.jpg)  
