<?php

namespace IdeHelperExtra\Test\TestCase\Tools\Generator\Task;

use Cake\TestSuite\TestCase;
use Cake\View\View;
use IdeHelper\Generator\Directive\ExpectedArguments;
use IdeHelperExtra\Tools\Generator\Task\FormatIconBootstrapTask;
use Tools\View\Helper\FormatHelper;

class FormatIconBootstrapTaskTest extends TestCase {

	/**
	 * @var \Tools\View\Helper\FormatHelper
	 */
	protected $helper;

	/**
	 * @return void
	 */
	public function setUp(): void {
		parent::setUp();

		$this->helper = new FormatHelper(new View());
	}

	/**
	 * Show that we are still API compatible/valid.
	 *
	 * @return void
	 */
	public function testIcon(): void {
		$result = $this->helper->icon('foo-bar', ['iconNamespace' => 'bi']);
		$this->assertTextContains('bi bi-foo-bar', $result);
	}

	/**
	 * @return void
	 */
	public function testCollect(): void {
		$path = TEST_FILES . 'Tools' . DS . 'bootstrap' . DS . 'bootstrap-icons.json';
		$task = new FormatIconBootstrapTask($path);

		$result = $task->collect();

		$this->assertCount(2, $result);

		/** @var \IdeHelper\Generator\Directive\RegisterArgumentsSet $directive */
		$directive = array_shift($result);

		$list = $directive->toArray()['list'];
		$list = array_map(function ($className) {
			return (string)$className;
		}, $list);

		$this->assertTrue(count($list) > 1380, 'count of ' . count($list));
		$this->assertSame('\'info-circle-fill\'', $list['info-circle-fill']);

		/** @var \IdeHelper\Generator\Directive\ExpectedArguments $directive */
		$directive = array_shift($result);

		$this->assertInstanceOf(ExpectedArguments::class, $directive);
	}

}
