<?php

namespace IdeHelperExtra\Test\TestCase\Authentication\Generator\Task;

use Cake\TestSuite\TestCase;
use IdeHelperExtra\Authentication\Generator\Task\AuthServiceLoadAuthenticatorTask;
use Shim\TestSuite\TestTrait;

class AuthServiceLoadAuthenticatorTaskTest extends TestCase {

	use TestTrait;

	protected AuthServiceLoadAuthenticatorTask $task;

	/**
	 * @return void
	 */
	protected function setUp(): void {
		parent::setUp();

		$this->task = new AuthServiceLoadAuthenticatorTask();
	}

	/**
	 * @return void
	 */
	public function testCollect() {
		$result = $this->task->collect();

		$this->assertCount(1, $result);

		/** @var \IdeHelper\Generator\Directive\Override $directive */
		$directive = array_shift($result);
		$this->assertSame('\Authentication\AuthenticationService::loadAuthenticator(0)', $directive->toArray()['method']);

		$map = $directive->toArray()['map'];

		$map = array_map(function ($className) {
			return (string)$className;
		}, $map);

		$expectedMap = [
			'FooBar' => '\TestApp\Authenticator\FooBarAuthenticator::class',
		];
		$this->assertSame($expectedMap, $map);
	}

}
