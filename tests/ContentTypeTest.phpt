<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/bootstrap.php';

final class ContentTypeTest extends TestCase
{

	public function test1(): void
	{
		$validValues = [
			'application/schema+json',
			'application/vnd.openxmlformats-officedocument.presentationml.presentation',
			'audio/x-mp3',
			'image/jpeg',
			'text/csv',
			'video/mp4',
		];

		foreach ($validValues as $value) {
			$contentType = ContentType::from($value);

			Assert::same($value, $contentType->getValue());
		}

		$invalidValues = [
			'application/schema_json',
			'audio/3pm',
			'csv',
			'text-plain',
			'text/',
		];

		foreach ($invalidValues as $value) {
			Assert::throws(
				static function () use ($value): void {
					ContentType::from($value);
				},
				InvalidTypeException::class
			);
		}
	}

}

(new ContentTypeTest())->run();
