<?php

namespace App\Models;

use CodeIgniter\Model;

class PenilaianModel extends Model
{
    protected $table = 'tb_penilaian';
    protected $primaryKey = 'id_penilaian';
    protected $allowedFields = ['id_alternatif', 'id_kriteria', 'nilai'];
}
