<?php

namespace App\Traits;

use Carbon\Carbon;
use App\Company;
use App\Rid;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Trait WorksWithRIDs
 *
 * @package App\Traits
 */
trait WorksWithRIDs
{
	use \App\Traits\GeneratesStrings, Hashable;

	/**
	 * @var int $ridRandSectionLen The length of the random string in a rid number
	 */
	protected $ridRandSectionLen = 8;

	/**
	 * @var string $resupplySuffix The suffix for Resupplies
	 */
	private $resupplySuffix = 'RS';

	/**
	 * @var string $appealSuffix The suffix for appeals
	 */
	private $appealSuffix = 'AP';

	protected $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";

	/**
	 * Generate a rid number and check to ensure that it is unique
	 *
	 * @param Company $company A result of a company
	 * @param Rid|null $parentRid The parent rid or null
	 * @param bool $isResupply Whether or not the call is a resupply
	 * @param bool $isAppeal Whether or not the call is an appeal
	 * @return string The generated number
	 *
	 * @throws \InvalidArgumentException
	 */
	protected function generateRidNumber(Company $company, Rid $parentRid = null, $isResupply = false, $isAppeal = false): string
	{
		if ($isResupply && $isAppeal) throw new \InvalidArgumentException('Both $isResupply and $isAppeal cannot be set to TRUE');
		if (is_null($parentRid) && ($isResupply || $isAppeal)) throw new \InvalidArgumentException('A parent rid result is required if is appeal or resupply');
		if (!is_null($parentRid) && !($isResupply || $isAppeal)) throw  new \InvalidArgumentException('If a parent rid is supplied, then either the $isAppeal or $isResupply must be set to TRUE');

		if (isset($parentRid)) {
			$ridNumber = $parentRid->number;
		} else {
			$ridNumber = $company->abbr . '-' . Carbon::now()->format('Ymd') . '-' . $this->generate($this->GENERATESSTRINGS_CHARS_UPPER_NUM, 8);
		}

		if ($isResupply) {
			$children = Rid::where([
				'parent_id' => $parentRid->id,
				'is_resupply' => 1,
			]);
			if ($children->count()) {
				$ridNumber = $ridNumber . '_' . $this->resupplySuffix . str_pad($children->count() + 1, 3, '0', STR_PAD_LEFT);
			} else {
				$ridNumber = $ridNumber . '_' . $this->resupplySuffix . '001';
			}
		}

		if ($isAppeal) {
			$children = Rid::where([
				'parent_id' => $parentRid->id,
				'is_appeal' => 1,
			]);
			if ($children->count()) {
				$ridNumber = $ridNumber . '_' . $this->resupplySuffix . str_pad($children->count() + 1, 3, '0', STR_PAD_LEFT);
			} else {
				$ridNumber = $ridNumber . '_' . $this->resupplySuffix . '001';
			}
		}

		try {
			$res = Rid::where('number', '=', $ridNumber)->firstOrFail(); // Should Fail
			return $this->generateRidNumber($company, $parentRid, $isResupply, $isAppeal);
		} catch (ModelNotFoundException $notFoundException) {
			return $ridNumber;
		}
	}

	/*
	 * Generate a password for a rid
	 *
	 * @return array The `hashed' and `unhashed` passwords
	 */
	protected function generateRidPassword(): array
	{
		$string = '';
		for ($i = 0; $i < config('eac.password_length'); $i++) {
			$string .= $this->chars[mt_rand(0, strlen($this->chars) - 1)];
		}

		return [
			'unhashed' => $string,
			'hashed' => $this->makeHash($string),
		];
	}
}
