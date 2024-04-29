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
  Flex,
} from "@chakra-ui/react";
import { useAuth } from "../Hooks/useAuth";
import axios from "axios";

const EditListingForm = ({ listing_id, onListingUpdated }) => {
  // States for form data
  const [price, setPrice] = useState("");
  const [condition, setCondition] = useState("");
  const [description, setDescription] = useState("");
  const [success, setSuccess] = useState(false);
  const { token } = useAuth();

   // Fetch initial listing data
   useEffect(() => {
    const fetchListing = async () => {
      if (!listing_id) {
        return;
      }

      try {
        const response = await axios.get(`/editlistingform/${listing_id}`);
        setPrice(response.data.price);
        setCondition(response.data.condition);
        setDescription(response.data.description);
      } catch (error) {
        console.error("Error fetching listing data:", error);
      }
    };

    fetchListing();
  }, [listing_id]);

   // Handle form submission
   const handleSubmit = async (e) => {
    e.preventDefault();

    console.log("Price:", price);
    console.log("Condition:", condition);
    console.log("Description:", description);

    try {
      const response = await axios.put(`/editlistingform/${listing_id}`, {
        price,
        condition,
        description,
      });

      if (response.status === 200) {
        setSuccess(true);
        if (onListingUpdated) {
          onListingUpdated(); // Trigger callback to refetch listings
        }
      }
    } catch (error) {
      console.error("Error updating listing:", error);
    }
  };

  return (
    <Flex
      alignItems="center"
      justifyContent="center"
      width="100%"
      flexDirection="column"
      height="100vh" // Set height to 100% of viewport height
      position="fixed" // Position the form fixed so it floats above other content
      top="0"
      left="0"
      zIndex="9999" // Ensure it's above other content
      bg="rgba(34, 34, 34, 0.8)" // Set background color with 30% transparency
      color="black" // Set text color
      padding="20px" // Add padding for content
      borderRadius="10px" // Add rounded corners
    >
      <Flex
        as="form"
        flexDirection="column"
        width="100%"
        maxWidth="400px"
        padding="20px"
        bg="#fff" // Set background color for the form
        borderRadius="10px" // Add rounded corners
        boxShadow="0 0 10px rgba(0, 0, 0, 0.1)" // Add subtle light effect
      >   
        <Box textAlign="center" mb={4}>
          <h2 style={{ fontSize: "24px", fontWeight: "bold", color: "#333" }}>
            Edit Listing
          </h2>
        </Box>
        
        <FormControl isRequired>
          <FormLabel>Price</FormLabel>
          <InputGroup>
            <InputLeftAddon children="$" />
            <Input
              type="number"
              placeholder="00.00"
              value={price}
              onChange={(e) => setPrice(e.target.value)}
            />
          </InputGroup>
        </FormControl>

        <FormControl isRequired marginTop={4}>
          <FormLabel>Condition</FormLabel>
          <Select
            placeholder="Select condition"
            value={condition}
            onChange={(e) => setCondition(e.target.value)}
          >
            <option value="0">New</option>
            <option value="1">Like New</option>
            <option value="2">Used</option>
            <option value="3">Acceptable</option>
          </Select>
        </FormControl>

        <FormControl isRequired marginTop={4}>
          <FormLabel>Description</FormLabel>
          <Textarea
            value={description}
            onChange={(e) => setDescription(e.target.value)}
          />
        </FormControl>

        {success && (
          <Alert status="success" marginTop={4}>
            Listing updated successfully!
          </Alert>
        )}

        <Flex justifyContent="center">
          <Button colorScheme="blue" type="submit" marginTop={4} onClick={handleSubmit}>
            Update
          </Button>

          <Button colorScheme="blue" type="submit" marginTop={4} marginLeft={4}>
            Cancel
          </Button>
        </Flex>
        
      </Flex>
    </Flex>
  );
};

export default EditListingForm;
