<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use SmartEmailing\Types\ExtractableTraits\ArrayExtractableTrait;
use SmartEmailing\Types\ExtractableTraits\EnumExtractableTrait;
use SmartEmailing\Types\Helpers\ExtractableHelpers;
use SmartEmailing\Types\Helpers\UniqueToStringArray;
use Tester\Assert;
use Tester\TestCase;

require __DIR__ . '/bootstrap.php';

/**
 * @extends \SmartEmailing\Types\Enum<string>
 */
final class InvalidTypeExceptionTestTopic extends Enum
{

	use EnumExtractableTrait;

	public const EMAIL = 'email';

}

/**
 * @extends \SmartEmailing\Types\Enum<string>
 */
final class InvalidTypeExceptionTestOtherEnum extends Enum
{

	public const EMAIL = 'email';

}

/**
 * @extends \SmartEmailing\Types\Enum<string>
 */
final class InvalidTypeExceptionTestDuplicateEnum extends Enum
{

	public const A = 'a';
	public const B = 'a';

}

/**
 * @extends \SmartEmailing\Types\Enum<mixed>
 */
final class InvalidTypeExceptionTestArrayEnum extends Enum
{

	public const A = ['a'];

}

final class InvalidTypeExceptionTestProgress
{

	use ArrayExtractableTrait;

	/**
	 * @param array<mixed> $data
	 */
	private function __construct(
		array $data
	) {
		IntType::extract($data, 'committed_row_id');
		InvalidTypeExceptionTestTopic::extract($data, 'topic');
	}

}

final class InvalidTypeExceptionTestStream
{

	use ArrayExtractableTrait;

	/**
	 * @param array<mixed> $data
	 */
	private function __construct(
		array $data
	) {
		InvalidTypeExceptionTestProgress::extract($data, 'progress');
	}

}

final class InvalidTypeExceptionTest extends TestCase
{

	public function testEnum(): void
	{
		$e = $this->catch(static fn () => InvalidTypeExceptionTestTopic::extract(['topic' => 'sms'], 'topic'));

		Assert::same('Problem at key topic: "sms" [string] is not a valid value for SmartEmailing\Types\InvalidTypeExceptionTestTopic, accepted values: email', $e->getMessage());
		Assert::same('Problem at key topic: "sms" is not a valid value, accepted values: email', $e->getPublicMessage());
		Assert::same('topic', $e->getKey());
		Assert::same('sms', $e->getInvalidValue());
		Assert::same(['email'], $e->getAcceptedValues());

		$e = $this->catch(static fn () => InvalidTypeExceptionTestTopic::get(5));

		Assert::same('5 [integer] is not a valid value for SmartEmailing\Types\InvalidTypeExceptionTestTopic, accepted values: email', $e->getMessage());
		Assert::same('5 is not a valid value, accepted values: email', $e->getPublicMessage());
		Assert::null($e->getKey());
		Assert::same(5, $e->getInvalidValue());
		Assert::same(['email'], $e->getAcceptedValues());

		$value = new \stdClass();
		$e = $this->catch(static fn () => InvalidTypeExceptionTestTopic::get($value));

		Assert::same('stdClass [object] is not a valid value for SmartEmailing\Types\InvalidTypeExceptionTestTopic, accepted values: email', $e->getMessage());
		Assert::same('Given value is not a valid value, accepted values: email', $e->getPublicMessage());
		Assert::same($value, $e->getInvalidValue());
	}

	public function testEnumDefinitionErrors(): void
	{
		$e = $this->catch(static fn () => InvalidTypeExceptionTestTopic::get('email')->equals(InvalidTypeExceptionTestOtherEnum::get('email')));

		Assert::same(
			'Operation supported only for enum of same class: SmartEmailing\Types\InvalidTypeExceptionTestOtherEnum given, '
			. 'SmartEmailing\Types\InvalidTypeExceptionTestTopic expected',
			$e->getMessage()
		);
		Assert::same('Operation supported only for enums of the same type', $e->getPublicMessage());

		$e = $this->catch(static fn () => InvalidTypeExceptionTestDuplicateEnum::getAvailableValues());

		Assert::same('Value a [string] is specified in SmartEmailing\Types\InvalidTypeExceptionTestDuplicateEnum\'s available values multiple times', $e->getMessage());
		Assert::same('Value a is specified in available values multiple times', $e->getPublicMessage());

		$e = $this->catch(static fn () => InvalidTypeExceptionTestArrayEnum::getAvailableValues());

		Assert::same('int|string|float|bool|null expected, ["a"] [] given', $e->getMessage());
		Assert::same('Enum values must be scalar or null', $e->getPublicMessage());
	}

