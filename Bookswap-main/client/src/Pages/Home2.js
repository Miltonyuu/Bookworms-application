import React from 'react';
import Header2 from '../Components/Header2'
import SearchBar from '../Components/SearchBar'
import AListings from '../Components/AListings';
import { Carousel } from 'react-responsive-carousel';
import "react-responsive-carousel/lib/styles/carousel.min.css";

import "../Pages/slider.css";

import img1  from "../Images/rezimage1.jpg";
import img2  from "../Images/rezimage2.jpg";
import img3  from "../Images/rezimage3.jpg";


function Home2() {
    
    return (
        <div>
            <Header2 />
            <div className="card" style={{paddingTop:"50px"}}>
                <Carousel className='main-carousel'>
                    <div>
                        <img src={img1} style={{height:"500px", width:"2000px"}} alt="promoteImg1" />
                    </div>
                    <div>
                        <img src={img2} style={{height:"500px", width:"2000px"}} alt="promoteImg2" />
                    </div>
                    <div>
                        <img src={img3} style={{height:"500px", width:"2000px"}} alt="promoteImg3" />
                    </div>
                </Carousel>

            <div style={{paddingTop: "40px", paddingBottom: "10px"}}>
                <SearchBar />
            </div>

        </div>
            <AListings />
            
            
        </div>
        
    );
}

export default Home2;