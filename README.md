# captcha-repository
captcha-repository for laravel or lumen

## Configuration

Install package `composer require "superman2014/captcha-repository:1.0.x@dev"`

### Laravel

Open config/app.php and register the required service provider above your application providers.

```
'providers' => [
    Superman2014\CaptchaRepository\CaptchaServiceProvider::class,
]
```
If you'd like to make configuration changes in the configuration file you can pubish it with the following Aritsan command:

```
php artisan vendor:publish --provider="Superman2014\CaptchaRepository\CaptchaServiceProvider"
```

### Lumen

Open bootstrap/app.php and register the required service provider.

```
$app->register(Superman2014\CaptchaRepository\CaptchaServiceProvider::class);
```
