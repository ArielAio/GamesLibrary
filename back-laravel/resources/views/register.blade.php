<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1 className='title'>Cadastre-se na GamesLib!</h1>
            <form action="/api/register" method="POST" className='form-register'>
                <input type="hidden" name="_token" value='{{csrf_token()}}''>
                <p>Insira seu nome <input type="text" placeholder="Nome"/></p>
                <p>Insira seu email <input type="text" placeholder="Email"/></p>
                <p>Insira sua senha <input type="password" placeholder="Senha"/></p>
                <button type="submit" className='btn-register'>Cadastrar</button>
            </form>
            <p className='login'>Já tem uma conta? <a href='/login'>Clique aqui</a></p>
</body>
</html>