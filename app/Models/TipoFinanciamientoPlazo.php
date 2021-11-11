<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;

class TipoFinanciamientoPlazo extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'tipo_financiamiento_plazo';

    /**
     * @return Builder
     */
    public static function builder()
    {
        return TipoFinanciamientoPlazo::select('tipo_financiamiento_plazo.*');
    }

    /**
     * @param int|TipoFinanciamiento $tipoFinanciamiento
     * @return array|null|TipoFinanciamientoPlazo
     */
    public static function getModelTipoFinanciamiento($tipoFinanciamiento)
    {
        return self::builder()
                ->where('tipo_financiamiento_id', is_object($tipoFinanciamiento) ? $tipoFinanciamiento->id : $tipoFinanciamiento)
                ->first() ?? [];
    }

    /**
     * @param int|TipoFinanciamiento $tipoFinanciamiento
     * @return array|null|TipoFinanciamientoPlazo
     */
    public static function getModelTipoFinanciamientoPlazo($tipoFinanciamiento, $plazo)
    {
        return self::builder()
                ->where('tipo_financiamiento_id', is_object($tipoFinanciamiento) ? $tipoFinanciamiento->id : $tipoFinanciamiento)
                ->where('plazo',$plazo)
                ->first() ?? [];
    }

    /**
     * @param $tipoFinanciamiento
     * @return int|mixed
     */
    public static function getCuotaInicialTipoFinanciamiento($tipoFinanciamiento)
    {
        if ($model = self::getModelTipoFinanciamiento($tipoFinanciamiento)) {
            return $model->cuota_entrada;
        }

        return 0;
    }

    /**
     * @param $tipoFinanciamiento
     * @return int|mixed
     */
    public static function getCuotaFinalTipoFinanciamiento($tipoFinanciamiento)
    {
        if ($model = self::getModelTipoFinanciamiento($tipoFinanciamiento)) {
            return $model->cuota_final;
        }

        return 0;
    }

    /**
     * @param $tipoFinanciamiento
     * @return int|mixed
     */
    public static function getPlazoTipoFinanciamiento($tipoFinanciamiento)
    {
        if ($model = self::getModelTipoFinanciamiento($tipoFinanciamiento)) {
            return $model->plazo;
        }

        return 0;
    }
}
