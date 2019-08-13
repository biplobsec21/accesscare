<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as Controller;
use App\Support\GenerateID;
use App\DataTables\DataTableResponse;

class BaseController extends Controller
{
	use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
