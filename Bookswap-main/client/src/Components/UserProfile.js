import React from 'react';
import Header2 from '../Components/Header2';
import { Text, Center, Stack, Box} from '@chakra-ui/react';

const UserProfile = () => (
  
  <div style={{ display: 'flex', justifyContent: 'center', alignItems: 'center' }}>  {/* Center the content horizontally and vertically */}
    <Header2 />
    <Box
      // Set width and height equal to create a square
      width="500px"
      height="300px"
      // Set borderRadius to 50% for a perfect circle
      borderRadius="10%"
      backgroundColor="#E2E8F0"
      p={4}
    >
      <Center bg='transparent' color='black' font-family='Helvetica'>
        USER PROFILE
      </Center>
      <Stack spacing={2}>
        <Text fontSize='3xl' font-family='Helvetica'>First Name</Text>
        <flex>
        <Box
    backgroundColor="red"
    padding={4}
    borderRadius="md"  /* Adjust radius as needed */
  ></Box>
        </flex>
        <Text fontSize='3xl' font-family='Helvetica'>Last Name</Text>
        <flex>
        <Box
    backgroundColor="red"
    padding={4}
    borderRadius="md"  /* Adjust radius as needed */
  ></Box>
    
        </flex>
        <Text fontSize='3xl' font-family='Helvetica'>Phone Number</Text>
        <flex>
        <Box
    backgroundColor="red"
    padding={4}
    borderRadius="md"  /* Adjust radius as needed */
  ></Box>
    
        </flex>
        <Text fontSize='3xl' font-family='Helvetica'>Address</Text>
      </Stack>
      
    </Box>
  </div>
);

export default UserProfile;
