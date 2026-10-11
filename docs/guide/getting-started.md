# Getting started

Complete [Installation](./installation). This example adds PhpStorm metadata for an existing CakePHP Authentication integration. It does not change authentication behavior.

## Register one task

In `config/app_local.php`, add this entry to the configuration array returned by the file. Put the `use` declaration above the return statement:

```php
use IdeHelperExtra\Authentication\Generator\Task\AuthServiceLoadAuthenticatorTask;

return [
    // Keep your other application configuration here.
    'IdeHelper' => [
        'generatorTasks' => [
            AuthServiceLoadAuthenticatorTask::class => AuthServiceLoadAuthenticatorTask::class,
        ],
    ],
];
```

Merge this task into any existing `IdeHelper.generatorTasks` configuration. Other parent tasks remain enabled unless you disable them explicitly.

## Generate the metadata

The parent’s default tasks also inspect database metadata. Use your application’s configured database connection, or disable its database tasks as described in the [parent docs](https://dereuromark.github.io/cakephp-ide-helper/generator/tasks).

From the application root:

```sh
bin/cake generate phpstorm
```

The parent command writes `.phpstorm.meta.php/.ide-helper.meta.php` inside the application root. Regenerate it after adding or renaming classes. The plugin scans authenticator files in your application and discoverable plugin paths; `src/Authenticator/CustomAuthenticator.php` supplies the name `Custom` when its class can be resolved. Plugin classes use aliases such as `Authentication.Form`.

## Check completion

In PhpStorm, open code that calls your authentication service:

```php
$service->loadAuthenticator('Custom');
```

Replace `Custom` with the name of an authenticator your application actually provides. The generated metadata supplies its corresponding class as the return type. Keep the metadata file inside the indexed project. If completion is missing, inspect it for `AuthenticationService::loadAuthenticator(0)` and your class name, then check the [parent editor setup](https://dereuromark.github.io/cakephp-ide-helper/).

Extra provides PhpStorm metadata, not a runtime authenticator or a replacement for the Authentication plugin. For filter-name completion, configure the [Search task](/reference/tasks#search-filters) instead.
