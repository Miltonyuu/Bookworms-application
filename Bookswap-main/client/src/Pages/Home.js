import React from 'react';
import Header from '../Components/Header'
import YourListings from '../Components/YourListings'
import SearchBar from '../Components/SearchBar'
import { useAuth } from '../Hooks/useAuth';
import { Carousel } from 'react-responsive-carousel';
import "react-responsive-carousel/lib/styles/carousel.min.css";

import "../Pages/slider.css";

import img1  from "../Images/rezimage1.jpg";
import img2  from "../Images/rezimage2.jpg";
import img3  from "../Images/rezimage3.jpg";

function Home() {
    const {isAuthenticated} = useAuth()
    
    return (
        <div>
            <Header />
            <div style={{paddingTop: "50px", paddingBottom: "50px"}}>
                <SearchBar />
            </div>
            {isAuthenticated && <YourListings />}

            <div className="card">
                <Carousel className='main-carousel'>
                    <div>
                        <img src={img1} style={{height:"500px", width:"2000px"}} />
                    </div>
                    <div>
                        <img src={img2} style={{height:"500px", width:"2000px"}} />
                    </div>
                    <div>
                        <img src={img3} style={{height:"500px", width:"2000px"}} />
                    </div>
                </Carousel>
            </div>

        </div>
    );
}

export default Home;
