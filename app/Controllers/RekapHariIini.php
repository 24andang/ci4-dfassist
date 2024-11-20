<?

namespace App\Controllers;

use App\Controllers\BaseController;

class RekapHariIni extends BaseController
{
    public function rekapHariIniTL()
    {
        // Load view dari folder hr/rekap_hari_ini_tl
        return view('hr/rekap_hari_ini_tl');
    }
}
