<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Models\Game;

// Controlador para lidar com as requisições relacionadas aos jogos
class GameController extends Controller
{
    private $apiKey; // Chave de API para acessar a API RAWG

    // Construtor para inicializar a chave de API
    public function __construct()
    {
        $this->apiKey = env('API_KEY'); // Obtém a chave de API do arquivo .env
    }

    // Função privada para buscar jogos na API RAWG com base na URL fornecida
    private function fetchGames($url)
    {
        $client = new Client(); // Cria uma instância do cliente HTTP Guzzle

        // Tenta fazer uma requisição GET à API RAWG
        try {
            $response = $client->request('GET', $url); // Faz a requisição GET
            $content = $response->getBody()->getContents(); // Obtém o conteúdo da resposta
            $data = json_decode($content, true); // Decodifica o JSON para um array associativo
            
            $games = []; // Array para armazenar os dados dos jogos
            
            // Seleciona os resultados da resposta e extrai os dados relevantes dos jogos
            foreach ($data['results'] as $game) {
                $games[] = [ // Adiciona os dados do jogo ao array de jogos
                    'id' => $game['id'],
                    'name' => $game['name'],
                    'background_image' => $game['background_image'],
                    'released' => $game['released'],
                    'rating' => $game['rating'],
                    'metacritic' => $game['metacritic']
                ];
            }
            
            return $games; // Retorna os dados dos jogos
        } catch (\Exception $e) {
            return null; // Retorna null em caso de erro na requisição
        }
    }

    // Função para retornar jogos na página inicial
    public function home()
    {
        $url = "https://api.rawg.io/api/games?key={$this->apiKey}&page=3&page_size=15"; // URL para a página inicial
        $games = $this->fetchGames($url); // Busca os jogos usando a função fetchGames()

        // Verifica se os jogos foram encontrados e retorna uma resposta JSON apropriada
        if ($games !== null) {
            return response()->json($games);
        } else {
            return response()->json(['error' => 'Erro ao fazer a requisição à API RAWG'], 500);
        }
    }

     // Função para buscar jogos na API RAWG com base em uma consulta de busca
     public function search($query)
     {
         $url = "https://api.rawg.io/api/games?key={$this->apiKey}&search={$query}"; // URL de busca
         $games = $this->fetchGames($url); // Busca os jogos usando a função fetchGames()
 
         // Verifica se os jogos foram encontrados e retorna uma resposta JSON apropriada
         if ($games !== null) {
             return response()->json($games);
         } else {
             return response()->json(['error' => 'Erro ao fazer a requisição à API RAWG'], 500);
         }
     }

    // Função para retornar jogos favoritos
    public function favorites()
    {
        $url = "https://api.rawg.io/api/games?key={$this->apiKey}&page=1&page_size=8"; // URL para os jogos favoritos
        $games = $this->fetchGames($url); // Busca os jogos usando a função fetchGames()

        // Verifica se os jogos foram encontrados e retorna uma resposta JSON apropriada
        if ($games !== null) {
            return response()->json($games);
        } else {
            return response()->json(['error' => 'Erro ao fazer a requisição à API RAWG'], 500);
        }
    }
}