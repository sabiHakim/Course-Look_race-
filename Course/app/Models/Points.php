<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Points extends Model
{
    use HasFactory;
    protected $table = 'point';
    public $timestamps = false;
    protected  $fillable = ['classement', 'points'];
    public  static function insertPts($classement,$points)
    {
        $res = DB::select("insert into point(classement,points) values(?,?)",[$classement,$points]);
        return $res;
    }
}
