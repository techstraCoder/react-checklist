// import logo from './logo.svg';
import 'bootstrap/dist/css/bootstrap.min.css';
import './App.css';
import Header from './components/Navigation/Header.js'
import Footer from './components/Navigation/Footer.js'
import Login from './components/Login.jsx';
import router from './components/Route.jsx';
import {RouterProvider } from 'react-router-dom';


function App() {
  return (
    <div className="App">
       <style>{'@import url("https://fonts.googleapis.com/css2?family=ABeeZee:ital@0;1&display=swap"); body{background:#3070cef7;};'}</style>
      <RouterProvider router={router}/>       
    </div>
  );
}

export default App;
