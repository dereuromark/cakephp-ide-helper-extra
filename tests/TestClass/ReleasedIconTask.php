<?php

declare(strict_types=1);

namespace IdeHelperExtra\Test\TestClass;

use IdeHelperExtra\Tools\Generator\Task\IconRenderTask;

class ReleasedIconTask extends IconRenderTask {

	/**
	 * @var array<string, mixed>
	 */
	protected $config;

	public function configuration(): array {
		return $this->config;
	}

}
