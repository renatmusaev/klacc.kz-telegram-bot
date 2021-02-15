# Brandenburg

Laravel Authorization Package

[![Latest Version on Packagist](https://img.shields.io/packagist/v/Silvanite/brandenburg.svg?style=for-the-badge)](https://packagist.org/packages/silvanite/brandenburg)
[![Build Status](https://img.shields.io/travis/Silvanite/brandenburg/master.svg?style=for-the-badge)](https://travis-ci.org/Silvanite/brandenburg)

A opinionated Authorization package to closely integrate with standard Laravel Gates. It differs from other authorization packages by using hard-coded permissions defined within gate policies, rather than duplicating them within the Database.

TLDR; This package provides Users with Roles which are granted access to permissions (Laravel Gates).

## Version compatibility

| Laravel | Brandenburg |
| ------- | ----------- |
| <=5.7.x | 1.1.x       |
| >=5.8.x | 1.2.x       |
| ^6.0    | 1.3.x       |
| ^7.0    | 1.4.x       |
| ^8.0    | 1.5.x       |

## Installation

```sh
composer require silvanite/brandenburg
```

This package uses auto-loading in Laravel 5.5 of both the service provider and the `BrandenburgPolicy` Facade

For Laravel 5.1 - 5.4 load the Service Provider and Facade.

```php
// config/app.php
'providers' => [
    ...
    Silvanite\Brandenburg\Providers\BrandenburgServiceProvider::class,
];

'aliases' => [
    ...
    'BrandenburgPolicy' => Silvanite\Brandenburg\Facades\PolicyFacade::class,
],
```

Three additional tables are required to enable User Roles. These will be installed automatically when you run the migrations. See the migration in this repository's source code for details about the tables created.

```sh
php artisan migrate
```

If you are not going to use Brandenburg's default migrations, you should change the `ignoreMigrations` option in the configuration file. You may export the default migrations using:

```sh
php artisan vendor:publish --tag=brandenburg-config
```

## Usage

This package provides two traits. The main trait is intended for your user model which enabled model relationships.

```php
use Silvanite\Brandenburg\Traits\HasRoles;

class User
{
    use HasRoles;
    ...
}
```

The second Trait `ValidatesPermissions` can optionally be used in your AuthServiceProvider when writing Gates. It can be used to stop users from getting locked out or to make some permissions optional by allowing access to a permission if no user in the system has been given access to it.

```php
// AuthServiceProvider.php

if ($this->nobodyHasAccess('create-articles')) {
    return true;
};

// Check if the user has access
...
```

### Creating Roles

Use the `Silvanite\Brandenburg\Role` model to create and manage user roles.

```php
$editor = Silvanite\Brandenburg\Role::create([
    'name' => 'Editor',
    'slug' => 'editor',
]);
```

### Creating Permissions

All Gates defined within your application will automatically be available as Permissions, there is no need/way to create these specifically in the database. Please see the [Laravel Gates documentation](https://laravel.com/docs/5.5/authorization#writing-gates) for additional information.

### Managing Roles and Permissions

All permissions are assigned by providing the key defined by your Gate. They can be granted and revoked.

```php
// Grant access
$editor->grant('create-articles');

// Revoke access
$editor->revoke('create-articles');
```

A couple of additional helper methods provide a convenient way to manage permissions.

```php
// Grant access to a set of permissions and remove all other permissions
$editor->setPermissions([
    'create-articles',
    'read-articles',
    'update-articles',
    'delete-articles',
]);

// Revoke all permissions
$editor->revokeAll();
```

You can see which permissions a given role has by accessing the `permissions` attribute.

```php
$editorPermissions = $editor->permissions;

// returns ['create-articles', 'read-articles', 'update-articles', 'delete-articles']
```

### Assigning/Removing Roles

Roles can be assigned/removed directly from the User model (provided the `HasRoles` trait is used). You can either pass in the `Role` model or the slug of the role.

```php
// Using slug
$user->assignRole('editor');
$user->removeRole('editor');

// Using model
use Silvanite\Brandenburg\Role;

$user->assignRole(Role::first());
$user->removeRole(Role::first());
```

There is also a helper method to sync roles (or you can simply use the eloquent relationship itself).

```php
$user->setRolesById([1, 3, 4]);

// Same as
$user->roles()->sync([1, 3, 4]);
```

### Validating Access Rights

Within your Gate definition you can validate if a given user has access to a specific permission, which will be based on the user Role(s).

```php
$canCreateArticle = $user->hasRoleWithPermission('create-articles');
```

Outside of your Gate definitions you should use the standard Laravel Gate methods and helpers to check if a user has access rights. See the [Laravel Documentation](https://laravel.com/docs/5.5/authorization#authorizing-actions-via-gates) for more details.

## Contributing

1. Fork it!
2. Create your feature branch: `git checkout -b my-new-feature`
3. Commit your changes: `git commit -am 'Add some feature'`
4. Run the tests: `./vendor/bin/phpunit`
5. Push to the branch: `git push origin my-new-feature`
6. Submit a pull request

## Support

If you require any support please contact me on [Twitter](https://twitter.com/m2de_io) or open an issue on this repository.

## License

GPL
