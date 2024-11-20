<?php

namespace App\Models;

use CodeIgniter\Model;

class ProgressModel extends Model
{
    protected $DBGroup = 'maklon';
    protected $table = 'progress';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'registrasi_id', 'dp', 'rmpm', 'desain_mockup', 'produksi', 'surat_jalan', 'pelunasan', 'pengiriman'
    ];
}
