<?php

namespace App\DataTables;

class DataTableResponse
{
    protected $class;
    protected $settings;
    protected $rows = [];

    public function __construct($items, $_settings)
    {
        $this->columns = collect($_settings["columns"]);
        $this->order = collect($_settings["order"]);
        $this->page = $_settings['start'] / $_settings['length'] + 1;
        $this->pageLength = $_settings['length'];
        $this->items = $items;
        $this->rows = collect([]);
        $this->total = $items->count();
        $this->run();
    }

    protected function run()
    {
        $this->search();
        $this->sort();
        $this->paginate();
        $this->build();
    }

    protected function build()
    {
        foreach ($this->items as $index => $item) {
            $row = new DataTableRow($item->id);
            foreach ($this->columns as $col) {
                if (!array_key_exists('type', $col)) {
                    $col['type'] = "string";
                }
                switch (strtolower($col['type'])) {
                    case "string":
                        $row->setColumn($col['data'], $this->getThroughModel($col['data'], $item));
                        break;
                    case "btn":
                        $value = "<a href=\"{$this->getThroughModel($col['data'], $item)}\" ";
                        $value .= "class=\"{$col['classes']}\">";
                        $value .= $col['icon'] . " " . $col['text'];
                        $value .= "</a>";
                        $row->setColumn($col['data'], $value);
                        break;
                    case "link":
                        $value = "<a href=\"{$this->getThroughModel($col['href'], $item)}\">";
                        $value .= $this->getThroughModel($col['data'], $item);
                        $value .= "</a>";
                        $row->setColumn($col['data'], $value);
                        break;
                    case "count":
                        $value = '<span class="badge badge-mw badge-outline-info">';
                        $value .= $this->getThroughModel($col['data'], $item)->count();
                        $value .= '</span>';
                        $row->setColumn($col['data'], $value);
                        break;
                }
                // add active or inactive badges
                if($col['data'] === 'active'){
                    $value = $this->getThroughModel($col['data'], $item) == '1'
                        ? '<span class="badge badge-success">Active' 
                        : '<span class="badge badge-danger">Inactive';
                    $value .= '</span>';
                    $row->setColumn($col['data'], $value);
                }
                // template view download
                if($col['data'] === 'template'){
                    if($item->file){ // check file exist 
                        $value =  view('include.portal.file-btns', ['id' => $item->file->id]);
                        $row->setColumn($col['data'], $value->render());
                    }
                }
            }
            $this->addRow($row);
        }
    }

    protected function getThroughModel($accessors, $item)
    {
        foreach (explode('-', $accessors) as $accessor) {
            $item = $item->{$accessor} ?? null;
        }
        return $item;
    }

    public function addRow(DataTableRow $row)
    {
        return $this->rows->push($row);
    }

    public function toJSON()
    {
        $response = new \stdClass();
        $response->data = [];
        foreach ($this->rows as $row) {
            $json = new \stdClass();
            foreach ($row->cells as $cell) {
                $json->{$cell->key} = $cell->format;
            }
            array_push($response->data, $json);
        }
        $response->recordsFiltered = $this->total;
        $response->recordsTotal = $this->total;
        return json_encode($response);
    }

    protected function paginate()
    {
        $this->items = $this->items->forPage($this->page, $this->pageLength)->values();
    }

    protected function sort()
    {
        $items = $this->items;
        switch ($this->order->count()) {
            case 0:
                break;
            case 1:
                if($this->order[0]['dir'] == "asc")
                    $items = $items->sortBy($this->columns[$this->order[0]['column']]['data']);
                else
                    $items = $items->sortByDesc($this->columns[$this->order[0]['column']]['data']);
                break;
            default:
                if($this->order[0]['dir'] == "asc")
                    $items = $items->sortBy($this->columns[$this->order[0]['column']]['data']);
                else
                    $items = $items->sortByDesc($this->columns[$this->order[0]['column']]['data']);

                break;
        }
        $this->items = collect($items->values());
    }

    protected function search()
    {
        $filters = collect([]);
        foreach ($this->columns as $column) {
            if (!$column['search']['value'])
                continue;
            if ($column['searchable'] === "false")
                continue;
            $filters->push(["data" => $column['data'], "value" => $column['search']['value'], "type" => $column['type']]);
        }
        $this->items = $this->items->filter(function ($model) use ($filters) {
            $passed = true;
            foreach ($filters as $filter) {
                $value = $this->getThroughModel($filter['data'], $model);
                if (strpos(strtolower($value), strtolower($filter['value'])) === false)
                    $passed = false;
            }
            return $passed;
        });
    }
}
