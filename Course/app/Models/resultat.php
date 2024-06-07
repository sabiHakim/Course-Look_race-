<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class resultat extends Model
{
    use HasFactory;
    protected $table = 'resultat';
    public $timestamps = false;
    protected  $fillable  = ['etape_rang ','numero_dossard','nom','genre','date_naissance','equipe','arriver'];
    public  static function insert($etape_rang,$umero_dossard,$nom,$genre,$date_naissance,$equipe,$arriver)
    {
      $res =  DB::select("insert into resultat( etape_rang,numero_dossard,nom,genre,date_naissance,equipe,arriver)values(?,?,?,?,?,?,?)",[$etape_rang,$umero_dossard,$nom,$genre,$date_naissance,$equipe,$arriver]);
    return $res;
    }
}
