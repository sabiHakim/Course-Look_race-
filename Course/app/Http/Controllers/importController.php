<?php

namespace App\Http\Controllers;

use App\Imports\EtapeImport;
use App\Imports\PointImport;
use App\Imports\resultatImport;
use App\Models\Categorie;
use App\Models\Etape;
use App\Models\Points;
use App\Models\resultat;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Mockery\Exception;
use MongoDB\Driver\Session;

class importController extends Controller
{
    public  function  importER()
    {
        return view('acceuilAdmin.import.import');
    }
    public  function  importERP()
    {
        return view('acceuilAdmin.import.importPoint');
    }

    public  function etp(Request $request)
    {
        DB::beginTransaction();
        try {
            if ( $request->hasFile('etp')&&$request->hasFile('res'))
            {
//  etape
                $file = $request->file("etp");
                $nomFichier = Carbon::now()->format('Ymd_His') .'_'. $file->getClientOriginalName();
                $file->move(public_path('upload'), $nomFichier);
                $data = Excel::toArray(new EtapeImport(),'upload/'. $nomFichier);
//                dd($data);
                $error = [];
                foreach ($data as $dat){
                    for($i = 0 ; $i < count($dat) ; $i++){
                        if(!Etape::checkNombre($dat[$i]['rang'])) {
                            $error[] = "Erreur sur le fichier etapes .montant à la ligne " . ($i + 1) . " : " . $dat[$i]['rang'];
                        }
                    }
                }
//              resultat
                $fileres = $request->file("res");
                $nomFichierresultat = Carbon::now()->format('Ymd_His') .'_'. $file->getClientOriginalName();
                $fileres->move(public_path('upload'), $nomFichierresultat);
                $donnes = Excel::toArray(new resultatImport(),'upload/'. $nomFichierresultat);
//                dd($donnes);
                if(!empty($error)) {
                    return view('aceuilAdmin.import.import',compact('error'));
                }
                else{
                    foreach ($data as $dataa) {
                        for ($i = 0; $i < count($dataa) ; $i++) {

                            Etape::insertEtapecsv( $dataa[$i]['etape'],str_replace(',','.',$dataa[$i]['longueur']),$dataa[$i]['nb_coureur'],$dataa[$i]['rang'],$dataa[$i]['date_depart'],$dataa[$i]['date_depart'].' '.$dataa[$i]['heure_depart']);
                        }
                    }
                    foreach ($donnes as $donner){
                        for ($j = 0; $j <count($donner) ; $j++ )
                        {
                            resultat::insert( $donner[$j]['etape_rang'],$donner[$j]['numero_dossard'],$donner[$j]['nom'],$donner[$j]['genre'],$donner[$j]['date_naissance'],$donner[$j]['equipe'],$donner[$j]['arrivee']);
                        }
                    }
                    $equipe = DB::table('resultat')->select('equipe')->distinct()->pluck('equipe');
                    foreach ($equipe as $e){
                        $login  = $e.'@gmail.com';
                        $pwd = $e;
                        try{
                            DB::table('equipe')->insert([
                                    'nom'=>$e,
                                    'login'=>$login,
                                    'pwd'=>$pwd
                                ]);
//                            DB::insert("insert into equipe(nom,login,pwd) values($e,$login,$e)");
                        }
                        catch (\Exception $e)
                        {
                            return redirect()->back()->with('error',$e->getMessage());
                        }
                    }
//                            dd('..');
                    try {
                        DB::insert("
                        insert into coureur(nom ,numd, genre ,dtn ,idequipe)
                        select
                            r.nom,r.numero_dossard,r.genre,r.date_naissance,e.id
                        from  resultat r
                        join equipe e on   e.nom=r.equipe group by r.nom,r.nom, r.numero_dossard, r.genre, r.date_naissance, e.id;
                        ");
                    }
                    catch (\Exception $e){
                        return redirect()->back()->with('error',$e->getMessage());
                    }
                    try {
                        DB::insert("
                        insert into coureur_etape(idcoureur,idetapes)
                        select
                            c.id as coureur_id,
                            e.id as etape_id
                        from resultat r
                        join coureur c
                        on r.numero_dossard  = c.numd
                        join etape e
                        on r.etape_rang = e.rang_etape
                        ");
                    }
                    catch (\Exception $e){
                        return redirect()->back()->with('error',$e->getMessage());
                    }
                    try {
                        DB::insert("
                            insert into temps_coureur_etape(idc,ide,arriver)
                            select
                                    c.id as coureur_id,
                                    e.id as etape_id,
                                    arriver as date_arrive
                            from resultat r
                            join  coureur c on r.numero_dossard  = c.numd
                            join  etape e on r.etape_rang = e.rang_etape
                        ");
                    }catch (\Exception $e){
                        return redirect()->back()->with('error',$e->getMessage());
                    }
                    DB::commit();
                    return redirect()->back();
                }
            }
        }
        catch (Exception $e){
            DB::rollBack();
            echo $e->getMessage();
            return redirect()->back()->with('error',$e->getMessage());
        }
    }
    public  function  pts(Request $request)
    {
        try{
            if ( $request->hasFile('pts'))
            {
                $fi= $request->file("pts");
                $nomFi = Carbon::now()->format('Ymd_His') .'_'. $fi->getClientOriginalName();
                $fi->move(public_path('upload'), $nomFi);
                $pts = Excel::toArray(new PointImport(),'upload/'. $nomFi);
//                dd($pts);
                $error = [];
                foreach ($pts as $dat){
                    for($i = 0 ; $i < count($dat) ; $i++){
                        if(!Etape::checkNombre($dat[$i]['points'])) {
                            $error[] = "Erreur sur le fichier pts . à la ligne " . ($i + 1) . " : " . $dat[$i]['points'];
                        }
                    }
                }
                if(!empty($error)) {
                    return view('aceuilAdmin.import.import',compact('error'));
                }
                else{
                    foreach ($pts as $dataa) {
                        for ($i = 0; $i < count($dataa) ; $i++) {
                            Points::insertPts( $dataa[$i]['classement'],$dataa[$i]['points']);
                        }
                    }
                }

            }
            return redirect()->back();
        } catch (\Exception $e){
            return redirect()->back()->with('error',$e->getMessage());
        }
    }
    public  function  genererCat()
    {
         Categorie::generer();
         $res = DB::select("SELECT * FROM v_coureur_age ");
         foreach ($res as $coureur)
         {
                 $categories = [];
                 if ($coureur->genre === 'F') {
                     $categories[] = 'F'; // Catégorie Femme
                 }
                 if ($coureur->genre === 'M') {
                     $categories[] = 'M'; // Catégorie Femme
                 }
                 if ($coureur->age < 18) {
                     $categories[] = 'Junior';
                 }
//                 if ($coureur->age > 18) {
//                     $categories[] = 'Senior';
//                 }
                 foreach ($categories as $categorie) {
                     DB::table('categori_coureur')->insert([
                         'cat' => $categorie,
                         'idcoureur' => $coureur->id,
                     ]);
                 }

         }
         return  redirect(url('acceuil'));
    }
    public  function affiche_cat(Request $request)
    {
       $categoriee =   $request->input('categorie');
        $categorie = DB::select("select * from toute_cat");
       $res = DB::select("
             WITH point AS (
      SELECT
          vc.*,
          DENSE_RANK() OVER (PARTITION BY vc.ide, vc.cat ORDER BY vc.temp_penaliter_plus ASC) AS cla,
          COALESCE(p.points, 0) AS pts
      FROM
          v_temps_penaliter vc
              LEFT JOIN
          point p ON vc.cla = p.classement
      WHERE
              vc.cat = ?
  )
  SELECT
      vc.idequipe,
      vc.nom_equipe,
      SUM(vc.pts) AS total_pts,
      DENSE_RANK() OVER (ORDER BY SUM(vc.pts) DESC) AS rank
  FROM
      point vc
  GROUP BY
      vc.idequipe, vc.nom_equipe;
       ",[$categoriee]);
       return view('acceuilAdmin.classement.classementEquipe',compact('res','categorie'));
    }
    public  function pdf()
    {
        $pdf = \Illuminate\Support\Facades\Session::get('pdf');
        $pdf = Pdf::loadView('acceuilAdmin.pdf.certificat',[
            'equipe' => $pdf->nom_equipe,
            'total_pts'=>$pdf->total_pts
        ]);
        return $pdf->download('RunningChamps.pdf');
//        dd($pdf);
    }
}

