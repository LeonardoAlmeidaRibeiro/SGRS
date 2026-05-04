<?php

namespace App\Services;

use App\Models\Interesse;
use App\Models\Residuo;

class MatchInteligenteService
{
    public function recomendarParaResiduo(Residuo $residuo, int $limite = 10)
    {
        $residuo->loadMissing(['empresa', 'classificacao', 'unidade']);

        return Interesse::with(['empresa', 'classificacao'])
            ->where('empresa_id', '!=', $residuo->empresa_id)
            ->where('classificacao_id', $residuo->classificacao_id)
            ->where(function ($query) use ($residuo) {
                $query->where('tipo_material', 'like', '%' . $residuo->tipo_material . '%')
                    ->orWhereRaw('? like concat("%", tipo_material, "%")', [$residuo->tipo_material]);
            })
            ->where(function ($query) use ($residuo) {
                $query->whereNull('quantidade_minima')
                    ->orWhere('quantidade_minima', '<=', $residuo->quantidade);
            })
            ->where(function ($query) use ($residuo) {
                $query->whereNull('quantidade_maxima')
                    ->orWhere('quantidade_maxima', '>=', $residuo->quantidade);
            })
            ->get()
            ->map(function (Interesse $interesse) use ($residuo) {
                $distancia = $this->distanciaKm(
                    $residuo->latitude,
                    $residuo->longitude,
                    optional($interesse->empresa)->latitude,
                    optional($interesse->empresa)->longitude
                );

                $score = 55;
                $score += stripos($residuo->tipo_material, $interesse->tipo_material) !== false ? 20 : 10;
                $score += $interesse->classificacao_id === $residuo->classificacao_id ? 15 : 0;

                if ($distancia !== null) {
                    if ($interesse->raio_km !== null && $distancia > (float) $interesse->raio_km) {
                        $score -= 35;
                    }

                    $score += max(0, 10 - min(10, $distancia / 50));
                }

                $interesse->match_score = round(max(0, min(100, $score)), 1);
                $interesse->distancia_km = $distancia === null ? null : round($distancia, 1);

                return $interesse;
            })
            ->filter(fn ($interesse) => $interesse->match_score >= 50)
            ->sortByDesc('match_score')
            ->take($limite)
            ->values();
    }

    private function distanciaKm($lat1, $lon1, $lat2, $lon2): ?float
    {
        if ($lat1 === null || $lon1 === null || $lat2 === null || $lon2 === null) {
            return null;
        }

        $earthRadius = 6371;
        $dLat = deg2rad((float) $lat2 - (float) $lat1);
        $dLon = deg2rad((float) $lon2 - (float) $lon1);
        $a = sin($dLat / 2) ** 2
            + cos(deg2rad((float) $lat1)) * cos(deg2rad((float) $lat2)) * sin($dLon / 2) ** 2;

        return $earthRadius * (2 * atan2(sqrt($a), sqrt(1 - $a)));
    }
}
