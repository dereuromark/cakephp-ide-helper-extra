<?php

declare(strict_types=1);

namespace IdeHelperExtra\Test\TestCase\Compatibility;

use Cake\TestSuite\TestCase;
use IdeHelperExtra\Test\TestClass\TypedAuthenticatorTask;
use IdeHelperExtra\Test\TestClass\TypedIconTask;
use IdeHelperExtra\Test\TestClass\TypedIdentifierTask;

class TypedTaskExtensionTest extends TestCase {

	public function testTypedIdentifierOverrideMatchesContract(): void {
		$task = new TypedIdentifierTask();
		$this->assertSame([], $task->collect());
	}

	public function testTypedAuthenticatorOverrideMatchesContract(): void {
		$task = new TypedAuthenticatorTask();
		$this->assertSame([], $task->collect());
	}

	public function testTypedIconConfigPropertyMatchesContract(): void {
		$task = new TypedIconTask(['icons' => ['custom']]);
		$this->assertSame(['icons' => ['custom']], $task->configuration());
	}

}
