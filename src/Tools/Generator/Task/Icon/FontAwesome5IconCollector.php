<?php

namespace IdeHelperExtra\Tools\Generator\Task\Icon;

use RuntimeException;

class FontAwesome5IconCollector {

	/**
	 * @param string $filePath
	 *
	 * @return array<string>
	 */
	public static function collect(string $filePath): array {
		$content = file_get_contents($filePath);
		if ($content === false) {
			throw new RuntimeException('Cannot read file: ' . $filePath);
		}

		$array = json_decode($content, true);
		if (!$array) {
			throw new RuntimeException('Cannot parse JSON: ' . $filePath);
		}

		$icons = [];
		foreach ($array['icons'] as $row) {
			$icons[] = $row['name'];
		}

		return $icons;
	}

}