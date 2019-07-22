<?php

namespace App\DataTables;

class DataTableResponse
{
	protected $class;
	protected $settings;
	protected $rows = [];

	public function __construct($_class, $_settings)
	{
		$this->settings = $_settings;
		$this->class = $_class;
		$this->rows = collect([]);
	}

	public function addRow(DataTableRow $row)
	{
		return $this->rows->push($row);
	}

	public function toJSON()
	{
//		$this->search();
//		$this->orderRows();
		$response = new \stdClass();
		$response->data = [];
		foreach ($this->rows as $row) {
			$json = new \stdClass();
			foreach ($row->cells as $cell) {
				$json->{$cell->key} = $cell->format;
			}
			array_push($response->data, $json);
		}
		return json_encode($response);
	}

	protected function orderRows()
	{
		$orders = $this->settings['order'];
		for ($i = 0; $i < count($orders); $i++) {
			$col = $this->settings['columns'][$orders[$i]['column']]['data'];
			if ($orders[$i]['dir'] == 'asc') {
				$this->rows = collect($this->rows->sortBy(function ($row) use ($col) {
					return $row->getColumn($col);
				})->all());
			} else {
				$this->rows = collect($this->rows->sortByDesc(function ($row) use ($col) {
					return $row->getColumn($col);
				})->all());
			}
		}
	}
	protected function search()
	{
		$cols = $this->settings['columns'];
		foreach ($cols as $col) {
			if($col['search']['value']) {
				$key = $col['data'];
				$val = trim(strtolower($col['search']['value']));
				$this->rows = collect($this->rows->filter(function ($row) use ($key, $val) {
					echo similar_text($key,  trim(strtolower($row->getColumn($key, true))));
					return 3 < similar_text($key,  trim(strtolower($row->getColumn($key, true))));
				})->all());
				dd($this->rows);
			}
		}
	}
}
