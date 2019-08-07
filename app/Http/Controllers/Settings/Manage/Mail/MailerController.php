<?php

namespace App\Http\Controllers\Settings\Manage\Mail;

use App\Http\Controllers\Controller;
use App\Mailer;
use App\Traits\Logger;
use Illuminate\Http\Request;
use App\Traits\Notifier;
use Auth;
use App\Role;
use App\User;
use App\Log;

/**
 * Class CountryController
 * @package App\Http\Controllers\Settings\Manage\Country
 *
 * @author Andrew Mellor <andrew@quasars.com>
 */
class MailerController extends Controller
{
    use Logger;

    /**
     * CountryController constructor.
     */
    public function __construct()
    {
        $this->middleware("auth");
    }

    public function index()
    {
        $mailers = Mailer::all();

        return view('portal.settings.manage.emails.notification-mail', ['templates' => $mailers]);
    }

    public function create()
    {
        // dd(session()->all());
        $currentuserid = Auth::user()->id;
        $user = User::where('id', '=', $currentuserid)->firstOrFail();
        $user_type = $user->type_id;
        $user_title = $user->title;
        // echo $user_title;
        // dd();
        $user_first_name = $user->first_name;
        $user_last_name = $user->last_name;
        $useraccess = Role::where('type_id', '=', $user_type)->firstOrFail();
        $rolename = $useraccess->name;
        if ($rolename == 'EAC Admin') {
            return view('portal.settings.manage.emails.create')
                ->with('rolename', $rolename)
                ->with('user_title', $user_title)
                ->with('first_name', $user_first_name)
                ->with('last_name', $user_last_name);

        } else {
            return view('portal.settings.manage.emails.create')
                ->with('user_title', $user_title)
                ->with('first_name', $user_first_name)
                ->with('last_name', $user_last_name);

        }
        // dd();
    }

