<?php

namespace Tests\Http\Controllers;

use Tests\TestCase;
use Illuminate\Support\Facades\Http;

class SearchControllerTest extends TestCase
{
  public function testInvalidCep() {
    Http::fake([
      "https://viacep.com.br/ws/invalid/json/" => Http::response(404)
    ]);

    $response = $this->call("GET", "/search/local/invalid");

    $response->assertStatus(200)
            ->assertJson([[
              "error" => "Falha ao consultar CEP: invalid"
            ]]);
  }

  public function testValidCep() {
    Http::fake([
      'https://viacep.com.br/ws/12345678/json/' => Http::response([
        'cep' => '12345678',
        'logradouro' => 'Rua Exemplo',
        'complemento' => '',
        'bairro' => 'Bairro Exemplo',
        'localidade' => 'Cidade Exemplo',
        'uf' => 'EX',
        'ibge' => '1234567',
        'gia' => '0001',
        'ddd' => '11',
        'siafi' => '0000',
      ]),
    ]); 

    $response = $this->call("GET", "/search/local/12345678");

    $response->assertStatus(200)
            ->assertJson([
              [
                "cep" => "12345678",
                "label" => "Rua Exemplo, Cidade Exemplo",
                "logradouro" => "Rua Exemplo",
                "complemento" => "",
                'bairro' => 'Bairro Exemplo',
                'localidade' => 'Cidade Exemplo',
                'uf' => 'EX',
                'ibge' => '1234567',
                'gia' => '0001',
                'ddd' => '11',
                'siafi' => '0000',
              ]
            ]);
  }

  public function testMultipleValidCep() {
    Http::fake([
      'https://viacep.com.br/ws/12345678/json/' => Http::response([
        'cep' => '12345678',
        'logradouro' => 'Rua Exemplo',
        'complemento' => '',
        'bairro' => 'Bairro Exemplo',
        'localidade' => 'Cidade Exemplo',
        'uf' => 'EX',
        'ibge' => '1234567',
        'gia' => '0001',
        'ddd' => '11',
        'siafi' => '0000',
      ]),
      'https://viacep.com.br/ws/87654321/json/' => Http::response([
        'cep' => '87654321',
        'logradouro' => 'Avenida Exemplo',
        'complemento' => 'Apto 101',
        'bairro' => 'Outro Bairro',
        'localidade' => 'Outra Cidade',
        'uf' => 'OT',
        'ibge' => '7654321',
        'gia' => '0002',
        'ddd' => '21',
        'siafi' => '1111',
      ]),
    ]);

    $response = $this->call("GET", "/search/local/12345678,87654321");

    $response->assertStatus(200)
            ->assertJson([
              [
                "cep" => "12345678",
                "label" => "Rua Exemplo, Cidade Exemplo",
                "logradouro" => "Rua Exemplo",
                "complemento" => "",
                'bairro' => 'Bairro Exemplo',
                'localidade' => 'Cidade Exemplo',
                'uf' => 'EX',
                'ibge' => '1234567',
                'gia' => '0001',
                'ddd' => '11',
                'siafi' => '0000',
              ],
              [
                'cep' => '87654321',
                "label" => "Avenida Exemplo, Outra Cidade",
                'logradouro' => 'Avenida Exemplo',
                'complemento' => 'Apto 101',
                'bairro' => 'Outro Bairro',
                'localidade' => 'Outra Cidade',
                'uf' => 'OT',
                'ibge' => '7654321',
                'gia' => '0002',
                'ddd' => '21',
                'siafi' => '1111',
              ]
            ]);
  }
}
