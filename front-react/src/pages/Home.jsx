//Imports necessários
import 'slick-carousel/slick/slick.css';
import 'slick-carousel/slick/slick-theme.css';

import ListFavoriteGames from '../components/ListFavoriteGames';
import ListGames from '../components/ListGames';


const Home = () => {

    //Renderiza a estrutura de lista/pesquisa da página
    return (
        <div className="container">
            <>
                <ListFavoriteGames />
            </>

            <div className="games-container" >
                <ListGames />
            </div>
        </div>
    );
    
};

export default Home;