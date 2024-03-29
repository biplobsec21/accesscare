<?php

namespace App\Traits;

use App\Mailer;
use App\Notification;
use App\User;
use App\UserType;
use Mail;
use App\Mail\GenericEmail;

/**
 * Trait Notifier
 */
trait Notifier
{
    protected function createNotice($name, $context, $user)
    {
        $users = collect([$user]);
        if ($user === 'eac')
            $users = User::where('type_id', UserType::where('name', 'Early Access Care')->first()->id)->get();
        $mailer = Mailer::where('name', $name)->first();

        $this->buildNotice($mailer, $context, $users);
    }

    protected function buildNotice($mailer, $context, $users)
    {
        foreach ($users as $user) {
            $notice = new Notification();
            $notice->id = $this->newID(Notification::class);
            $notice->user_id = $user->id;
            $notice->subject_id = $context->id;
            $notice->message = strip_tags($this->applyTokens($mailer->html, $context));
            $notice->save();

            $this->sendMail($mailer, $context, $user);
        }
    }

    public function sendMail($mailer, $context, $user)
    {
        $content = new \stdClass();
        $content->subject = 'V2ADEV' . $mailer->subject;
        $content->message = $this->applyTokens($mailer->html, $context);
        $content->receiver = $user->full_name;
        $content->context = $context;

        //return Mail::to('andrew@quasars.com')->send(new GenericEmail($content));
    }

    private function applyTokens($str, $context)
    {
        $tokens = array(
            '{rid.view}',
            '{rid.edit}',
            '{rid.post_approval}',
            '{rid.number}',
            '{rid.created_at}',
            '{rid.physician.full_name}',
            '{rid.drug_name}',
            '{user.email}',
            '{user.first_name}',
            '{user.last_name}',
            '{user.full_name}',
            '{user.dashboard}',
            '{user.id}',
            '&nbsp;'
        );
        $val = array(
            route('eac.portal.rid.show', $context->id),
            route('eac.portal.rid.edit', $context->id),
            route('eac.portal.rid.postreview', $context->id),
            $context->number ?? '',
            $context->created_at ?? '',
            $context->physician->full_name ?? '',
            $context->drug->name ?? '',
            $context->email ?? '',
            $context->first_name ?? '',
            $context->last_name ?? '',
            $context->full_name ?? '',
            route('eac.portal.getDashboard'),
            $context->id ?? '',
            ' '
        );
        $str = str_replace($tokens, $val, $str);
        return $str;
    }
}
