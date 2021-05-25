<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use SmartEmailing\Types\Comparable\ComparableInterface;
use SmartEmailing\Types\Comparable\StringComparableTrait;
use SmartEmailing\Types\ExtractableTraits\EnumExtractableTrait;

final class HttpMethod extends Enum implements ToStringInterface, ComparableInterface
{

	use EnumExtractableTrait;
	use ToStringTrait;
	use StringComparableTrait;

	public const GET = 'GET';

	public const HEAD = 'HEAD';

	public const POST = 'POST';

	public const PUT = 'PUT';

	public const DELETE = 'DELETE';

	public const CONNECT = 'CONNECT';

	public const OPTIONS = 'OPTIONS';

	public const TRACE = 'TRACE';

	public const PATCH = 'PATCH';

}
