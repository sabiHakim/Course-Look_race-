<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Penalite extends Model
{
    use HasFactory;
    protected $table = 'penalite';
    public $timestamps = false;
    protected  $fillable = [ 'id_etapes' , 'id_equipe' , 'temps'];
    public  static function  penalite($idetape,$idequipe,$time)
    {
        $res  =DB::select("INSERT into penalite(id_etapes,id_equipe,temps)values(?,?,?) ",[$idetape,$idequipe,$time]);
        return $res;
    }
}