	public function testTypeError(): void
	{
		$e = $this->catch(static fn () => IntType::from('abc'));

		Assert::same('Expected int, got string (abc)', $e->getMessage());
		Assert::same('Expected int, got "abc"', $e->getPublicMessage());
		Assert::null($e->getKey());
		Assert::same('abc', $e->getInvalidValue());
		Assert::null($e->getAcceptedValues());

		$e = $this->catch(static fn () => IntType::extract(['name' => 1.5], 'name'));

		Assert::same('Problem at key name: Expected int, got float (1.5)', $e->getMessage());
		Assert::same('Problem at key name: Expected int, got 1.5', $e->getPublicMessage());
		Assert::same('name', $e->getKey());
		Assert::same(1.5, $e->getInvalidValue());

		$e = $this->catch(static fn () => IntType::from(true));

		Assert::same('Expected int, got boolean (1)', $e->getMessage());
		Assert::same('Expected int, got true', $e->getPublicMessage());

		$value = new \stdClass();
		$e = $this->catch(static fn () => IntType::from($value));

		Assert::same('Expected int, got object (stdClass)', $e->getMessage());
		Assert::same('Expected int, got object', $e->getPublicMessage());
		Assert::same($value, $e->getInvalidValue());

		$e = $this->catch(static fn () => UniqueToStringArray::from(['abc']));

		Assert::same('Expected all members of array must implement SmartEmailing\Types\ToStringInterface, got string (abc)', $e->getMessage());
		Assert::same('Invalid value "abc"', $e->getPublicMessage());

		$e = $this->catch(static fn () => UniqueToStringArray::from([[]]));

		Assert::same('Invalid value', $e->getPublicMessage());
	}

	public function testTypesError(): void
	{
		$e = $this->catch(static fn () => ExtractableHelpers::extractValue('abc', 'key'));

		Assert::same('Expected types [array, ArrayAccess], got string (abc)', $e->getMessage());
		Assert::same('Expected array, got "abc"', $e->getPublicMessage());

		$e = $this->catch(static fn () => JsonString::from(null));

		Assert::same('Expected types [string, array], got NULL', $e->getMessage());
		Assert::same('Expected string or array, got null', $e->getPublicMessage());
		Assert::null($e->getInvalidValue());

		$e = $this->catch(static fn () => ExtractableHelpers::extractValue('abc', 'key'));
		Assert::same('abc', $e->getInvalidValue());
		Assert::null($e->getKey());
	}

	public function testMissingKey(): void
	{
		$e = $this->catch(static fn () => InvalidTypeExceptionTestTopic::extract([], 'topic'));

		Assert::same('Missing key: topic', $e->getMessage());
		Assert::same('Missing key: topic', $e->getPublicMessage());
		Assert::same('topic', $e->getKey());
		Assert::null($e->getInvalidValue());
		Assert::null($e->getAcceptedValues());
	}

	public function testCannotBeEmptyError(): void
	{
		$e = $this->catch(static fn () => UniqueIntArray::extractNotEmpty(['ids' => []], 'ids'));

		Assert::same('Array at key ids must not be empty.', $e->getMessage());
		Assert::same('Array at key ids must not be empty.', $e->getPublicMessage());
		Assert::same('ids', $e->getKey());
		Assert::null($e->getInvalidValue());
	}

	public function testDirectConstruction(): void
	{
		$previous = new \Exception('previous');
		$e = new InvalidTypeException('Label must not be empty.', 5, $previous);

		Assert::same('Label must not be empty.', $e->getMessage());
		Assert::same('Label must not be empty.', $e->getPublicMessage());
		Assert::same(5, $e->getCode());
		Assert::same($previous, $e->getPrevious());
		Assert::null($e->getKey());
		Assert::null($e->getInvalidValue());
		Assert::null($e->getAcceptedValues());

		$wrapped = $e->wrap('label');

		Assert::same('Problem at key label: Label must not be empty.', $wrapped->getMessage());
		Assert::same('Problem at key label: Label must not be empty.', $wrapped->getPublicMessage());
		Assert::same('label', $wrapped->getKey());
		Assert::same(5, $wrapped->getCode());
		Assert::same($e, $wrapped->getPrevious());

		$e = new InvalidTypeException();

		Assert::same('', $e->getMessage());
		Assert::same('', $e->getPublicMessage());

		$e = $this->catch(static fn () => Emailaddress::extract(['email' => 'abc'], 'email'));

		Assert::type(InvalidEmailaddressException::class, $e);
		Assert::same('Problem at key email: Invalid emailaddress: abc', $e->getMessage());
		Assert::same('Problem at key email: Invalid emailaddress: abc', $e->getPublicMessage());
		Assert::same('email', $e->getKey());
		Assert::null($e->getInvalidValue());

		$e = $this->catch(
			static fn () => DateTimeRange::from([
				'from' => '2020-01-02 00:00:00',
				'to' => '2020-01-01 00:00:00',
			])
		);

		Assert::same('SmartEmailing\Types\DateTimeRange cannot have negative duration', $e->getMessage());
		Assert::same('Date time range cannot have negative duration', $e->getPublicMessage());
	}

