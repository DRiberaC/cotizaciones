<?php

use App\Models\Ufv;
use App\Models\Dolar;
use App\Models\DolarRef;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    putenv('API_KEY=secreto123');
});

test('ufv can be created or updated if exists (upsert)', function () {
    $header = ['X-API-KEY' => 'secreto123'];

    // 1. Create a new UFV
    $response = $this->postJson('/api/ufv', [
        'fecha' => '2026-06-01',
        'valor' => 2.50000
    ], $header);

    $response->assertStatus(201);
    $this->assertDatabaseHas('ufvs', [
        'fecha' => '2026-06-01',
        'valor' => 2.50000
    ]);

    // 2. Try to store the same date (should update instead of failing)
    $response2 = $this->postJson('/api/ufv', [
        'fecha' => '2026-06-01',
        'valor' => 2.55000
    ], $header);

    $response2->assertStatus(201);
    $this->assertDatabaseHas('ufvs', [
        'fecha' => '2026-06-01',
        'valor' => 2.55000
    ]);
    expect(Ufv::count())->toBe(1);

    // 3. Bulk creation containing new and existing dates (should upsert)
    $responseMany = $this->postJson('/api/ufv', [
        [
            'fecha' => '2026-06-01',
            'valor' => 2.60000
        ],
        [
            'fecha' => '2026-06-02',
            'valor' => 2.70000
        ]
    ], $header);

    $responseMany->assertStatus(201);
    $this->assertDatabaseHas('ufvs', [
        'fecha' => '2026-06-01',
        'valor' => 2.60000
    ]);
    $this->assertDatabaseHas('ufvs', [
        'fecha' => '2026-06-02',
        'valor' => 2.70000
    ]);
    expect(Ufv::count())->toBe(2);
});

test('dolar can be created or updated if exists (upsert)', function () {
    $header = ['X-API-KEY' => 'secreto123'];

    // 1. Create a new Dolar rate
    $response = $this->postJson('/api/dolar', [
        'fecha' => '2026-06-01',
        'precio_compra' => 6.86000,
        'precio_venta' => 6.96000
    ], $header);

    $response->assertStatus(201);
    $this->assertDatabaseHas('dolars', [
        'fecha' => '2026-06-01',
        'precio_compra' => 6.86000,
        'precio_venta' => 6.96000
    ]);

    // 2. Try to store the same date (should update instead of failing)
    $response2 = $this->postJson('/api/dolar', [
        'fecha' => '2026-06-01',
        'precio_compra' => 6.90000,
        'precio_venta' => 7.00000
    ], $header);

    $response2->assertStatus(201);
    $this->assertDatabaseHas('dolars', [
        'fecha' => '2026-06-01',
        'precio_compra' => 6.90000,
        'precio_venta' => 7.00000
    ]);
    expect(Dolar::count())->toBe(1);

    // 3. Bulk creation containing new and existing dates (should upsert)
    $responseMany = $this->postJson('/api/dolar', [
        [
            'fecha' => '2026-06-01',
            'precio_compra' => 6.95000,
            'precio_venta' => 7.05000
        ],
        [
            'fecha' => '2026-06-02',
            'precio_compra' => 6.86000,
            'precio_venta' => 6.96000
        ]
    ], $header);

    $responseMany->assertStatus(201);
    $this->assertDatabaseHas('dolars', [
        'fecha' => '2026-06-01',
        'precio_compra' => 6.95000,
        'precio_venta' => 7.05000
    ]);
    $this->assertDatabaseHas('dolars', [
        'fecha' => '2026-06-02',
        'precio_compra' => 6.86000,
        'precio_venta' => 6.96000
    ]);
    expect(Dolar::count())->toBe(2);
});

test('dolar_ref can be created or updated if exists (upsert)', function () {
    $header = ['X-API-KEY' => 'secreto123'];

    // 1. Create a new DolarRef rate
    $response = $this->postJson('/api/dolar-ref', [
        'fecha' => '2026-06-01',
        'precio_compra' => 6.86000,
        'precio_venta' => 6.96000
    ], $header);

    $response->assertStatus(201);
    $this->assertDatabaseHas('dolar_refs', [
        'fecha' => '2026-06-01',
        'precio_compra' => 6.86000,
        'precio_venta' => 6.96000
    ]);

    // 2. Try to store the same date (should update instead of failing)
    $response2 = $this->postJson('/api/dolar-ref', [
        'fecha' => '2026-06-01',
        'precio_compra' => 6.90000,
        'precio_venta' => 7.00000
    ], $header);

    $response2->assertStatus(201);
    $this->assertDatabaseHas('dolar_refs', [
        'fecha' => '2026-06-01',
        'precio_compra' => 6.90000,
        'precio_venta' => 7.00000
    ]);
    expect(DolarRef::count())->toBe(1);

    // 3. Bulk creation containing new and existing dates (should upsert)
    $responseMany = $this->postJson('/api/dolar-ref', [
        [
            'fecha' => '2026-06-01',
            'precio_compra' => 6.95000,
            'precio_venta' => 7.05000
        ],
        [
            'fecha' => '2026-06-02',
            'precio_compra' => 6.86000,
            'precio_venta' => 6.96000
        ]
    ], $header);

    $responseMany->assertStatus(201);
    $this->assertDatabaseHas('dolar_refs', [
        'fecha' => '2026-06-01',
        'precio_compra' => 6.95000,
        'precio_venta' => 7.05000
    ]);
    $this->assertDatabaseHas('dolar_refs', [
        'fecha' => '2026-06-02',
        'precio_compra' => 6.86000,
        'precio_venta' => 6.96000
    ]);
    expect(DolarRef::count())->toBe(2);
});
