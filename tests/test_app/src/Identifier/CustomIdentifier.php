<?php

namespace TestApp\Identifier;

use Authentication\Identifier\AbstractIdentifier;

class CustomIdentifier extends AbstractIdentifier {

	public function identify(array $credentials): ?array {
		return null;
	}

}
