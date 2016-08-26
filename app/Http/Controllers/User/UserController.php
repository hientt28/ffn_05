<?php

namespace App\Http\Controllers\User;

use App\Http\Requests;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use App\Services\FileUpload;
use Exception;

class UserController extends Controller
{
    use FileUpload;
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index() {
        return view('welcome');
    }

    public function show($id)
    {
        $user = $this->userRepository->find($id);

        return view('user.show', compact('user'));
    }

    public function edit($id)
    {
        $user = $this->userRepository->find($id);

        return view('user.edit', compact('user'));
    }

    public function update(UserRequest $request, $id)
    {
        try {
            $user = $this->userRepository->find($id);
            if ($request->hasFile('avatar')) {
                $fileName = $request->avatar;
                $user['avatar'] = $this->cloudder($fileName, config('common.path_cloud_avatar') . $user->name);
            }

            $user->name = $request->get('name', '');
            $user->address = $request->get('address', '');
            $user->email = $request->get('email', '');

            $user->save();
        } catch (Exception $ex) {
            return redirect()->route('users.profile.edit')->withError($ex->getMessage());
        }

        return redirect('/');
    }
}
