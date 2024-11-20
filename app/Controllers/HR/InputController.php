<?php

namespace App\Controllers\HR;

use App\Controllers\BaseController;
use App\Models\HR\CutiBersamaModel;
use App\Models\Login\UserModel;
use App\Models\HR\SisaCutiModel;
use App\Models\HR\ReguSecurityModel;
use App\Models\HR\JadwalSecurityModel;

class InputController extends BaseController
{
    public function ganti_hari()
    {
        $cutiBersamaModel = new CutiBersamaModel();
        $data['cuti_bersama'] = $cutiBersamaModel->where('keterangan', 'weekend')->findAll();
        return view('/hr/ganti_hari', $data);
    }

    public function submit_ganti_hari()
    {
        $cutiBersamaModel = new CutiBersamaModel();
        $date1 = $this->request->getVar('date1');
        $date2 = [
            'tanggal' => $this->request->getVar('date2'),
            'tanggal_awal' => $date1
        ];
        $idTgl = $cutiBersamaModel->where('tanggal', $date1)->find();

        $cutiBersamaModel->update($idTgl[0], $date2);
        return redirect()->to('/hr/input/ganti_hari');
    }

    public function reset_ganti_hari($id)
    {
        $cutiBersamaModel = new CutiBersamaModel();
        $date = [
            'tanggal' => $this->request->getVar('tanggal'),
            'tanggal_awal' => null
        ];
        $cutiBersamaModel->update($id, $date);

        return redirect()->to('/hr/input/ganti_hari');
    }

    public function getUserByNik()
    {
        $nik = $this->request->getPost('nik');
        if ($nik) {
            $userModel = new UserModel();
            $user = $userModel->getUserByNik($nik);
            if ($user) {
                return $this->response->setJSON($user);
            } else {
                return $this->response->setJSON(['error' => 'User not found']);
            }
        } else {
            return $this->response->setJSON(['error' => 'NIK is missing']);
        }
    }

    public function per_nik()
    {
        // Ambil data yang dikirim melalui POST
        $nik = $this->request->getPost('nik');
        $hak_cuti = $this->request->getPost('hak_cuti'); // Ambil hak cuti dari input

        // Simpan ke database
        $sisaCutiModel = new SisaCutiModel();

        $data = [
            'nik' => $nik,
            'nama' => $this->request->getPost('nama'),
            'periode' => $this->request->getPost('periode'),
            'sisa_cuti' => $hak_cuti,
            'jabatan' => $this->request->getPost('jabatan'),
            'departemen' => $this->request->getPost('departemen'),
            'tgl_join' => $this->request->getPost('tgl_join')
        ];

        if ($sisaCutiModel->insert($data)) {
            return redirect()->to('/input_hak_cuti')->with('message', 'Data berhasil disimpan');
        } else {
            return redirect()->to('/input_hak_cuti')->with('message', 'Gagal menyimpan data');
        }
    }

    // jadwal security

    public function jadwal_security()
    {
        $userModel = new UserModel();
        $reguSecurityModel = new ReguSecurityModel();
        $jadwalSecurityModel = new JadwalSecurityModel();
        $data['security'] = $userModel->where('jabatan', 'security')->where('inisial !=', 'NIH')->findAll();
        $data['regu'] = $reguSecurityModel->findAll();
        $data['jadwal'] = $jadwalSecurityModel->where('nama_2 !=', 'Plant-2')->findAll();
        return view('/hr/jadwal_Security', $data);
    }

    public function jadwal_security_plant2()
    {
        $userModel = new UserModel();
        $reguSecurityModel = new ReguSecurityModel();
        $jadwalSecurityModel = new JadwalSecurityModel();
        $data['security'] = $userModel->where('jabatan', 'security plant-2')->where('inisial !=', 'NIH')->findAll();
        $data['regu'] = $reguSecurityModel->findAll();
        $data['jadwal'] = $jadwalSecurityModel->where('nama_2', 'Plant-2')->findAll();
        return view('/hr/jadwal_Security_plant2', $data);
    }

    public function regu_security()
    {
        $reguSecurityModel = new ReguSecurityModel();
        $nama_2 = $this->request->getVar('nama-2');
        $regu = $this->request->getVar('regu');

        if (!$nama_2) {
            return redirect()->to('/hr/input/jadwal_security')->with('pesan_gagal', 'Data tidak valid.');
        } else {
            $input = [
                'regu' => $regu,
                'nama_1' => $this->request->getVar('nama-1'),
                'nama_2' => $nama_2,
            ];

            $id = $reguSecurityModel->where('regu', $regu)->first();
            $reguSecurityModel->update($id, $input);
            return redirect()->to('/hr/input/jadwal_security')->with('pesan_sukses', 'Data berhasil diinput.');
        }
    }

    public function csv_security()
    {
        $reguSecurityModel = new ReguSecurityModel();
        $jadwalSecurityModel = new JadwalSecurityModel();
        $csv_file = $this->request->getFile('csv-file');
        $bulan = $this->request->getPost('bulan');
        $tahun = $this->request->getPost('tahun');

        $csvTemp = $csv_file->getTempName();
        $buka_file = fopen($csvTemp, 'r');

        $i = 0; // baris pertama dalam csc adalah 0
        while (($row = fgetcsv($buka_file, 32, ';')) !== FALSE) {

            if ($i > 0) {
                $tanggal = date('Y-m-d', strtotime($tahun . '-' . $bulan . '-' . $row[0]));
                $data[] = [
                    'tanggal' => $tanggal,
                    'regu'  => $row[1],
                    'nama_1' => $reguSecurityModel->select('nama_1')->where('regu', $row[1])->first()['nama_1'],
                    'nama_2' => $reguSecurityModel->select('nama_2')->where('regu', $row[1])->first()['nama_2']
                ];
            }
            $i++;
        }
        fclose($buka_file);
        // openStream : membuka file tanpa menyipan.  r = read.
        // fgetcsv : memilih file csv
        // fclose : menutup file

        $jadwalSecurityModel->insertBatch($data);
        return redirect()->back()->with('csv_sukses', 'Jadwal berhasil diupload.');
    }
}
