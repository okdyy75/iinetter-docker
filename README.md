# iinetter-docker
いいねがたくさんできるtwitter風SNS  

### サービス
https://iinetter.herokuapp.com  

テストアカウント  
Email：test@example.com  
Password：password  

### 管理画面
https://adm-iinetter.herokuapp.com/login

### Swagger API
https://adm-iinetter.herokuapp.com/api/docs  

簡単な仕様
- ツイートするにはログイン必須
- 各ユーザーのタイムラインは未ログインで閲覧可能
- アカウント名・メールアドレスの変更。アカウントの削除が不可（ツイートは削除可能）
- 出来ること：アカウント登録・ツイート・リツイート・返信・いいね
- 出来ないこと：フォロー・ツイート検索・DM・ブックマーク・etc...（終わりが見えなかったので）
- 管理画面はadmin権限を付与したユーザーのみログイン可

# 使用環境・ツール
- PostgreSQL 12.5
- PHP 8.0
- Laravel 8.12
- laravel-generator 8.0.x-dev
- adminlte-templates 8.0.x-dev
- Swagger 2.0
- Nuxt 2.14 (Vue 2.6)
- ※Heroku(本番)だとapacheを使用

## About
ルートディレクトリ  
バックエンド：iinetter-docker/web/iinetter  
フロントエンド：iinetter-docker/web/iinetter/frontend  


# Heroku環境構築
フロントエンドとバックエンドをappごと分ける

フロントエンド
----------
- 参考：https://ja.nuxtjs.org/faq/heroku-deployment/
- buildpackでnodejsを追加

事前にconfig設定
```
heroku config:set -a iinetter HOST=0.0.0.0
heroku config:set -a iinetter NODE_ENV=production
heroku config:set -a iinetter NPM_CONFIG_PRODUCTION=false
```

```
# デプロイ
git subtree push --prefix web/iinetter/frontend front-heroku main
git push front-heroku `git subtree split --prefix web/iinetter/frontend main`:main --force

```

バックエンド
----------
- addonsからpostgreを選択（容量1GB使えるので）
- buildpackでphpを設定

事前にconfig設定
```
heroku config:set -a adm-iinetter APP_NAME=IInetter
heroku config:set -a adm-iinetter APP_KEY=$(php artisan key:generate --show)
heroku config:set -a adm-iinetter APP_URL=https://adm-iinetter.herokuapp.com
heroku config:set -a adm-iinetter DB_CONNECTION=pgsql
heroku config:set -a adm-iinetter DB_HOST=xxxxxxxxxx
heroku config:set -a adm-iinetter DB_PORT=xxxx
heroku config:set -a adm-iinetter DB_DATABASE=xxxxxxxxxx
heroku config:set -a adm-iinetter DB_USERNAME=xxxxxxxxxx
heroku config:set -a adm-iinetter DB_PASSWORD=xxxxxxxxxxxxxxxxxxxx
```

```
# 初期データ投入
heroku run -a adm-iinetter php artisan migrate:fresh --seed --force

# デプロイ
git subtree push --prefix web/iinetter adm-heroku main
git push adm-heroku `git subtree split --prefix web/iinetter main`:main --force

```