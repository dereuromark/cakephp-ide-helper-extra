<?php
declare(strict_types = 1);

namespace IdeHelperExtra\Tools\Generator\Task;

use Cake\Core\Configure;
use Cake\View\View;
use IdeHelper\Generator\Directive\ExpectedArguments;
use IdeHelper\Generator\Directive\RegisterArgumentsSet;
use IdeHelper\Generator\Task\TaskInterface;
use RuntimeException;
use Tools\View\Helper\FormatHelper;
use Tools\View\Icon\Collector\FontAwesome4IconCollector;

/**
 * Autocomplete for FormatHelper::icon() with Font Awesome v4 icons.
 */
class FormatIconFontAwesome4Task implements TaskInterface {

	public const CLASS_FORMAT_HELPER = FormatHelper::class;

	/**
	 * @var string
	 */
	public const SET_ICONS_FONTAWESOME = 'fontawesomeIcons';

	protected string $fontPath;

	/**
	 * @param string|null $fontPath
	 */
	public function __construct(?string $fontPath = null) {
		if ($fontPath === null) {
			$fontPath = (string)Configure::readOrFail('Format.fontPath');
		}
		if ($fontPath && !file_exists($fontPath)) {
			throw new RuntimeException('File not found: ' . $fontPath);
		}

		$this->fontPath = $fontPath;
	}

	/**
	 * @return array<\IdeHelper\Generator\Directive\BaseDirective>
	 */
	public function collect(): array {
		$result = [];

		$icons = $this->collectIcons();
		$list = [];
		foreach ($icons as $icon) {
			$list[$icon] = '\'' . $icon . '\'';
		}

		ksort($list);

		$registerArgumentsSet = new RegisterArgumentsSet(static::SET_ICONS_FONTAWESOME, $list);
		$result[$registerArgumentsSet->key()] = $registerArgumentsSet;

		$method = '\\' . static::CLASS_FORMAT_HELPER . '::icon()';
		$directive = new ExpectedArguments($method, 0, [(string)$registerArgumentsSet]);
		$result[$directive->key()] = $directive;

		return $result;
	}

	/**
	 * Fontawesome v4 using variables.scss or variables.less file.
	 *
	 * Set your custom file path in your app.php:
	 *     'fontPath' => ROOT . '/node_modules/.../scss/variables.scss'
	 *
	 * @return array<string>
	 */
	protected function collectIcons(): array {
		$helper = new FormatHelper(new View());
		$configured = $helper->getConfig('fontIcons');
		/** @var array<string> $configured */
		$configured = array_keys($configured);

		$icons = FontAwesome4IconCollector::collect($this->fontPath);

		$icons = array_merge($configured, $icons);
		sort($icons);

		return $icons;
	}

}
