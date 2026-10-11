# Installation

Install this development add-on in your application:

```sh
composer require --dev dereuromark/cakephp-ide-helper-extra
```

Composer installs the required [IdeHelper plugin](https://dereuromark.github.io/cakephp-ide-helper/) too. The [dependency manifest](https://github.com/dereuromark/cakephp-ide-helper-extra/blob/master/composer.json) defines supported PHP and CakePHP versions. For an older application, see the [version map](https://github.com/dereuromark/cakephp-ide-helper-extra/wiki#cakephp-version-map).

## Load the development plugins

In `src/Application.php`, inside `bootstrap()` after `parent::bootstrap()`:

```php
if (PHP_SAPI === 'cli' && class_exists(\IdeHelperExtra\IdeHelperExtraPlugin::class)) {
    $this->addPlugin('IdeHelper');
    $this->addPlugin('IdeHelperExtra');
}
```

Register each plugin once. If you already load IdeHelper, add only the Extra registration to that existing development block. The class check allows production installs made with `composer install --no-dev` to bootstrap without these packages.

Extra has no routes, middleware, bootstrap configuration or commands. Loading it makes its namespace available to the parent plugin’s task discovery; tasks still need explicit configuration.

## Choose an integration

Authentication and Search are separate application plugins. Install and configure the integration you use through its own documentation:

- [CakePHP Authentication](https://book.cakephp.org/authentication/3/en/)
- [FriendsOfCake Search](https://github.com/FriendsOfCake/search)

Extra does not add these packages to your production dependencies. The [beginner example](./getting-started) uses a custom authenticator class that already exists in your application.
