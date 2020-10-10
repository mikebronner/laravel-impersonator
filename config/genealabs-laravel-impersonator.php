<?php

return [
    'layout' => 'layouts.app',
    'content-section' => 'content',
    'user-model' => config('auth.providers.users.model'),
    'orderby-column' => 'name',
    'middleware' => ['web', 'auth'],
];
