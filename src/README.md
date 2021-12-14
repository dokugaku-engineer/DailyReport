# RailsAPIアプリの開発環境構築手順

**Version**

Ruby 3.0.3

Rails 6.1.4

**構築手順**

codeをcloneしたら、開発環境のディレクトリで以下のコマンドを入力する
```
$ docker image build -t 任意名:latest .
```

```
$ docker container run -it -p 3000:3000 -v ${PWD}/src:/app [docker-image名]
```

これで、ローカルのディレクトリとコンテナ内のディレクトリがリアルタイムで同期するので、ローカル環境で開発した内容がDockerffileに反映される。

コンテナ内で`rails server`を立ち上げる時は、
```
$ rails server 0.0.0.0
```
で立ち上げると、http://localhost:3000 でアクセスできるようになる。