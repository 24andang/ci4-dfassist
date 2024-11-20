<?php

namespace App\Controllers\BeritaAcara;

use App\Controllers\BaseController;
use App\Models\HR\IzinModel;
use App\Models\BeritaAcara\BatalCutiIzinModel;
use App\Models\HR\SisaCutiModel;
use App\Models\Login\UserModel;

class HRController extends BaseController
{
    public function batal_cuti_izin()
    {
        $izinModel = new IzinModel();

        $data['absensi'] = $izinModel->where('approval1', 1)->findAll();

        return view('/berita_acara/batal_cuti_izin', $data);
    }

    public function ajukan_batal_izin()
    {
        $batalModel = new BatalCutiIzinModel();
        $izinModel = new IzinModel();
        $id_izin = $this->request->getVar('id_izin');


        if ($batalModel->where('id_izin', $id_izin)->first()) {
            session()->setFlashdata('block', 'Berita acara sudah diajukan, tidak bisa duplikat.');
        } else {

            $input = [
                'id_izin' => $id_izin,
                'alasan_batal' => $this->request->getVar('alasan_batal'),
                'alasan_batal' => $this->request->getVar('alasan_batal'),
                'izin_awal' => $this->request->getVar('izin_awal'),
                'alasan_izin' => $this->request->getVar('alasan_izin'),
                'nik' => session()->get('nik'),
                'nama' => session()->get('nama'),
                'inisial' => session()->get('inisial'),
                'departemen' => session()->get('departemen'),
                'total_cuti' => $this->request->getVar('total_cuti'),
                'periode_cuti' => $this->request->getVar('periode_cuti')
            ];

            $batalModel->save($input);

            session()->setFlashdata('pass', 'Berita acara berhasil diajukan.');
        }

        $data['surat_izin'] = $izinModel->where('inisial', session()->get('inisial'))->where('alasan_izin !=', 'cuti')->findAll();
        $data['id_izin'] = $izinModel->findAll();

        return view('/hr/izin_history', $data); //------------------- PR (berita acara cuti tetap masuk ke history izin)
    }

    public function ajukan_batal_cuti()
    {
        $batalModel = new BatalCutiIzinModel();
        $izinModel = new IzinModel();
        $id_izin = $this->request->getVar('id_izin');


        if ($batalModel->where('id_izin', $id_izin)->first()) {
            session()->setFlashdata('block', 'Berita acara sudah diajukan, tidak bisa duplikat.');
        } else {

            $input = [
                'id_izin' => $id_izin,
                'alasan_batal' => $this->request->getVar('alasan_batal'),
                'alasan_batal' => $this->request->getVar('alasan_batal'),
                'izin_awal' => $this->request->getVar('izin_awal'),
                'alasan_izin' => $this->request->getVar('alasan_izin'),
                'nik' => session()->get('nik'),
                'nama' => session()->get('nama'),
                'inisial' => session()->get('inisial'),
                'departemen' => session()->get('departemen'),
                'total_cuti' => $this->request->getVar('total_cuti'),
                'periode_cuti' => $this->request->getVar('periode_cuti')
            ];

            $batalModel->save($input);

            session()->setFlashdata('pass', 'Berita acara berhasil diajukan.');
        }

        $data['surat_izin'] = $izinModel->where('inisial', session()->get('inisial'))->where('alasan_izin', 'cuti')->findAll();
        $data['id_izin'] = $izinModel->findAll();

        return view('/hr/cuti_history', $data); //------------------- PR (berita acara cuti tetap masuk ke history izin)
    }

    public function batalkan_cuti_izin()
    {
        $batalModel = new BatalCutiIzinModel();

        $data['batalkan'] = $batalModel->findAll();

        return view('/berita_acara/batal_cuti_izin', $data);
    }

    public function batalkan_by_hr()
    {
        $batalModel = new BatalCutiIzinModel();
        $izinModel = new IzinModel();
        $sisaCutiModel = new SisaCutiModel();

        $id_izin = $this->request->getVar('id_izin');
        $id_batal = $this->request->getVar('id_batal');
        $izin = $izinModel->find($id_izin);


        if ($izin && $izin['alasan_izin'] == 'cuti') {
            // Ambil total cuti dan nik dari data izin
            $totalCuti = $izin['total_cuti'];
            $nik = $izin['nik'];
            $periode_cuti = $izin['periode_cuti']; // Asumsi ada kolom periode di tabel surat_izin

            // Update sisa cuti di tabel tb_sisa_cuti
            $sisaCuti = $sisaCutiModel->where('nik', $nik)
                ->where('periode', $periode_cuti)
                ->first();

            if ($sisaCuti) {
                // Tambah sisa cuti dengan total cuti yang akan dihapus
                $newSisaCuti = $sisaCuti['sisa_cuti'] + $totalCuti;

                // Update sisa cuti
                $sisaCutiModel->update($sisaCuti['id_sisa_cuti'], ['sisa_cuti' => $newSisaCuti]);
            }
        }

        $update = [
            'history' => $this->request->getVar('inisial_hr')
        ];

        $batalModel->update($id_batal, $update); // Update persetujuan pembatalan cuti/izin
        $data['batalkan'] = $batalModel->findAll(); // kembalikan data untuk history
        $izinModel->where('id_izin', $id_izin)->delete(); // delete dari tb surat_izin = mengurangi rekap
        session()->setFlashdata('done', 'Berita acara pembatalan cuti/izin telah disetujui.');

        return view('/berita_acara/batal_cuti_izin', $data);
    }

    public function delete($id_izin)
    {
        $izinModel = new IzinModel();
        $sisaCutiModel = new SisaCutiModel();

        // Ambil data izin yang akan dihapus
        $izin = $izinModel->find($id_izin);

        if ($izin && $izin['alasan_izin'] == 'cuti') {
            // Ambil total cuti dan nik dari data izin
            $totalCuti = $izin['total_cuti'];
            $nik = $izin['nik'];
            $periode = $izin['periode']; // Asumsi ada kolom periode di tabel surat_izin

            // Update sisa cuti di tabel tb_sisa_cuti
            $sisaCuti = $sisaCutiModel->where('nik', $nik)
                ->where('periode', $periode)
                ->first();

            if ($sisaCuti) {
                // Tambah sisa cuti dengan total cuti yang akan dihapus
                $newSisaCuti = $sisaCuti['sisa_cuti'] + $totalCuti;

                // Update sisa cuti
                $sisaCutiModel->update($sisaCuti['id_sisa_cuti'], ['sisa_cuti' => $newSisaCuti]);
            }
        }

        // Hapus data izin
        $izinModel->delete($id_izin);

        // Redirect kembali ke daftar cuti
        return redirect()->to('daftar-cuti')->with('message', 'Data cuti berhasil dihapus.');
    }
}
