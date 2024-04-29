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
import ViewListing from './ViewListing'; // Assuming ViewListing.js is in the same directory

function AListings() {
    const [listings, setListings] = useState();
    const [selectedListingId, setSelectedListingId] = useState(null); // State for selected listing
    const [isModalOpen, setIsModalOpen] = useState(false); // State for modal visibility

    useEffect(() => {
        const getListings = async () => {
            try {
                const responseListings = await axios.get(
                    process.env.REACT_APP_API_BASE + "/alistings"
                );
                console.log("Listings response:", responseListings);

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

            <SimpleGrid spacing={3} templateColumns="repeat(auto-fill, minmax(300px, 1fr))" p={10}>
                {!listings ? (
                    <p>Loading listings...</p>
                ) : (
                    <>
                        {listings.length === 0 ? (
                            <Text fontSize="xl" pl={"40px"}>
                                No listings available
                            </Text>
                        ) : (
                            listings.map((listing, i) => (
                                <Card maxW="xs" key={i} pr={6}>
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
                                            <Button
                                                p={4}
                                                leftIcon={<ViewIcon />}
                                                variant="solid"
                                                colorScheme="blue"
                                                onClick={() => {
                                                    console.log("listing._id before update:", listing._id);

                                                    // Safeguard: Check if listing._id actually exists
                                                    if (listing._id) {
                                                        const stringId = listing._id.$oid; // Access the $oid property
                                                        console.log("listing._id after toString():", stringId);
                                                        setSelectedListingId(stringId);
                                                        console.log("selectedListingId after update:", selectedListingId);
                                                        setIsModalOpen(true);
                                                        console.log("listing._id at source:", listing._id);
                                                    } else {
                                                        console.error("Error: listing._id is missing");
                                                        // Handle the case where listing._id is unavailable, perhaps display an error message
                                                    }
                                                }}
                                            >
                                                View
                                            </Button>
                                        </HStack>
                                    </CardFooter>
                                </Card>
                            ))
                        )}
                    </>
                )}
            </SimpleGrid>

            {isModalOpen && ( // Conditionally render the modal
                <ViewListing
                    listingId={selectedListingId}
                    onClose={() => { 
                        setSelectedListingId(null); 
                        setIsModalOpen(false);
                    }}
                />
            )} 
        </>
    );
}

export default AListings;

