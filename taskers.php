<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Taskers List</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
  <style>
    .tasker-card {
      border: 1px solid #0e5a6b;
      border-radius: 10px;
      background-color: #bde8f2;
      padding: 15px;
      margin-bottom: 20px;
      transition: all 0.3s ease;
    }
    .tasker-card:hover {
      box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
  </style>
</head>
<body>


   <nav class="navbar navbar-light bg-white border-bottom p-3 px-4">
    <a class="navbar-brand d-flex align-items-center fw-bold" href="#">
      <img src="images/logo2.png" alt="TaskRabbit" height="50">HandyHelp
    </a>
    <div class="d-flex gap-3 align-items-center">
      <a href="Services2.html" class="text-dark fw-semibold text-decoration-none">Services</a>
      <a href="login.html" class="text-dark fw-semibold text-decoration-none">Sign up / Log in</a>
     <a href="become-a-tasker.html"> <button class="btn btn-outline-success">Become a Tasker</button></a>
    </div>
  </nav>

  
  <div class="container my-5">
    <h2 id="category-heading" class="mb-4 text-center"></h2>
    <div id="tasker-list" class="row justify-content-center"></div>
  </div>

  <script>
    // Step 1: Read category from URL
    const urlParams = new URLSearchParams(window.location.search);
    const selectedCategory = urlParams.get("category");

    // Step 2: All taskers (full list)
    const taskers = [
      { name: "Ravi Mehta", category: "Mehandi Artist", location: "Pune", rating: 4.8 },
      { name: "Kiran Tailor", category: "Mehandi Artist", location: "Mumbai", rating: 4.6 },
      { name: "Anita Sharma", category: "Cleaning", location: "Nashik", rating: 4.9 },
      { name: "Sahil Electrician", category: "Cleaning", location: "Nagpur", rating: 4.7 },
      { name: "Deepak Kumar", category: "Assembly", location: "Delhi", rating: 4.5 },
      { name: "Nisha Events", category: "Events", location: "Bhopal", rating: 4.9 },
      { name: "Manoj Movers", category: "Moving", location: "Hyderabad", rating: 4.2 },
      { name: "Rupa Mehendi", category: "Mehandi", location: "Jaipur", rating: 4.8 },
      { name: "Vikas Mount", category: "Mounting", location: "Lucknow", rating: 4.4 },
      { name: "Pooja Decor", category: "Decorations", location: "Chandigarh", rating: 4.7 },
      // Add more taskers here
    ];

    // Step 3: Filter taskers by selected category
    const filteredTaskers = selectedCategory 
      ? taskers.filter(t => t.category.toLowerCase() === selectedCategory.toLowerCase()) 
      : taskers;

    // Step 4: Render heading
    const heading = document.getElementById("category-heading");
    heading.innerText = selectedCategory 
      ? `Available Taskers for "${selectedCategory}"`
      : "All Available Taskers";

    // Step 5: Render taskers
    const taskerList = document.getElementById("tasker-list");

    if (filteredTaskers.length === 0) {
      taskerList.innerHTML = `<p class="text-center text-danger">No taskers found for "${selectedCategory}".</p>`;
    } else {
      filteredTaskers.forEach(t => {
        const card = `
          <div class="col-md-4">
            <div class="tasker-card">
              <h4>${t.name}</h4>
              <p><strong>Category:</strong> ${t.category}</p>
              <p><strong>Location:</strong> ${t.location}</p>
              <p><strong>Rating:</strong> ${t.rating} ⭐</p>
              <button class="btn btn-primary">Book Now</button>
            </div>
          </div>
        `;
        taskerList.innerHTML += card;
      });
    }
  </script>
</body>
</html>
