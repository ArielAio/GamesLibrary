import React, { useState, useEffect } from 'react';
import './Css/Register.css';

function Register() {
    const [name_user, setName_User] = useState('');
    const [email_user, setEmail_User] = useState('');
    const [password_user, setPassword_User] = useState('');
    const [csrfToken, setCsrfToken] = useState('');

    useEffect(() => {
        async function fetchCsrfToken() {
            try {
                const response = await fetch('http://127.0.0.1:8000/csrf-token');
                const data = await response.json();
                setCsrfToken(data.csrfToken);
            } catch (error) {
                console.error('Erro ao obter token CSRF:', error);
            }
        }
        fetchCsrfToken();
    }, []);

    const handleSubmit = async (e) => {
        e.preventDefault();
        try {
            const response = await fetch('http://127.0.0.1:8000/api/register', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: JSON.stringify({ name_user, email_user, password_user }),
            });
            if (response.ok) {
                console.log('Cadastro realizado com sucesso!');
            } else {
                console.error('Erro ao cadastrar:', await response.text());
            }
        } catch (error) {
            console.error('Erro ao enviar requisição:', error);
        }
    };

    return (
        <div>
            <h1 className='title'>Cadastre-se na GamesLib!</h1>
            <form onSubmit={handleSubmit} className='form-register'>
                <p>Insira seu nome <input type="text" placeholder="Nome" value={name_user} onChange={(e) => setName_User(e.target.value)} /></p>
                <p>Insira seu email <input type="text" placeholder="Email" value={email_user} onChange={(e) => setEmail_User(e.target.value)} /></p>
                <p>Insira sua senha <input type="password" placeholder="Senha" value={password_user} onChange={(e) => setPassword_User(e.target.value)} /></p>
                <button type="submit" className='btn-register'>Cadastrar</button>
            </form>
            <p className='login'>Já tem uma conta? <a href='/login'>Clique aqui</a></p>
        </div>
    );
}

export default Register;