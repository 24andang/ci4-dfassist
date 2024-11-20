<?php

namespace App\Controllers\HR;

use App\Controllers\BaseController;
use App\Models\Login\UserModel;
use App\Models\HR\HakCutiModel;
use App\Models\HR\SisaCutiModel;
use App\Models\HR\IzinModel;
use App\Models\HR\CutiBersamaModel;
use App\Models\HR\JadwalSecurityModel;
use CodeIgniter\Database\Query;

class CutiController extends BaseController
{
    public function index()
    {
        $model = new SisaCutiModel();

        // Ambil data periode dan sisa_cuti
        $sisaCutiData = $model->getSisaCutiData(); // Pastikan method ini ada di model
        $periodeOptions = array_keys($sisaCutiData);

        $data = [
            'periode_options' => $periodeOptions,
            'sisa_cuti_data' => $sisaCutiData
        ];

        $cutiBersamaModel = new CutiBersamaModel();


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
        $data['cuti_bersama']  = $cutiBersamaModel->findAll();

        return view('/hr/cuti', $data);
    }

    // ===========================

    public function submit()
    {
        $model = new IzinModel();
        $sisaCutiModel = new SisaCutiModel();

        $nik = $this->request->getPost('nik');
        $periode = $this->request->getPost('periode');
        $sisa_cuti = $this->request->getPost('sisa_cuti');
        $sisa_cuti_hidden = $this->request->getPost('sisa_cuti_hidden');
        $total_cuti = $this->request->getPost('total_cuti');
        $sisa_cuti_input = $sisa_cuti - $total_cuti;

        $dataCuti = [
            'nik' => $nik,
            'inisial' => $this->request->getPost('inisial'),
            'nama' => $this->request->getPost('nama'),
            'sisa_cuti' => $sisa_cuti_input,
            'periode_cuti' => $periode,
            'departemen' => $this->request->getPost('departemen'),
            'total_cuti' => $this->request->getPost('total_cuti'),
            'level' => $this->request->getPost('level'),
            'alasan_izin' => $this->request->getPost('alasan_izin'),
            'izin_awal' => $this->request->getPost('izin_awal'),
            'izin_akhir'  => empty($this->request->getPost('izin_akhir')) ? null : $this->request->getPost('izin_akhir'),
            'izin_awal2'  => empty($this->request->getPost('izin_awal2')) ? null : $this->request->getPost('izin_awal2'),
            'izin_akhir2'  => empty($this->request->getPost('izin_akhir')) ? null : $this->request->getPost('izin_akhir2'),
            'tgl_masuk_kerja' => $this->request->getPost('tgl_masuk_kerja'),
            'keterangan' => $this->request->getPost('keterangan'),
            'telp' => $this->request->getPost('telp'),
            'alamat' => $this->request->getPost('alamat'),
            'approval1' => in_array(session()->get('inisial'), ['HKO', 'TNR', 'FHP']) ? 1 : 0,
            'approval2' => in_array(session()->get('inisial'), ['HKO', 'TNR', 'FHP']) ? 1 : 0
        ];

        if ($sisa_cuti_hidden < $total_cuti) {

            session()->setFlashdata('block_cuti', 'Jumlah hari cuti tidak bisa melebihi sisa hak cuti.');

            return redirect()->back();
        } else if (!$sisa_cuti_hidden) {

            $sisaCutiModel->where('nik', $nik)
                ->where('periode', $periode)
                ->set(['sisa_cuti' => $sisa_cuti_input])
                ->update();

            $model->insert($dataCuti);

            return redirect()->back()->with('pass_cuti', 'Pengajuan cuti berhasih dibuat.'); //harus kembali ke halaman yang akses controller index cuti

        } else {

            $sisaCutiModel->where('nik', $nik)
                ->where('periode', $periode)
                ->set(['sisa_cuti' => $sisa_cuti_input])
                ->update();

            $model->insert($dataCuti);

            return redirect()->back()->with('pass_cuti', 'Pengajuan cuti berhasih dibuat.'); //harus kembali ke halaman yang akses controller index cuti
        }
    }

    public function cuti_spesial()
    {
        $cutiBersamaModel = new CutiBersamaModel();
        $data['cuti_bersama']  = $cutiBersamaModel->findAll();

        return view('/hr/cuti_spesial', $data);
    }

    public function create_cuti_spesial()
    {
        $cutiBersamaModel = new CutiBersamaModel();
        $izinModel = new IzinModel();
        $userModel = new UserModel();

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
            'izin_akhir2'  => empty($this->request->getPost('izin_akhir')) ? null : $this->request->getPost('izin_akhir2'),
            'keterangan' => $this->request->getPost('keterangan'),
            'kendaraan' => $this->request->getPost('kendaraan'),
            'pengemudi' => $this->request->getPost('pengemudi'),
            'telp' => $this->request->getPost('telp'),
            'alamat' => $this->request->getPost('alamat'),
            'approval1' => 0,
            'approval2' => 0
        ];
        $id = session()->get('id');
        $izinModel->insert($data);
        $inisial = session()->get('inisial');
        $data['surat_izin'] = $izinModel->where('inisial', $inisial)->findAll();
        $data['user'] = $userModel->find($id);
        $data['cuti_bersama']  = $cutiBersamaModel->findAll();

