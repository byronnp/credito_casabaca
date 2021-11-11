<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use PhpParser\Builder;

class TipoFinanciamiento extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'tipo_financiamiento';

    /**
     * @return \Illuminate\Database\Query\Builder
     */
    public static function builder()
    {
        return TipoFinanciamiento::select('tipo_financiamiento.*');
    }

    /**
     * @param string $sku
     * @return array|null|TipoFinanciamiento
     */
    public static function getTipoFinanciamientoSku($sku)
    {
        return self::builder()->where('sku', $sku)->first() ?? [];
    }

    /**
     * @return TipoFinanciamiento|array|null
     */
    public static function getFinanciamientoSiempreNuevo()
    {
        return self::getTipoFinanciamientoSku('TOYOTA-SIEMPRE_NUEVO');
    }

    /**
     * @return TipoFinanciamiento|array|null
     */
    public static function getFinanciamientoTradicional()
    {
        return self::getTipoFinanciamientoSku('TRADICIONAL');
    }
}
