<?php

namespace IdeHelperExtra\Test\TestCase\Authentication\Generator\Task;

use Cake\TestSuite\TestCase;
use IdeHelperExtra\Authentication\Generator\Task\AuthServiceLoadIdentifierTask;
use Shim\TestSuite\TestTrait;

class AuthServiceLoadIdentifierTaskTest extends TestCase {

	use TestTrait;

	protected AuthServiceLoadIdentifierTask $task;

	/**
	 * @return void
	 */
	protected function setUp(): void {
		parent::setUp();

		$this->task = new AuthServiceLoadIdentifierTask();
	}

	/**
	 * @return void
	 */
	public function testCollect() {
		$result = $this->task->collect();

		$this->assertCount(1, $result);

		/** @var \IdeHelper\Generator\Directive\Override $directive */
		$directive = array_shift($result);
		$this->assertSame('\Authentication\Identifier\IdentifierCollection::load(0)', $directive->toArray()['method']);

		$map = $directive->toArray()['map'];

		$map = array_map(function ($className) {
			return (string)$className;
		}, $map);

		$expectedMap = [
			'Custom' => '\TestApp\Identifier\CustomIdentifier::class',
		];
		$this->assertSame($expectedMap, $map);
	}

}
