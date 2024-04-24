import React, { useState, useEffect } from "react";
import axios from "axios";
import { PlusSquareIcon, ViewIcon } from "@chakra-ui/icons";
import {
  SimpleGrid,
  Skeleton,
  Text,
  Card,
  CardBody,
  Center,
  Image,
  Stack,
  Heading,
  Box,
  Button,
  CardFooter,
  HStack,
} from "@chakra-ui/react";

function AListings() {
  const [listings, setListings] = useState();
  
  useEffect(() => {
    const getListings = async () => {
      try {
        // **1. Verify API Call:**
        const responseListings = await axios.get(
          process.env.REACT_APP_API_BASE + "/alistings"
        );
        console.log("Listings response:", responseListings); // Log the response
        
        // **2. Check Response Data:**
        if (responseListings.status === 200) {
          setListings(responseListings.data);
        } else {
          console.error("Failed to fetch listings:", responseListings);
        }
      } catch (error) {
        console.error("Get listings error:", error);
      }
    };

    getListings();
  }, []);

  return (
    <>
      <Text fontSize="2xl" pl={"40px"}>
        All Listings
      </Text>
      {!listings && (
        <Skeleton isLoaded={listings}>
          <Box h={"300px"} />
        </Skeleton>
      )}

      <SimpleGrid
        spacing={3}
        templateColumns="repeat(auto-fill, minmax(300px, 1fr))"
        p={10}
      >
        {!listings && <p>Loading listings...</p>}
        {listings && (
          <>
            {/* **3. Check State and Rendering:** */}
            {listings.length === 0 ? (
              <Text fontSize="xl" pl={"40px"}>
                No listings available
              </Text>
            ) : (
              listings.map((listing, i) => (
                <Card maxW="xs" key={i}pr={6}>
                  <CardBody pr={6}>
                    <Center>
                      {listing.img && (
                        <Image
                          src={listing.img[0]}
                          alt={listing.title}
                          borderRadius="lg"
                        />
                      )}
                    </Center>

                    <Stack mt="6" spacing="3">
                      <Heading size="md">{listing.title}</Heading>
                      <Text>ISBN: {listing.isbn}</Text>
                      <Text>{listing.description}</Text>
                      <Text color="blue.600" fontSize="2xl">
                        ${Number(listing.price).toFixed(2)}
                      </Text>
                      <Text>Seller's Name: {listing.seller}</Text>
                    </Stack>
                  </CardBody>
                  <CardFooter pl={1}>
                        <HStack mt="1" spacing="1" pl={1}>
                          <Button p={4}  leftIcon={<ViewIcon/>} variant="solid" colorScheme="blue">
                            View
                          </Button>
                          <Button p={4}  leftIcon={<PlusSquareIcon/>} variant="solid" colorScheme="yellow" color={'white'}>
                            Bookmark
                          </Button>
                          <Button p={4}  leftIcon={<Text>$</Text>} variant="solid" colorScheme="green">
                            Buy
                          </Button>
                        </HStack>
                  </CardFooter>
                </Card>
              ))
            )}
          </>
        )}
      </SimpleGrid>
    </>
  );
}

export default AListings;
