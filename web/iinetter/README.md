
## バックエンド
http://localhost  

swagger確認  
http://localhost/api/docs


### 基本コマンド
```
# とりあえずCRUD作成
php artisan infyom:scaffold Xxxxx

# ファイルからCRUD作成
php artisan infyom:scaffold Xxxxx --fieldsFile=Xxxxx.json

# ファイルからapi作成
php artisan infyom:api Xxxxx --fieldsFile=Xxxxx.json --prefix=v1

# テーブルからCRUD作成
php artisan infyom:scaffold User --fromTable --tableName=xxxxx

```

### schema作成時のプロパティ
```
{
    // カラム名
    "name": "user_id",
    // カラム定義
    "dbType": "bigInteger:unsigned:foreign,users,id",
    // 入力フォームのタイプ
    "htmlType": "",
    // バリデーション
    "validations": "",
    // トップの検索から引っかかるか
    "searchable": false,
    // 入力許可
    "fillable": true,
    // プライマリーキーか
    "primary": false,
    // フォーム表示
    "inForm": false,
    // 一覧ページに表示するか
    "inIndex": true,
    // 詳細ページに表示するか
    "inView": true
},
```

サンプルスキーマ参考  
vendor/infyomlabs/laravel-generator/samples/fields_sample.json  

リレーション周りはソースを参考に  
vendor/infyomlabs/laravel-generator/src/Common/GeneratorFieldRelation.php  


### テーブル設計
```
users
------------------
id
is_admin
name
email
email_verified_at
password
remember_token
api_token
created_at
updated_at

user_profiles
------------------
id
screen_name
description
location
url
icon
header_image
created_at
updated_at

tweets
------------------
id
user_id
ref_tweet_id
tweet_type
tweet_text
reply_count
retweet_count
favorite_count
created_at
updated_at
deleted_at
```


## フロントエンド
- SSR
- typescript導入したが、補完が上手くいかなかったのでほぼ使用せず

nuxt作成時
```
npm init nuxt-app frontend

create-nuxt-app v3.4.0
✨  Generating Nuxt.js project in frontend
? Project name: iinetter
? Programming language: TypeScript
? Package manager: Npm
? UI framework: Bootstrap Vue
? Nuxt.js modules: Axios
? Linting tools: ESLint
? Testing framework: None
? Rendering mode: Single Page App
? Deployment target: Static (Static/JAMStack hosting)
? Development tools: (Press <space> to select, <a> to toggle all, <i> to invert selection)
? Continuous integration: GitHub Actions (GitHub only)
? What is your GitHub username? okdyy75
? Version control system: None
```


以下初期README
----------------------------------------------------------------------------------------------------
<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains over 1500 video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the Laravel [Patreon page](https://patreon.com/taylorotwell).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Cubet Techno Labs](https://cubettech.com)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[Many](https://www.many.co.uk)**
- **[Webdock, Fast VPS Hosting](https://www.webdock.io/en)**
- **[DevSquad](https://devsquad.com)**
- **[Curotec](https://www.curotec.com/)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
