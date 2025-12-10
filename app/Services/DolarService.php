<?php

namespace App\Services;

use App\Models\Dolar;
use Illuminate\Database\Eloquent\Collection;

class DolarService
{
    public function index(): Collection
    {
        return Dolar::all();
    }

    public function store(array $data): Dolar
    {
        return Dolar::create($data);
    }

    public function storeMany(array $data): Collection
    {
        $now = now();
        foreach ($data as &$item) {
            $item['created_at'] = $now;
            $item['updated_at'] = $now;
        }
        Dolar::insert($data);
        return Dolar::whereIn('fecha', array_column($data, 'fecha'))->get();
    }

    public function read($fecha): Dolar
    {
        return Dolar::where('fecha', $fecha)->firstOrFail();
    }

    public function update($fecha, array $data): Dolar
    {
        $dolar = Dolar::where('fecha', $fecha)->firstOrFail();
        $dolar->update($data);
        return $dolar;
    }

    public function delete($fecha): ?bool
    {
        $dolar = Dolar::where('fecha', $fecha)->firstOrFail();
        return $dolar->delete();
    }
}
