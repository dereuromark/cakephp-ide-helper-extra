<?php

declare(strict_types=1);

namespace IdeHelperExtra\Test\TestClass;

use IdeHelperExtra\Authentication\Generator\Task\AuthServiceLoadAuthenticatorTask;

class TypedAuthenticatorTask extends AuthServiceLoadAuthenticatorTask {

	/**
	 * @param array<string, string> $components
	 * @param string $folder
	 * @param string|null $plugin
	 * @return array<string, string>
	 */
	protected function addAuthenticators(array $components, string $folder, ?string $plugin = null): array {
		return [];
	}

}
