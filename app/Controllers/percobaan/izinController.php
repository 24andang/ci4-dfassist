<?php

namespace App\Controllers;

use App\Models\Login\UserModel;
use App\Models\HR\IzinModel;
use App\Models\Users\DepartemenModel;
use App\Controllers\BaseController;
use App\Models\HR\CutiBersamaModel;
use App\Models\HR\JadwalSecurityModel;
use App\Models\HR\ReguSecurityModel;
use App\Models\HR\SisaCutiModel;

class IzinController extends BaseController
{
    public function approval()
    {
        $izinModel = new IzinModel();
        $departemen = session()->get('departemen');
        $level = session()->get('level') - 1;

        if ($departemen == 'HR & GA' && in_array(session()->get('inisial'), ['IAI', 'AWK', 'DKA', 'ODP', 'OAL'])) {
            // Jika departemen adalah HR, ambil semua data
            $data['surat_izin'] = $izinModel->orderBy('approval1', 'desc')->orderBy('alasan_izin', 'desc')->findAll();
        } elseif ($departemen === 'Directorate') {
            $data['surat_izin'] = $izinModel->where('level', $level)->orderBy('approval1', 'asc')->orderBy('alasan_izin', 'desc')->findAll();
        } else {
            // Jika departemen bukan HR, ambil data sesuai dengan departemen pengguna
            $data['surat_izin'] = $izinModel->where('departemen', $departemen)->orderBy('approval1', 'asc')->orderBy('alasan_izin', 'desc')->findAll();
        }

        return view('/hr/izin_approval', $data);
    }
}
