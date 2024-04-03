import React, { useState, useEffect } from "react";
import { 
  Box,
  FormControl,
  FormLabel,
  Input,
  InputGroup,
  Select,
  Textarea,
  Button,
  Alert,
  InputLeftAddon,
} from "@chakra-ui/react";
import { useAuth } from "../Hooks/useAuth";
import axios from 'axios';


const EditListingForm = ({ listingId }) => {
  // States for form data
  const [price, setPrice] = useState("");  
  const [condition, setCondition] = useState(""); 
  const [description, setDescription] = useState(""); 
  const [success, setSuccess] = useState(false);

  const { token } = useAuth();

  // Fetch initial listing data
  useEffect(() => {
    const fetchListing = async () => {
      try{
        console.log(listingId); // Added this line to inspect the listingId value
        const response = await axios.get(`/listings/${listingId}`, {
          headers: { Authorization: `Bearer ${token}` },
        });

        if (response.status === 200) {
          setPrice(response.data.price);
          setCondition(response.data.condition);
          setDescription(response.data.description);
        } 

      } catch (error) {
        console.error("Error fetching listing data:", error);
        // Handle fetching errors appropriately 
      }
    };

    fetchListing(); 
}, [listingId, token]);


  // Handle form submission
  const handleSubmit = async (e) => {
    e.preventDefault();

    try {
        const response = await axios.put(
          `/listings/${listingId}`,
          { price, condition, description }, 
          { headers: { Authorization: `Bearer ${token}` } }
        );

        if (response.status === 200) { 
          setSuccess(true);
          // (Optional) Refetch listings in YourListings component
        } 
    } catch (error) {
      console.error("Error updating listing:", error);
      // Handle updating errors appropriately 
    }
};


  return (
    <form onSubmit={handleSubmit}>
      <Box>
        <FormControl isRequired>
          <FormLabel>Price</FormLabel>
          <InputGroup>
            <InputLeftAddon children="$" />
            <Input 
              type="number" // Or type="text" if needed
              placeholder="00.00" 
              value={price} 
              onChange={(e) => setPrice(e.target.value)} 
             />
          </InputGroup>
        </FormControl>

        <FormControl isRequired>
          <FormLabel>Condition</FormLabel>
          <Select 
            placeholder="Select condition"
            value={condition} 
            onChange={(e) => setCondition(e.target.value)}>
            {/* Add your <option> elements for conditions here */}
            <option value="0">New</option> 
            <option value="1">Like New</option>
            <option value="2">Used</option>
            <option value="3">Acceptable</option>
          </Select>
        </FormControl>

         <FormControl isRequired>
          <FormLabel>Description</FormLabel>
          <Textarea 
            value={description} 
            onChange={(e) => setDescription(e.target.value)}
          />
        </FormControl>

        {success && ( 
          <Alert status="success">
            Listing updated successfully!
          </Alert>
        )}

        <Button colorScheme="blue" type="submit">Update Listing</Button>
      </Box>
    </form>
  );
};

export default EditListingForm;