	public function testNestedWrap(): void
	{
		$e = $this->catch(
			static fn () => InvalidTypeExceptionTestStream::extract(
				['stream' => ['progress' => ['committed_row_id' => 'abc', 'topic' => 'email']]],
				'stream'
			)
		);

		Assert::same('Problem at key stream: Problem at key progress: Problem at key committed_row_id: Expected int, got string (abc)', $e->getMessage());
		Assert::same('Problem at key stream: Problem at key progress: Problem at key committed_row_id: Expected int, got "abc"', $e->getPublicMessage());
		Assert::same('stream.progress.committed_row_id', $e->getKey());
		Assert::same('abc', $e->getInvalidValue());
		Assert::null($e->getAcceptedValues());

		$e = $this->catch(
			static fn () => InvalidTypeExceptionTestProgress::extract(
				['progress' => ['committed_row_id' => 1, 'topic' => 'sms']],
				'progress'
			)
		);

		Assert::same(
			'Problem at key progress: Problem at key topic: "sms" [string] is not a valid value for SmartEmailing\Types\InvalidTypeExceptionTestTopic, '
			. 'accepted values: email',
			$e->getMessage()
		);
		Assert::same('Problem at key progress: Problem at key topic: "sms" is not a valid value, accepted values: email', $e->getPublicMessage());
		Assert::same('progress.topic', $e->getKey());
		Assert::same('sms', $e->getInvalidValue());
		Assert::same(['email'], $e->getAcceptedValues());

		$e = $this->catch(
			static fn () => InvalidTypeExceptionTestProgress::extract(
				['progress' => ['topic' => 'email']],
				'progress'
			)
		);

		Assert::same('Problem at key progress: Missing key: committed_row_id', $e->getMessage());
		Assert::same('Problem at key progress: Missing key: committed_row_id', $e->getPublicMessage());
		Assert::same('progress.committed_row_id', $e->getKey());
	}

	public function testPublicMessageHasNoInternalDetails(): void
	{
		$value = new \stdClass();
		$callbacks = [
			static fn () => InvalidTypeExceptionTestTopic::extract(['topic' => 'sms'], 'topic'),
			static fn () => InvalidTypeExceptionTestTopic::get(1),
			static fn () => InvalidTypeExceptionTestTopic::get($value),
			static fn () => InvalidTypeExceptionTestTopic::get('email')->equals(InvalidTypeExceptionTestOtherEnum::get('email')),
			static fn () => InvalidTypeExceptionTestDuplicateEnum::getAvailableValues(),
			static fn () => InvalidTypeExceptionTestArrayEnum::getAvailableValues(),
			static fn () => IntType::extract(['a' => 'abc'], 'a'),
			static fn () => FloatType::from([]),
			static fn () => StringType::from($value),
			static fn () => BoolType::from('abc'),
			static fn () => Arrays::from(1),
			static fn () => DateTimes::from('abc'),
			static fn () => Dates::from('abc'),
			static fn () => UniqueToStringArray::from([$value]),
			static fn () => UniqueIntArray::from(['abc']),
			static fn () => ExtractableHelpers::extractValue($value, 'key'),
			static fn () => JsonString::from($value),
			static fn () => Duration::from(1),
			static fn () => DateTimeRange::from(['from' => '2020-01-02 00:00:00', 'to' => '2020-01-01 00:00:00']),
			static fn () => InvalidTypeExceptionTestStream::extract(['stream' => ['progress' => ['committed_row_id' => $value]]], 'stream'),
		];

		foreach ($callbacks as $callback) {
			$publicMessage = $this->catch($callback)->getPublicMessage();

			Assert::notContains('\\', $publicMessage);
			Assert::false(
				(bool) \preg_match('/\[(string|int|integer|float|double|bool|boolean|array|object|NULL)\]/', $publicMessage),
				$publicMessage
			);
		}
	}

	private function catch(
		callable $callback
	): InvalidTypeException
	{
		try {
			$callback();
		} catch (InvalidTypeException $e) {
			return $e;
		}

		Assert::fail('InvalidTypeException was not thrown');
	}

}

(new InvalidTypeExceptionTest())->run();
