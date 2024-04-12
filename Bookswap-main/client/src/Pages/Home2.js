import React from 'react';
import Header2 from '../Components/Header2'
import SearchBar from '../Components/SearchBar'
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
            <div style={{paddingTop: "50px", paddingBottom: "10px"}}>
                <SearchBar />
            </div>

            <div className="card">
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

        </div>
            
            
        </div>
        
    );
}

export default Home2;