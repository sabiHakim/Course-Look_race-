<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Coureur extends Model
{
    use HasFactory;
    protected $table = 'coureur';
    public $timestamps = false;
    protected $fillable  = ['id' ,  'nom'   , 'numd' , 'genre' ,    'dtn'     , 'idequipe'];
    public static  function getnom_By_id($id)
    {
        $res = DB::select("select genre from coureur where id = ? ",[$id]);
//        dd($res);
        return $res[0]->genre;
    }
    public   static  function get_C_ide_idEquipe($idequipe,$idetape)
    {
        $resultat = DB::select("select * from v_temps_coureur_etape where idequipe = ? and ide = ?",[$idequipe,$idetape]);
        return $resultat;
    }
    public  static function  getC_by_E($id)
    {
        $res = DB::select("select * from coureur where idequipe = ?",[$id]);
        return $res;
    }
    public  static function  coureur_actuel_etape($idetape,$idequipe)
    {
        $res = DB::select("select * from v_coureur_etape_equipe where idetapes = ? and idequipe= ?",[$idetape,$idequipe]);
        return $res;
    }

    public static function  insert_coureur_etape($idCoureur,$idEtape)
    {
        $res = DB::select("insert into coureur_etape(idCoureur,idEtapes) values(?,?)",[$idCoureur,$idEtape]);
        return $res;
    }
    public  static function insert_temps_coureur_etape($ide,$idc,$arriver)
    {
        $res = DB::select("insert into temps_coureur_etape(ide,idc,arriver) values(?,?,?)",[$ide,$idc,$arriver]);
        return $res;
    }
    public  static  function maka_genre($id)
    {
        $res = DB::select("
                    select * from v_genre where ide= ? order by cla
        ",[$id]);
        return $res;
    }
    public  static  function classement($id)
    {
//                   select * from v_classement_equipe where ide= ? order by classementEquipe
        $res = DB::select("
                    select * from v_classement_equipe_p where ide= ? order by cla
        ",[$id]);
        return $res;
    }
    public  static  function classementEquipe()
    {
//                         select * from v_classement_equipe2 order by total_pts desc;
        $res = DB::select("select * from  v_classement_equipe_p22 order by total_pts desc;");
//        dd($res);
        return $res;
    }
    public  static  function Toute_Categorie($valeur)
    {   $res = '';
        if($valeur == 1){
            $res = Coureur::classementEquipe();
            return  $res;
        }
        else{
            $res = DB::select("
                             select * from v_calcul where cat = ?;
                            ",[$valeur]);
            return $res;
        }
    }

}
