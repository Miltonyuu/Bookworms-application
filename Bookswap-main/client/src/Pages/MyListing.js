import React from 'react';
import Header2 from '../Components/Header2'
import YourListings from '../Components/YourListings'
import SearchBar from '../Components/SearchBar'
import { useAuth } from '../Hooks/useAuth';

function MyListing() {
    const {isAuthenticated} = useAuth()
    
    return (
        <div>
            <Header2 />
            <div style={{paddingTop: "50px", paddingBottom: "50px"}}>
                <SearchBar />
            </div>
            {isAuthenticated && <YourListings />}
            
        </div>
        
    );
}

export default MyListing;