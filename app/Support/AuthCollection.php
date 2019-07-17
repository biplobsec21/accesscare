<?php

namespace App\Support;

use Illuminate\Support\Collection;

class AuthCollection extends Collection
{
	protected $all = false;
	protected $none = false;

	public function pushAccess($items)
	{
		return $this->items = (array_merge($this->items, $this->getArrayableItems($items)));
	}

	public function gate(string $gates, $id = null)
	{
		if($this->all)
			return 1;

		if($this->none)
			return 0;

		echo $gates . ' -> ' . $this->recursiveNeedleInHaystack($gates);
		return $this->recursiveNeedleInHaystack($gates);
	}

	public function recursiveNeedleInHaystack($needles)
	{
		$needles = explode('.', $needles);
		$haystack = $this->recursiveObjectToArray($this->items);
		foreach($needles as $needle) {
			if(array_key_exists($needle, $haystack))
				$haystack = $haystack[$needle];
			else
				return 0;
		}
		return $haystack;
	}

	public function recursiveObjectToArray($obj)
	{
		return json_decode(json_encode($obj), true);
	}

	public function setAuthAll()
	{
		$this->all = true;
		$this->none = false;
	}

	public function setAuthNone()
	{
		$this->all = false;
		$this->none = true;
	}
}
