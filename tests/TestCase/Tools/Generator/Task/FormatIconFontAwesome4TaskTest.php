<?php

namespace IdeHelperExtra\Test\TestCase\Tools\Generator\Task;

use Cake\TestSuite\TestCase;
use Cake\View\View;
use IdeHelper\Generator\Directive\ExpectedArguments;
use IdeHelper\Generator\Directive\RegisterArgumentsSet;
use IdeHelperExtra\Tools\Generator\Task\FormatIconFontAwesome4Task;
use Tools\View\Helper\FormatHelper;

class FormatIconFontAwesome4TaskTest extends TestCase {

	protected FormatHelper $helper;

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
	 * @dataProvider extensions
	 *
	 * @param string $extension
	 *
	 * @return void
	 */
	public function testCollect(string $extension): void {
		$path = TEST_FILES . 'Tools' . DS . 'fa4' . DS . 'variables.' . $extension;
		$task = new FormatIconFontAwesome4Task($path);

		$result = $task->collect();

		$this->assertCount(2, $result);

		/** @var \IdeHelper\Generator\Directive\RegisterArgumentsSet $directive */
		$directive = array_shift($result);

		$this->assertInstanceOf(RegisterArgumentsSet::class, $directive);

		$list = $directive->toArray()['list'];
		$list = array_map(function ($className) {
			return (string)$className;
		}, $list);

		$this->assertTrue(count($list) > 780, 'count of ' . count($list));
		$this->assertSame('\'smile-o\'', $list['smile-o']);

		/** @var \IdeHelper\Generator\Directive\ExpectedArguments $directive */
		$directive = array_shift($result);
		$this->assertInstanceOf(ExpectedArguments::class, $directive);
	}

	/**
	 * @return array
	 */
	public function extensions(): array {
		return [
			'scss' => ['scss'],
			'less' => ['less'],
		];
	}

}
