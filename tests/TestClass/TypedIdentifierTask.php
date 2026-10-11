<?php

declare(strict_types=1);

namespace IdeHelperExtra\Test\TestClass;

use IdeHelperExtra\Authentication\Generator\Task\AuthServiceLoadIdentifierTask;

class TypedIdentifierTask extends AuthServiceLoadIdentifierTask {

	/**
	 * @param array<string, string> $components
	 * @param string $folder
	 * @param string|null $plugin
	 * @return array<string, string>
	 */
	protected function addIdentifiers(array $components, string $folder, ?string $plugin = null): array {
		return [];
	}

}
