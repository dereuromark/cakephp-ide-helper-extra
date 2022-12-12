<?php

namespace IdeHelperExtra\Test\TestCase\Tools\Generator\Task;

use Cake\TestSuite\TestCase;
use Cake\View\View;
use IdeHelper\Generator\Directive\ExpectedArguments;
use IdeHelper\Generator\Directive\RegisterArgumentsSet;
use IdeHelperExtra\Tools\Generator\Task\FormatIconFontAwesome6Task;
use Tools\View\Helper\FormatHelper;

class FormatIconFontAwesome6TaskTest extends TestCase {

	/**
	 * @var \Tools\View\Helper\FormatHelper
	 */
	protected $helper;

	/**
	 * @return void
	 */
	public function setUp(): void {
		parent::setUp();

		$this->helper = new FormatHelper(new View(), [
			'iconNamespace' => 'fas',
			'autoPrefix' => 'fa',
		]);
	}

	/**
	 * Show that we are still API compatible/valid.
	 *
	 * @return void
	 */
	public function testIcon(): void {
		$result = $this->helper->icon('foo-bar');
		$this->assertTextContains('fas fa-foo-bar', $result);
	}

	/**
	 * @return void
	 */
	public function testCollect(): void {
		$path = TEST_FILES . 'Tools' . DS . 'fa6' . DS . 'icons.json';
		$task = new FormatIconFontAwesome6Task($path);

		$result = $task->collect();

		$this->assertCount(2, $result);

		/** @var \IdeHelper\Generator\Directive\RegisterArgumentsSet $directive */
		$directive = array_shift($result);

		$this->assertInstanceOf(RegisterArgumentsSet::class, $directive);

		$list = $directive->toArray()['list'];
		$list = array_map(function ($className) {
			return (string)$className;
		}, $list);

		$this->assertTrue(count($list) > 900);
		$this->assertSame('\'smile\'', $list['smile']);

		/** @var \IdeHelper\Generator\Directive\ExpectedArguments $directive */
		$directive = array_shift($result);
		$this->assertInstanceOf(ExpectedArguments::class, $directive);
	}

}
