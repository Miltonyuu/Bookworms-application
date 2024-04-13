import React from "react";
import Header2 from "../Components/Header2";
import { Box, Heading, Text, Container, useColorModeValue, Button } from "@chakra-ui/react";
import { Link } from 'react-router-dom';

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
          alignItems="center"
          padding="30px"
          boxShadow="0px 2px 10px rgba(0, 0, 0, 0.1)"
          borderRadius="50px"
        >
          <Heading mb={4} color={useColorModeValue("teal.500", "yellow.400")}>
            Our Story
          </Heading>
          <Text lineHeight="1.5" textAlign="center">
            We are fourth-year BSIS students at the Technological University of the Philippines developing BookSwap as our thesis project. Driven by our passion for books and technology, we aim to create a platform for avid readers to exchange and discover new literary treasures.
          </Text>

          {/* Add margin to the top using `marginTop` */}
          <Button as={Link} 
                  to="/home2" 
                  colorScheme={useColorModeValue("teal", "yellow")} 
                  variant="outline" 
                  marginTop={4}>
            Back to Home
          </Button>
        </Box>
      </Container>
    </div>
  );
};
export default AboutStory2;
