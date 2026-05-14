<?php 

namespace App\Models;

use App\Models\Logs;
use Illuminate\Database\Eloquent\Model;

class DailyProducts extends Model

{
    protected $connection  = 'sqlsrv';

    protected $table = 'ETIQUETA_PLACAS_RESULTADO';

    protected $primaryKey = 'ID';

    public $timestamps = false; 


    public static function getDailyProducts($loja)
{
    $ids = Logs::all()
        ->flatMap(function ($log) {
            preg_match('/[\["](?:IDS:|IDS"\s*:\s*")[^\d]*([\d,\s]+)/', $log->COMANDO_EXECUTADO, $m);
            return isset($m[1]) ? array_map('trim', explode(',', $m[1])) : [];
        })
        ->filter()
        ->unique()
        ->values()
        ->toArray();

    $query = DailyProducts::query()
        ->whereNotNull('ID_TEMPLATE')
        ->whereNotNull('LOJA')
        ->where('loja', $loja);

    foreach (array_chunk($ids, 2000) as $chunk) {
        $query->whereNotIn('ID', $chunk);
    }

    return $query->get();
}

}
