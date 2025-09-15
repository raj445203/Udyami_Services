<?php
header('Content-Type: application/json');

$services = [
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
    "Physiotherapist", 
    "Gym Trainer",
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

$q = isset($_GET['q']) ? strtolower($_GET['q']) : '';
$matches = [];

if ($q !== '') {
    foreach ($services as $service) {
        if (stripos($service, $q) !== false) {
            $matches[] = $service;
        }
    }
}

// Return matches as JSON
echo json_encode($matches);
