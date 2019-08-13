<?php

namespace App\Http\Controllers;

use App\Example;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Support\GenerateID;
use App\DataTables\DataTableResponse;

class ExampleController extends BaseController
{
    public function __construct()
    {
        $this->middleware('auth');
    }

	public function list(string $model)
	{
        return view('portal.drug.depot.list', [
            'examples' => Example::all(),
        ]);
	}

    public function create()
    {
        $countries = $this->getCountry();
        $states = \App\State::all()->sortBy('name');
        return view('portal.drug.depot.create', [
            'states' => $states,
            'countries' => $countries,
        ]);
    }
}
