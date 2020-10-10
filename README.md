![Laravel Package](https://github.com/GeneaLabs/laravel-impersonator/workflows/Laravel%20Package/badge.svg?branch=master)
[![codecov](https://codecov.io/gh/GeneaLabs/laravel-impersonator/branch/master/graph/badge.svg)](https://codecov.io/gh/GeneaLabs/laravel-impersonator)

# Impersonator for Laravel

![Impersonator for Laravel masthead image.](https://repository-images.githubusercontent.com/90768538/6b44c600-f29c-11e9-88af-65e839679460)

## Supporting This Package
This is an MIT-licensed open source project with its ongoing development made possible by the support of the community. If you'd like to support this, and our other packages, please consider [becoming a backer or sponsor on Patreon](https://www.patreon.com/mikebronner).

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
- `genealabs-laravel-impersonator.middleware`: the middleware to use for the impersonatee routes (default: `['web', 'auth']`). You may specify `only` or `except` parameters. E.g. `['web', 'auth', 'password.confirm' => ['except' => 'destroy']]`

If you need to customize these settings:
```sh
php artisan impersonator:publish --config
```

## Usage
1. Add trait `GeneaLabs\LaravelImpersonator\Traits\Impersonatable` to your user model.
2. Override trait method `public function getCanImpersonateAttribute() : bool` that determines if a given user can impersonate other users.
3. (optional) Override trait method `public function getCanBeImpersonatedAttribute() : bool` that determines if a given user can be impersonated.
4. Use `route('impersonatees.index')` to view a list of all impersonatable users.
You could add something like the following to your menu:
  ```php
  @if ((auth()->user()->canImpersonate ?? false) && ! session('impersonator'))
      <a class="dropdown-item" href="{{ route('impersonatees.index') }}">Impersonator</a>
  @endif
  ```

5. (optional) Add something like the following to your menu view to allow
imporsonator to stop impersonating:
  ```php
  @if (session('impersonator'))
      <a href="{{ url('/logout') }}"
          class="dropdown-item"
          onclick="event.preventDefault(); document.getElementById('end-personation-session-form').submit();"
      >
          End Impersonation Session
      </a>
      <form action="{{ route('impersonatees.destroy', auth()->user()) }}"
          method="POST"
          style="display: none;"
          id="end-personation-session-form"
      >
          {{ csrf_field () }}
          {{ method_field ('DELETE') }}
      </form>
  @else
      <a href="{!! route('logout') !!}"
          class="dropdown-item"
          onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
          Logout
      </a>
      <form method="POST"
          action="{{ route('logout') }}"
          accept-charset="UTF-8"
          id="logout-form"
          style="display:none;"
      >
          {{ csrf_field () }}
      </form>
  @endif
  ```

## Customization
```sh
php artisan impersonator:publish --views
```

## Credits
In large part prodded and inspired by LaraCasts' tutorial: https://laracasts.com/series/how-do-i/episodes/17. Thank you @JeffreyWay!
