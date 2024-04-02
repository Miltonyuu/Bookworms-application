import React from 'react'
import { Routes, Route } from "react-router-dom";
import CreateListing from './Pages/CreateListing';
import Home from './Pages/Home';
import Register from './Pages/Register';
import Login from './Pages/Login';
import AboutStory from './Pages/AboutStory';
import AboutTeam from './Pages/AboutTeam';
import ContactUs from './Pages/ContactUs';

function App() {

  return (
    <div>
      <Routes>
        <Route path="/" element={<Home />} />
        <Route path="/register" element={<Register />} />
        <Route path="/createlisting" element={<CreateListing />} />
        <Route path="/login" element={<Login />} />
        <Route path="/aboutstory" element={<AboutStory />} />
        <Route path="/aboutteam" element={<AboutTeam />} />
        <Route path="/contactus" element={<ContactUs />} />
      </Routes>
    </div>
  )
}

export default App