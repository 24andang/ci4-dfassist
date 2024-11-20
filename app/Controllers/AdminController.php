<?php

namespace App\Controllers;

use App\Models\Login\UserModel;
use App\Controllers\BaseController;
use App\Models\Users\JabatanModel;
use App\Models\Users\DepartemenModel;


class AdminController extends BaseController
{
    public function index()
    {
        if (!session()->get('inisial')) {
            return redirect()->to('/login');
        } else {
            $model = new UserModel();
            $jabatanModel = new JabatanModel();
            $deptModel = new DepartemenModel();
            $data['user'] = $model->findAll();
            $data['jabatan'] = $jabatanModel->findAll();
            $data['departemen'] = $deptModel->findAll();

            return view('admin/index', $data);
        }
    }

    public function create()
    {
        $userModel = new UserModel();
        $jabatanModel = new JabatanModel();
        $deptModel = new DepartemenModel();

        $data['departemen'] = $deptModel->findAll();
        $inisial = $this->request->getPost('inisial');
        $userRow = $userModel->where('inisial', $inisial)->first();
        $jabatan =  $this->request->getPost('jabatan');
        $tgl_join = $this->request->getPost('tgl_join');

        if ($userRow) {
            session()->setFlashdata('message', 'Inisial sudah digunakan oleh ' . $userRow['nama'] . ' - ' . $userRow['departemen']);
        } else {
            $data = [
                'inisial' => $inisial,
                'nama' => $this->request->getPost('nama'),
                'nik' => $this->request->getPost('nik'),
                'departemen' => $this->request->getVar('departemen'),
                'tgl_join' => date('d-m-Y', strtotime($tgl_join)),
                'jabatan' => $jabatan,
                'level' => $jabatanModel->select('level')->where('jabatan', $jabatan)->first(),
                'pass' => $this->request->getVar('pass'),
            ];
            $userModel->save($data);
        }
        $data['user'] = $userModel->findAll();
        $data['jabatan'] = $jabatanModel->findAll();

        return redirect()->to('/admin');
    }

    public function update($id)
    {
        $userModel = new UserModel();
        $deptModel = new DepartemenModel();
        $jabatanModel = new JabatanModel();

        $data['jabatan'] = $jabatanModel->findAll();
        $data['departemen'] = $deptModel->findAll();
        $userRow = $userModel->where('id', $id)->first();

        $updatedata = [
            'inisial' => $this->request->getPost('inisial'),
            'nama' => $this->request->getPost('nama'),
            'dept' => $this->request->getPost('dept'),
            'jabatan' => $this->request->getPost('jabatan'),
            'pass' => $this->request->getVar('pass'),
        ];
        $userModel->update($id, $updatedata);

        $data['user'] = $userModel->findAll();

        session()->setFlashdata('message', 'Data ' . $userRow['nama'] . ' berhasil diubah.');
        return view('admin/index', $data);
    }

    public function delete($id)
    {
        $userModel = new UserModel();
        $jabatanModel = new JabatanModel();
        $deptModel = new DepartemenModel();

        $userModel->delete($id);
        $data['departemen'] = $deptModel->findAll();
        $data['user'] = $userModel->findAll();
        $data['jabatan'] = $jabatanModel->findAll();

        session()->setFlashdata('message', 'Data user dihapus');
        return view('admin/index', $data);
    }
}
