<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TestingCode extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_store_pegawai_first()
    {
        $response = $this->withHeaders([
            'X-Header' => 'Value',
        ])->post('/pegawai', [
            'nama' => 'Risky',
            'total' => 8500000
        ]);
        $response->assertStatus(201);
    }

    public function test_store_pegawai_second()
    {
        $response = $this->withHeaders([
            'X-Header' => 'Value',
        ])->post('/pegawai', [
            'nama' => 'Sandi',
            'total' => 4500000
        ]);
        $response->assertStatus(201);
    }

    public function test_get_pegawai()
    {
        $response = $this->get('/pegawai');
        $response->assertStatus(200);
    }

    public function test_store_gaji_pegawai()
    {
        $response = $this->withHeaders([
            'X-Header' => 'Value',
        ])->post('/gaji-pegawai', [
            'id_pegawais' => 2,
        ]);
        $response->assertStatus(201);
    }

    public function test_store_gaji_pegawai_batch()
    {
        $response = $this->post('/gaji-pegawai/batch');
        $response->assertStatus(201);
    }

    public function test_get_gaji_pegawai()
    {
        $response = $this->get('/gaji-pegawai');
        $response->assertStatus(200);
    }
}
