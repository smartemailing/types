<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Consistence\Type\ObjectMixinTrait;
use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/bootstrap.php';

final class UrlTypeTest extends TestCase
{

	use ObjectMixinTrait;

	public function test1(): void
	{
		$validValues = [
			'https://www.vyzva21dni.cz/sq-podekovani-2018/?utm_source=seznam&utm_medium=cpc&utm_campaign=Sklik-[sch] - Cviky%2C Cviceni&utm_content=Stehna&email=xxx@seeznam.cz',
		];

		foreach ($validValues as $validValue) {
			$url = UrlType::from($validValue);
			Assert::type(UrlType::class, $url);
		}
	}

	public function testMethods(): void
	{
		$url = UrlType::from('https://www.seznam.cz/');
		Assert::equal('https://www.seznam.cz/', $url->getValue());
		Assert::equal('https://www.seznam.cz/', $url->getAbsoluteUrl());
		Assert::equal('https://www.seznam.cz/', $url->getBaseUrl());
		Assert::equal('www.seznam.cz', $url->getAuthority());
		Assert::equal('www.seznam.cz', $url->getHost());
		Assert::equal('https', $url->getScheme());
		Assert::equal('/', $url->getPath());
	}

	public function testQueryParameters(): void
	{
		$url = UrlType::from('https://www.seznam.cz');

		Assert::equal(
			[],
			$url->getParameters()
		);

		$parameterX = $url->getQueryParameter(
			'x'
		);

		Assert::null($parameterX);

		$url = $url->withQueryParameter(
			'x',
			'y'
		);

		$hasParameters = $url->hasParameters(
			[
				'x',
			]
		);

		Assert::true($hasParameters);

		$hasParameters = $url->hasParameters(
			[
				'x',
				'z',
			]
		);

		Assert::false($hasParameters);

		$parameters = $url->getParameters();
		Assert::equal(
			[
				'x' => 'y',
			],
			$parameters
		);

		Assert::equal('x=y', $url->getQueryString());

		Assert::equal('y', $url->getParameter('x'));

		Assert::equal('https://www.seznam.cz/?x=y', $url->getValue());
		Assert::equal('https://www.seznam.cz/?x=y', $url->toString());

		Assert::throws(
			static function (): void {
				UrlType::from('ddddd');
			},
			InvalidTypeException::class
		);
	}

}

(new UrlTypeTest())->run();
