#  CakePHP IdeHelperExtra Plugin

[![CI](https://github.com/dereuromark/cakephp-ide-helper-extra/actions/workflows/ci.yml/badge.svg?branch=master)](https://github.com/dereuromark/cakephp-ide-helper-extra/actions/workflows/ci.yml?query=branch%3Amaster)
[![Coverage Status](https://img.shields.io/codecov/c/github/dereuromark/cakephp-ide-helper-extra/master.svg)](https://codecov.io/github/dereuromark/cakephp-ide-helper-extra/branch/master)
[![PHPStan](https://img.shields.io/badge/PHPStan-level%208-brightgreen.svg?style=flat)](https://phpstan.org/)
[![Latest Stable Version](https://poser.pugx.org/dereuromark/cakephp-ide-helper-extra/v/stable.svg)](https://packagist.org/packages/dereuromark/cakephp-ide-helper-extra)
[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%208.5-8892BF.svg)](https://php.net/)
[![License](https://poser.pugx.org/dereuromark/cakephp-ide-helper-extra/license.svg)](license)
[![Total Downloads](https://poser.pugx.org/dereuromark/cakephp-ide-helper-extra/d/total.svg)](https://packagist.org/packages/dereuromark/cakephp-ide-helper-extra)
[![Coding Standards](https://img.shields.io/badge/cs-PSR--2--R-purple.svg?style=flat-square)](https://github.com/php-fig-rectified/fig-rectified-standards)

IdeHelperExtra plugin for CakePHP applications.

- Provides useful Tasks/Addons for [IdeHelper](https://github.com/dereuromark/cakephp-ide-helper)

For older applications, see [version map](https://github.com/dereuromark/cakephp-ide-helper-extra/wiki#cakephp-version-map).

## Future API preparation

The `cake6` development branch targets CakePHP 6 and uses its matching IdeHelper branch. The `master` branch remains available for CakePHP 5.

Custom identifier tasks that override `addIdentifiers()` must declare `addIdentifiers(array $components, string $folder, ?string $plugin = null): array`. Custom authenticator tasks that override `addAuthenticators()` must declare its plugin parameter as `?string $plugin = null`. Subclasses that redeclare `IconRenderTask::$config` must use `protected array $config`. These declarations differ from the released contracts on `master`; existing applications should continue using a stable release.

## Tasks

- Authentication authenticator names and return types.
- Search filter names, including application and plugin filters.
- Legacy identifier and Tools icon tasks for existing integrations. These tasks are deprecated; the docs explain current alternatives.

Extra extends [CakePHP IdeHelper](https://dereuromark.github.io/cakephp-ide-helper/). It does not provide separate generator commands or annotation support.

## Documentation

Read the [documentation website](https://dereuromark.github.io/cakephp-ide-helper-extra/), starting with [Installation](https://dereuromark.github.io/cakephp-ide-helper-extra/guide/installation) and [Getting started](https://dereuromark.github.io/cakephp-ide-helper-extra/guide/getting-started).

The [parent IdeHelper docs](https://dereuromark.github.io/cakephp-ide-helper/) cover generator commands and editor setup. Additional tasks belong here when their integration should stay outside the parent plugin’s dependency list.
