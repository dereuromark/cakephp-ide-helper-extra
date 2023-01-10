<?php

namespace IdeHelperExtra\Test\TestCase\Tools\Generator\Task;

use Cake\TestSuite\TestCase;
use Cake\View\View;
use IdeHelper\Generator\Directive\ExpectedArguments;
use IdeHelperExtra\Tools\Generator\Task\IconRenderTask;
use Tools\View\Helper\IconHelper;
use Tools\View\Icon\BootstrapIcon;

class IconRenderTaskTest extends TestCase {

	protected IconHelper $helper;

	/**
	 * @return void
	 */
	public function setUp(): void {
		parent::setUp();

		$config = [
			'sets' => [
				'bs' => [
					'class' => BootstrapIcon::class,
					'path' => TEST_FILES . 'Tools/bootstrap/bootstrap-icons.json',
				],
			],
		];

		if (!file_exists($config['sets']['bs']['path'])) {
			exec('cd test_files && php update-test-files.php');
		}

		$this->helper = new IconHelper(new View(), $config);
	}

	/**
	 * Show that we are still API compatible/valid.
	 *
	 * @return void
	 */
	public function testIcon(): void {
		$result = $this->helper->render('foo-bar');
		$this->assertTextContains('bi bi-foo-bar', $result);
	}

	/**
	 * @return void
	 */
	public function testCollect(): void {
		$config = $this->helper->getConfig();

		$task = new IconRenderTask($config);

		$result = $task->collect();

		$this->assertCount(2, $result);

		/** @var \IdeHelper\Generator\Directive\RegisterArgumentsSet $directive */
		$directive = array_shift($result);

		$list = $directive->toArray()['list'];
		$list = array_map(function ($className) {
			return (string)$className;
		}, $list);

		$this->assertTrue(count($list) > 299, 'count of ' . count($list));
		$this->assertSame('\'zoom-in\'', $list['zoom-in']);

		/** @var \IdeHelper\Generator\Directive\ExpectedArguments $directive */
		$directive = array_shift($result);

		$this->assertInstanceOf(ExpectedArguments::class, $directive);
	}

}
