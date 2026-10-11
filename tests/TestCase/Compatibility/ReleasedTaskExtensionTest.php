<?php

declare(strict_types=1);

namespace IdeHelperExtra\Test\TestCase\Compatibility;

use Cake\TestSuite\TestCase;
use IdeHelperExtra\Test\TestClass\ReleasedIdentifierTask;
use IdeHelperExtra\Test\TestClass\ReleasedIconTask;

class ReleasedTaskExtensionTest extends TestCase {

	public function testReleasedIdentifierOverrideRemainsCompatible(): void {
		$task = new ReleasedIdentifierTask();
		$this->assertSame([], $task->collect());
	}

	public function testReleasedIconConfigPropertyRemainsCompatible(): void {
		$task = new ReleasedIconTask(['icons' => ['custom']]);
		$this->assertSame(['icons' => ['custom']], $task->configuration());
	}

}
