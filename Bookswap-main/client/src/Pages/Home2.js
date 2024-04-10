import React from 'react';
import Header2 from '../Components/Header2'
import SearchBar from '../Components/SearchBar'

function Home2() {
    
    return (
        <div>
            <Header2 />
            <div style={{paddingTop: "50px", paddingBottom: "50px"}}>
                <SearchBar />
            </div>
            
            
        </div>
        
    );
}

export default Home2;