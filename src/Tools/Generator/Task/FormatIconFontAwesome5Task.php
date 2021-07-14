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

class FormatIconFontAwesome5Task implements TaskInterface {

	public const CLASS_FORMAT_HELPER = FormatHelper::class;
	public const SET_ICONS_FONTAWESOME = 'fontawesomeIcons';

	/**
	 * @var string
	 */
	protected $fontPath;

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
	 * @return \IdeHelper\Generator\Directive\BaseDirective[]
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
		$directive = new ExpectedArguments($method, 0, [$registerArgumentsSet]);
		$result[$directive->key()] = $directive;

		return $result;
	}

	/**
	 * Fontawesome v5 using sprites .svg files.
	 *
	 * Set your custom file path in your app.php:
	 * 'Format' => [
	 *     'fontPath' => ROOT . '/webroot/css/fontawesome-free/sprites/solid.svg',
	 *
	 * @return string[]
	 */
	protected function collectIcons(): array {
		$helper = new FormatHelper(new View());
		$configured = $helper->getConfig('fontIcons');
		$configured = array_keys($configured);

		$fontFile = $this->fontPath;
		$icons = [];
		if (!file_exists($fontFile)) {
			throw new RuntimeException('File not found: ' . $fontFile);
		}

		$content = file_get_contents($fontFile);
		if ($content === false) {
			throw new RuntimeException('Cannot read file: ' . $fontFile);
		}
		preg_match_all('/symbol id="([a-z][^"]+)"/', $content, $matches);
		$icons = $matches[1];

		$icons = array_merge($configured, $icons);
		sort($icons);

		return $icons;
	}

}