        session()->setFlashdata('message', 'Izin berhasih dibuat.');

        return view('hr//cuti_spesial', $data);
    }

    // ===========================

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
                'jatah_security' => 12,
                'jatah_karyawan_baru' => 0

            ];

            $HCModel->save($data);

            $allUser = $userModel->findAll();

            foreach ($allUser as $user) {

                // Hitung selisih tahun dari tanggal_join
                $tanggalJoinDate = new \DateTime(date('d-m-Y', strtotime($user['tgl_join'])));
                $today = new \DateTime();
                $diff = $today->diff($tanggalJoinDate);

                if ($user['jabatan'] == 'Security' && $user['inisial'] !== 'NIH') {
                    $jatah_cuti = 12;
                } elseif ($diff->y < 1) {
                    $jatah_cuti = 0;
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

    public function hapus_periode()
    {
        $HCModel = new HakCutiModel();
        $sisaCutiModel = new SisaCutiModel();
        $periode = $this->request->getVar('periode');

        $HCModel->where('periode', $periode)->delete();
        $sisaCutiModel->where('periode', $periode)->delete();

        session()->setFlashdata('done', "Periode . $periode . telah hangus.");

        return view('/hr/input_hak_cuti');
    }

    // public function per_nik()
    // {
    //     $sisaCutiModel = new SisaCutiModel();
    //     $nik = $this->request->getVar('nik');
    //     $periode = $this->request->getVar('periode');

    //     $update = [
    //         'hak_cuti' => $this->request->getVar('hak_cuti'),
    //     ];

    //     $sisaCutiModel->where('nik', $nik)->where('periode', $periode)->update($update);

    //     session()->setFlashdata('done', "Periode . $periode . telah hangus.");

    //     return view('/hr/input_hak_cuti');
    // }

    public function history($inisial)
    {
        $izinModel = new IzinModel();

        // Query untuk menampilkan data dengan filter nik dan alasan_izin = cuti
        $data['surat_izin'] = $izinModel->where('inisial', $inisial)
            ->where('alasan_izin', 'cuti')
            ->findAll();

        return view('hr/cuti_history', $data);
    }

    public function cuti_bersama()
    {
        $cutiBersamaModel = new CutiBersamaModel();
        $data['cuti_bersama'] = $cutiBersamaModel->where('keterangan !=', 'weekend')->findAll();
        return view('/hr/cuti_bersama', $data);
    }

    public function input_cuti_bersama()
    {
        $cutiBersamaModel = new CutiBersamaModel();
        $cuber = $this->request->getVar('cuber');
        $keterangan = $this->request->getVar('keterangan');

        $dataInput = [
            'keterangan' => $cuber ? $cuber : $keterangan,
            'tanggal' => $this->request->getVar('tanggal')
        ];

        // Asumsikan Anda menggunakan model untuk menyimpan data
        $cutiBersamaModel->insert($dataInput);

        // Redirect atau tampilan sesuai kebutuhan
        return redirect()->to('/hr/cuti/bersama');
    }

    public function hapus_cuti_bersama($id)
    {
        $cutiBersamaModel = new CutiBersamaModel();
        $cutiBersamaModel->where('id', $id)->delete();
        return redirect()->to('/hr/cuti/bersama');
    }

    public function batal($id)
    {
        $sisaCutiModel = new SisaCutiModel();
        $izinModel = new IzinModel();
        $izinByID = $izinModel->find($id);
        $totalCuti = $izinByID['total_cuti'];
        $nik = $izinByID['nik'];
        $periode = $izinByID['periode_cuti'];

        $tbSisaCuti = $sisaCutiModel->where('nik', $nik)
            ->where('periode', $periode)
            ->first();

        $jumlah = $tbSisaCuti['sisa_cuti'] + $totalCuti;
        $sisaCutiModel->update($tbSisaCuti['id_sisa_cuti'], ['sisa_cuti' => $jumlah]);
        $izinModel->delete($id);

        return redirect()->to('/hr/cuti/history/' . $izinByID['inisial']);
    }

    public function cuti_security($inisial)
    {
        $userModel = new UserModel();
        $sisaCutiModel = new SisaCutiModel();
        $jadwalSecurityModel = new JadwalSecurityModel();

        $namaUser = $userModel->select('nama')->where('inisial', $inisial)->first();
        $nikUser = $userModel->where('inisial', $inisial)->select('nik')->first();
        $data['user'] = $userModel->where('inisial', $inisial)->first();
        $data['sisa_cuti'] = $sisaCutiModel->where('nik', $nikUser)->findAll();
        $data['jadwal'] = $jadwalSecurityModel->where('nama_1', $namaUser)->orWhere('nama_2', $namaUser)->findAll();

        return view('/hr/cuti_security', $data);
    }
}
