<?php

namespace App\Http\Controllers;

use App\Models\Equipe;
use App\Models\Etape;
use App\Models\Penalite;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenaliteController extends Controller
{
    //
    public  function  deleteF(Request $request)
    {
        $id = $request->input('id');
        $res =DB::select("delete from penalite where id_penalite = ?",[$id]);
        return redirect()->back();

    }
    public  function  Penalites()
    {
          $res = DB::select("select  * from aff_penalite");
         return view('acceuilAdmin.penaliter.penaliter',compact('res'));
    }
    public  function  addPenalites()
    {
        $etape  =Etape::all();
        $equipe  =Equipe::all();
        return view('acceuilAdmin.penaliter.addpenaliter',compact('etape','equipe'));
    }
    public  function  traiAddPenaliter(Request $request)
    {
//        $request->validate([
//            'number_step' => 'required|gte:0',
//            'name_step' => 'required|max:255',
//            'length_step' => 'required|gte:0',
//            'number_runner' => 'required|gte:0',
//            'departure_time' => 'required',
//            'depart_hh' => 'required|numeric|between:0,23|gte:0',
//            'depart_mm' => 'required|numeric|between:0,59|gte:0',
//            'depart_ss' => 'required|numeric|between:0,59|gte:0',
//        ], [
//            'number_step.required' => 'The step number is required.',
//            'number_step.gte' => 'The step number must not be a negative value.',
//            'name_step.required' => 'The step name is required.',
//            'name_step.max' => 'The step name may not be greater than 255 characters.',
//            'length_step.required' => 'The step length is required.',
//            'length_step.gte' => 'The step length must not be a negative value.',
//            'number_runner.required' => 'The number of runners is required.',
//            'number_runner.gte' => 'The number of runners must not be a negative value.',
//            'departure_time.required' => 'The departure time is required.',
//            'depart_hh.required' => 'The departure hour is required.',
//            'depart_hh.numeric' => 'The departure hour must be a number.',
//            'depart_hh.between' => 'The departure hour must be between 0 and 23.',
//            'depart_hh.gte' => 'The departure hour must not be a negative value.',
//            'depart_mm.required' => 'The departure minute is required.',
//            'depart_mm.numeric' => 'The departure minute must be a number.',
//            'depart_mm.between' => 'The departure minute must be between 0 and 59.',
//            'depart_mm.gte' => 'The departure minute must not be a negative value.',
//            'depart_ss.required' => 'The departure second is required.',
//            'depart_ss.numeric' => 'The departure second must be a number.',
//            'depart_ss.between' => 'The departure second must be between 0 and 59.',
//            'depart_ss.gte' => 'The departure second must not be a negative value.',
//        ]);
        $etape =$request->input('etape') ;
        $equipe = $request->input('equipe');
        $hh = $request->input('depart_hh');
        Penalite::penalite($etape,$equipe,$hh);
        return redirect()->back();
    }
}
