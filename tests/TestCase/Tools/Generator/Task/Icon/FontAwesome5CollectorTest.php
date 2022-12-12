<?php

namespace IdeHelperExtra\Test\TestCase\Tools\Generator\Task\Icon;

use Cake\TestSuite\TestCase;
use IdeHelperExtra\Tools\Generator\Task\Icon\FontAwesome5IconCollector;

class FontAwesome5CollectorTest extends TestCase {

	/**
	 * Show that we are still API compatible/valid.
	 *
	 * @return void
	 */
	public function testCollect(): void {
		$path = TEST_FILES . 'Tools' . DS . 'fa5' . DS . 'icons.json';

		$result = FontAwesome5IconCollector::collect($path);

		$this->assertTrue(count($result) > 1456, 'count of ' . count($result));
		$this->assertTrue(in_array('thumbs-up', $result, true));
	}

}
