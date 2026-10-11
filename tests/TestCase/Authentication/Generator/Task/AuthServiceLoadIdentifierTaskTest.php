<?php

namespace IdeHelperExtra\Test\TestCase\Authentication\Generator\Task;

use Authentication\Identifier\IdentifierFactory;
use Cake\TestSuite\TestCase;
use IdeHelperExtra\Authentication\Generator\Task\AuthServiceLoadIdentifierTask;
use Shim\TestSuite\TestTrait;
use TestApp\Identifier\CustomIdentifier;

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
		$this->assertSame('\Authentication\Identifier\IdentifierFactory::create(0)', $directive->toArray()['method']);

		$map = $directive->toArray()['map'];

		$map = array_map(function ($className) {
			return (string)$className;
		}, $map);

		$expectedMap = [
			'Custom' => '\TestApp\Identifier\CustomIdentifier::class',
		];
		$this->assertSame($expectedMap, $map);
		$identifier = IdentifierFactory::create('Custom');
		$this->assertInstanceOf(CustomIdentifier::class, $identifier);
	}

}
