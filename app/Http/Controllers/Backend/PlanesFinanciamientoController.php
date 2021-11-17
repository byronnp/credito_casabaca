<?php

namespace App\Http\Controllers\Backend;

use App\Helpers\Calculo;
use App\Http\Controllers\Controller;
use App\Models\TipoFinanciamiento;
use App\Models\TipoFinanciamientoPlazo;
use Illuminate\Http\Request;

class PlanesFinanciamientoController extends Controller
{
    public $monto_total = 0;
    public $tasa_financiamiento = 0;
    public $tasa_interes = 0;
    public $porcentaje_cuota_entrada = 0;
    public $porcentaje_cuota_final = 0;
    public $depreciacion_estimada = 0;
    public $porcentaje_entrada = 0;
    public $plazo = 0;
    public $cuota_entrada = 0;
    public $cuota_final = 0;

    public $pago_final = 0;
    public $pagos_mensual = 0;
    public $cuota_mensual = 0;

    public function clear()
    {
        $this->monto_total = 0;
        $this->tasa_financiamiento = 0;
        $this->tasa_interes = 0;
        $this->porcentaje_cuota_entrada = 0;
        $this->porcentaje_cuota_final = 0;
        $this->depreciacion_estimada = 0;
        $this->porcentaje_entrada = 0;
        $this->plazo = 0;
        $this->cuota_entrada = 0;
        $this->cuota_final = 0;
        $this->pago_final = 0;
        $this->pagos_mensual = 0;
        $this->cuota_mensual = 0;
    }

    public function planFinanciamientoSiempreNuevo(TipoFinanciamiento $tipoFinanciamiento, $monto_total, $plazo, $cuota_entrada)
    {
        $this->clear();
        $this->monto_total = floatval($monto_total);
        $this->cuota_entrada = floatval($cuota_entrada);

        if ($this->setParametrosTipoFinanciamiento($tipoFinanciamiento, $plazo)) {
            if (!$cuota_entrada) {
                $this->getCalculoCuotaInicial();
            }

            $this->getCalculoCuotaFinal();
            $this->va();
            $this->getCalculoPagoMensual();
            $this->pago($this->pagos_mensual);
        }

        return $this->data();
    }

    /**
     * @param $tipoFinanciamiento
     */
    public function setParametrosTipoFinanciamiento($tipoFinanciamiento, $plazo)
    {
        $this->plazo = (int)$plazo;

        if ($modelPlazo = TipoFinanciamientoPlazo::getModelTipoFinanciamientoPlazo($tipoFinanciamiento, $plazo)) {
            $this->porcentaje_cuota_entrada = $modelPlazo->cuota_entrada;
            $this->porcentaje_cuota_final = $modelPlazo->cuota_final;
            $this->tasa_financiamiento = $tipoFinanciamiento->tasa_financiamiento;
            $this->depreciacion_estimada = $modelPlazo->depreciacion_estimada;
            $this->porcentaje_entrada = $modelPlazo->porcentaje_entrada;
            $this->tasa_interes = Calculo::porcentajetaTasaInteres(($this->tasa_financiamiento / 12));

            return true;
        }

        return false;
    }

    /**
     * @param $monto_total
     */
    public function getCalculoCuotaInicial()
    {
        $this->cuota_entrada = ($this->monto_total * $this->porcentaje_cuota_entrada) / 100;
        return $this->cuota_entrada;
    }

    /**
     * @param $monto_total
     */
    public function getCalculoCuotaFinal()
    {
        $this->cuota_final = ($this->monto_total * $this->porcentaje_cuota_final) / 100;
    }

    /**
     * @param $monto_total
     */
    public function getCalculoPagoMensual()
    {
        $this->pagos_mensual = ($this->monto_total - $this->cuota_entrada) - $this->pago_final;
    }

    function va()
    {
        $powTasaInteres = pow($this->tasa_interes, $this->plazo);
        $this->pago_final = $this->cuota_final / $powTasaInteres;
    }

    function pago($monto)
    {
        $I = $this->tasa_financiamiento / 12 / 100;
        $I2 = $I + 1;
        $I2 = pow($I2, -$this->plazo);

        $this->cuota_mensual = ($I * $monto) / (1 - $I2);
    }

    public function data()
    {
        $data = [
            'monto_financiar' => $this->monto_total,
            'porcentaje_cuota_entrada' => $this->porcentaje_cuota_entrada,
            'porcentaje_cuota_final' => $this->porcentaje_cuota_final,
            'plazo' => $this->plazo,
            'cuota_entrada_user' => $this->cuota_entrada,
            'cuota_entrada' => $this->getCalculoCuotaInicial(),
            'cuota_final' => $this->cuota_final,
            'tasa_financiamiento' => $this->tasa_financiamiento,
            'tasa_interes' => $this->tasa_interes,
            'pago_final' => $this->pago_final,
            'pago_mensual' => $this->pagos_mensual,
            'cuota_mensual' => $this->cuota_mensual,
        ];

        return $data;
    }

    public function planFinanciamientoTradicional(TipoFinanciamiento $tipoFinanciamiento, $monto_total, $plazo, $cuota_entrada)
    {
        $this->clear();
        $this->monto_total = floatval($monto_total);
        $this->cuota_entrada = floatval($cuota_entrada);

        if ($this->setParametrosTipoFinanciamiento($tipoFinanciamiento, $plazo)) {
            if (!$cuota_entrada) {
                $this->getCalculoCuotaInicial();
            }

            $this->cuota_final = $this->monto_total;
            $monto_total = $this->getCalculoMontoFinanciar();
            $this->pago($monto_total);
        }

        return $this->data();
    }

    public function getCalculoMontoFinanciar()
    {
        return $this->monto_total - $this->cuota_entrada;
    }


}
