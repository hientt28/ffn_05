<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Services\FileUpload;
use Exception;
use App\Repositories\UserRepository;

class AdminController extends Controller
{
    use FileUpload;
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('welcome');
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
                $filename = $request->avatar;
                $user['avatar'] = $this->cloudder($fileName, config('common.path_cloud_avatar') . $user->name);
            }

            $user->name = $request->get('name', '');
            $user->address = $request->get('address', '');
            $user->email = $request->get('email', '');

            $user->save();
        } catch (Exception $ex) {
            return redirect()->route('admin.profile.edit')->withError($ex->getMessage());
        }

        return redirect('/');
    }
}
