import React, { useState, useEffect } from 'react';
import { FaStar } from "react-icons/fa";
import "./Css/GameDetails.css";

const Game = () => {
    const [detailGame, setDetailGame] = useState([]);
    const [isLoading, setIsLoading] = useState(false);

    const url = window.location.pathname;
    const parts = url.split("/")
    const slug = parts[parts.length - 1]

    useEffect(() => {
        const fetchGame = async () => {
            setIsLoading(true);
            try {
                const res = await fetch(`http://127.0.0.1:8000/api/game/${slug}`);
                if (!res.ok) {
                    throw new Error('Não foi possível carregar o jogo.');
                }
                const data = await res.json();
                setDetailGame(Array.isArray(data) ? data : [data]);
            } catch (error) {
                console.error('Erro:', error.message);
            }
            setIsLoading(false);
        };
        fetchGame();
    }, [slug]);

    if (isLoading) {
        return (
            <div className="loading-container">
                <div className="spinner"></div>
            </div>
        );
    }

    return (
        <div className="game-details">
            {detailGame.map((game) => (
                <div key={game.id} className="game-container">
                    <h1 className="game-title">{game.name}
                        <div className='icons'>
                            <a className='metacriticIco' href={game.metacritic_url}><img width="30" height="30" src="https://img.icons8.com/color/48/metascore.png" alt="metascore" /></a>

                            <a className='redditIco' href={game.reddit_url}><img width="30" height="30" src="https://img.icons8.com/fluency/48/reddit.png" alt="reddit" /></a>

                            <a className='websiteIco' href={game.website}><img width="30" height="30" src="https://img.icons8.com/color/48/internet--v1.png" alt="internet--v1" /></a>
                        </div>


                    </h1>
                    <img className="game-image" src={game.background_image} alt={game.name} />
                    <div className="game-rating">
                        <p><FaStar className='star' />{game.rating}</p>
                        <p>Metacritic: {game.metacritic}</p>
                        <p>Horas mínimas: {game.playtime} horas</p>
                    </div>
                    <div className='moreInfo'>
                        <div className="platforms">
                            <h2>Plataformas</h2>
                            <ul>
                                {game.platforms && game.platforms.map((platform, index) => (
                                    <li key={index}>{platform}</li>
                                ))}
                            </ul>
                        </div>
                        <div className="genres">
                            <h2>Gêneros</h2>
                            <ul>
                                {game.genres && game.genres.map((genre, index) => (
                                    <li key={index}>{genre}</li>
                                ))}
                            </ul>
                        </div>
                        <div className="description">
                            <h2>Descrição</h2>
                            <div dangerouslySetInnerHTML={{ __html: game.description }} />
                        </div>
                    </div>
                </div>
            ))}
        </div>
    );
};

export default Game;
