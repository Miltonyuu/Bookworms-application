import React from "react";
import { Link } from "react-router-dom";
import Header from "../Components/Header"; 
import { useColorModeValue } from "@chakra-ui/react";
import { Box, Heading, Text, Stack, Image, Grid, GridItem, Button, Spacer } from "@chakra-ui/react";

function AboutTeam() {
  const bgColor = useColorModeValue("gray.50", "gray.800");

  const teamMembers = [
    {
      name: "Ian Bautista",
      jobTitle: "Researcher",
      imageUrl: "https://i.ibb.co/FnznzVK/cz-M6-Ly9t-ZWRp-YS1wcml2-YXRl-Lm-Nhbn-Zh-Lm-Nvb-S9-XRXI0-RS9-NQUZu-OWt-XRXI0-RS8x-L3-Auc-G5n.png", 
    },
    {
      name: "Milton Bautista",
      jobTitle: "Lead Developer",
      imageUrl: "https://i.ibb.co/V3s5Njd/cz-M6-Ly9t-ZWRp-YS1wcml2-YXRl-Lm-Nhbn-Zh-Lm-Nvb-S9sbn-ZMQS9-NQUZu-OWdsbn-ZMQS8x-L3-Auc-G5n.png", 
    },
    {
      name: "Michael Angelo Magante",
      jobTitle: "Backend Developer",
      imageUrl: "https://i.ibb.co/tLHgpms/cz-M6-Ly9t-ZWRp-YS1wcml2-YXRl-Lm-Nhbn-Zh-Lm-Nvb-S9-KMj-Nq-OC9-NQUZu-OWp-KMj-Nq-OC8x-L3-Auc-G5n.png", 
    },
    {
      name: "Jay Gerardo",
      jobTitle: "Documentation Lead",
      imageUrl: "https://i.ibb.co/vQBtxzp/cz-M6-Ly9t-ZWRp-YS1wcml2-YXRl-Lm-Nhbn-Zh-Lm-Nvb-S95-WUhf-OC9-NQUZu-OXF5-WUhf-OC8x-L3-Auc-G5n.png", 
    },
    {
      name: "Jomar Catalino",
      jobTitle: "Front-end Developer",
      imageUrl: "https://i.ibb.co/yN2FFC7/cz-M6-Ly9t-ZWRp-YS1wcml2-YXRl-Lm-Nhbn-Zh-Lm-Nvb-S9-DMj-ZTOC9-NQUZu-OXZDMj-ZTOC8x-L3-Auc-G5n.webp", 
    },
  ];

  return (
    <div>
      <Header /> 
      <Box p={4} bg={bgColor}>
        <Stack spacing={8} align="center">
          <Heading fontSize={"3xl"} color={useColorModeValue("teal.500", "yellow.400")}>
            Our Amazing Team
          </Heading>
          <Text fontSize={"lg"} color={useColorModeValue("gray.700", "white")}>
            Meet the passionate individuals who make this all possible.
          </Text>
          <Grid
            templateColumns={{
              base: "repeat(1, 1fr)", 
              md: "repeat(2, 1fr)", 
              lg: "repeat(5, 1fr)", // Adjust for 5 columns
            }}
            gap={6} // Adjust spacing between members
          >
            {teamMembers.map((member) => (
              <GridItem key={member.name}>
                <Image
                  src={member.imageUrl}
                  alt={member.name}
                  borderRadius="full"
                  boxSize="150px"
                  objectFit="cover"
                  mb={2}
                  border={useColorModeValue("gray.200", "white")}
                />
                <Heading fontSize="md" textAlign="center">
                  {member.name}
                </Heading>
                <Text fontSize="sm" color={useColorModeValue("gray.600", "white")} textAlign="center">
                  {member.jobTitle}
                </Text>
              </GridItem>
            ))}
          </Grid>
          <Button
            as={Link} 
            to="/" 
            colorScheme={useColorModeValue("teal", "yellow")} 
            variant="outline" 
          >
            Back to Home
          </Button>
        </Stack>
      </Box>
    </div>
  );
}
export default AboutTeam;
