<?php

namespace App\Controllers\HR;

use App\Controllers\BaseController;
use App\Models\Login\UserModel;
use App\Models\HR\HakCutiModel;
use App\Models\HR\SisaCutiModel;
use App\Models\HR\IzinModel;

class CutiController extends BaseController
{
    public function index($nik)
    {
        $hcModel = new HakCutiModel();
        $sisaCutiModel = new SisaCutiModel();

        $sisaan = $sisaCutiModel->findAll();

        foreach ($sisaan as $sisa) {
            if ($sisa['nik'] == $nik) {
                $data['sisa'] = [
                    'nik' => $sisa['nik'],
                    'nama' => $sisa['nama'],
                    'periode' => $sisa['periode'],
                    'sisa_cuti' => $sisa['sisa_cuti'],
                    'jabatan' => $sisa['jabatan'],
                    'departemen' => $sisa['departemen'],
                    'tgl_join' => $sisa['tgl_join'],
                ];
            }
        }

        $data['hakcuti'] = $hcModel->findAll();

        return view('/hr/cuti', $data);
    }

    public function input_hak_cuti()
    {
        return view('/hr/input_hak_cuti');
    }

    public function input_hc_all()
    {
        $HCModel = new HakCutiModel();
        $userModel = new UserModel();
        $sisaCutiModel = new SisaCutiModel();
        $periode = $this->request->getVar('periode');
        $jatah_cuti = $this->request->getVar('jatah_cuti');

        if ($HCModel->where('periode', $periode)->first()) {

            session()->setFlashdata('gagal', 'Data Hak Cuti Tidak Bisa Diubah');

            return view('/hr/input_hak_cuti');
        } else {
            $data = [
                'periode' => $periode,
                'jatah_cuti' => $jatah_cuti,
                'jatah_security' => 12

            ];

            $HCModel->save($data);

            $allUser = $userModel->findAll();
            foreach ($allUser as $user) {

                if ($user['jabatan'] == 'Security') {
                    $jatah_cuti = 12;
                } else {
                    $jatah_cuti = $this->request->getVar('jatah_cuti');
                }

                $inputSisaCuti[] = [
                    'nik' => $user['nik'],
                    'nama' => $user['nama'],
                    'periode' => $periode,
                    'jabatan' => $user['jabatan'],
                    'departemen' => $user['departemen'],
                    'tgl_join' => $user['tgl_join'],
                    'sisa_cuti' => $jatah_cuti
                ];
            }

            $sisaCutiModel->insertBatch($inputSisaCuti);

            session()->setFlashdata('sukses', 'Data Hak Cuti Berhasil Ditambahkan');

            return view('/hr/input_hak_cuti');
        }
    }

    
    public function contoh()
    {
        $model = new SisaCutiModel();

        // Ambil data periode dan sisa_cuti
        $sisaCutiData = $model->getSisaCutiData(); // Pastikan method ini ada di model
        $periodeOptions = array_keys($sisaCutiData);

        $data = [
            'periode_options' => $periodeOptions,
            'sisa_cuti_data' => $sisaCutiData
        ];

        // Ambil data dari form, termasuk izin_awal, izin_akhir, izin_awal2, izin_akhir2
        $izin_awal = $this->request->getPost('izin_awal');
        $izin_akhir = $this->request->getPost('izin_akhir');
        $izin_awal2 = $this->request->getPost('izin_awal2');
        $izin_akhir2 = $this->request->getPost('izin_akhir2');

        $totalHari = 0;

        // Hitung periode pertama
        if (!empty($izin_awal) && !empty($izin_akhir)) {
            $totalHari += (strtotime($izin_akhir) - strtotime($izin_awal)) / (60 * 60 * 24);
        }

        // Hitung periode kedua
        if (!empty($izin_awal2) && !empty($izin_akhir2)) {
            $totalHari += (strtotime($izin_akhir2) - strtotime($izin_awal2)) / (60 * 60 * 24);
        }

        // Pastikan total hari hanya hitungan hari penuh
        $totalHari = intval($totalHari);

        // Kirim hasil total ke view
        $data['total_cuti'] = $totalHari;

        return view('form_surat_cuti', $data);
    }

    public function submit()
    {
        $model = new IzinModel();
        $sisaCutiModel = new SisaCutiModel();
        
        $nik = $this->request->getPost('nik');
        $periode = $this->request->getPost('periode');
        $sisa_cuti = $this->request->getPost('sisa_cuti');
        $total_cuti = $this->request->getPost('total_cuti');
        $sisa_cuti_input = $sisa_cuti-$total_cuti;

        $data = [
            'nik' => $nik,
            'nama' => $this->request->getPost('nama'),
            'periode' => $periode,
            'sisa_cuti' => $sisa_cuti_input,
            'alasan_izin' => $this->request->getPost('alasan_izin'),
            'izin_awal' => $this->request->getPost('izin_awal'),
            'izin_akhir' => $this->request->getPost('izin_akhir'),
            'izin_awal2' => $this->request->getPost('izin_awal2'),
            'izin_akhir2' => $this->request->getPost('izin_akhir2')
        ];

        $sisaCutiModel->where('nik', $nik)
                      ->where('periode', $periode)
                      ->set(['sisa_cuti' => $sisa_cuti_input])
                      ->update();

        $model->insert($data);

        return redirect()->to('/contoh-cuti');
    }
}
