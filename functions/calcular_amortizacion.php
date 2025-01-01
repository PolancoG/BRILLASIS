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
            'cuota_mensual' => round($cuotaMensual, 2),
            'interes' => round($interesCuota, 2),
            'capital' => round($capital, 2),
            'saldo_restante' => round($saldo, 2)
        ];
    }

    return $amortizacion;
}
