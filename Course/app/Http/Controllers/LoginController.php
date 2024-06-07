<?php

namespace App\Http\Controllers;

use App\Models\Coureur;
use App\Models\Etape;
use App\Models\Login;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    //
    public  function  traitLogin(Request $request)
    {
        $n = $request->input('name');
        $m = $request->input('mdp');
        $res = Login::checkM($n,$m);
        if($res)
        {
            session()->put('admin',$res);
            $res = Etape::all();

            return view('acceuilAdmin.accAdmin',compact('res'));
        }
        return redirect()->back()->with('inconito','verifier les input');
    }
    public  function  init()
    {
        Login::initialiser();
    }
    public  function  logout()
    {
        session()->forget('admin');
        $admin = Login::all();
        return view('Login.login',compact('admin'));
    }
    public  function acceuil()
    {
        $res = Etape::all();
        return view('acceuilAdmin.accAdmin',compact('res'));
    }
    public  function AffectationHeure($id)
    {
        $res =  Etape::get_c_etape($id);
//        dd($res);
        return view('acceuilAdmin.affectation.affectTemps',compact('res'));
    }
    public  function verif()
    {
        $t = 178322 ;
        $res = Etape::conversion($t);
        return $res;
    }
    public function traitAffHeurre(Request $request)
    {
        $ide = $request->input('idetape');
        $depart = Etape::get_Depart($ide);
        $heurre_depart = $depart->date_heure_depart;
        $carbonDateDepart = Carbon::parse($heurre_depart);
        $formattedDatetime_depart = $carbonDateDepart->format('Y-m-d H:i:s');

        $idc = $request->input('idc');
        $arrive = $request->input('ta');
        $sa = $request->input('sa');
        $temps_arriver_AvecSecondes = [];
        for ($i = 0; $i < count($arrive); $i++) {
            $temps_arriver = $arrive[$i];
            $secondearriver = $sa[$i];
            $carbonTempsArriver = Carbon::parse($temps_arriver);
            $carbonTempsArriver->addSeconds($secondearriver);
            $temps_arriver_AvecSecondes[] = $carbonTempsArriver->format('Y-m-d H:i:s');
        }
//        dd($temps_arriver_AvecSecondes);
        for ($i = 0; $i < count($temps_arriver_AvecSecondes);$i++) {
            Coureur::insert_temps_coureur_etape($ide,$idc[$i],$temps_arriver_AvecSecondes[$i]);
        }
        return redirect()->back();
    }


    public  function  classementAdmin()
    {
        $etape = Etape::all();
//        dd($etape);
        return view('acceuilAdmin.classement.classement',compact('etape'));
    }
    public  function  classementEquipeAdmin()
    {
        $categorie = DB::select("select * from toute_cat");
        $res =    Coureur::classementEquipe();
        Session::put('pdf',$res[0]);
//        Session::put();
        return view('acceuilAdmin.classement.classementEquipe',compact('res','categorie'));
    }
    public  function  classementAdmin_chaque_etape($id)
    {
//        dd($id);
        $resultat =Coureur::maka_genre($id);
//        dd($resultat);
        return view('acceuilAdmin.rg.rg',compact('resultat'));
    }
}

