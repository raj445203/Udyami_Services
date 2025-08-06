const express = require('express');
const path = require('path');
const app = express();
const PORT = 3000;

// Middleware to parse JSON and form data
app.use(express.json());
app.use(express.urlencoded({ extended: true }));

// Serve static frontend files from "public" folder
app.use(express.static(path.join(__dirname, 'public')));

// Route: Home Page
app.get('/', (req, res) => {
  res.sendFile(path.join(__dirname, 'public', 'index.html'));
});

// Route: Taskers List Page
app.get('/taskers', (req, res) => {
  res.sendFile(path.join(__dirname, 'public', 'taskers.html'));
});

// Example: API route for fetching taskers (optional)
app.get('/api/taskers', (req, res) => {
  const dummyTaskers = [
    { id: 1, name: "Ravi Kumar", category: "Plumbing", rating: 4.8 },
    { id: 2, name: "Anjali Verma", category: "Cleaning", rating: 4.5 },
    { id: 3, name: "Suresh Singh", category: "Painting", rating: 4.7 },
  ];
  res.json(dummyTaskers);
});

// Start the server
app.listen(PORT, () => {
  console.log(`✅ Server is running at http://localhost:${PORT}`);
});
