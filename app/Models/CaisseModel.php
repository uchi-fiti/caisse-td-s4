<?php

namespace App\Models;

use CodeIgniter\Model;

class CaisseModel extends Model
{
    protected $table         = 'caisse';
    protected $primaryKey    = 'id';

    protected $allowedFields = ['nom'];

    public function getCaisseByName($name){
        return $this->where('nom', $name)->first();
    }
}
