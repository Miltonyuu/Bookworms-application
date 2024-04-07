import React from 'react'
import { Routes, Route } from "react-router-dom";
import CreateListing from './Pages/CreateListing';
import Home from './Pages/Home';
import Home2 from './Pages/Home2';
import Register from './Pages/Register';
import Login from './Pages/Login';
import AboutStory from './Pages/AboutStory';
import AboutStory2 from './Pages/AboutStory2';
import AboutTeam from './Pages/AboutTeam';
import AboutTeam2 from './Pages/AboutTeam2';
import ContactUs from './Pages/ContactUs';
import ContactUs2 from './Pages/ContactUs2';
import Dashboard from './Components/Dashboard';
import UserProfile from './Components/UserProfile';
import MyListing from './Pages/MyListing';

function App() {

  return (
    <div>
      <Routes>
        <Route path="/" element={<Home />} />
        <Route path="/home2" element={<Home2 />} />
        <Route path="/register" element={<Register />} />
        <Route path="/createlisting" element={<CreateListing />} />
        <Route path="/mylisting" element={<MyListing />} />
        <Route path="/login" element={<Login />} />
        <Route path="/aboutstory" element={<AboutStory />} />
        <Route path="/aboutstory2" element={<AboutStory2 />} />
        <Route path="/aboutteam" element={<AboutTeam />} />
        <Route path="/aboutteam2" element={<AboutTeam2 />} />
        <Route path="/contactus" element={<ContactUs />} />
        <Route path="/contactus2" element={<ContactUs2 />} />
        <Route path="/dashboard" element={<Dashboard />} />
        <Route path="/userprofile" element={<UserProfile />} />
      </Routes>
    </div>
  )
}

export default App