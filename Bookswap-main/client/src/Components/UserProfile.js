import React from 'react';
import Header2 from '../Components/Header2';
import {
  FormLabel,
  Flex,
  Box,
  Input,
  Stack,
  Button,
  Heading,
  Text,
  useColorModeValue,
} from "@chakra-ui/react";

const UserProfile = () => (
  
  <div>
      <Header2 />
      <Flex
        minH={"10vh"}
        align={"center"}
        justify={"center"}
      >
        <Stack spacing={8} mx={"auto"} w={"500px"} maxW={"lg"} py={12} px={6}>
          <Stack align={"center"}>
            <Heading fontSize={"4xl"} textAlign={"center"}>
              Update Profile
            </Heading>
          </Stack>
          <form>
            <Box
              rounded={"lg"}
              bg={useColorModeValue("white", "gray.700")}
              boxShadow={"lg"}
              p={8}
              w={"500px"} 
            >
              <Stack spacing={2}>
                  <FormLabel>Username</FormLabel>
                  <Input type="username" />
                  <FormLabel>Email address</FormLabel>
                  <Input type="email" />
                  <FormLabel>Name</FormLabel>
                  <Input type="name" />
                  <FormLabel>Age</FormLabel>
                  <Input type="age" />
                  <FormLabel>Address</FormLabel>
                  <Input type="address" />
                  <FormLabel>Desired Book # 1</FormLabel>
                  <Input type="book1" />
                  <FormLabel>Desired Book # 2</FormLabel>
                  <Input type="book2" />
                  
                  <Stack spacing={10} pt={2}>

                  <Button
                    type="submit"
                    loadingText="Submitting"
                    size="lg"
                    bg={"blue.400"}
                    color={"white"}
                    _hover={{
                      bg: "blue.500",
                    }}
                  ><Text>Update</Text>
                  </Button>
                </Stack>
              </Stack>
            </Box>
          </form>
        </Stack>
      </Flex>
  </div>
);

export default UserProfile;
