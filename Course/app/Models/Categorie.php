<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Categorie extends Model
{
    use HasFactory;
    protected $table = 'categorie';
    public $timestamps = false;
    protected  $fillable = [ 'id' , 'nom' , 'age'];
    public   static  function  generer()
    {
        $res = DB::select("select * from v_coureur_age");
        return $res;
    }
    public   static function distinct()
    {
        $r = DB::select("select distinct cat from v_coureur_age ");
    }
}
