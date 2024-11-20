<?php

namespace App\Controllers\HR;

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
    public function index($id)
    {
        $session = session();
        $izinModel = new IzinModel();
        $userModel = new UserModel();
        $cutiBersamaModel = new CutiBersamaModel();
        $data['cuti_bersama'] = $cutiBersamaModel->findAll();
        $inisial = $session->get('inisial');

        if (!$session->get('inisial')) {
            return redirect()->to('/');
        } else {
            $data['surat_izin'] = $izinModel->where('inisial', $inisial)->findAll();
            $data['user'] = $userModel->find($id);
            return view('hr/izin', $data);
        }
    }

    public function create()
    {
        $izinModel = new IzinModel();
        $userModel = new UserModel();

        $cutiBersamaModel = new CutiBersamaModel();


        // Ambil input dari form
        $keterangan_waktu = $this->request->getPost('keterangan_waktu');
        $sampai_dengan = $this->request->getPost('sampai_dengan');
        $alasan_tidak_hadir = $this->request->getPost('alasan_tidak_hadir');

        // Gabungkan input menjadi satu string jika ada isian
        $sub_alasan_parts = [];

        if (!empty($keterangan_waktu)) {
            $sub_alasan_parts[] = "$keterangan_waktu";
        }
        if (!empty($sampai_dengan)) {
            $sub_alasan_parts[] = "$sampai_dengan";
        }
        if (!empty($alasan_tidak_hadir)) {
            $sub_alasan_parts[] = "$alasan_tidak_hadir";
        }

        // Gabungkan bagian-bagian yang ada menjadi satu string, atau biarkan kosong jika tidak ada bagian
        $sub_alasan = implode(' - ', $sub_alasan_parts);

        $id =  $this->request->getPost('id');

        $data = [
            'nama' => $this->request->getPost('nama'),
            'nik' => $this->request->getPost('nik'),
            'inisial' => session()->get('inisial'),
            'departemen' => $this->request->getPost('departemen'),
            'level' => $this->request->getPost('level'),
            'alasan_izin' => $this->request->getPost('alasan_izin'),
            'sub_alasan' => $sub_alasan,
            'izin_awal' => $this->request->getPost('izin_awal'),
            'izin_akhir'  => empty($this->request->getPost('izin_akhir')) ? null : $this->request->getPost('izin_akhir'),
            'izin_awal2'  => empty($this->request->getPost('izin_awal2')) ? null : $this->request->getPost('izin_awal2'),
            'izin_akhir2'  => empty($this->request->getPost('izin_akhir2')) ? null : $this->request->getPost('izin_akhir2'),
            'keterangan' => $this->request->getPost('keterangan'),
            'kendaraan' => $this->request->getPost('kendaraan'),
            'pengemudi' => $this->request->getPost('pengemudi'),
            'telp' => $this->request->getPost('telp'),
            'alamat' => $this->request->getPost('alamat'),
            'approval1' => in_array(session()->get('inisial'), ['HKO', 'TNR', 'FHP']) ? 1 : 0,
            'approval2' => in_array(session()->get('inisial'), ['HKO', 'TNR', 'FHP']) ? 1 : 0
        ];
        $id = session()->get('id');
        $izinModel->insert($data);
        $inisial = session()->get('inisial');
        $data['surat_izin'] = $izinModel->where('inisial', $inisial)->findAll();
        $data['user'] = $userModel->find($id);
        $data['cuti_bersama'] = $cutiBersamaModel->findAll();
        session()->setFlashdata('message', 'Izin berhasil dibuat.');

        return redirect()->back();
    }

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

    public function history($inisial)
    {
        $izinModel = new IzinModel();

        // Query untuk menampilkan data dengan filter nik dan alasan_izin = cuti
        $data['surat_izin'] = $izinModel->where('inisial', $inisial)
            ->where('alasan_izin !=', 'cuti')
            ->findAll();

        return view('hr/izin_history', $data);
    }

    public function batal($id)
    {
        $izinModel = new IzinModel();
        $inisial = session()->get('inisial');
        $izinModel->where('id_izin', $id)->delete();
        $izinByInisial['id_izin'] = $izinModel->findAll();
        $izinByInisial['surat_izin'] = $izinModel->where('inisial', session()->get('inisial'))->findAll();

        return redirect()->to("/hr/izin/history/$inisial");
    }

    public function approval_satu($id)
    {
        $izinModel = new IzinModel();
        $sisaCutiModel = new SisaCutiModel();
        $approval1 = $this->request->getPost('approval1');
        $alasan = $this->request->getPost('alasan_izin');
        $atasan = $this->request->getPost('atasan');

        $izinByID = $izinModel->find($id);

        if ($approval1 == 0) {
            return redirect()->to('/approval')->with('radio_zero', 'Pilih approve atau reject terlebih dulu.');
        } elseif ($alasan == 'cuti' && $atasan == 'HKO') {
            if ($approval1 == 1) {

                $data = [
                    'approval1' => $approval1,
                    'approval2' => 1,
                    'atasan' => $atasan
                ];

                $izinModel->update($id, $data);
            } else {
                $totalCuti = $izinByID['total_cuti'];
                $nik = $izinByID['nik'];
                $periode = $izinByID['periode_cuti'];

                $tbSisaCuti = $sisaCutiModel->where('nik', $nik)
                    ->where('periode', $periode)
                    ->first();

                $jumlah = $tbSisaCuti['sisa_cuti'] + $totalCuti;
                $sisaCutiModel->update($tbSisaCuti['id_sisa_cuti'], ['sisa_cuti' => $jumlah]);
            }

            $data = [
                'approval1' => $approval1,
                'atasan' => $atasan
            ];

            $izinModel->update($id, $data);
        } elseif ($alasan == 'cuti') {

            if ($approval1 == 9) {
                $totalCuti = $izinByID['total_cuti'];
                $nik = $izinByID['nik'];
                $periode = $izinByID['periode_cuti'];

                $tbSisaCuti = $sisaCutiModel->where('nik', $nik)
                    ->where('periode', $periode)
                    ->first();

                $jumlah = $tbSisaCuti['sisa_cuti'] + $totalCuti;
                $sisaCutiModel->update($tbSisaCuti['id_sisa_cuti'], ['sisa_cuti' => $jumlah]);
            }

            $data = [
                'approval1' => $approval1,
                'atasan' => $atasan
            ];

            $izinModel->update($id, $data);
        } else {
            $data = [
                'approval1' => $approval1,
                'atasan' => $atasan
            ];

            $izinModel->update($id, $data);
        }

        return redirect()->to('/approval');
    }

    public function approval_hr($id)
    {
        $izinModel = new IzinModel();
        $sisaCutiModel = new SisaCutiModel();
        $approval2 = $this->request->getPost('approval2');
        $alasan = $this->request->getPost('alasan_izin');

        $izinByID = $izinModel->find($id);


        if ($approval2 == 0) {
            return redirect()->to('/approval')->with('radio_zero', 'Pilih approve atau reject terlebih dulu.');
        } elseif ($alasan == 'cuti') {

            if ($approval2 == 9) {
                $totalCuti = $izinByID['total_cuti'];
                $nik = $izinByID['nik'];
                $periode = $izinByID['periode_cuti'];

                $tbSisaCuti = $sisaCutiModel->where('nik', $nik)
                    ->where('periode', $periode)
                    ->first();

                $jumlah = $tbSisaCuti['sisa_cuti'] + $totalCuti;
                $sisaCutiModel->update($tbSisaCuti['id_sisa_cuti'], ['sisa_cuti' => $jumlah]);
            }

            $data = [
                'approval2' => $approval2
            ];

            $izinModel->update($id, $data);
        } else {
            $data = [
                'approval2' => $approval2
            ];

            $izinModel->update($id, $data);
        }

        return redirect()->to('/approval');
    }

    public function update($id_izin)
    {
        $model = new IzinModel();

        $approval1 = $this->request->getPost('approval1') ? 1 : 0;
        $approval2 = $this->request->getPost('approval2') ? 1 : 0;

        $data = [
            'approval1' => $approval1,
            'approval2' => $approval2
        ];

        $model->update($id_izin, $data);

        return redirect()->to('/hr/izin');
    }

    public function izin_security($inisial)
    {
        $jadwalSecurityModel = new JadwalSecurityModel();
        $userModel = new UserModel();

        $data['jadwal'] = $jadwalSecurityModel->findAll();
        $data['user'] = $userModel->where('inisial', $inisial)->first();

        return view('/hr/izin_security', $data);
    }

    public function rekapHariIni()
    {
        // Inisialisasi model
        $izinModel = new IzinModel();

        // Ambil tanggal hari ini
        $today = date('Y-m-d');

        // Query untuk mendapatkan data izin yang berlaku hari ini
        $izin_hari_ini = $izinModel->where('izin_awal <=', $today)
            ->groupStart()
            ->where('alasan_izin', 'pulang lebih awal')
            ->orWhere('alasan_izin', 'meninggalkan kantor')
            ->groupEnd()
            ->findAll();

        // Array untuk konversi hari ke Bahasa Indonesia
        $hari = array(
            'Sunday'    => 'Minggu',
            'Monday'    => 'Senin',
            'Tuesday'   => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday'  => 'Kamis',
            'Friday'    => 'Jumat',
            'Saturday'  => 'Sabtu',
        );

        // Menentukan hari ini dalam Bahasa Indonesia
        $hari_ini = $hari[date('l')];

        // Data tambahan yang ingin dikirim ke view
        $data = [
            'izin_hari_ini' => $izin_hari_ini,  // Data izin yang berlaku hari ini
            'judul'         => 'Rekap Izin Hari Ini',  // Contoh variabel tambahan
            'tanggal'       => $today,  // Tanggal hari ini
            'hari'          => $hari_ini  // Hari ini dalam Bahasa Indonesia
        ];

        // Kirim data ke view
        return view('rekap_hari_ini', $data);
    }
}
