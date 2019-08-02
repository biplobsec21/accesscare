<?php

namespace App\Http\Controllers\Settings;

use App\DataTables\DataTableResponse;
use App\DataTables\DataTableRow;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Class SettingsController
 * @package App\Http\Controllers\Settings
 *
 * @author Andrew Mellor <andrew@quasars.com>
 */
class SettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('user.approved');

    }

    /**
     * Show the settings page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('portal.settings.settings');
    }

    public function responseDT($model, Request $request)
    {
        $model = 'App\\' . $model;
        if (!class_exists($model)) {
            dd('Model not found at: ' . $model);
        }
        $methods = get_class_methods($model);
        $items = $model::all();
        $response = new DataTableResponse(null, $request->all());
        foreach ($items as $item) {
            $row = new DataTableRow($item->id);
            foreach($request->input('cols') as $col) {
                if(!array_key_exists('type', $col)) {
                    $col['type'] = "string";
                }
                switch (strtolower($col['type'])) {
                    case "string":
                        $row->setColumn($col['data'], $this->getThroughModel($col['data'], $item));
                        break;
                    case "btn":
                        $value = "<a href=\"{$this->getThroughModel($col['data'], $item)}\" ";
                        $value .= "class=\"{$col['styling']}\">";
                        $value .= $col['icon'] . " " . $col['text'];
                        $value .= "</a>";
                        $row->setColumn($col['data'], $value);
                        break;
                    case "link":
                        echo "i equals 2";
                        break;
                }

            }
            $response->addRow($row);
        }
        return $response->toJSON();
    }

    public function getThroughModel($accessors, $item)
    {
        foreach(explode('-', $accessors) as $accessor) {
            $item = $item->{$accessor} ?? null;
        }
        return $item;
    }
}
