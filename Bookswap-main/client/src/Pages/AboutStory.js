import React from "react";
import { Link } from "react-router-dom";
import Header from "../Components/Header"; // Assuming Header is in Components folder
import { useColorModeValue } from "@chakra-ui/react";
import { Box, Heading, Text, Stack, Image, Grid, GridItem, Button } from "@chakra-ui/react";

function AboutTeam() {
  const bgColor = useColorModeValue("gray.50", "gray.800"); // Dynamic background color

  return (
    <div>
      <Header /> {/* Add the Header component here */}
      <Box p={4} bg={bgColor}>
        <Stack spacing={8} align="center">
          <Heading fontSize={"3xl"} color={useColorModeValue("teal.500", "yellow.400")}>
            Our Amazing Team
          </Heading>
          <Text fontSize={"lg"} color={useColorModeValue("gray.700", "white")}>
            Meet the passionate individuals who make this all possible.
          </Text>
          <Grid templateColumns="repeat(auto-fit, minmax(250px, 1fr))" gap={6}>
            {/* Team member sections */}
            <GridItem>
              {/* ... Team member content ... */}
            </GridItem>
            {/* ... More GridItem sections for other team members ... */}
          </Grid>
          <Button // Convert the Link to a Button
            as={Link} // Maintain routing functionality
            to="/" // Link to the home page
            colorScheme={useColorModeValue("teal", "yellow")} // Dynamic color scheme
            variant="outline" // Button style
          >
            Back to Home
          </Button>
        </Stack>
      </Box>
    </div>
  );
}

export default AboutTeam;
