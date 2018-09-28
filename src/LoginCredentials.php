<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Consistence\Type\ObjectMixinTrait;
use SmartEmailing\Types\ExtractableTraits\ArrayExtractableTrait;

final class LoginCredentials
{

	use ObjectMixinTrait;
	use ArrayExtractableTrait;

	/**
	 * @var string
	 */
	private $login;

	/**
	 * @var string
	 */
	private $password;

	/**
	 * @param string[] $data
	 */
	private function __construct(
		array $data
	) {
		$this->login = PrimitiveTypes::extractString($data, 'login');
		$this->password = PrimitiveTypes::extractString($data, 'password');
	}

	public function getLogin(): string
	{
		return $this->login;
	}

	public function getPassword(): string
	{
		return $this->password;
	}

	/**
	 * @return mixed[]
	 */
	public function toArray(): array
	{
		return [
			'login' => $this->login,
			'password' => $this->password,
		];
	}

}
