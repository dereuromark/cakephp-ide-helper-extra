<?php

declare(strict_types=1);

namespace IdeHelperExtra\Test\TestClass;

use IdeHelperExtra\Tools\Generator\Task\IconRenderTask;

class TypedIconTask extends IconRenderTask {

	/**
	 * @var array<string, mixed>
	 */
	protected array $config;

	public function configuration(): array {
		return $this->config;
	}

}
