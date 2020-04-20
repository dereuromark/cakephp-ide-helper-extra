<?php

namespace IdeHelperExtra\Test\TestCase\Tools\Generator\Task;

use Cake\TestSuite\TestCase;
use Cake\View\View;
use IdeHelperExtra\Tools\Generator\Task\FormatIconFontAwesome4Task;
use IdeHelper\Generator\Directive\ExpectedArguments;
use Tools\View\Helper\FormatHelper;

class FormatIconFontAwesome4TaskTest extends TestCase {

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
		$result = $this->helper->icon('foo-bar');
		$this->assertTextContains('fa fa-foo-bar', $result);
	}

	/**
	 * @return void
	 */
	public function testCollect(): void {
		$path = TEST_FILES . 'Tools' . DS . 'fa4' . DS . 'fontawesome-webfont.svg';
		$task = new FormatIconFontAwesome4Task($path);

		$result = $task->collect();

		$this->assertCount(1, $result);

		/** @var \IdeHelper\Generator\Directive\ExpectedArguments $directive */
		$directive = array_shift($result);

		$this->assertInstanceOf(ExpectedArguments::class, $directive);

		$list = $directive->toArray()['list'];
		$list = array_map(function ($className) {
			return (string)$className;
		}, $list);

		$this->assertTrue(count($list) > 380);
		$this->assertSame('\'smile\'', $list['smile']);
	}

}
