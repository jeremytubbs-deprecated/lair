## Lair - Laravel Roles and Permissions

This Package provides migrations for roles and permissions, middleware for checking (roles, permissions, owns), blade extensions for @role and @owner, config for super_role and default_role, publishes basic views for auth (login, register, reset, password) and finally provides routes for auth.

I have created this to save myself time... Consider this a kitchen sink for auth.

### Standard Setup
Add the service provider to `config\app.php`
```
Jeremytubbs\Lair\LairServiceProvider::class,
```

Publish Lair `$ php artisan vendor:publish`


This package is some what based on [Jeffrey Way's](https://twitter.com/jeffrey_way) video on [Laracasts](https://laracasts.com/series/whats-new-in-laravel-5-1/episodes/16) and its [Github Repo](https://github.com/laracasts/laravel-5-roles-and-permissions-demo).


Todo -
- Add admin area for managing users/roles/permissions
- API for Auth