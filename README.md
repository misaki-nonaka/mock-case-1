# お問い合わせフォーム

## 環境構築
- Dockerビルド  
    ・git clone git@github.com:misaki-nonaka/mock-case-1.git  
    ・cp src/.env.example .env  
    ・docker-compose up -d --build  

- Laravel環境構築  
    ・cp src/.env.example src/.env　、適宜環境変数変更  
    ・docker-compose exec php bash  
    ・composer install  
    ・php artisan key:generate  
    ・php artisan migrate  
    ・php artisan db:seed  

- 開発環境  
    ・お問い合わせ画面：http://localhost/  
    ・ユーザー登録：http://localhost/register  
    ・phpMyAdmin：http://localhost:8080/  

## 使用技術(実行環境)
・PHP 8.4.13  
・Laravel 8.83.8  
・MySQL 8.0.26  
・nginx 1.21.1  
・phpMyAdmin 5.2.3  

## ER図
/home/misaki/coachtech/laravel/mock-case-1_flea-market/ER.drawio.png


## Stripe CLIの導入を書くこと