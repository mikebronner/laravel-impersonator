# Laravel Impersonator

## Pre-requisites
- Bootstrap 3 (4 coming soon)
- Laravel 5.4+

## Installation
```sh
composer require genealabs/laravel-impersonator
```

Add service provider to your application:
```php
// 'providers' => [
    GeneaLabs\LaravelImpersonator\Providers\LaravelImpersonatorService::class,
// ],
```

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
4. (optional) Use view partial `genealabs-laravel-impersonator::partials.end-impersonation-or-logout` in user drop-down menu to allow existing of impersonation session or logging out if user is not being impersonated.
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

## ToDo Items
- Cache and clear session before impersonating user.
- Restore original session after exiting an impersonation session.
