# Installation

Install this development add-on in your application:

```sh
composer require --dev dereuromark/cakephp-ide-helper-extra
```

Composer installs the required [IdeHelper plugin](https://dereuromark.github.io/cakephp-ide-helper/) too. The [dependency manifest](https://github.com/dereuromark/cakephp-ide-helper-extra/blob/master/composer.json) defines supported PHP and CakePHP versions. For an older application, see the [version map](https://github.com/dereuromark/cakephp-ide-helper-extra/wiki#cakephp-version-map).

## Load the development plugins

In `src/Application.php`, inside `bootstrap()` after `parent::bootstrap()`:

```php
if (PHP_SAPI === 'cli' && class_exists(\IdeHelper\IdeHelperPlugin::class)) {
    $this->addPlugin('IdeHelper');
}
```

Register IdeHelper once. If you already load it, keep that existing development block. The class check allows production installs made with `composer install --no-dev` to bootstrap without these packages.

Extra has no routes, middleware, bootstrap configuration or commands. Composer autoloading and explicit task configuration are sufficient. Registering `IdeHelperExtra` as a CakePHP plugin is optional; it does not discover or enable tasks automatically.

## Choose an integration

Authentication and Search are separate application plugins. Install and configure the integration you use through its own documentation:

- [CakePHP Authentication](https://book.cakephp.org/authentication/3/en/)
- [FriendsOfCake Search](https://github.com/FriendsOfCake/search)

Extra does not add these packages to your production dependencies. The [beginner example](./getting-started) uses a custom authenticator class that already exists in your application.
