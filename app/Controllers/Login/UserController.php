<?php

namespace App\Controllers\Login;

use App\Models\Login\UserModel;
use App\Controllers\BaseController;

class UserController extends BaseController
{
    public function index()
    {
        return view('Login/landing_page');
    }

    public function deleteuser($id)
    {
        $userModel = new UserModel();
        $userModel->delete($id);

        return redirect('/');
    }

    public function gantipass($id): string
    {
        $userModel = new UserModel();
        $data['user'] = $userModel->where('id', $id)->first();

        return view('Login/gantipass', $data);
    }

    public function simpanpass($id)
    {
        $userModel = new UserModel();
        $userModel->update($id, ['pass' => $this->request->getPost('pass')]);

        return redirect()->to('/')->with('msg', 'Password berhasil diubah, silakan log in kembali');
    }
}
