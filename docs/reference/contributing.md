# Contributing

Install development dependencies, then run:

```sh
composer test
composer cs-check
composer stan-setup
composer stan
```

`stan-setup` installs PHPStan locally before analysis. CI checks PHP 8.2, PHP 8.5 and the lowest supported dependency versions.

## Add a task

Implement `IdeHelper\Generator\Task\TaskInterface` and return directives from `collect()`. Place integration-specific tasks under `src/<Plugin>/Generator/Task/` and test both generated directives and the current integration API. Optional plugins need coverage for loaded and absent states.

Register new tasks explicitly in application configuration. The parent plugin owns task construction, command execution and metadata output; see its [generator documentation](https://dereuromark.github.io/cakephp-ide-helper/).

## Icon fixtures

Legacy icon tests read committed files under `tests/test_files/Tools/`. The maintenance script `tests/test_files/update-test-files.php` copies assets from installed npm packages into those fixtures. Updating them can change a large number of expected icon names; review the resulting diff and run the icon tests before committing.

Repository CI runs through GitHub Actions. There is no configured Travis cron job.
