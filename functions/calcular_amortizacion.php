<?php
function calcularAmortizacion($monto, $interes, $plazo) {
    $cuotaMensual = ($monto * ($interes / 100) / 12) / 
        (1 - pow(1 + ($interes / 100) / 12, -$plazo));
    
    $amortizacion = [];
    $saldo = $monto;

    for ($i = 1; $i <= $plazo; $i++) {
        $interesCuota = $saldo * ($interes / 100) / 12;
        $capital = $cuotaMensual - $interesCuota;
        $saldo -= $capital;

        $amortizacion[] = [
            'cuota' => $i,
            'fecha_pago' => date('Y-m-d', strtotime("+$i month")),
            'cuota_mensual' => round($cuotaMensual),
            'interes' => round($interesCuota),
            'capital' => round($capital),
            'saldo_restante' => round($saldo)
        ];
    }

    return $amortizacion;
}
