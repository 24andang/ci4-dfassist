<?php

namespace App\Controllers\Login;

use App\Models\Login\UserModel;
use App\Controllers\BaseController;

class AuthController extends BaseController
{
    public function index()
    {
        return view('Login/login_page');
    }

    public function login()
    {
        $session = session();
        $userModel = new UserModel();
        $inisial = $this->request->getVar('inisial');
        $pass = $this->request->getVar('pass');

        $data = $userModel->where('inisial', $inisial)->first();

        if ($data) {
            $password = $data['pass'];

            if ($password == $pass) {
                $ses_data = [
                    'id' => $data['id'],
                    'nik' => $data['nik'],
                    'inisial' => $data['inisial'],
                    'nama' => $data['nama'],
                    'departemen' => $data['departemen'],
                    'jabatan' => $data['jabatan'],
                    'level' => $data['level'],
                    'tgl_join' => $data['tgl_join']
                ];
                $session->set($ses_data);
                return view('Login/landing_page');
            } else {
                $session->setFlashdata('msg', 'Password salah.');
                return redirect()->to('/');
            }
        } else {
            $session->setFlashdata('msg', 'Inisial tidak ditemukan.');
            return redirect()->to('/');
        }
    }

    public function logout()
    {
        $session = session();
        $session->destroy();
        return view('Login/login_page');
    }
}
