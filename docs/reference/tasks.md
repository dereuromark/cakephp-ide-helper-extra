# Tasks and configuration

Tasks are opt-in entries under `IdeHelper.generatorTasks`. The parent collection accepts a task class name or an already constructed `TaskInterface` instance. Constructor options belong in a task instance; a nested options array is not supported.

Configuration examples are entries inside the array returned by your app configuration file. Keep the `use` declarations above that return statement.

## Authenticators

`AuthServiceLoadAuthenticatorTask` generates return-type overrides for `Authentication\AuthenticationService::loadAuthenticator(0)`.

It scans `Authenticator` directories in the application and discoverable plugins, resolves filenames ending in `Authenticator.php`, excludes `AbstractAuthenticator.php`, and sorts the resulting aliases. It returns no directive if no classes can be resolved.

```php
use IdeHelperExtra\Authentication\Generator\Task\AuthServiceLoadAuthenticatorTask;

return [
    'IdeHelper' => [
        'generatorTasks' => [
            AuthServiceLoadAuthenticatorTask::class => AuthServiceLoadAuthenticatorTask::class,
        ],
    ],
];
```

## Search filters

`SearchManagerAddFilterTask` generates expected values for the second argument of `Search\Manager::add()`.

Load your application’s Search plugin before generating metadata. When Search is not loaded, this task returns no directives. It scans `Model/Filter` directories in the application and discoverable plugins, excluding base, collection, interface and trait filenames. Plugin filters use dotted aliases.

```php
use IdeHelperExtra\Search\Generator\Task\SearchManagerAddFilterTask;

return [
    'IdeHelper' => [
        'generatorTasks' => [
            SearchManagerAddFilterTask::class => class_exists(SearchManagerAddFilterTask::class)
                ? new SearchManagerAddFilterTask(includeDefaultFilters: false)
                : false,
        ],
    ],
];
```

The `class_exists()` guard keeps this configuration safe when production installs omit development packages.

The default is `true`, which includes `Search.Boolean`, `Search.Callback`, `Search.Compare`, `Search.Exists`, `Search.Finder`, `Search.Like` and `Search.Value`. The scanner also includes other installed Search filters, such as `Search.Mapped`. Setting it to `false` skips all filters shipped in the Search plugin, including future additions; application filters and filters in other plugins remain available. An empty result produces no directive.

The task provides name completion for `Search\Manager::add()`, not return-type overrides or filter validation. It does not add completion to `Search\Model\Filter\FilterCollection::add()`, even though that method accepts the same filter argument.

## Identifier factory

`AuthServiceLoadIdentifierTask` generates return-type overrides for `Authentication\Identifier\IdentifierFactory::create(0)` by scanning `Identifier` directories. Its class name is retained, but the generated target follows Authentication 5.

The factory accepts a string alias, configuration array or existing identifier. These overrides apply to string aliases. See the [Authentication 5 documentation](https://book.cakephp.org/authentication/5/) for configuring identifiers on authenticators.

```php
use IdeHelperExtra\Authentication\Generator\Task\AuthServiceLoadIdentifierTask;

return [
    'IdeHelper' => [
        'generatorTasks' => [
            AuthServiceLoadIdentifierTask::class => AuthServiceLoadIdentifierTask::class,
        ],
    ],
];
```
