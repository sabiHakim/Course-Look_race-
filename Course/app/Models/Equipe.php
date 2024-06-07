<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Equipe extends Model
{
    use HasFactory;
    protected $table = 'equipe';
    public $timestamps = false;
    protected  $fillable = [ 'id',   'nom'   , 'login' , 'pwd'];
//    public  function  genererEquipe()
//    {
//        $res = resultat::all();
//        foreach ($res as $r)
//        {
//            DB::select("ini");
//
//        }
//    }
}
