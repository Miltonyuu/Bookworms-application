import React, { useState } from "react";
import { Link } from "react-router-dom";
import Header from "../Components/Header";
import {
  useColorModeValue,
  Box,
  Heading,
  Text,
  Stack,
  Grid,
  GridItem,
  Button,
  FormControl,
  FormLabel,
  Input,
  Textarea,
  Select,
  Icon,
  Alert,
} from "@chakra-ui/react";

function ContactUs() {
  const bgColor = useColorModeValue("gray.50", "gray.800");
  const [formData, setFormData] = useState({
    name: "",
    email: "",
    subject: "",
    message: "",
  });
  const [isSent, setIsSent] = useState(false);

  const handleChange = (e) => {
    setFormData((prevData) => ({ ...prevData, [e.target.name]: e.target.value }));
  };

  const handleSubmit = (e) => {
    e.preventDefault();
    // Handle form submission logic (e.g., send email)
    // Assuming a successful submission:
    setIsSent(true);
    console.log(formData); // Log form data for debugging
  };

  return (
    <div>
      <Header />
      <Box p={4} bg={bgColor}>
        <Stack spacing={4} align="center">
          <Heading fontSize="3xl" color={useColorModeValue("teal.500", "yellow.400")}>
            Get in Touch
          </Heading>
          <Text fontSize="lg" color={useColorModeValue("gray.700", "gray.200")}>
            Have questions or feedback? We're here to listen!
          </Text>
          {isSent && (
            <Alert status="success" mx="auto" mb={4}>
              Your message has been sent!
            </Alert>
          )}
          <form onSubmit={handleSubmit}>
            <Grid templateColumns="repeat(auto-fit, minmax(250px, 1fr))" gap={4}>
              <GridItem>
                <FormControl isRequired>
                  <FormLabel htmlFor="name">Your Name</FormLabel>
                  <Input id="name" type="text" name="name" value={formData.name} onChange={handleChange} />
                </FormControl>
              </GridItem>
              <GridItem>
                <FormControl isRequired>
                  <FormLabel htmlFor="email">Your Email</FormLabel>
                  <Input id="email" type="email" name="email" value={formData.email} onChange={handleChange} />
                </FormControl>
              </GridItem>
              <GridItem>
                <FormControl isRequired>
                  <FormLabel htmlFor="subject">Subject</FormLabel>
                  <Select // Ensure correct binding
                    id="subject"
                    value={formData.subject} // Bind to state variable
                    onChange={handleChange}
                  >
                    <option value="">Select a subject</option>
                    <option value="General Inquiry">General Inquiry</option>
                    <option value="Support Request">Support Request</option>
                    <option value="Feedback">Feedback</option>
                    <option value="Other">Other</option>
                  </Select>
                </FormControl>
              </GridItem>
              <GridItem>
                <FormControl isRequired>
                  <FormLabel htmlFor="message">Message</FormLabel>
                  <Textarea id="message" value={formData.message} onChange={handleChange} />
                </FormControl>
              </GridItem>
            </Grid>
            <Button type="submit" colorScheme="teal" variant="solid" mt={4}>
              Send Message
              <Icon as={Icon} ml={2} name="paper-plane" />
            </Button>
          </form>
          <console.log>
            {/* Added for debugging purposes */}
            {formData.subject && <p>Selected Subject: {formData.subject}</p>}
            {formData.message && <p>Message: {formData.message}</p>}
          </console.log>
        </Stack>
      </Box>
    </div>
  );
}

export default ContactUs;
