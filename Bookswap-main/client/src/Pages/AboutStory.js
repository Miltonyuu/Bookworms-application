import React from "react";
import Header from "../Components/Header"; 
import { Box, Heading, Text, Container } from "@chakra-ui/react";

const AboutStory = () => {
  return (
    <div>
      <Header /> 
      <Container maxW='container.md' p={12}> 
        <Box 
          bg="white"  
          width="100%"
          height="400px"
          display="flex"
          flexDirection="column"
          justifyContent="center"
          alignItems="start"  
          padding="30px" 
          boxShadow="0px 2px 10px rgba(0, 0, 0, 0.1)"  
          borderRadius="50px"  
        >
          <Heading mb={4}>Our Story</Heading>
          <Text lineHeight="1.5"> 
            We are fourth-year BSIS students at the Technological University of the Philippines 
            developing BookSwap as our thesis project.  Driven by our passion for books and technology, 
            we aim to create a platform for avid readers to exchange and discover new literary treasures.
          </Text>
        </Box>
      </Container>
    </div>
  );
};

export default AboutStory;
