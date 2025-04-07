<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use SmartEmailing\Types\ExtractableTraits\EnumExtractableTrait;

/**
 * @extends \SmartEmailing\Types\Enum<string>
 */
final class HttpMethod extends Enum implements ToStringInterface
{

	use EnumExtractableTrait;
	use ToStringTrait;

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
