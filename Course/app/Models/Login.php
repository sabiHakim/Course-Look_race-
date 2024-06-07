<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Login extends Model
{
    use HasFactory;
    protected $table = 'admin';
    public $timestamps = false;
    protected  $fillable = ['login','pwd'];
    public   static  function  checkM($nom,$mdp)
    {
        $resultat = DB::select("select * from admin where login =? and pwd =?",[$nom,$mdp]);
        return $resultat;
    }
    public   static  function  checkE($nom,$mdp)
    {
        $resultat = DB::select("select * from equipe where login =? and pwd =?",[$nom,$mdp]);
        return $resultat;
    }
    public  static function  initialiser()
    {
        DB::select("truncate temps_coureur_etape cascade");
        DB::select("truncate coureur_etape cascade");
        DB::select("truncate etape cascade");
        DB::select("truncate categori_coureur cascade");
        DB::select("truncate coureur cascade");
//        DB::select("truncate categorie cascade");
        DB::select("truncate equipe cascade ");
        DB::select("truncate resultat cascade ");
        DB::select("truncate point cascade ");
        DB::select("truncate penalite cascade ");
        return redirect('admin');
    }
}
