<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Support\GenerateID;
use App\DataTables\DataTableResponse;

class Controller extends BaseController
{
	use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

	public static function newID(string $model)
	{
		return GenerateID::run(10);
	}
        
	public static function logData(string $model)
	{
		$tableName = $model::getTableName();
		$sql='select log.subject_id as id,count(log.id) as total_action  from log,'.$tableName.' where log.subject_id = '.$tableName.'.id group by log.subject_id' ;
		$result = DB::select($sql);
		return $result;
	}

	public function getCountry()
	{

		$countries = \App\Country::where('active', 1)->get()->sortBy('index');
		return $countries;
	}
}
