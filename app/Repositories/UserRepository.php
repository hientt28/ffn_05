<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\EloquentRepository;
use Mail;

class UserRepository extends EloquentRepository
{
    public function __construct(User $user)
    {
        parent::__construct($user);
    }

    public function createUser($request, $confirmationCode)
    {
        $user = [
            'email' => $request->email,
            'name' => $request->name,
            'password' => bcrypt($request->password),
            'confirmation_code' => $confirmationCode,
        ];

        $createUsers = $this->create($user);

        if (!$createUsers) {
            throw new Exception(trans('message.create_user_fail'));
        }

        $sendMailData = [
            'email' => $request->email,
            'name' => $request->name,
            'confirmation_code' => $confirmationCode,
        ];
        Mail::send('auth.emails.mail', $sendMailData, function ($message) use ($sendMailData) {
            $message->to($sendMailData['email'])->subject(trans('common.confirm_register'));
        });

        return $createUser;
    }

    public function updateConfirm($confirmationCode)
    {
        $user = $this->findBy('confirmation_code', $confirmationCode);
        if (!$user) {
            throw new Exception(trans('message.item_not_exist'));
        }

        $user->confirmation_code = '';
        $user->save();

        return $user;
    }
}
