//Imports necessários
import Slider from 'react-slick';
import React, { useState, useEffect } from 'react';
import { useNavigate } from 'react-router-dom';

import 'slick-carousel/slick/slick.css'; 
import 'slick-carousel/slick/slick-theme.css';

import './Css/ListFavoriteGame.css';

function ListFavoriteGames() {
    const [favorites, setFavorites] = useState([]); // Define o estado para os jogos favoritos
    const navigate = useNavigate(); // Permite a navegação programática entre rotas

    useEffect(() => {
        // Efeito que executa a busca dos jogos favoritos ao montar o componente
        const fetchFavorites = async () => {
            try {
                const res = await fetch('http://127.0.0.1:8000/api/favorites'); // Faz uma requisição para obter os jogos favoritos
                if (!res.ok) {
                    throw new Error('Erro ao carregar jogos favoritos.'); // Lança um erro se a requisição falhar
                }
                const data = await res.json(); // Converte a resposta para JSON
                setFavorites(data); // Define os jogos favoritos no estado
            } catch (error) {
                console.error('Erro:', error.message); // Exibe um erro no console em caso de falha
            }
        };

        fetchFavorites(); // Chama a função para buscar os jogos favoritos
    }, []);

    const sliderSettings = {
        // Configurações do Slider
        infinite: true,
        speed: 500,
        slidesToShow: 3,
        slidesToScroll: 3,
        responsive: [
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2,
                    infinite: true,
                }
            },
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }
        ]
    };

    // Função para navegar para os detalhes do jogo
    const goToGameDetails = (game) => {
        navigate(`/game/${game.id}`, { state: { game } });
    };

    return (
        <>
            <h2 className="title-favorites">Jogos Favoritos:</h2> {/* Título da lista de jogos favoritos */}
            <Slider {...sliderSettings}> {/* Componente Slider com as configurações definidas */}
                {favorites.map((game) => (
                    <div key={game.id} className="game-card" onClick={() => goToGameDetails(game)}> {/* Cartão de jogo individual */}
                        <img src={game.background_image} alt={game.name} className="game-image" /> {/* Imagem do jogo */}
                        <h3>{game.name}</h3> {/* Nome do jogo */}
                    </div>
                ))}
            </Slider>
        </>
    );

};

export default ListFavoriteGames;