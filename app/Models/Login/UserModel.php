<?php

namespace App\Models\Login;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $DBGroup = 'users';
    protected $table      = 'users';
    protected $primaryKey = 'id';

    // protected $useAutoIncrement = true;
    // protected $returnType       = 'array';
    // protected $useSoftDeletes   = true;

    protected $allowedFields = ['nik', 'inisial', 'nama', 'departemen', 'jabatan', 'pass', 'level', 'tgl_join'];

    // protected $useTimestamps = true;
    // protected $createdField  = 'created_at';
    // protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at';

    // protected $validationRules    = [];
    // protected $validationMessages = [];
    // protected $skipValidation     = false;

    public function getUserByNik($nik)
    {
        return $this->where('nik', $nik)->first();
    }
}
