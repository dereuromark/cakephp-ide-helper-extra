# Legacy icon task

`IdeHelperExtra\Tools\Generator\Task\IconRenderTask` is deprecated. For new applications, use the icon helper and generator integration provided by [CakePHP Templating](https://github.com/dereuromark/cakephp-templating).

The legacy task needs the Tools plugin’s `Tools\View\Helper\IconHelper`. Tools is optional for consumers of Extra; installing Extra does not install it as a production dependency.

## Register the legacy task

Add this entry to your configuration array if your application still uses that helper:

```php
use IdeHelperExtra\Tools\Generator\Task\IconRenderTask;

return [
    'IdeHelper' => [
        'generatorTasks' => [
            IconRenderTask::class => IconRenderTask::class,
        ],
    ],
];
```

The task reads `Configure::read('Icon')`. It collects names from the configured icon sets, aliases in `Icon.map`, and unprefixed names from the first set when `autoPrefix` is enabled. Configure paths and sets according to your installed Tools version; bundled test data is not installed into your application’s icon configuration.

The generated `icons` argument set supplies completion for the first argument of `IconHelper::render()`.

![Legacy icon rendering completion](/icon-render.png)

For all other generator behavior, see the [parent docs](https://dereuromark.github.io/cakephp-ide-helper/).
