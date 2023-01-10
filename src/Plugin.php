<?php

namespace IdeHelperExtra;

use Cake\Core\BasePlugin;

class Plugin extends BasePlugin {

	/**
  * Plugin name.
  */
	protected ?string $name = 'IdeHelperExtra';

	/**
	 * @var bool
	 */
	protected bool $middlewareEnabled = false;

	/**
	 * @var bool
	 */
	protected bool $bootstrapEnabled = false;

	/**
	 * @var bool
	 */
	protected bool $routesEnabled = false;

	/**
	 * @var bool
	 */
	protected bool $consoleEnabled = false;

}
