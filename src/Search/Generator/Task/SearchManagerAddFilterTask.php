<?php

declare(strict_types=1);

namespace IdeHelperExtra\Search\Generator\Task;

use Cake\Core\Plugin;
use IdeHelper\Filesystem\Folder;
use IdeHelper\Generator\Directive\ExpectedArguments;
use IdeHelper\Generator\Task\TaskInterface;
use IdeHelper\Utility\App;
use IdeHelper\Utility\AppPath;
use IdeHelper\Utility\Plugin as PluginUtility;
use IdeHelper\ValueObject\StringName;

class SearchManagerAddFilterTask implements TaskInterface {

	/**
	 * @var list<string>
	 */
	protected array $defaultFilters = [
		'Search.Boolean',
		'Search.Callback',
		'Search.Compare',
		'Search.Exists',
		'Search.Finder',
		'Search.Like',
		'Search.Value',
	];

	/**
	 * @param bool $includeDefaultFilters Include built-in filters that are also available as fluent methods.
	 */
	public function __construct(
		protected bool $includeDefaultFilters = true,
	) {
	}

	/**
	 * @return array<\IdeHelper\Generator\Directive\BaseDirective>
	 */
	public function collect(): array {
		if (!Plugin::isLoaded('Search')) {
			return [];
		}

		$method = '\Search\Manager::add()';

		$list = [];
		if ($this->includeDefaultFilters) {
			foreach ($this->defaultFilters as $name) {
				$list[$name] = StringName::create($name);
			}
		}

		$filters = $this->collectFilters();
		foreach ($filters as $name) {
			$list[$name] = StringName::create($name);
		}

		ksort($list);

		$directive = new ExpectedArguments($method, 1, $list);

		return [$directive->key() => $directive];
	}

	/**
	 * @return list<string>
	 */
	protected function collectFilters(): array {
		$filters = [];

		$folders = AppPath::get('Model/Filter');
		foreach ($folders as $folder) {
			$filters = $this->addFilters($filters, $folder);
		}

		$plugins = PluginUtility::all();
		foreach ($plugins as $plugin) {
			$folders = AppPath::get('Model/Filter', $plugin);
			foreach ($folders as $folder) {
				$filters = $this->addFilters($filters, $folder, $plugin);
			}
		}

		return $filters;
	}

	/**
	 * @param list<string> $filters
	 * @param string $folder
	 * @param string|null $plugin
	 * @return list<string>
	 */
	protected function addFilters(array $filters, string $folder, ?string $plugin = null): array {
		$folderContent = (new Folder($folder))->read(Folder::SORT_NAME, true);

		foreach ($folderContent[1] as $file) {
			preg_match('/^(.+)\.php$/', $file, $matches);
			if (!$matches) {
				continue;
			}
			$name = $matches[1];
			if ($name === 'Base' || str_ends_with($name, 'Collection') || str_ends_with($name, 'Interface') || str_ends_with($name, 'Trait')) {
				continue;
			}

			if ($plugin) {
				$name = $plugin . '.' . $name;
			}

			$className = App::className($name, 'Model/Filter');
			if (!$className) {
				continue;
			}

			$filters[] = $name;
		}

		return $filters;
	}

}
