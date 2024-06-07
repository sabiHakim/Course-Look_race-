<?php

namespace App\Http\Controllers;

use App\Models\Coureur;
use App\Models\Etape;
use App\Models\Login;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EquipeController extends Controller
{
    //
    public  function  profilEquipe()
    {
        return view('Login.Profilequipe');
    }
    public  function  traitLoginEquipe(Request $request)
    {
        $n = $request->input('name');
        $m = $request->input('mdp');
        $res = Login::checkE($n,$m);
        if($res)
        {
            session()->put('equipe',$res);
            $idequipe =  session('equipe')[0]->id;
            $res = DB::select("select * from etape");
            return view('acceuil.acc',compact('res',));
        }
        return redirect()->back()->with('inconito','verifier les input');
    }
    public  function accequipe()
    {
        $res = Etape::all();
        return view('acceuil.acc',compact('res'));
    }
    public  function  logoutequipe()
    {
        session()->forget('equipe');
        return view('Login.Profilequipe');
    }
    public  function  affectation($id){
        $equipe = session('equipe');
         $c = Coureur::getC_by_E($equipe[0]->id);
         $etape = $id;
         return view('acceuil.affectation.affect',compact('c','etape'));
    }
    public  function  traitAffect(Request $request)
    {
        $equipe = session('equipe')[0]->id;
        $choix = $request->input('team_members');
        $etapes = $request->input('etape');
        $nb_coureur = Etape::get_nb_etape($etapes);
        $actu  =Coureur::coureur_actuel_etape($etapes,$equipe);

        if (count($choix) + count($actu) > $nb_coureur)
        {
            return redirect()->back()->with([
                'sup' => 'trop de Coureur',
                'coureur' => $nb_coureur
            ]);
        }
        else
        {
            foreach ($choix as $c)
            {
                Coureur::insert_coureur_etape($c,$etapes);
            }
            return redirect()->back();
        }
    }
    public  function  classement()
    {
        $etape = Etape::all();
        return view('acceuil.classement.classement',compact('etape'));
    }
    public  function  classementEquipe()
    {
        $res =    Coureur::classementEquipe();
        return view('acceuil.classement.classementEquipe',compact('res'));
    }
}
