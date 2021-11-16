<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Backend\PlanesFinanciamientoController;
use App\Http\Controllers\Controller;
use App\Models\TipoFinanciamiento;
use Illuminate\Http\Request;

class CreditController extends Controller
{
    public function cotizador(Request $request)
    {
        $validated = $request->validate([
            'monto_financiar' => 'required|numeric',
            'cuota_entrada' => 'nullable|numeric',
            'plazo' => 'required|numeric'
        ]);

        $data = [];
        $planFinanciamiento = new PlanesFinanciamientoController();
        if ($financiamientoSiempreNuevo = TipoFinanciamiento::getFinanciamientoSiempreNuevo()) {
            $data['tsn'] = $planFinanciamiento
                ->planFinanciamientoSiempreNuevo($financiamientoSiempreNuevo, $request->monto_financiar, $request->plazo, $request->cuota_entrada);
        }

        if ($financiamientoTradicional = TipoFinanciamiento::getFinanciamientoTradicional()) {
            $data['tradicional'] = $planFinanciamiento
                ->planFinanciamientoTradicional($financiamientoTradicional, $request->monto_financiar, $request->plazo, $request->cuota_entrada);
        }

        return $data;
    }
}
