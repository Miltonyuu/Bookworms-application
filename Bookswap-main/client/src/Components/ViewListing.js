import React, { useState, useEffect } from "react";
import { useAuth } from "../Hooks/useAuth";
import axios from "axios";
import { 
    Modal,
    ModalOverlay,
    ModalContent,
    ModalHeader,
    ModalFooter,
    ModalBody,
    ModalCloseButton,
    Button,
    useDisclosure   // Import for Chakra UI modal control
} from "@chakra-ui/react";

// ... other necessary imports for your popup modal (e.g., Chakra UI components)

function ViewListing({ listingId, onClose }) { 
    const [listing, setListing] = useState(null);
    const { isOpen, onOpen, onModalClose } = useDisclosure(); 

    const { token } = useAuth(); // Get the token inside the component

    useEffect(() => {
        console.log("listingId in ViewListing useEffect:", listingId); // Add this line
        const fetchListingDetails = async () => {
            console.log("listingId in fetchListingDetails:", listingId);
            if (listingId) {
                try {
                    const headers = {};
                    if (token) {  
                        headers.Authorization = `Bearer ${token}`;
                    }  
        
                    // Extract string ID for URL
                    const listingIdString = listingId.toString(); 
                    console.log("listingIdString:", listingIdString); 
        
                    const response = await axios.get(`${process.env.REACT_APP_API_BASE}/ViewListing/${listingIdString}`, { headers });
                    setListing(response.data);
                } catch (error) { 
                    console.error("Error fetching listing details:", error);
                }
            }
        };
        
        
        fetchListingDetails();
    }, [listingId]); 
    
    return (
      <> 
      <Button onClick={onOpen}>View Details</Button> 

      <Modal isOpen={isOpen} onClose={onModalClose}>
          <ModalOverlay />
          <ModalContent>
              <ModalHeader>Listing Details</ModalHeader>
              <ModalCloseButton />
              <ModalBody>
                        {listing && (
                            <Stack spacing={4}>
                                <Image src={listing.image} alt={listing.title} />
                                <Text fontSize="xl">Title: {listing.title}</Text>
                                <Text>ISBN: {listing.isbn}</Text>
                                <Text>Price: ${listing.price}</Text>
                                <Text>Description: {listing.description}</Text>
                                <Text>Seller: {listing.seller}</Text> 
                                <Text>Condition: {listing.condition}</Text>
                            </Stack>
                        )}
                    </ModalBody>

              <ModalFooter>
                  <Button colorScheme="blue" mr={3} onClick={onModalClose}>
                      Close
                  </Button>
              </ModalFooter>
          </ModalContent>
      </Modal>
    </>
    );
}

export default ViewListing;