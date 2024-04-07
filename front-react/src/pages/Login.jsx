import './Css/Register.css'

function Register(){

    return(

        <div>
            <h1 className='title'>Entrar na GamesLib!</h1>
            <form action="" className='form-register'>
            <p>Insira seu email <input type="text" placeholder="Email"/></p>
            <p>Insira sua senha <input type="password" placeholder="Senha"/></p>
            <button type="submit" className='btn-register'>Entrar</button>
            </form>
            <p className='login'>Ainda não tem uma conta? <a href='/register'>Clique aqui</a></p>

        </div>

    )

}

export default Register;