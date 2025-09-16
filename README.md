# CodeIgniter 3 Starter
> A PHP Application Project Starter with CodeIgniter 3

## Fatures
- Security Improvement, with changing index.php (root document) to public directory
- Dynamic Base URL
- [HMVC / Modular Extensions](https://github.com/sunuazizrahayu/CodeIgniter-HMVC-Modular-Extension)
- Config with `.env` ([phpdotenv](https://github.com/vlucas/phpdotenv))
- [Database Migration](https://github.com/sunuazizrahayu/CodeIgniter-Migration-CLI)
- Send email with background process
- Blade Template Engine, with [Slice-Library](https://github.com/GustMartins/Slice-Library)
- Storage Library (upload file)
- Multi Language & Auto Translate
- Laravel-Like Routes
- User Auth
  - Login
  - Register (with activation link)
  - Register Account Activation
  - Resend Activation
  - Forgot Password

## Requirements
- PHP 8.0 or 8.1
- Composer
> It is recommended to run this application using [Docker](#docker).

### Docker
1. Copy `docker-compose.example.yml` to `docker-compose.yml`
2. Run docker image with `docker-compose -f docker-compose.example.yml up -d`
3. Open `http://127.0.0.1:8080` or `http://127.0.0.1:8081`


## Tips
- All Controller must be use `MY_Controller`
- Make sure `public/storage` have chown `www-data:www-data`