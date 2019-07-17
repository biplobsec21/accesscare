<?php
namespace EAC\DataTables;

use EAC\DataTables\DataTableCell;
use Illuminate\Support\Collection;

class DataTableRow
{
	public $cells;

	public function __construct($_id)
	{
		$this->cells = collect([new DataTableCell('id', $_id)]);
	}

	public function setColumn($key, $val, $format = null)
	{
		$this->cells->push(new DataTableCell($key, $val, $format));
	}

	public function getColumn($key, $format = false)
	{
		if($format)
			return $this->cells->where('key', $key)->first()->format ?? null;
		else
			return $this->cells->where('key', $key)->first()->val ?? null;
	}
}
