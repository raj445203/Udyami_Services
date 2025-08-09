// Example service list
const services = [
  // Original services
  "Plumbing",
  "Electrician", 
  "Carpentry",
  "House Cleaning",
  "Gardening",
  "Furniture Assembly",
  "Painting",
  "AC Repair",
  
  // Popular Services
  "Mehandi Artist",
  "Makeup Artist",
  "Cleaning",
  "Plumber",
  "Movers & Packers",
  "Painter",
  "Beautician",
  "Cook / Tiffin Services",
  "Driver on Call",
  
  // Household & Maintenance
  "Housemaid / Househelp",
  "Elderly Care / Nurse",
  "Pest Control",
  "Washing Machine Repair",
  "AC Servicing",
  "Geyser Repair",
  "Refrigerator Technician",
  "RO Water Purifier Services",
  "Kitchen / Bathroom Cleaning",
  "Water Tank Cleaning",
  
  // Construction & Renovation
  "Civil Contractor",
  "Interior Designer",
  "POP / False Ceiling Work",
  "Fabrication & Welding",
  "Tiling & Marble Work",
  "Painter / Whitewash",
  "Modular Kitchen Setup",
  "Vastu Consultant",
  "Architect",
  "Carpenter",
  
  // Personal & Lifestyle
  "Hair Stylist / Barber",
  "Mehndi Designer",
  "Personal Trainer",
  "Yoga Instructor",
  "Massage Therapist",
  "Tailor / Stitching",
  "Dog Walker / Pet Groomer",
  "Tattoo Artist",
  "Astrologer / Numerologist",
  "Spa & Wellness Expert",
  
  // Decoration & Art
  "Home Decorator",
  "Wallpaper Installation",
  "Wall Art / Mural Painting",
  "Floral Decorator",
  "Indoor Plants & Setup",
  "Handicraft Decor Services",
  "Light Installation (Decor)",
  "Wedding Stage Setup",
  
  // Event Services
  "Event Planner",
  "Birthday Decorator",
  "Balloon Artist",
  "DJ & Sound System",
  "Caterer / Halwai",
  "Dhol / Tasha Party",
  "Tent House",
  "Photography & Videography",
  "Invitation Card Designer",
  "Emcee / Anchor",
  
  // Movers & Transport
  "Home Shifting (Local)",
  "Intercity Movers & Packers",
  "Truck / Tempo on Hire",
  "Bike / Car Transport",
  "Furniture Delivery",
  "Goods Transport Help",
  "Office Relocation",
  "Driver on Demand"
];

const searchInput = document.getElementById("service-search");
const resultsContainer = document.getElementById("autocomplete-results");
const searchButton = document.getElementById("search-button");

searchInput.addEventListener("input", function () {
  const query = this.value.trim().toLowerCase();
  resultsContainer.innerHTML = "";
  
  if (!query) {
    resultsContainer.style.display = "none";
    return;
  }

  // Filter services
  const matches = services.filter(service => service.toLowerCase().includes(query));

  if (matches.length > 0) {
    resultsContainer.style.display = "block";
    matches.forEach(match => {
      const item = document.createElement("div");
      item.classList.add("autocomplete-item");
      item.textContent = match;
      item.onclick = () => {
        searchInput.value = match; // Autofill
        resultsContainer.style.display = "none";
      };
      resultsContainer.appendChild(item);
    });
  } else {
    resultsContainer.style.display = "none";
  }
});

// Redirect on search
searchButton.addEventListener("click", function () {
  const service = searchInput.value.trim();
  if (service) {
    // Redirect to workers list page with category in URL
    window.location.href = `taskers.html?category=${encodeURIComponent(service)}`;
  }
});
