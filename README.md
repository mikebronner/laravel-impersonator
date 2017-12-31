# Laravel Impersonator

[![Join the chat at https://gitter.im/GeneaLabs/laravel-impersonator](https://badges.gitter.im/GeneaLabs/laravel-impersonator.svg)](https://gitter.im/GeneaLabs/laravel-impersonator?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge)
[![Travis](https://img.shields.io/travis/GeneaLabs/laravel-impersonator.svg)](https://travis-ci.org/GeneaLabs/laravel-impersonator)
[![Coveralls](https://img.shields.io/coveralls/GeneaLabs/laravel-impersonator.svg)](https://coveralls.io/github/GeneaLabs/laravel-impersonator)

## Pre-requisites
- Bootstrap 3 (4 coming soon)
- Laravel 5.5
- PHP 7.0+

## Installation
If you are using Larvel 5.4, please switch to the
[laravel-5.4 branch](https://github.com/GeneaLabs/laravel-impersonator/tree/laravel-5.4)
and follow the instructions there.

```sh
composer require genealabs/laravel-impersonator
```

This package will be auto-loaded by Laravel 5.5, it is not necessary to register
any service providers or aliases for this package.

## Configuration
- `genealabs-laravel-impersonator.layout`: master blade layout view for your application (default `layouts.app`).
- `genealabs-laravel-impersonator.content-section`: name of content section in master layout blade view (default `content`).
- `genealabs-laravel-impersonator.user-model`: user model of your application (default `config('auth.providers.users.model')`).

If you need to customize these settings:
```sh
php artisan impersonator:publish --config
```

## Usage
1. Add trait `GeneaLabs\LaravelImpersonator\Traits\Impersonatable` to your user model.
2. Override trait method `public function getCanImpersonateAttribute() : bool` that determines if a given user can impersonate other users.
3. (optional) Override trait method `public function getCanBeImpersonatedAttribute() : bool` that determines if a given user can be impersonated.
4. (optional) Use view partial `genealabs-laravel-impersonator::partials.end-impersonation-or-logout` in user drop-down menu to allow ending of impersonation session or logging out if user is not being impersonated.
5. Use `route('impersonatees.index')` to view a list of all impersonatable users and choose one to impersonate in you menu in the following manner:
```php
@if(auth()->check() && (auth()->user()->canImpersonate ?? false) && ! session('impersonator'))
    <li><a href="{{ route('impersonatees.index') }}">Impersonator</a></li>
@endif
```

## Customization
```sh
php artisan impersonator:publish --views
```

## Credits
In large part prodded and inspired by LaraCasts' tutorial: https://laracasts.com/series/how-do-i/episodes/17. Thank you @JeffreyWay!
