<?php

namespace App\Controllers;

use App\Models\ProgressModel;
use App\Models\RegistrasiModel;
use CodeIgniter\Controller;

class ProgressController extends Controller
{
    public function index()
{
    $progressModel = new ProgressModel();
    $registrasiModel = new RegistrasiModel();

    $data['progress'] = $progressModel->select('progress.*, registrasi.merk, registrasi.nama_perusahaan')
        ->join('registrasi', 'registrasi.id = progress.registrasi_id')
        ->findAll();

    // Mengambil data registrasi
    $data['registrasi'] = $registrasiModel->findAll(); // Atau gunakan metode lain sesuai kebutuhan

    return view('progress/index', $data);
}

    public function create()
    {
        $registrasiModel = new RegistrasiModel();
        $data['registrasi'] = $registrasiModel->findAll();
        
        return view('progress/create', $data);
    }

    public function store()
    {
        $progressModel = new ProgressModel();
        
        $data = [
            'registrasi_id' => $this->request->getPost('registrasi_id'),
        ];
        
        $progressModel->save($data);
        
        return redirect()->to('/prog-maklon');
    }

    public function edit($id)
    {
        $progressModel = new ProgressModel();
        $registrasiModel = new RegistrasiModel();

        $data['progress'] = $progressModel->find($id);
        $data['registrasi'] = $registrasiModel->findAll();
        
        return view('progress/edit', $data);
    }

    public function update($id)
    {
    $progressModel = new ProgressModel();
    $data = [
        //'registrasi_id' => $this->request->getPost('registrasi_id'),
        'dp' => $this->request->getPost('dp') ? 1 : 0,
        'rmpm' => $this->request->getPost('rmpm') ? 1 : 0,
        'desain_mockup' => $this->request->getPost('desain_mockup') ? 1 : 0,
        'produksi' => $this->request->getPost('produksi') ? 1 : 0,
        'surat_jalan' => $this->request->getPost('surat_jalan') ? 1 : 0,
        'pelunasan' => $this->request->getPost('pelunasan') ? 1 : 0,
        'pengiriman' => $this->request->getPost('pengiriman') ? 1 : 0,
    ];

    $progressModel->update($id, $data);

    return redirect()->to('/prog-maklon');
    }

    public function delete($id)
    {
        $progressModel = new ProgressModel();
        $progressModel->delete($id);

        return redirect()->to('/prog-maklon')->with('success', 'Data deleted successfully');
    }

}
