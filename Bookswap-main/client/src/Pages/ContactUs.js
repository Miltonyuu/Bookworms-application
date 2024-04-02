import React, { useState } from "react";
import { Link } from "react-router-dom";
import Header from "../Components/Header";
import {
  useColorModeValue,
  Box,
  Heading,
  Text,
  Grid,
  GridItem,
  FormControl,
  FormLabel,
  Input,
  Textarea,
  Select,
  Button,
  Alert,
  useDisclosure,
} from "@chakra-ui/react";

function ContactUs() {
  const bgColor = useColorModeValue("gray.50", "gray.900"); // Lighter background for this design
  const secondaryColor = "gray.700"; // Secondary color for text and borders
  const primaryColor = "teal"; // Choose your primary color
  const textColor = useColorModeValue(secondaryColor, "gray.200"); // Adjust text color
  const [formData, setFormData] = useState({
    name: "",
    email: "",
    subject: "",
    message: "",
  });
  const [isSent, setIsSent] = useState(false);
  const { isOpen, onOpen, onClose } = useDisclosure(); // For success message

  const handleChange = (e) => {
    setFormData((prevData) => ({ ...prevData, [e.target.name]: e.target.value }));
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    // Handle form submission logic (e.g., send email)
    setIsSent(true);
    onOpen(); // Open success message
    console.log(formData); // Log form data for debugging
  };

  return (
    <div>
      <Header />
      <Box p={4} bg={bgColor} borderRadius="md">
        <Grid templateColumns="repeat(auto-fit, minmax(300px, 1fr))" gap={4}>
          <GridItem>
            <Heading fontSize="3xl" mb={2}color={primaryColor}>
              Get in Touch
            </Heading>
            <Text fontSize="lg"  color={textColor}>
              Have questions or feedback? We're here to listen!
            </Text>
          </GridItem>
          <GridItem>
            {isSent && (
              <Alert status="success" mx="auto" mb={4} onDismiss={onClose}>
                Your message has been sent!
              </Alert>
            )}
            <form onSubmit={handleSubmit}>
              <FormControl isRequired mb={7}>
                <FormLabel htmlFor="name">Your Name</FormLabel>
                <Input
                  id="name"
                  type="text"
                  name="name"
                  value={formData.name}
                  onChange={handleChange}
                  placeholder="Enter your name"
                />
              </FormControl>
              <FormControl isRequired mb={7}>
                <FormLabel htmlFor="email">Your Email</FormLabel>
                <Input
                  id="email"
                  type="email"
                  name="email"
                  value={formData.email}
                  onChange={handleChange}
                  placeholder="Enter your email address"
                />
              </FormControl>
              <FormControl isRequired mb={7}>
                <FormLabel htmlFor="subject">Subject</FormLabel>
                <Select
                  id="subject"
                  value={formData.subject}
                  onChange={handleChange}
                >
                  <option value="">Select a subject</option>
                  <option value="General Inquiry">General Inquiry</option>
                  <option value="Support Request">Support Request</option>
                  <option value="Feedback">Feedback</option>
                  <option value="Other">Other</option>
                </Select>
              </FormControl>
              <FormControl isRequired mb={7}>
                <FormLabel htmlFor="message">Message</FormLabel>
                <Textarea
                  id="message"
                  value={formData.message}
                  onChange={handleChange}
                  placeholder="Write your message here"
                  height="250px"
                />
              </FormControl>
              <Button type="submit" colorScheme={primaryColor} variant="solid" >
                Send Message
              </Button>
            </form>
          </GridItem>
        </Grid>
      </Box>
    </div>
  );
}

export default ContactUs;
