import React from 'react';
import { useLocation } from 'react-router-dom';
import { FaStar } from "react-icons/fa";

import "./Css/GameDetails.css";


// Componente funcional Game para exibir detalhes do jogo
const Game = () => {
    // Obtém os dados do jogo da localização
    const location = useLocation();
    const game = location.state.game;

    // Retorna o JSX com os detalhes do jogo
    return (
        <div className="game-details">
            {game && (
                <>
                    <h1 className="game-title">{game.name}</h1>
                    <img className="game-image" src={game.background_image} alt="Imagem do jogo" />
                    <div className="game-rating">
                        <p><FaStar />{game.rating}</p>
                        <p>Metacritic: {game.metacritic}</p>
                        <p>Lançado em: {game.released}</p>
                    </div>

                    {game.platforms && game.platforms.map((platform, index) => (
                        <div className="platform-details" key={index}>
                            <h2 className="platform-name">{platform.platform.name}</h2>
                            <p className="platform-released">Released at: {platform.released_at}</p>
                            <p className="platform-requirements">Requirements: {JSON.stringify(platform.requirements)}</p>
                        </div>
                    ))}
                </>
            )}
        </div>
    );

};

export default Game;
