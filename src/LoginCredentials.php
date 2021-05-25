<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use SmartEmailing\Types\ExtractableTraits\ArrayExtractableTrait;

final class LoginCredentials
{

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
	 * @param array<string> $data
	 */
	private function __construct(
		array $data
	) {
		$this->login = StringType::extract($data, 'login');
		$this->password = StringType::extract($data, 'password');
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
	 * @return array<mixed>
	 */
	public function toArray(): array
	{
		return [
			'login' => $this->login,
			'password' => $this->password,
		];
	}

}
