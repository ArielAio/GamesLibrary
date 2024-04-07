<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Models\Game;
use GuzzleHttp\Exception\RequestException;

// Controlador para lidar com as requisições relacionadas aos jogos
class GameController extends Controller
{
    private $apiKey; // Chave de API para acessar a API RAWG

    // Construtor para inicializar a chave de API
    public function __construct()
    {
        $this->apiKey = env('API_KEY'); // Obtém a chave de API do arquivo .env
    }

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
                $gameData = [ // Array para armazenar os dados do jogo
                    'id' => $game['id'],
                    'name' => $game['name'],
                    'slug' => $game['slug'],
                    'background_image' => $game['background_image'],
                    'released' => $game['released'],
                    'rating' => $game['rating'],
                    'metacritic' => $game['metacritic'],
                    'genres' => []
                ];
    
                // Verifica se 'genres' existe e é um array no jogo atual
                if (isset($game['genres']) && is_array($game['genres'])) {
                    // Itera sobre os gêneros do jogo
                    foreach ($game['genres'] as $genre) {
                        // Verifica se 'name' existe
                        if (isset($genre['name'])) {
                            // Adiciona o nome do gênero ao array genres do jogo atual
                            $gameData['genres'][] = $genre['name'];
                        }
                    }
                }
    
                $games[] = $gameData; // Adiciona os dados do jogo ao array de jogos
            }
            
            return $games; // Retorna os dados dos jogos
        } catch (\Exception $e) {
            return null; // Retorna null em caso de erro na requisição
        }
    }

    private function fetchGame($url)
    {
        $client = new Client();
    
        try {
            $response = $client->request('GET', $url);
    
            // Verifica se a requisição foi bem-sucedida
            if ($response->getStatusCode() === 200) {
                $content = $response->getBody()->getContents();
    
                // Verifica se o conteúdo é válido antes de decodificar o JSON
                if ($content !== null) {
                    $data = json_decode($content, true);
    
                    // Verifica se a decodificação teve êxito
                    if ($data !== null && is_array($data)) {
                        // Inicializa o array detailGame
                        $detailGame = [
                            'id' => $data['id'],
                            'name' => $data['name'],
                            'slug' => $data['slug'],
                            'description' => $data['description'],
                            'background_image' => $data['background_image'],
                            'playtime' => $data['playtime'],
                            'website' => $data['website'],
                            'released' => $data['released'],
                            'rating' => $data['rating'],
                            'reddit_url' => $data['reddit_url'],
                            'metacritic' => $data['metacritic'],
                            'metacritic_url' => $data['metacritic_url'],
                            'platforms' => [], // Inicializa um array vazio para armazenar os nomes das plataformas
                            'genres' => [], // Inicializa um array vazio para armazenar os nomes dos gêneros
                            'requirements' => []
                        ];
    
                        // Verifica se 'genres' existe e é um array
                        if (isset($data['genres']) && is_array($data['genres'])) {
                            // Itera sobre os gêneros
                            foreach ($data['genres'] as $genre) {
                                // Verifica se 'name' existe
                                if (isset($genre['name'])) {
                                    // Adiciona o nome do gênero ao array genres
                                    $detailGame['genres'][] = $genre['name'];
                                }
                            }
                        } else {
                            // Define 'genres' como null se não estiver presente nos dados
                            $detailGame['genres'] = null;
                        }
    
                        // Verifica se 'platforms' existe e é um array
                        if (isset($data['platforms']) && is_array($data['platforms'])) {
                            // Itera sobre as plataformas
                            foreach ($data['platforms'] as $platform) {
                                // Verifica se 'platform' e 'name' existem
                                if (isset($platform['platform'], $platform['platform']['name'])) {
                                    // Adiciona o nome da plataforma ao array platforms
                                    $detailGame['platforms'][] = $platform['platform']['name'];
                                }
                            }
                        } else {
                            // Define 'platforms' como null se não estiver presente nos dados
                            $detailGame['platforms'] = null;
                        }

                        // Verifica se 'platforms' existe e é um array
                        if (isset($data['platforms']) && is_array($data['platforms'])) {
                            // Itera sobre as plataformas
                            foreach ($data['platforms'] as $requirements) {
                                // Verifica se 'platform' e 'name' existem
                                if (isset($requirements['requirements'], $requirements['requirements']['minimum'])) {
                                    // Adiciona o nome da plataforma ao array requirements
                                    $detailGame['requirements'][] = $requirements['requirements']['minimum'];
                                } 
                            }
                        } else {
                            // Define 'requirements' como null se não estiver presente nos dados
                            $detailGame['requirements'] = null;
                        }
    
                        return $detailGame;
                    } else {
                        // JSON inválido
                        return null;
                    }
                } else {
                    // Conteúdo da resposta está vazio
                    return null;
                }
            } else {
                // Requisição falhou
                return null;
            }
        } catch (RequestException $e) {
            // Erro na requisição
            return null;
        }
    }

//     public function listGenresAndGames($url)
// {
//     // Criar uma instância do cliente Guzzle
//     $client = new Client();

//     // Fazer a requisição GET para a API
//     $response = $client->request('GET', $url);

//     // Verificar se a requisição foi bem-sucedida (código de status 200)
//     if ($response->getStatusCode() == 200) {
//         // Decodificar o conteúdo da resposta em JSON
//         $data = json_decode($response->getBody(), true);

//         // Extrair os resultados da resposta
//         $results = $data['results'];

//         // Array para armazenar os gêneros e seus respectivos jogos
//         $gameGenres = [];

//         // Iterar sobre os resultados e exibir as informações
//         foreach ($results as $genre) {
//             $games = [];
//             foreach ($genre['games'] as $game) {
//                 $games[] = $game['name'];
//             }

//             // Adicionar o gênero e seus jogos ao array
//             $gameGenres[] = [
//                 'genre' => $genre['name'],
//                 'games' => $games
//             ];
//         }

//         // Retornar o array com os gêneros e jogos
//         return $gameGenres;
//     } else {
//         echo "Erro ao obter os dados da API.";
//     }
// }

    
    public function select($query)
    {
        $url = "https://api.rawg.io/api/games/{$query}?key={$this->apiKey}"; // URL para a página inicial
        $detailGame = $this->fetchGame($url); // Busca os jogos usando a função fetchGames()

        // Verifica se os jogos foram encontrados e retorna uma resposta JSON apropriada
        if ($detailGame !== null) {
            return response()->json($detailGame);
        } else {
            return response()->json(['error' => 'Erro ao fazer a requisição à API RAWG'], 500);
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

