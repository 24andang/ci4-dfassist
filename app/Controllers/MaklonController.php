<?php

namespace App\Controllers;

use App\Models\MaklonModel;

class MaklonController extends BaseController
{
    public function regmaklon()
    {
        $session = session()->get('inisial');
        $maklonModel = new MaklonModel();

        if ($session == '') {
            return redirect()->to('/');
        } else {
            $data['maklon'] = $maklonModel->findAll();
            return view('/regmaklon', $data);
        }
    }
}
