<?php

namespace App\Controllers\HR;

use App\Models\Login\UserModel;
use App\Models\HR\IzinModel;
use App\Models\Users\DepartemenModel;
use App\Controllers\BaseController;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class RekapController extends BaseController
{
    public function rekap()
    {
        $izinModel = new IzinModel();
        $departemenModel = new DepartemenModel();

        // Mendapatkan semua departemen untuk ditampilkan di filter dropdown
        $data['departemen'] = $departemenModel->findAll();

        // Mengambil nilai filter dari form
        $filterDept = $this->request->getVar('departemen');
        $startDate = $this->request->getVar('start_date');
        $endDate = $this->request->getVar('end_date');

        // Mengambil data rekap sesuai filter yang diberikan
        $data['kehadiran'] = $izinModel->getRekapKehadiran($filterDept, $startDate, $endDate);

        return view('hr/rekap_kehadiran', $data);
    }


    public function excel()
    {

        $input = [[
            'nik' => $this->request->getVar('nik'),
            'nama' => $this->request->getVar('nama'),
            'I' => $this->request->getVar('I'),
            'C' => $this->request->getVar('C'),
            'S' => $this->request->getVar('S'),
            'CL' => $this->request->getVar('CL'),
            'Late' => $this->request->getVar('Late'),
            'PA' => $this->request->getVar('PA'),
            'LK' => $this->request->getVar('LK'),
        ]];

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set header kolom
        $sheet->setCellValue('A1', 'nik');
        $sheet->setCellValue('B1', 'nama');
        $sheet->setCellValue('C1', 'I');
        $sheet->setCellValue('D1', 'C');
        $sheet->setCellValue('E1', 'S');
        $sheet->setCellValue('F1', 'CL');
        $sheet->setCellValue('G1', 'Late');
        $sheet->setCellValue('H1', 'PA');
        $sheet->setCellValue('I1', 'LK');

        // Isi data ke spreadsheet
        $row = 2; // Mulai dari baris ke-2
        foreach ($input as $record) {
            $sheet->setCellValue('A' . $row, $record['nik']);
            $sheet->setCellValue('B' . $row, $record['nama']);
            $sheet->setCellValue('C' . $row, $record['I']);
            $sheet->setCellValue('D' . $row, $record['C']);
            $sheet->setCellValue('E' . $row, $record['S']);
            $sheet->setCellValue('F' . $row, $record['CL']);
            $sheet->setCellValue('G' . $row, $record['Late']);
            $sheet->setCellValue('H' . $row, $record['PA']);
            $sheet->setCellValue('I' . $row, $record['LK']);
            $row++;
        }

        // Tulis ke file Excel
        $writer = new Xlsx($spreadsheet);
        $filename = 'data_export.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }

    public function hari_ini()
    {
        $izinModel = new IzinModel();
        $data['izin_hari_ini'] = $izinModel
            ->where('izin_awal', date('Y-m-d'))
            ->groupStart()
            ->where('alasan_izin', 'pulang lebih awal')
            ->orWhere('alasan_izin', 'meninggalkan kantor')
            ->groupEnd()
            ->findAll();

        $hari = array(
            'Sunday' => 'Minggu',
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu',
        );

        $data['hari'] = $hari[date('l')];

        return view('/hr/rekap_hari_ini', $data);
    }

    public function rekap_dept()
    {
        $izinModel = new IzinModel();
        $data['alasan'] = $this->request->getVar('alasan');
        $tgl1 = $this->request->getVar('date1');
        $tgl2 = $this->request->getVar('date2');

        if ($data['alasan']) {
            // Ambil data yang berpotensi berada dalam range filter
            $dataIzin = $izinModel
                ->where('departemen', session()->get('departemen'))
                ->where('alasan_izin', $data['alasan'])
                ->groupStart()
                ->where('izin_awal <=', $tgl2)  // Ambil data yang dimulai sebelum atau pada tanggal akhir filter
                ->where('izin_akhir >=', $tgl1) // Ambil data yang berakhir setelah atau pada tanggal awal filter
                ->orWhere('izin_akhir', null)
                ->orderBy('izin_awal', 'ASC')
                ->groupEnd()
                ->findAll();

            $filteredData = [];
            foreach ($dataIzin as $izin) {
                $izinAkhir = $izin['izin_akhir'] ?: $izin['izin_awal'];

                $startDate = max($izin['izin_awal'], $tgl1); // Ambil tanggal yang lebih besar antara izin_awal dan date1
                $endDate = min($izinAkhir, $tgl2);

                if ($startDate <= $endDate) {
                    $izin['izin_akhir'] = $endDate;
                    $filteredData[] = $izin;
                }
            }

            $data['izin'] = $filteredData;
        } else {
            $data['izin'] = [];
        }

        return view('hr/rekap_dept', $data);
    }

    public function cut_off()
    {
        $izinModel = new IzinModel();
        $departemenModel = new DepartemenModel();
        $data['alasan'] = $this->request->getVar('alasan');
        $data['devisi'] = $this->request->getVar('dept');
        $data['nama'] = $this->request->getVar('nama');
        $tgl1 = $this->request->getVar('date1');
        $tgl2 = $this->request->getVar('date2');

        if ($data['alasan']) {
            // Ambil data yang berpotensi berada dalam range filter
            $dataIzin = $izinModel
                ->where('departemen', $data['devisi'])
                ->where('alasan_izin', $data['alasan'])
                ->like('nama', $data['nama'])
                ->groupStart()
                ->where('izin_awal <=', $tgl2)  // Ambil data yang dimulai sebelum atau pada tanggal akhir filter
                ->where('izin_akhir >=', $tgl1) // Ambil data yang berakhir setelah atau pada tanggal awal filter
                ->orWhere('izin_akhir', null)
                ->groupEnd()
                ->findAll();

            $filteredData = [];
            foreach ($dataIzin as $izin) {
                $izinAkhir = $izin['izin_akhir'] ?: $izin['izin_awal'];

                $startDate = max($izin['izin_awal'], $tgl1); // Ambil tanggal yang lebih besar antara izin_awal dan date1
                $endDate = min($izinAkhir, $tgl2);

                if ($startDate <= $endDate) {
                    $izin['izin_akhir'] = $endDate;
                    $filteredData[] = $izin;
                }
            }

            $data['izin'] = $filteredData;
            $data['departemen'] = $departemenModel->findAll();
        } else {
            $data['izin'] = [];
            $data['departemen'] = $departemenModel->findAll();
        }

        return view('/hr/rekap_cut_off', $data);
    }
}
