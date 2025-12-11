<?php

namespace App\Services;

use App\Models\Ufv;
use Illuminate\Database\Eloquent\Collection;

class UfvService
{
    public function index(): Collection
    {
        return Ufv::all();
    }

    public function store(array $data): Ufv
    {
        return Ufv::create($data);
    }

    public function storeMany(array $data): Collection
    {
        $now = now();
        foreach ($data as &$item) {
            $item['created_at'] = $now;
            $item['updated_at'] = $now;
        }
        Ufv::insert($data);
        return Ufv::whereIn('fecha', array_column($data, 'fecha'))->get();
    }

    public function getByMonth(string $yearMonth): Collection
    {
        [$year, $month] = explode('-', $yearMonth);
        return Ufv::whereYear('fecha', $year)
                  ->whereMonth('fecha', $month)
                  ->get();
    }

    public function read($fecha): Ufv
    {
        return Ufv::where('fecha', $fecha)->first() ?? new Ufv([
            'fecha' => $fecha,
            'valor' => 0
        ]);
    }

    public function update($fecha, array $data): Ufv
    {
        $ufv = Ufv::where('fecha', $fecha)->firstOrFail();
        $ufv->update($data);
        return $ufv;
    }

    public function delete($fecha): ?bool
    {
        $ufv = Ufv::where('fecha', $fecha)->firstOrFail();
        return $ufv->delete();
    }
}
