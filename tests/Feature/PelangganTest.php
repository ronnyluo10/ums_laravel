<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PelangganTest extends TestCase
{   
    public function testMustAuthenticateGetPelanggan()
    {
        $this->json("POST", "api/pelanggan", [], ['Authorization' => '', 'Accept' => 'application/json'])
            ->assertStatus(401)
            ->assertJson([
                "message" => "Unauthenticated.",
            ]);
    }

    public function testSuccessGetPelanggan()
    {
        $this->json("POST", "api/pelanggan", [
                "search" => "", 
                "tbody" => ["nama", "domisili", "jenis_kelamin"], 
                "sort" => ["created_at", "DESC"], 
                "offset" => 1
            ], 
            ['Accept' => 'application/json', 'Authorization' => 'Bearer p0NZ09Pio3bwnevEnN6l1obYIhJ8pHJ8BgCEgGrW'])
            ->assertStatus(200)
            ->assertJsonStructure([
                "success",
                "results"
            ]);
    }

    public function testMustAuthenticateStorePelanggan()
    {
        $this->json("POST", "api/pelanggan/store", [], ["Authorization" => "", "Accept" => "application/json"])
            ->assertStatus(401)
            ->assertJson([
                "message" => "Unauthenticated.",
            ]);
    }

    public function testRequiredFieldsStorePelanggan()
    {
        $this->json("POST", "api/pelanggan/store", [], ["Authorization" => "Bearer p0NZ09Pio3bwnevEnN6l1obYIhJ8pHJ8BgCEgGrW", "Accept" => "application/json"])
            ->assertStatus(422)
            ->assertJson([
                "message" => "The given data was invalid.",
                "errors" => [
                    "nama" => ["The nama field is required."],
                    "domisili" => ["The domisili field is required."],
                    "jenis_kelamin" => ["The jenis_kelamin field is required."],
                ]
            ]);
    }

    public function testSuccessfulStorePelanggan()
    {
        $this->json("POST", "api/pelanggan/store", 
                [
                    "nama" => "Jennifer",
                    "domisili" => "JAK-BAR",
                    "jenis_kelamin" => "WANITA",
                ], 
                ["Authorization" => "Bearer p0NZ09Pio3bwnevEnN6l1obYIhJ8pHJ8BgCEgGrW", "Accept" => "application/json"]
            )
            ->assertStatus(200)
            ->assertJsonStructure([
                "success",
                "results"
            ]);
    }

    public function testMustAuthenticateUpdatePelanggan()
    {
        $pelanggan = encrypt('pelanggan_12');
        $this->json("PUT", "api/pelanggan/update/".$pelanggan, [], ["Authorization" => "", "Accept" => "application/json"])
            ->assertStatus(401)
            ->assertJson([
                "message" => "Unauthenticated.",
            ]);
    }

    public function testRequiredFieldsUpdatePelanggan()
    {
        $pelanggan = encrypt('pelanggan_12');
        $this->json("PUT", "api/pelanggan/update/".$pelanggan, [], ["Authorization" => "Bearer p0NZ09Pio3bwnevEnN6l1obYIhJ8pHJ8BgCEgGrW", "Accept" => "application/json"])
            ->assertStatus(422)
            ->assertJson([
                "message" => "The given data was invalid.",
                "errors" => [
                    "nama" => ["The nama field is required."],
                    "domisili" => ["The domisili field is required."],
                    "jenis_kelamin" => ["The jenis_kelamin field is required."],
                ]
            ]);
    }

    public function testSuccessfulUpdatePelanggan()
    {
        $pelanggan = encrypt('pelanggan_12');
        $this->json("PUT", "api/pelanggan/update/".$pelanggan, 
                [
                    "nama" => "Jennifer Lopez",
                    "domisili" => "JAK-UT",
                    "jenis_kelamin" => "WANITA",
                ], 
                ["Authorization" => "Bearer p0NZ09Pio3bwnevEnN6l1obYIhJ8pHJ8BgCEgGrW", "Accept" => "application/json"]
            )
            ->assertStatus(200)
            ->assertJsonStructure([
                "success",
                "results"
            ]);
    }

    public function testMustAuthenticateDeletePelanggan()
    {
        $pelanggan = encrypt('pelanggan_12');
        $this->json("DELETE", "api/pelanggan/delete/".$pelanggan, [], ["Authorization" => "", "Accept" => "application/json"])
            ->assertStatus(401)
            ->assertJson([
                "message" => "Unauthenticated.",
            ]);
    }

    public function testSuccessfulDeletePelanggan()
    {
        $pelanggan = encrypt('pelanggan_12');
        $this->json("DELETE", "api/pelanggan/delete/".$pelanggan, 
                [
                    "nama" => "Jennifer Lopez",
                    "domisili" => "JAK-UT",
                    "jenis_kelamin" => "WANITA",
                ], 
                ["Authorization" => "Bearer p0NZ09Pio3bwnevEnN6l1obYIhJ8pHJ8BgCEgGrW", "Accept" => "application/json"]
            )
            ->assertStatus(200)
            ->assertJsonStructure([
                "success",
                "results"
            ]);
    }

    
}
