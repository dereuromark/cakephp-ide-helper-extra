<?php
declare(strict_types = 1);

namespace IdeHelperExtra\Tools\Generator\Task;

use Cake\Core\Configure;
use Cake\View\View;
use IdeHelper\Generator\Directive\ExpectedArguments;
use IdeHelper\Generator\Task\TaskInterface;
use Tools\View\Helper\FormatHelper;

/**
 * Autocomplete for FormatHelper::icon() with Font Awesome v4 icons.
 */
class FormatIconFontAwesome4Task implements TaskInterface {

	const CLASS_FORMAT_HELPER = FormatHelper::class;

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

		$method = '\\' . static::CLASS_FORMAT_HELPER . '::icon()';
		$directive = new ExpectedArguments($method, 0, $list);
		$result[$directive->key()] = $directive;

		return $result;
	}

	/**
	 * Fontawesome v4 using fontawesome-webfont.svg file.
	 *
	 * Set your custom file path in your app.php:
	 *     'fontPath' => ROOT . '/webroot/css/fonts/fontawesome-webfont.svg'
	 *
	 * @return string[]
	 */
	protected function collectIcons(): array {
		$helper = new FormatHelper(new View());
		$configured = $helper->getConfig('fontIcons');

		$fontFile = $this->fontPath;
		$icons = [];
		if ($fontFile && file_exists($fontFile)) {
			$content = file_get_contents($fontFile);
			preg_match_all('/glyph-name="([a-z][^"]+)"/', $content, $matches);
			$icons = $matches[1];
			foreach ($icons as $key => $icon) {
				if (strpos($icon, 'uni') === 0 || preg_match('#[a-z]\d[a-z]\d#i', $icon)) {
					unset($icons[$key]);
				}
			}
		}

		$icons = array_merge($configured, $icons);
		sort($icons);

		return $icons;
	}

}
