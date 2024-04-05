//Imports necessários
import React, { useState, useEffect } from 'react';
import { FaStar } from 'react-icons/fa';
import { useNavigate } from 'react-router-dom';
import { BiSearchAlt2 } from 'react-icons/bi';

import './Css/ListGames.css';

function ListGames() {
    const [games, setGames] = useState([]); // Define o estado games e a função setGames
    const [isLoading, setIsLoading] = useState(false); // Define o estado isLoading e a função setIsLoading
    const [searchTerm, setSearchTerm] = useState(''); // Define o estado searchTerm e a função setSearchTerm
    const navigate = useNavigate(); // Define a função navigate com o hook useNavigate

    useEffect(() => {
        const fetchGames = async () => {
            setIsLoading(true); // Define isLoading como true enquanto carrega os jogos
            try {
                const res = await fetch('http://127.0.0.1:8000/api'); // Faz uma requisição para obter os jogos
                if (!res.ok) {
                    throw new Error('Não foi possível carregar os jogos.'); // Lança um erro se não for possível carregar os jogos
                }
                const data = await res.json(); // Converte a resposta para JSON
                setGames(data); // Define os jogos no estado
            } catch (error) {
                console.error('Erro:', error.message); // Exibe um erro no console em caso de falha
            }
            setIsLoading(false); // Define isLoading como false após carregar os jogos
        };
        fetchGames(); // Chama a função para carregar os jogos
    }, []);

    // Função para navegar para os detalhes do jogo
    const goToGameDetails = (game) => {
        navigate(`/game/${game.id}`, { state: { game } });
    };

    // Função para lidar com a pesquisa de jogos
    const handleSearch = async (event) => {
        event.preventDefault(); // Previne o comportamento padrão do formulário
        setIsLoading(true); // Define isLoading como true enquanto realiza a pesquisa
        try {
            const res = await fetch(`http://127.0.0.1:8000/api/search/${searchTerm}`); // Faz uma requisição para buscar os jogos com base no termo de pesquisa
            if (!res.ok) {
                throw new Error('Erro na busca dos jogos.'); // Lança um erro se não for possível realizar a busca
            }
            const data = await res.json(); // Converte a resposta para JSON
            setGames(data); // Define os jogos encontrados no estado
        } catch (error) {
            console.error('Erro:', error.message); // Exibe um erro no console em caso de falha
        }
        setIsLoading(false); // Define isLoading como false após realizar a pesquisa
    };

    return (
        <div className="container">

            <h1 className="title">Buscar</h1>
            <form onSubmit={handleSearch}>
                <input
                    type="text"
                    value={searchTerm}
                    onChange={(e) => setSearchTerm(e.target.value)}
                    placeholder="Pesquisar jogos..."
                />
                <button type="submit">
                    <BiSearchAlt2 />
                </button>
            </form>
            {isLoading && (
                <div className="loading-container">
                    <div className="spinner"></div>
                </div>
            )}

            <div className='games-container'>
                {games.map((game, index) => (
                    <div key={game.id} className="game-card" onClick={() => goToGameDetails(game)}>
                        <h2>{game.name}</h2>
                        {game.background_image && (
                            <img src={game.background_image} alt="Imagem do jogo" />
                        )}
                        {game.rating !== undefined && (
                            <p>
                                <FaStar /> {game.rating}
                            </p>
                        )}
                        <button
                            onClick={() => goToGameDetails(game)}
                            className="details-button">
                            Detalhes
                        </button>
                    </div>
                ))}
            </div>
        </div>
    );

};

export default ListGames;
