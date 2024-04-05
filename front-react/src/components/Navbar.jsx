//Imports necessários
import { Link } from "react-router-dom";
import { IoGameController } from "react-icons/io5";

import "./Css/Navbar.css";

// Componente funcional Navbar para a barra de navegação
const Navbar = () => {
  // Função para recarregar a página ao clicar no logo
  const handleReloadPage = () => {
    // Navegar para a página inicial e recarregar a página
    window.location.href = '/';
  };

  // Renderiza a Navbar
  return (
    <nav id="navbar">
      <h2>
        <Link to="/" onClick={handleReloadPage}>
          <IoGameController />GamesLib
        </Link>
      </h2>
    </nav>
  );

};

export default Navbar;