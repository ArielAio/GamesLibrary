import React from 'react';
import ReactDOM from 'react-dom/client';
import { BrowserRouter, Routes, Route } from "react-router-dom";


import App from './App';
import Home from './pages/Home';
import Game from './pages/Game';


const root = ReactDOM.createRoot(document.getElementById('root'));
root.render(
  <React.StrictMode>
    <BrowserRouter>
      <Routes>
        <Route element={<App />}>
          <Route path="/" element={<Home />} />
          <Route path="game/:id" element={<Game />} />
        </Route>
      </Routes>
    </BrowserRouter>

  </React.StrictMode>
);