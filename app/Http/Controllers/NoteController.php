<?php

namespace App\Http\Controllers;

use App\Note;
use App\Http\Requests\Note\CreateRequest;
use App\Traits\Notifier;

/**
 * Class NoteController
 * @package App\Http\Controllers\Note
 *
 * @author Andrew Mellor <andrew@quasars.com>
 */
class NoteController extends Controller
{
	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
    use Notifier;
	public function store(CreateRequest $request)
	{
		$note = new Note();
		$note->id = $this->newID(Note::class);
		$note->text = $request->input('text');
		$note->subject_id = $request->input('subject_id');
		$note->physican_viewable = $request->input('physican_viewable') ?? 0;
		$note->author_id = \Auth::user()->id;
		$note->save();

		if($note->PhysicianMember()->count() > 0){
			// rid_notes is the mailer template
			//$this->createNotice('rid_notes', $note, $note->PhysicianMember());
		}

		return redirect()->back();
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		$note = Note::where('id', $id)->first();
		$note->delete();
		return redirect()->back();
	}
}
