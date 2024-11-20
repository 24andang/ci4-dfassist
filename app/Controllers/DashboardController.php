<?php

namespace App\Controllers;

use App\Models\Login\UserModel;
use App\Models\SuratCutiModel;
use CodeIgniter\Controller;

class DashboardController extends Controller
{

    public function createSuratCuti()
    {
        $session = session();
        $userModel = new UserModel();
        $model = new SuratCutiModel();
        $inisial = $session->get('inisial');

        // Ambil periode cuti terbaru
        $latestPeriod = $model->getLatestPeriod();
        $userName = session()->get('nama');
        $periodId = $latestPeriod['id_periode'];

        // Ambil sisa cuti dari periode terbaru
        $remainingLeave = $model->getRemainingLeave($userName, $periodId);
        $data['inisial'] = $inisial;
        $data['periode_cuti'] = $latestPeriod['tahun_periode'];
        $data['jatah_cuti'] = $latestPeriod['jatah_cuti'];
        $data['sisa_cuti'] = $remainingLeave ? $remainingLeave['sisa_cuti'] : $latestPeriod['jatah_cuti'];

        return view('form_surat_cuti', $data);
    }

    public function storeSuratCuti()
    {

        $model = new SuratCutiModel();

        // Ambil data dari form
        $awal_cuti = $this->request->getPost('awal_cuti');
        $akhir_cuti = $this->request->getPost('akhir_cuti');
        $userName = session()->get('inisial');

        // Hitung jumlah hari cuti
        $jumlah_cuti = $this->calculateDaysBetween($awal_cuti, $akhir_cuti);

        // Ambil periode cuti terbaru
        $latestPeriod = $model->getLatestPeriod();
        $periodId = $latestPeriod['id_periode'];

        // Ambil sisa cuti sebelumnya
        $remainingLeave = $model->getRemainingLeave($userName, $periodId);
        $sisa_cuti = $remainingLeave ? $remainingLeave['sisa_cuti'] - $jumlah_cuti : $latestPeriod['jatah_cuti'] - $jumlah_cuti;

        $data = [
            'nama' => $userName,
            'periode_cuti' => $latestPeriod['tahun_periode'],
            'awal_cuti' => $awal_cuti,
            'akhir_cuti' => $akhir_cuti,
            'jumlah_cuti' => $jumlah_cuti,
            'jatah_cuti' => $latestPeriod['jatah_cuti'],
            'sisa_cuti' => $sisa_cuti,
            'approval1' => $this->request->getPost('approval1'),
            'approval2' => $this->request->getPost('approval2'),
            'approval3' => $this->request->getPost('approval3'),
            'periode_cuti_id' => $periodId
        ];

        $model->insert($data);
        return redirect()->to('/dashboard')->with('success', 'Data cuti berhasil disimpan.');
    }

    private function calculateDaysBetween($startDate, $endDate)
    {
        $start = new \DateTime($startDate);
        $end = new \DateTime($endDate);
        $interval = $start->diff($end);
        return $interval->days + 1; // +1 karena tanggal akhir juga dihitung
    }
}
