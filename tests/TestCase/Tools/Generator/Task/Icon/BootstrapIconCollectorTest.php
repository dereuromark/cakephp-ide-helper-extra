<?php

namespace IdeHelperExtra\Test\TestCase\Tools\Generator\Task\Icon;

use Cake\TestSuite\TestCase;
use IdeHelperExtra\Tools\Generator\Task\Icon\BootstrapIconCollector;

class BootstrapIconCollectorTest extends TestCase {

	/**
	 * Show that we are still API compatible/valid.
	 *
	 * @return void
	 */
	public function testCollect(): void {
		$path = TEST_FILES . 'Tools' . DS . 'bootstrap' . DS . 'bootstrap-icons.json';

		$result = BootstrapIconCollector::collect($path);

		$this->assertTrue(count($result) > 1360, 'count of ' . count($result));
		$this->assertTrue(in_array('info-circle-fill', $result, true));
	}

}
