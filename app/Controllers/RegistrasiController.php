<?php

namespace App\Controllers;

use App\Models\RegistrasiModel;
use CodeIgniter\Controller;

class RegistrasiController extends BaseController
{
    
    public function index()
    {
        // Periksa apakah pengguna sudah login
        if (!session()->get('inisial')) {
            return redirect()->to('/login');
        }else{
            $model = new RegistrasiModel();
            $data['registrasi'] = $model->findAll();
    
            return view('registrasi/index', $data);
        }

        // $session = session()->get('inisial'); 
        // if ($session != '') {
           

       
    }

    public function create()
    {
        $registrasiModel = new RegistrasiModel();
        $data = [
            'tanggal_mou' => $this->request->getPost('tanggal_mou'),
            'nomor_surat' => $this->request->getPost('nomor_surat'),
            'nama_perusahaan' => $this->request->getPost('nama_perusahaan'),
            'user' => $this->request->getPost('user'),
            'merk' => $this->request->getPost('merk'),
            'akhir_kontrak' => $this->request->getPost('akhir_kontrak')
        ];

        $registrasiModel->save($data);

        return redirect()->to('/reg-maklon')->with('message', 'Data berhasil ditambahkan.');
    }

    public function store()
    {
        $model = new RegistrasiModel();
        
        $data = [
            'tanggal_mou' => $this->request->getPost('tanggal_mou'),
            'nomor_surat' => $this->request->getPost('nomor_surat'),
            'nama_perusahaan' => $this->request->getPost('nama_perusahaan'),
            'user' => $this->request->getPost('user'),
            'merk' => $this->request->getPost('merk'),
            'akhir_kontrak' => $this->request->getPost('akhir_kontrak'),
        ];
        
        $model->save($data);
        
        return redirect()->to('/reg-maklon');
    }

    public function edit($id)
    {
        $model = new RegistrasiModel();
        $data['registrasi'] = $model->find($id);
        
        return view('registrasi/edit', $data);
    }

    public function update($id)
    {
        $registrasiModel = new RegistrasiModel();
        $data = [
            'id' => $id,
            'tanggal_mou' => $this->request->getPost('tanggal_mou'),
            'nomor_surat' => $this->request->getPost('nomor_surat'),
            'nama_perusahaan' => $this->request->getPost('nama_perusahaan'),
            'user' => $this->request->getPost('user'),
            'merk' => $this->request->getPost('merk'),
            'akhir_kontrak' => $this->request->getPost('akhir_kontrak')
        ];

        $registrasiModel->save($data);

        return redirect()->to('/reg-maklon')->with('message', 'Data berhasil diperbarui.');
    }

    public function delete($id)
    {
        $registrasiModel = new RegistrasiModel();

        if ($registrasiModel->find($id)) {
            $registrasiModel->delete($id);
            return redirect()->to('/reg-maklon')->with('message', 'Data berhasil dihapus.');
        } else {
            return redirect()->to('/reg-maklon')->with('message', 'Data tidak ditemukan.');
        }
    }
}
