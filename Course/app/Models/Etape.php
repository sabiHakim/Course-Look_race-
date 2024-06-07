<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Etape extends Model
{
    use HasFactory;
    protected $table = 'etape';
    public $timestamps = false;
    protected  $fillable = ['id', 'nom' , 'longuer' , 'nb_coureur_equipe' , 'rang_etape','datedepart','heurre_depart'];
    public  static function  get_nb_etape($id)
    {
         $res = DB::select("select nb_coureur_equipe  from etape where id = ?",[$id]);
         $result  = $res[0]->nb_coureur_equipe;
         return $result;
    }
    public  static function  get_c_etape($id)
    {
         $res = DB::select("select *  from v_coureur_etape where idetapes = ?",[$id]);
         return $res;
    }
    public   static function get_Depart($id)
    {
        $res = DB::select("select * from etape where id = ?",[$id]);
//        dd($res[0]);
        return $res[0];
    }
    public  static function  conversion($totalSeconds)
    {
        $days = floor($totalSeconds / (60 * 60 * 24));
        $hours = floor(($totalSeconds - ($days * 60 * 60 * 24)) / (60 * 60));
        $minutes = floor(($totalSeconds - ($days * 60 * 60 * 24) - ($hours * 60 * 60)) / 60);
        $seconds = $totalSeconds % 60;
        $formattedDifference = "$days j $hours:$minutes:$seconds";
        return  $formattedDifference;
    }
    public static function checkNombre($nombre) {
        $pattern = '/[^a-zA-Z0-9.\sàâäèéêëïîôöùûüÀÂÄÈÉÊËÏÎÔÖÙÛÜ]/';
        if (preg_match($pattern, $nombre)) {
            return false;
        }
        if ($nombre < 0) {
            return false;
        }
        return true;
    }
    public static  function  insertEtapecsv($nom , $longuer , $nb_coureur_equipe , $rang_etape,$datedepart,$heurre_depart)
    {
        DB::select("insert into etape(nom ,longuer , nb_coureur_equipe , rang_etape ,datedepart,date_heure_depart)values(?,?,?,?,?,?)",[$nom,$longuer,$nb_coureur_equipe,$rang_etape,$datedepart,$heurre_depart]);
    }
}