    public function postCreate(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'subject' => 'required',
            'from_email' => 'required|email',
            'html' => 'required'
        ], [
            'name.required' => ' The name field is required.',
            'subject.required' => ' The subject field is required.',
            'from_email.required' => ' The from email field is required.',
            'from_name.required' => 'The from name field is required..',
            'reply_to.required' => 'The reply to field is required.',
            'cc.required' => 'The cc field is required.',
            'bcc.required' => 'The bcc field is required.',
            'html.required' => 'The html body field is required.',
        ]);


        $mail = new Mailer();
        $mail->id = $this->newID(Mailer::class);
        $mail->name = $request->input('name');
        $mail->subject = $request->input('subject');
        $mail->from_email = $request->input('from_email');
        $mail->from_name = $request->input('from_name');
        $mail->reply_to = $request->input('reply_to');
        $mail->cc = $request->input('cc');
        $mail->bcc = $request->input('bcc');
        $mail->html = $request->input('html');
        $mail->notes = $request->input('note');

        $mail->save();
        // return redirect()->route('eac.portal.user.show', $user->id);
        return redirect()->back()->with('success', 'Successfully added!');
    }

    public function ajaxMailData()
    {
        $sql = Mailer::where('id', '!=', '');
        // if (Request()->input('html')) {  // get status parameter
        // 	$RequestViewStatus = Request()->input('html');
        // 	$sql = Mailer::Where('html', '=', $RequestViewStatus);
        // }

        return \DataTables::of($sql)
            ->addColumn('name', function ($row) {
                return $row->name;
            })
            ->addColumn('subject', function ($row) {
                return $row->subject;
            })
            ->addColumn('from_email', function ($row) {
                return $row->from_email;
            })
            ->addColumn('from_name', function ($row) {
                return $row->from_name;
            })
            ->addColumn('reply_to', function ($row) {
                return $row->reply_to;
            })
            ->addColumn('cc', function ($row) {
                return $row->cc;
            })
            ->addColumn('bcc', function ($row) {
                return $row->bcc;
            })
            ->addColumn('html', function ($row) {
                return $row->html;
            })
            ->addColumn('ops_btns', function ($row) {
                $value = $row->id;
                return '
    <a title="Edit Email" href="' . route('eac.portal.settings.mail.edit') . '/' . $row->id . '">
     <i class="far fa-edit" aria-hidden="true"></i> <span class="sr-only">Edit Email</span>
    </a>
    <a class="text-danger" href="#" onclick="ConfirmDelete(' . "'" . $row->id . "'" . ')">
     <i class="far fa-times" aria-hidden="true"></i> <span class="sr-only">Delete Email</span>
    </a>
    ';
            })
            ->rawColumns([
                'name',
                'subject',
                'from_email',
                'from_name',
                'reply_to',
                'cc',
                'bcc',
                'html',
                'ops_btns'
            ])
            ->filterColumn('name', function ($query, $keyword) {
                $query->where('name', 'like', "%" . $keyword . "%");
            })
            ->filterColumn('subject', function ($query, $keyword) {
                $query->where('subject', 'like', "%" . $keyword . "%");
            })
            ->filterColumn('from_email', function ($query, $keyword) {
                $query->where('from_email', 'like', "%" . $keyword . "%");
            })
            ->filterColumn('from_name', function ($query, $keyword) {
                $query->where('from_name', 'like', "%" . $keyword . "%");
            })
            ->filterColumn('reply_to', function ($query, $keyword) {
                $query->where('reply_to', 'like', "%" . $keyword . "%");
            })
            ->filterColumn('cc', function ($query, $keyword) {
                $query->where('cc', 'like', "%" . $keyword . "%");
            })
            ->filterColumn('bcc', function ($query, $keyword) {
                $query->where('bcc', 'like', "%" . $keyword . "%");
            })
            ->filterColumn('html', function ($query, $keyword) {
                $query->where('html', 'like', "%" . $keyword . "%");
            })
            ->order(function ($query) {
                $columns = [
                    'name' => 0,
                    'subject' => 1,
                    'from_email' => 2,
                    'from_name' => 3,
                    'reply_to' => 4,
                    'cc' => 5,
                    'bcc' => 6,
                    'html' => 7
                ];

                $direction = request('order.0.dir');

                if (request('order.0.column') == $columns['name']) {
                    $query->orderBy('name', $direction);
                }
                if (request('order.0.column') == $columns['subject']) {
                    $query->orderBy('subject', $direction);
                }
                if (request('order.0.column') == $columns['from_email']) {
                    $query->orderBy('from_email', $direction);
                }

            })
            ->smart(0)
            ->toJson();
    }

    public function edit($id)
    {
        $mailbyId = Mailer::where('id', $id)->firstOrFail();

        return view('portal.settings.manage.emails.edit')
            ->with('mailbyId', $mailbyId);
    }


    public function ajaxMailDelete(Request $request)
    {

        $mailTypeId = $request->id;
        $mailType = Mailer::find($mailTypeId)->delete();
        return [
            "result" => "Success"
        ];
    }

    public function postEdit(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'subject' => 'required',
            'from_email' => 'required|email',
            'html' => 'required'
        ], [
            'name.required' => ' The name field is required.',
            'subject.required' => ' The subject field is required.',
            'from_email.required' => ' The from email field is required.',
            'from_name.required' => 'The from name field is required..',
            'reply_to.required' => 'The reply to field is required.',
            'cc.required' => 'The cc field is required.',
            'bcc.required' => 'The bcc field is required.',
            'html.required' => 'The html body field is required.',
        ]);

        $id = $request->input('eid');

        $mail = Mailer::find($id);
        $mail->name = $request->input('name');
        $mail->subject = $request->input('subject');
        $mail->from_email = $request->input('from_email');
        $mail->from_name = $request->input('from_name');
        $mail->reply_to = $request->input('reply_to');
        $mail->cc = $request->input('cc');
        $mail->bcc = $request->input('bcc');
        $mail->html = $request->input('html');
        $mail->notes = $request->input('note');
        $mail->save();

        $return_from = $request->input('return_from');
        if ($return_from == 'save') {

            return redirect()->route('eac.portal.settings.mail.notification-mail')->with('success', 'Successfully Updated!');
        } else {
            return redirect()->back()->with('success', 'Successfully Updated!');
        }
    }


    public function logMail()
    {

        $logData = $this->getLogs(Mailer::class);
        return view('portal.settings.manage.emails.loglist')
            ->with('logData', $logData);

    }
}
