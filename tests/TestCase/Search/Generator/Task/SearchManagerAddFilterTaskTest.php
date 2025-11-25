<?php

declare(strict_types=1);

namespace IdeHelperExtra\Test\TestCase\Search\Generator\Task;

use Cake\Core\Plugin;
use Cake\TestSuite\TestCase;
use IdeHelperExtra\Search\Generator\Task\SearchManagerAddFilterTask;
use Shim\TestSuite\TestTrait;

class SearchManagerAddFilterTaskTest extends TestCase {

	use TestTrait;

	protected SearchManagerAddFilterTask $task;

	/**
	 * @return void
	 */
	protected function setUp(): void {
		parent::setUp();

		$this->task = new SearchManagerAddFilterTask();
	}

	/**
	 * @return void
	 */
	public function testCollect(): void {
		if (!Plugin::isLoaded('Search')) {
			$this->markTestSkipped('Search plugin not loaded');
		}

		$result = $this->task->collect();

		$this->assertCount(1, $result);

		/** @var \IdeHelper\Generator\Directive\ExpectedArguments $directive */
		$directive = array_shift($result);
		$this->assertSame('\Search\Manager::add()', $directive->toArray()['method']);
		$this->assertSame(1, $directive->toArray()['position']);

		$list = $directive->toArray()['list'];

		$list = array_map(function ($stringName) {
			return (string)$stringName;
		}, $list);

		$this->assertArrayHasKey('Custom', $list);
		$this->assertSame("'Custom'", $list['Custom']);

		$this->assertArrayHasKey('Search.Value', $list);
		$this->assertSame("'Search.Value'", $list['Search.Value']);

		$this->assertArrayHasKey('Search.Like', $list);
		$this->assertArrayHasKey('Search.Boolean', $list);
		$this->assertArrayHasKey('Search.Callback', $list);
		$this->assertArrayHasKey('Search.Compare', $list);
		$this->assertArrayHasKey('Search.Exists', $list);
		$this->assertArrayHasKey('Search.Finder', $list);
	}

	/**
	 * @return void
	 */
	public function testCollectWithoutDefaultFilters(): void {
		if (!Plugin::isLoaded('Search')) {
			$this->markTestSkipped('Search plugin not loaded');
		}

		$task = new SearchManagerAddFilterTask(includeDefaultFilters: false);
		$result = $task->collect();

		$this->assertCount(1, $result);

		/** @var \IdeHelper\Generator\Directive\ExpectedArguments $directive */
		$directive = array_shift($result);

		$list = $directive->toArray()['list'];

		$list = array_map(function ($stringName) {
			return (string)$stringName;
		}, $list);

		$this->assertArrayHasKey('Custom', $list);
		$this->assertArrayNotHasKey('Search.Value', $list);
		$this->assertArrayNotHasKey('Search.Like', $list);
		$this->assertArrayNotHasKey('Search.Boolean', $list);
		$this->assertArrayNotHasKey('Search.Callback', $list);
	}

	/**
	 * @return void
	 */
	public function testCollectWithoutPlugin(): void {
		if (Plugin::isLoaded('Search')) {
			$this->markTestSkipped('Cannot test without Search plugin when it is loaded');
		}

		$result = $this->task->collect();

		$this->assertEmpty($result);
	}

}
