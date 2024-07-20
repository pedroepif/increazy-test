<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Http;
use Exception;

class SearchController extends BaseController
{
  public function consult($cep) {
    try {
      $cepArray = explode(",", $cep);
      $results = [];

      foreach ($cepArray as $cep) {
        $onlyNumber = preg_replace('/\D/', '', trim($cep));

        if (strlen($onlyNumber) == 8) {
          try {
            $response = Http::get("https://viacep.com.br/ws/{$onlyNumber}/json/");

            if ($response->successful()) {
              $json = $response->json();
              $results[] = [
                "cep" => preg_replace('/\D/', '', trim($json['cep'])),
                "label" => $json['logradouro'] . ", " . $json['localidade'],
                "logradouro" => $json['logradouro'],
                "complemento" => $json['complemento'],
                "bairro" => $json['bairro'],
                "localidade" => $json['localidade'],
                "uf" => $json['uf'],
                "ibge" => $json['ibge'],
                "gia" => $json['gia'],
                "ddd" => $json['ddd'],
                "siafi" => $json['siafi'],  
              ];
            }
          } catch (Exception $error) {
            $results[] = [
              "error" => "Falha ao consultar CEP: $onlyNumber"
            ];
          }
        } else {
          $results[] = [
            "error" => "Falha ao consultar CEP: $cep"
          ];
        }
      }
      return response()->json($results);
    } catch (Exception $error) {
      return response()->json([
        'error' => 'Falha ao validar CEPs'
      ]); 
    }
  }
}
