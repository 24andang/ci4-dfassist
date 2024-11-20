<?

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\HR\IzinModel;

class RekapHariIni extends BaseController
{
    public function index()
    {
        // Inisialisasi model
        $izinModel = new IzinModel();

        // Ambil tanggal hari ini
        $today = date('Y-m-d');

        // Query untuk mendapatkan data izin yang berlaku hari ini
        $izin_hari_ini = $izinModel->where('izin_awal <=', $today)
            ->where('izin_akhir >=', $today)
            ->where('alasan_izin', 'pulang lebih awal')
            ->orWhere('alasan_izin', 'meninggalkan kantor')
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
