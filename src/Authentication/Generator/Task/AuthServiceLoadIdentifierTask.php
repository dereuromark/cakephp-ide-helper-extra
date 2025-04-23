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

class AuthServiceLoadIdentifierTask implements TaskInterface {

	/**
	 * @return array<\IdeHelper\Generator\Directive\BaseDirective>
	 */
	public function collect(): array {
		$method = '\Authentication\Identifier\IdentifierCollection::load(0)';

		$map = [];

		$identifiers = $this->collectIdentifiers();
		foreach ($identifiers as $name => $className) {
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
	protected function collectIdentifiers(): array {
		$identifiers = [];

		$folders = AppPath::get('Identifier');
		foreach ($folders as $folder) {
			$identifiers = $this->addIdentifiers($identifiers, $folder);
		}

		$plugins = Plugin::all();
		foreach ($plugins as $plugin) {
			$folders = AppPath::get('Identifier', $plugin);
			foreach ($folders as $folder) {
				$identifiers = $this->addIdentifiers($identifiers, $folder, $plugin);
			}
		}

		return $identifiers;
	}

	/**
	 * @param array<string> $components
	 * @param string $folder
	 * @param string|null $plugin
	 *
	 * @return array<string>
	 */
	protected function addIdentifiers(array $components, $folder, $plugin = null) {
		$folderContent = (new Folder($folder))->read(Folder::SORT_NAME, true);

		foreach ($folderContent[1] as $file) {
			preg_match('/^(.+)Identifier\.php$/', $file, $matches);
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

			$className = App::className($name, 'Identifier', 'Identifier');
			if (!$className) {
				continue;
			}

			$components[$name] = $className;
		}

		return $components;
	}

}
