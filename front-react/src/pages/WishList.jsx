import React, { useState, useEffect } from 'react';
import cleanURL from '../components/ClearURL';
import './Css/WishList.css'; // Importe o arquivo de estilo

function WishList() {
    const [url, setUrl] = useState('');
    const [cleanUrl, setCleanUrl] = useState('');

    // Pegar último parâmetro da URL
    const parts = window.location.pathname.split("/");
    const nameGame = parts[parts.length - 1];

    // Limpar a URL quando o componente montar
    useEffect(() => {
        const cleanNameGame = cleanURL(nameGame);
        setUrl(nameGame);
        setCleanUrl(cleanNameGame);
    }, []);

 

    return (
        <div className="wish-list-container">
            <form className="wish-list-form" action="">
                <h2>Detalhes da Compra</h2>
                <p>Nome do Jogo:</p>
                <input type="text" value={cleanUrl} readOnly />
                <p>Seu Nome:</p>
                <input type="text" placeholder='Nome' />
                <p>Preço:</p>
                <input type="number" placeholder='R$' />
                <button type='submit'>Comprar</button>
            </form>
        </div>
    );
}

export default WishList;
