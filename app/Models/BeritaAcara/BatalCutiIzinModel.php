<?php

namespace App\Models\BeritaAcara;

use CodeIgniter\Model;

class BatalCutiIzinModel extends Model
{
    protected $table = 'batal_cuti_izin';
    protected $primaryKey = 'id_batal';

    protected $allowedFields = ['id_izin', 'alasan_batal', 'nik', 'nama', 'departemen', 'izin_awal', 'alasan_izin', 'inisial', 'history', 'total_cuti', 'periode_cuti'];

    // Tambahkan ini untuk memastikan model menggunakan database hr
    protected $DBGroup = 'ci4hr';
}
