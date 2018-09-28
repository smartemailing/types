<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Consistence\Type\ObjectMixinTrait;
use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/bootstrap.php';

final class LoginCredentialsTest extends TestCase
{

	use ObjectMixinTrait;

	public function test1(): void
	{
		$data = [
			'login' => 'admin',
			'password' => '1234',
		];

		$loginCredentials = LoginCredentials::from($data);
		Assert::type(LoginCredentials::class, $loginCredentials);

		Assert::equal('admin', $loginCredentials->getLogin());
		Assert::equal('1234', $loginCredentials->getPassword());

		Assert::equal($data, $loginCredentials->toArray());
	}

}

(new LoginCredentialsTest())->run();
