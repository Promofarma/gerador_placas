<?php 

namespace App\Models;

use App\Models\Logs;
use Illuminate\Database\Eloquent\Model;

class DailyProducts extends Model

{

    protected $table = 'VW_ETIQUETAS_PLACAS_RESULTADOS';

    protected $primaryKey = 'ID';

    public $timestamps = false; 


    public static function getDailyProducts($loja)
{
 
        return self::where('LOJA', $loja)
            ->get();
    }
}
