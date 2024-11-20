<?php

namespace App\Controllers\Info;

use App\Controllers\BaseController;
use App\Models\Info\LogbookModel;

class LogbookController extends BaseController
{
    public function penerimaanPaket()
    {
        $logbookModel = new LogbookModel();
        $data['logs'] = $logbookModel->where('kategori', 'paket')->where('pengambil', '')->findAll();
        return view('info/penerimaan-paket', $data);
    }

    public function pengambilanPaket()
    {
        $logbookModel = new LogbookModel();
        $id = $this->request->getVar('id');
        $update = [
            'pengambil' => $this->request->getVar('departemen') . ' - ' . $this->request->getVar('inisial')
        ];

        $logbookModel->update($id, $update);

        return redirect()->back()->with('diambil', 'Barang / paket berhasil diambil');
    }

    public function historyPaket()
    {
        $logbookModel = new LogbookModel();
        $data['category'] = $this->request->getVar('category');
        $date1 = $this->request->getVar('date1');
        $date2 = $this->request->getVar('date2');
        $logs = [];
        if ($data['category']) {
            $logs = $logbookModel
                ->where('kategori', $data['category'])
                ->where('pengambil !=', null)
                ->groupStart()
                ->where('tanggal >=', $date1)
                ->where('tanggal <=', $date2)
                ->groupEnd()
                ->findAll();
        }

        $data['logs'] = $logs;
        return view('info/history-paket', $data);
    }
}
