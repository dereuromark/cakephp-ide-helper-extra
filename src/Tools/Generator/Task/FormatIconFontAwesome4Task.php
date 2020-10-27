<?php
declare(strict_types = 1);

namespace IdeHelperExtra\Tools\Generator\Task;

use Cake\Core\Configure;
use Cake\View\View;
use IdeHelper\Generator\Directive\ExpectedArguments;
use IdeHelper\Generator\Task\TaskInterface;
use RuntimeException;
use Tools\View\Helper\FormatHelper;

/**
 * Autocomplete for FormatHelper::icon() with Font Awesome v4 icons.
 */
class FormatIconFontAwesome4Task implements TaskInterface {

	public const CLASS_FORMAT_HELPER = FormatHelper::class;

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

		$method = '\\' . static::CLASS_FORMAT_HELPER . '::icon()';
		$directive = new ExpectedArguments($method, 0, $list);
		$result[$directive->key()] = $directive;

		return $result;
	}

	/**
	 * Fontawesome v4 using variables.scss or variables.less file.
	 *
	 * Set your custom file path in your app.php:
	 *     'fontPath' => ROOT . '/node_modules/.../scss/variables.scss'
	 *
	 * @return string[]
	 */
	protected function collectIcons(): array {
		$helper = new FormatHelper(new View());
		$configured = $helper->getConfig('fontIcons');
		$configured = array_keys($configured);

		$fontFile = $this->fontPath;
		$icons = [];
		if ($fontFile && file_exists($fontFile)) {
			$content = file_get_contents($fontFile);
			if ($content === false) {
				throw new RuntimeException('Cannot read file: ' . $fontFile);
			}

			$ext = pathinfo($fontFile, PATHINFO_EXTENSION);
			switch ($ext) {
				case 'less':
					preg_match_all('/@fa-var-([0-9a-z-]+):/', $content, $matches);

					break;
				case 'scss':
					preg_match_all('/\$fa-var-([0-9a-z-]+):/', $content, $matches);

					break;
				default:
					throw new RuntimeException('Format not supported: ' . $ext);
			}

			$icons = !empty($matches[1]) ? $matches[1] : [];
		}

		$icons = array_merge($configured, $icons);
		sort($icons);

		return $icons;
	}

}
