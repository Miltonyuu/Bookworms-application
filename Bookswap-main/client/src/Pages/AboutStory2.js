import React from "react";
import Header2 from "../Components/Header2";
import { Box, Heading, Text, Container, useColorModeValue } from "@chakra-ui/react";

const AboutStory2 = () => {
  return (
    <div>
      <Header2 />
      <Container maxW="container.md" p={12}>
        <Box
          bg="white"
          width="100%"
          height="400px"
          display="flex"
          flexDirection="column"
          justifyContent="center"
          alignItems="center" // Change: Center the items horizontally
          padding="30px"
          boxShadow="0px 2px 10px rgba(0, 0, 0, 0.1)"
          borderRadius="50px"
        >
          <Heading mb={4} color={useColorModeValue("teal.500", "yellow.400")}>
            Our Story
          </Heading>
          <Text lineHeight="1.5" textAlign="center"> 
            We are fourth-year BSIS students at the Technological University of the Philippines 
            developing BookSwap as our thesis project. Driven by our passion for books and technology, 
            we aim to create a platform for avid readers to exchange and discover new literary treasures.
          </Text>
        </Box>
      </Container>
    </div>
  );
};

export default AboutStory2;
