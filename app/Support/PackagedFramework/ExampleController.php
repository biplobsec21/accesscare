<?php

namespace App\Http\Controllers;

use App\Example;
use App\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use App\Support\GenerateID;
use App\DataTables\DataTableResponse;

class ExampleController extends BaseController
{
    public function __construct()
    {
        $this->middleware('auth');
    }

	public function list()
	{
        return view('portal.drug.depot.list', [
            'examples' => Example::all(),
        ]);
	}

    public function create()
    {
        $users = User::all();
        return view('portal.drug.depot.create', [
            'users' => $users,
        ]);
    }

    public function show($id)
    {
	    $example = Example::where('id',$id)->first();
        return view('portal.drug.depot.create', [
	        'example' => $example,
        ]);
    }

    public function edit($id)
    {
	    $example = Example::where('id',$id)->first();
        return view('portal.drug.depot.create', [
            'example' => $example,
        ]);
    }

	public function store(Request $request)
	{
		$example = new Example();
		$example->id = Example::newID();
		$example->fill($request->all());
		$example->save();
		return $this->clientRedirect($request, ['success', 'Successful Creation!']);
	}

	public function update(Request $request)
	{
		$example = Example::where('id', $request->input('id'))->first();
		$example->fill($request->all());
		$example->save();
		return $this->clientRedirect($request, ['success', 'Successful Update!']);
	}
}
