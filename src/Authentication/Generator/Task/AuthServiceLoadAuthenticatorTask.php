<?php

declare(strict_types=1);

namespace IdeHelperExtra\Authentication\Generator\Task;

use IdeHelper\Filesystem\Folder;
use IdeHelper\Generator\Directive\Override;
use IdeHelper\Generator\Task\TaskInterface;
use IdeHelper\Utility\App;
use IdeHelper\Utility\AppPath;
use IdeHelper\Utility\Plugin;
use IdeHelper\ValueObject\ClassName;

class AuthServiceLoadAuthenticatorTask implements TaskInterface {

	/**
	 * @return array<\IdeHelper\Generator\Directive\BaseDirective>
	 */
	public function collect(): array {
		$method = '\Authentication\AuthenticationService::loadAuthenticator(0)';

		$map = [];
		$authenticators = $this->collectAuthenticators();
		foreach ($authenticators as $name => $className) {
			$map[$name] = ClassName::create($className);
		}

		if (!$map) {
			return [];
		}

		ksort($map);

		$directive = new Override($method, $map);

		return [$directive->key() => $directive];
	}

	/**
	 * @return array<string, string>
	 */
	protected function collectAuthenticators(): array {
		$authenticators = [];

		$folders = AppPath::get('Authenticator');
		foreach ($folders as $folder) {
			$authenticators = $this->addAuthenticators($authenticators, $folder);
		}

		$plugins = Plugin::all();
		foreach ($plugins as $plugin) {
			$folders = AppPath::get('Authenticator', $plugin);
			foreach ($folders as $folder) {
				$authenticators = $this->addAuthenticators($authenticators, $folder, $plugin);
			}
		}

		return $authenticators;
	}

	/**
	 * @param array<string, string> $authenticators
	 * @param string $folder
	 * @param string|null $plugin
	 * @return array<string, string>
	 */
	protected function addAuthenticators(array $authenticators, string $folder, $plugin = null): array {
		$folderContent = (new Folder($folder))->read(Folder::SORT_NAME, true);

		foreach ($folderContent[1] as $file) {
			preg_match('/^(.+)Authenticator\.php$/', $file, $matches);
			if (!$matches) {
				continue;
			}
			$name = $matches[1];
			if ($name === 'Abstract') {
				continue;
			}

			if ($plugin) {
				$name = $plugin . '.' . $name;
			}

			$className = App::className($name, 'Authenticator', 'Authenticator');
			if (!$className) {
				continue;
			}

			$authenticators[$name] = $className;
		}

		return $authenticators;
	}

}
