<?php
namespace App\DataTables;

use Illuminate\Support\Collection;

class DataTableCell
{
	public $key, $val, $format;


	public function __construct($_key, $_val, $_format = null)
	{
		$this->key = $_key;
		$this->val = $_val;
		$this->format = $_format ?? $_val;
	}
}
