<?php

namespace App\Traits;

use App\Log;
use App\Support\GenerateID;

/**
 * Trait Logger
 */
trait Logger
{
	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  string $id ID of Changed Row
	 * @param  array $data New Data [field => value[
     * @param  string $type type of change
	 * @return \Illuminate\Http\Response
	 */
	public function storeLog($id, $data, $type)
	{

		$log = new Log();
		$log->id = $this->newID(Log::class);
		$log->user_id = \Auth::user()->id ?? 'System';
		$log->subject_id = $id;
		$log->desc = json_encode($data);
		$log->type = $type;
		$log->save();
		return redirect()->back();
	}

    /**
     * Store a newly created resource in storage.
     *
     * @param  string $id ID of Changed Row
     * @param  array $data New Data [field => value[
     * @return \Illuminate\Http\Response
     */
    public function getLogs($id)
    {
        return Log::where('subject_id', $id)->get();
    }

	public static function newID(string $model)
	{
		return GenerateID::run(10);
	}
}
