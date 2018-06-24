<?php

declare(strict_types = 1);

namespace SmartEmailing\Types;

use Consistence\Type\ObjectMixinTrait;
use SmartEmailing\Types\ExtractableTraits\EnumExtractableTrait;

/**
 * Class LawfulBasisForProcessing
 *
 * @package SmartEmailing\Types
 * @see https://ico.org.uk/for-organisations/guide-to-the-general-data-protection-regulation-gdpr/lawful-basis-for-processing/
 */
final class LawfulBasisForProcessing extends Enum
{

	use ObjectMixinTrait;
	use EnumExtractableTrait;

	/**
	 * The individual has given clear consent for you
	 * to process their personal data for a specific purpose.
	 */
	public const CONSENT = 'consent';

	/**
	 * The processing is necessary for a contract you have
	 * with the individual, or because they have asked you
	 * to take specific steps before entering into a contract.
	 */
	public const CONTRACT = 'contract';

	/**
	 * The processing is necessary for you to comply
	 * with the law (not including contractual obligations).
	 */
	public const LEGAL_OBLIGATION = 'legal-obligation';

	/**
	 * The processing is necessary for your legitimate interests
	 * or the legitimate interests of a third party unless
	 * there is a good reason to protect the individual’s personal
	 * data which overrides those legitimate interests.
	 * (This cannot apply if you are a public authority processing
	 * data to perform your official tasks.)
	 */
	public const LEGITIMATE_INTEREST = 'legitimate-interest';

	/**
	 * The processing is necessary to protect someone’s life.
	 */
	public const VITAL_INTEREST = 'vital-interest';

	/**
	 * The processing is necessary for you to perform a task
	 * in the public interest or for your official functions,
	 * and the task or function has a clear basis in law.
	 */
	public const PUBLIC_TASK = 'public-task';

}
