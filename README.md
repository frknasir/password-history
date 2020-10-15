# Add password history to your laravel applications

[![Latest Version on Packagist](https://img.shields.io/packagist/v/starfolksoftware/password-history.svg?style=flat-square)](https://packagist.org/packages/starfolksoftware/password-history)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/starfolksoftware/password-history/run-tests?label=tests)](https://github.com/starfolksoftware/password-history/actions?query=workflow%3Arun-tests+branch%3Amaster)
[![Total Downloads](https://img.shields.io/packagist/dt/starfolksoftware/password-history.svg?style=flat-square)](https://packagist.org/packages/starfolksoftware/password-history)


Add password history to your laravel applications

## Installation

You can install the package via composer:

```bash
composer require starfolksoftware/password-history
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --provider="StarfolkSoftware\PasswordHistory\PasswordHistoryServiceProvider" --tag="migrations"
php artisan migrate
```

You can publish the config file with:
```bash
php artisan vendor:publish --provider="StarfolkSoftware\PasswordHistory\PasswordHistoryServiceProvider" --tag="config"
```

This is the contents of the published config file:

```php
[
    /*
    * When using the "HasPasswordHistory" trait from this package, we need to know which
    * Eloquent model should be used to retrieve your roles. Of course, it
    * is often just the "PasswordHistory" model but you may use whatever you like.
    *
    * The model you want to use as a PasswordHistory model needs to implement the
    * `StarfolkSoftware\PasswordHistory\Contracts\PasswordHistory` contract.
    */
    'password_history_class' => \StarfolkSoftware\PasswordHistory\PasswordHistory::class,

    /**
     * The table name for password histories.
     */
    'table_name' => 'password_histories',

    /**
     * The models password column name
     */
    'models_password_column_name' => 'password',

    /**
     * Password change can not be the same with any password in the last 
     * {{ password_history_check_length }} recent passwords
     */
    'password_history_check_length' => env('PASSWORD_HISTORY_CHECK_LENGTH', 5),

    /*
    * The user model that should be used. If null, the default user provider from your
    * Laravel authentication configuration will be used.
    */
    'user_model' => \Illuminate\Foundation\Auth\User::class,
]
```

## Usage

### Registering models

With this package, you can track password history of any model. To make your 
models `passwordhistorable`, add the `HasPasswordHistory` to the model classes as 
in the following

``` php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use StarfolkSoftware\PasswordHistory\Traits\HasPasswordHistory;

class User extends Model
{
    use HasPasswordHistory;
    ...
}
```

Password history is saved to the database the moment a `saved` event is fired on your model. Remember that also the `saved` event is fired when you first create a model.

### `NotInRecentPasswordHistory` validation rule

If you want to validate that a password is not in the recent password history, you 
can use the `NotInRecentPasswordHistory` rule as in the following snippet:

```php
use StarfolkSoftware\PasswordHistory\Rules\NotInRecentPasswordHistory;

validator(collect($model)->toArray(), [
    'password' => NotInRecentPasswordHistory::ofUser($model),
])->validate();
```

## Testing

``` bash
composer test
```

## Psalming

```bash
./vendor/bin/psalm --show-info=true
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Faruk Nasir](https://github.com/frknasir)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
