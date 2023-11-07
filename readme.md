#  CakePHP IdeHelperExtra Plugin

[![CI](https://github.com/dereuromark/cakephp-ide-helper-extra/actions/workflows/ci.yml/badge.svg?branch=master)](https://github.com/dereuromark/cakephp-ide-helper-extra/actions/workflows/ci.yml?query=branch%3Amaster)
[![Coverage Status](https://img.shields.io/codecov/c/github/dereuromark/cakephp-ide-helper-extra/master.svg)](https://codecov.io/github/dereuromark/cakephp-ide-helper-extra/branch/master)
[![Latest Stable Version](https://poser.pugx.org/dereuromark/cakephp-ide-helper-extra/v/stable.svg)](https://packagist.org/packages/dereuromark/cakephp-ide-helper-extra)
[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%208.1-8892BF.svg)](https://php.net/)
[![License](https://poser.pugx.org/dereuromark/cakephp-ide-helper-extra/license.png)](https://packagist.org/packages/dereuromark/cakephp-ide-helper-extra)
[![Total Downloads](https://poser.pugx.org/dereuromark/cakephp-ide-helper-extra/d/total.svg)](https://packagist.org/packages/dereuromark/cakephp-ide-helper-extra)

IdeHelperExtra plugin for CakePHP applications.

- Provides useful Tasks/Addons for [IdeHelper](https://github.com/dereuromark/cakephp-ide-helper)

This branch is for use with **CakePHP 5.0+**. For details see [version map](https://github.com/dereuromark/cakephp-ide-helper-extra/wiki#cakephp-version-map).

## Features

Supports IDE autocomplete/typehinting of (magic)strings as well as return types/values for:
- [Tools](https://github.com/dereuromark/cakephp-tools) plugin
    * IconHelper::render() and FontAwesome v4/v5/v6 or Bootstrap icons
- [Authentication](https://github.com/cakephp/authentication) plugin
    * AuthenticationService::loadIdentifier()
- ... and more (using PHPStorm meta file)

See [IdeHelper Wiki](https://github.com/dereuromark/cakephp-ide-helper-extra/wiki) for details and tips/settings.

You can submit your own tasks either inside your plugin or here as extra.

### Plugins with already included tasks and more
See https://github.com/dereuromark/cakephp-ide-helper/#plugins-with-meta-file-generator-tasks

### When to put addons in this plugin
The addons in this plugin aim to decouple the IdeHelper and other plugins. The dependency even as require-dev can sometimes not be desired.
So whenever you want to have the dependency not part of it, you can ask to put things here or make your own addon plugin of sorts.

### Install, Setup, Usage, Contribution
See the **[Docs](https://github.com/dereuromark/cakephp-ide-helper-extra/tree/master/docs)** for details.
