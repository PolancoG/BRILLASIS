<?php
    // calcular_amortizacion.php
    header("Content-Type: application/json");

    $data = json_decode(file_get_contents("php://input"), true);

    if (isset($data['monto'], $data['interes'], $data['plazo'])) {
        $monto = (float)$data['monto'];
        $interesAnual = (float)$data['interes'];
        $plazo = (int)$data['plazo'];

        function calcularTablaAmortizacion($monto, $interesAnual, $plazo) {
            $interesMensual = $interesAnual / 12 / 100;
            $cuotaMensual = ($monto * $interesMensual * pow(1 + $interesMensual, $plazo)) / (pow(1 + $interesMensual, $plazo) - 1);

            $tabla = [];
            $saldo = $monto;

            for ($mes = 1; $mes <= $plazo; $mes++) {
                $interes = $saldo * $interesMensual;
                $amortizacion = $cuotaMensual - $interes;
                $saldo -= $amortizacion;

                $tabla[] = [
                    'mes' => $mes,
                    'cuota' => round($cuotaMensual, 2),
                    'interes' => round($interes, 2),
                    'amortizacion' => round($amortizacion, 2),
                    'saldo' => round(max($saldo, 0), 2),
                ];
            }

            return $tabla;
        }

        $tabla = calcularTablaAmortizacion($monto, $interesAnual, $plazo);
        echo json_encode($tabla);
        exit;
    } else {
        echo json_encode(['error' => 'Datos inválidos']);
        exit;
    }
?>