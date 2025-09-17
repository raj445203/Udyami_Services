<?php
// Start the session to ensure the header can check for login status
session_start();

// Include the header file containing the navigation bar
include('header.php');

// Close the database connection if it was opened in header.php or another file
// In this case, since db.php is not included here, this line is not needed
// but is good practice to include if the connection is established.
// $conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Udyami Services</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="Servies2.css" />
    <style>
        /* New custom styles for the hero search bar */
        .hero-main-content {
            color: white;
        }

        .hero-section {
            background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('https://images.unsplash.com/photo-1542037105-c13f6406d28c?ixlib=rb-4.0.3&q=80&w=2070');
            background-size: cover;
            background-position: center;
            min-height: 40vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .hero-search-bar .form-control {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .search-button {
            background-color: #2cb0ca;
            color: white;
            height: 48px;
            width: 48px;
            border: none;
            transition: background-color 0.3s;
        }

        .search-button:hover {
            background-color: #1a7e94;
        }

        .services-grid-section {
            margin-top: 50px;
        }

        .service-card-bootstrap-link {
            text-decoration: none;
        }

        .service-card-bootstrap {
            background: #a0e6ebff;
            border: 1px solid #e0e0e0;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
            padding: 25px;
            text-align: center;
            transition: all 0.3s ease;
            height: 100%;
        }

        .service-card-bootstrap:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .service-card-bootstrap .icon-container {
            width: 60px;
            height: 60px;
            background: #d1e7dd;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
            color: #084650ff;
            font-size: 2rem;
        }

        .service-card-bootstrap h3 {
            font-size: 1.25rem;
            font-weight: bold;
            color: #084650ff;
            margin-bottom: 5px;
        }

        .service-card-bootstrap p {
            font-size: 0.9rem;
            color: #6c757d;
        }

        #suggestionsList {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: white;
            border: 1px solid #ddd;
            border-top: none;
            z-index: 1000;
            display: none;
            max-height: 200px;
            overflow-y: auto;
            border-radius: 0 0 20px 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        #suggestionsList li {
            padding: 10px 15px;
            cursor: pointer;
        }

        #suggestionsList li:hover {
            background-color: #f8f9fa;
        }
    </style>
</head>

<body>
    <section>
        <section class="hero-section">
            <div class="hero-main-content">
                <div class="container text-center">
                    <h1 class="display-4 fw-bold">Our Services</h1>
                    <p class="lead">Explore a wide range of services tailored to your needs, from home repairs to personal care.</p>

                    <!-- Hero Search Bar with Suggestions -->
                    <div class="hero-search-bar mt-4 position-relative mx-auto" style="max-width: 600px;">
                        <form id="searchForm" class="d-flex rounded-pill overflow-hidden">
                            <input type="search" id="serviceSearch" name="skills" placeholder="Search for a service (e.g., 'AC repair')" class="form-control border-0 py-3 ps-4 pe-5">
                            <button class="search-button btn position-absolute end-0 top-50 translate-middle-y rounded-circle me-1" type="submit">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </button>
                        </form>
                        <ul id="suggestionsList" class="list-group position-absolute mt-1 w-100 rounded-3 overflow-hidden"
                            style="z-index: 1000; display: none; box-shadow: 0 10px 25px rgba(0,0,0,0.1);"></ul>
                    </div>
                </div>
            </div>
        </section>
    </section>

    <main>
        <div class="services-grid-section">
            <div class="container">
                <div class="mb-5"><br><br><br>
                    <h2 id="popular-services" class="text-start mb-4">Popular Services</h2>
                    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
                        <div class="col">
                            <a href="taskers.php?skills=Mehandi Artist" class="service-card-bootstrap-link">
                                <div class="service-card-bootstrap">
                                    <div class="icon-container">
                                        <i class="fa-solid fa-paintbrush"></i>
                                    </div>
                                    <h3>Mehandi Artist</h3>
                                    <p>Beautiful and intricate henna designs for all occasions.</p>
                                </div>
                            </a>
                        </div>
                        <div class="col">
                            <a href="taskers.php?skills=Makeup Artist" class="service-card-bootstrap-link">
                                <div class="service-card-bootstrap">
                                    <div class="icon-container">
                                        <i class="fa-solid fa-spray-can-sparkles"></i>
                                    </div>
                                    <h3>Makeup Artist</h3>
                                    <p>Professional makeup for events, weddings, and photoshoots.</p>
                                </div>
                            </a>
                        </div>
                        <div class="col">
                            <a href="taskers.php?skills=Photography / Videography" class="service-card-bootstrap-link">
                                <div class="service-card-bootstrap">
                                    <div class="icon-container">
                                        <i class="fa-solid fa-camera-retro"></i>
                                    </div>
                                    <h3>Photography & Videography</h3>
                                    <p>Capture your special moments with professional media services.</p>
                                </div>
                            </a>
                        </div>
                        <div class="col">
                            <a href="taskers.php?skills=Tour Agent" class="service-card-bootstrap-link">
                                <div class="service-card-bootstrap">
                                    <div class="icon-container">
                                        <i class="fa-solid fa-car"></i>
                                    </div>
                                    <h3>Tour Agent</h3>
                                    <p>Plan a tour with Tour & Travel Agent.</p>
                                </div>
                            </a>
                        </div>
                        <div class="col">
                            <a href="taskers.php?skills=Caterer / Halwai" class="service-card-bootstrap-link">
                                <div class="service-card-bootstrap">
                                    <div class="icon-container">
                                        <i class="fa-solid fa-bowl-rice"></i>
                                    </div>
                                    <h3>Caterer / Halwai</h3>
                                    <p>Delicious food and professional catering for all gatherings.</p>
                                </div>
                            </a>
                        </div>
                        <div class="col">
                            <a href="taskers.php?skills=Home Decorator" class="service-card-bootstrap-link">
                                <div class="service-card-bootstrap">
                                    <div class="icon-container">
                                        <i class="fa-solid fa-lightbulb"></i>
                                    </div>
                                    <h3>Home Decorator</h3>
                                    <p>Styling and decorating services to beautify your home.</p>
                                </div>
                            </a>
                        </div>
                        <div class="col">
                            <a href="taskers.php?skills=Movers / Packers" class="service-card-bootstrap-link">
                                <div class="service-card-bootstrap">
                                    <div class="icon-container">
                                        <i class="fa-solid fa-truck-moving"></i>
                                    </div>
                                    <h3>Movers & Packers</h3>
                                    <p>Safe and reliable shifting for your home or office.</p>
                                </div>
                            </a>
                        </div>
                        <div class="col">
                            <a href="taskers.php?skills=Painter" class="service-card-bootstrap-link">
                                <div class="service-card-bootstrap">
                                    <div class="icon-container">
                                        <i class="fa-solid fa-paintbrush"></i>
                                    </div>
                                    <h3>Painter</h3>
                                    <p>Interior and exterior painting for a fresh new look.</p>
                                </div>
                            </a>
                        </div>
                        <div class="col">
                            <a href="taskers.php?skills=Beautician" class="service-card-bootstrap-link">
                                <div class="service-card-bootstrap">
                                    <div class="icon-container">
                                        <i class="fa-solid fa-spray-can-sparkles"></i>
                                    </div>
                                    <h3>Beautician</h3>
                                    <p>At-home beauty services including facials and waxing.</p>
                                </div>
                            </a>
                        </div>
                        <div class="col">
                            <a href="taskers.php?skills=Tattoo Artist" class="service-card-bootstrap-link">
                                <div class="service-card-bootstrap">
                                    <div class="icon-container">
                                        <i class="fa-solid fa-palette"></i>
                                    </div>
                                    <h3>Tattoo Artist</h3>
                                    <p>Creative and professional tattooing services in a hygienic setting.</p>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="mb-5">
                    <h2 id="household-maintenance" class="text-start mb-4">Household & Maintenance</h2>
                    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
                        <div class="col">
                            <a href="taskers.php?skills=Housemaid / Househelp" class="service-card-bootstrap-link">
                                <div class="service-card-bootstrap">
                                    <div class="icon-container">
                                        <i class="fa-solid fa-house-chimney"></i>
                                    </div>
                                    <h3>Housemaid / Househelp</h3>
                                    <p>Daily chores, deep cleaning, and domestic assistance.</p>
                                </div>
                            </a>
                        </div>
                        <div class="col">
                            <a href="taskers.php?skills=Pest Control" class="service-card-bootstrap-link">
                                <div class="service-card-bootstrap">
                                    <div class="icon-container">
                                        <i class="fa-solid fa-bug"></i>
                                    </div>
                                    <h3>Pest Control</h3>
                                    <p>Effective solutions for termites, rodents, and other pests.</p>
                                </div>
                            </a>
                        </div>
                        <div class="col">
                            <a href="taskers.php?skills=Washing Machine Repair" class="service-card-bootstrap-link">
                                <div class="service-card-bootstrap">
                                    <div class="icon-container">
                                        <i class="fa-solid fa-washer"></i>
                                    </div>
                                    <h3>Washing Machine Repair</h3>
                                    <p>Fixes for all washing machine brands and models.</p>
                                </div>
                            </a>
                        </div>
                        <div class="col">
                            <a href="taskers.php?skills=AC Servicing" class="service-card-bootstrap-link">
                                <div class="service-card-bootstrap">
                                    <div class="icon-container">
                                        <i class="fa-solid fa-air-conditioner"></i>
                                    </div>
                                    <h3>AC Servicing</h3>
                                    <p>Keep cool with our expert AC maintenance and repair.</p>
                                </div>
                            </a>
                        </div>
                        <div class="col">
                            <a href="taskers.php?skills=Geyser Repair" class="service-card-bootstrap-link">
                                <div class="service-card-bootstrap">
                                    <div class="icon-container">
                                        <i class="fa-solid fa-water-heater"></i>
                                    </div>
                                    <h3>Geyser Repair</h3>
                                    <p>Timely repair and installation of all types of geysers.</p>
                                </div>
                            </a>
                        </div>
                        <div class="col">
                            <a href="taskers.php?skills=Refrigerator Technician" class="service-card-bootstrap-link">
                                <div class="service-card-bootstrap">
                                    <div class="icon-container">
                                        <i class="fa-solid fa-refrigerator"></i>
                                    </div>
                                    <h3>Refrigerator Technician</h3>
                                    <p>Fast solutions for cooling issues and part replacements.</p>
                                </div>
                            </a>
                        </div>
                        <div class="col">
                            <a href="taskers.php?skills=RO Water Purifier Services" class="service-card-bootstrap-link">
                                <div class="service-card-bootstrap">
                                    <div class="icon-container">
                                        <i class="fa-solid fa-water-filter"></i>
                                    </div>
                                    <h3>RO Water Purifier Services</h3>
                                    <p>Installation, repair, and maintenance of RO systems.</p>
                                </div>
                            </a>
                        </div>
                        <div class="col">
                            <a href="taskers.php?skills=Kitchen / Bathroom Cleaning" class="service-card-bootstrap-link">
                                <div class="service-card-bootstrap">
                                    <div class="icon-container">
                                        <i class="fa-solid fa-sink"></i>
                                    </div>
                                    <h3>Kitchen / Bathroom Cleaning</h3>
                                    <p>Specialized deep cleaning for your kitchen and bathrooms.</p>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="mb-5">
                    <h2 id="construction-renovation" class="text-start mb-4">Construction & Renovation</h2>
                    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
                        <div class="col">
                            <a href="taskers.php?skills=Civil Contractor" class="service-card-bootstrap-link">
                                <div class="service-card-bootstrap">
                                    <div class="icon-container">
                                        <i class="fa-solid fa-helmet-safety"></i>
                                    </div>
                                    <h3>Civil Contractor</h3>
                                    <p>Comprehensive services for new construction and major renovations.</p>
                                </div>
                            </a>
                        </div>
                        <div class="col">
                            <a href="taskers.php?skills=Interior Designer" class="service-card-bootstrap-link">
                                <div class="service-card-bootstrap">
                                    <div class="icon-container">
                                        <i class="fa-solid fa-couch"></i>
                                    </div>
                                    <h3>Interior Designer</h3>
                                    <p>Space planning, design, and project management.</p>
                                </div>
                            </a>
                        </div>
                        <div class="col">
                            <a href="taskers.php?skills=POP / False Ceiling Work" class="service-card-bootstrap-link">
                                <div class="service-card-bootstrap">
                                    <div class="icon-container">
                                        <i class="fa-solid fa-ceiling-light"></i>
                                    </div>
                                    <h3>POP / False Ceiling Work</h3>
                                    <p>Professional false ceiling and plaster of Paris installation.</p>
                                </div>
                            </a>
                        </div>
                        <div class="col">
                            <a href="taskers.php?skills=Fabrication / Welding" class="service-card-bootstrap-link">
                                <div class="service-card-bootstrap">
                                    <div class="icon-container">
                                        <i class="fa-solid fa-welding-torch"></i>
                                    </div>
                                    <h3>Fabrication & Welding</h3>
                                    <p>Custom metal work, repairs, and structural fabrication.</p>
                                </div>
                            </a>
                        </div>
                        <div class="col">
                            <a href="taskers.php?skills=Tiling / Marble Work" class="service-card-bootstrap-link">
                                <div class="service-card-bootstrap">
                                    <div class="icon-container">
                                        <i class="fa-solid fa-tiles"></i>
                                    </div>
                                    <h3>Tiling & Marble Work</h3>
                                    <p>Expert installation and repair for floors, walls, and countertops.</p>
                                </div>
                            </a>
                        </div>
                        <div class="col">
                            <a href="taskers.php?skills=Painter / Whitewash" class="service-card-bootstrap-link">
                                <div class="service-card-bootstrap">
                                    <div class="icon-container">
                                        <i class="fa-solid fa-paint-roller"></i>
                                    </div>
                                    <h3>Painter / Whitewash</h3>
                                    <p>Interior and exterior painting for a fresh new look.</p>
                                </div>
                            </a>
                        </div>
                        <div class="col">
                            <a href="taskers.php?skills=Vastu Consultant" class="service-card-bootstrap-link">
                                <div class="service-card-bootstrap">
                                    <div class="icon-container">
                                        <i class="fa-solid fa-house-user"></i>
                                    </div>
                                    <h3>Vastu Consultant</h3>
                                    <p>Expert advice on architectural and interior design principles.</p>
                                </div>
                            </a>
                        </div>
                        <div class="col">
                            <a href="taskers.php?skills=Carpenter" class="service-card-bootstrap-link">
                                <div class="service-card-bootstrap">
                                    <div class="icon-container">
                                        <i class="fa-solid fa-tools"></i>
                                    </div>
                                    <h3>Carpenter</h3>
                                    <p>Furniture assembly, custom shelves, and door repairs.</p>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="mb-5">
                    <h2 id="personal-lifestyle" class="text-start mb-4">Personal & Lifestyle</h2>
                    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
                        <div class="col">
                            <a href="taskers.php?skills=Hair Stylist / Barber" class="service-card-bootstrap-link">
                                <div class="service-card-bootstrap">
                                    <div class="icon-container">
                                        <i class="fa-solid fa-scissors"></i>
                                    </div>
                                    <h3>Hair Stylist / Barber</h3>
                                    <p>Professional hair care and styling at your doorstep.</p>
                                </div>
                            </a>
                        </div>
                        <div class="col">
                            <a href="taskers.php?skills=Mehandi Artist" class="service-card-bootstrap-link">
                                <div class="service-card-bootstrap">
                                    <div class="icon-container">
                                        <i class="fa-solid fa-paintbrush-pencil"></i>
                                    </div>
                                    <h3>Mehandi Artist</h3>
                                    <p>Beautiful and intricate henna designs for all occasions.</p>
                                </div>
                            </a>
                        </div>
                        <div class="col">
                            <a href="taskers.php?skills=Massage Therapist" class="service-card-bootstrap-link">
                                <div class="service-card-bootstrap">
                                    <div class="icon-container">
                                        <i class="fa-solid fa-massage"></i>
                                    </div>
                                    <h3>Massage Therapist</h3>
                                    <p>Relaxing and therapeutic massages at your home.</p>
                                </div>
                            </a>
                        </div>
                        <div class="col">
                            <a href="taskers.php?skills=Physiotherapist" class="service-card-bootstrap-link">
                                <div class="service-card-bootstrap">
                                    <div class="icon-container">
                                        <i class="fa-solid fa-user-nurse"></i>
                                    </div>
                                    <h3>Physiotherapist</h3>
                                    <p>Expert physiotherapy for pain relief, injury recovery, and mobility improvement at home.</p>
                                </div>
                            </a>
                        </div>
                        <div class="col">
                            <a href="taskers.php?skills=Gym Trainer" class="service-card-bootstrap-link">
                                <div class="service-card-bootstrap">
                                    <div class="icon-container">
                                        <i class="fa-solid fa-dumbbell"></i>
                                    </div>
                                    <h3>Gym Trainer</h3>
                                    <p>Personalized fitness training and workout plans for your goals.</p>
                                </div>
                            </a>
                        </div>
                        <div class="col">
                            <a href="taskers.php?skills=Tailor / Stitching" class="service-card-bootstrap-link">
                                <div class="service-card-bootstrap">
                                    <div class="icon-container">
                                        <i class="fa-solid fa-scissors"></i>
                                    </div>
                                    <h3>Tailor / Stitching</h3>
                                    <p>Custom tailoring and clothing alterations delivered to your door.</p>
                                </div>
                            </a>
                        </div>
                        <div class="col">
                            <a href="taskers.php?skills=Dog Walker / Pet Groomer" class="service-card-bootstrap-link">
                                <div class="service-card-bootstrap">
                                    <div class="icon-container">
                                        <i class="fa-solid fa-dog"></i>
                                    </div>
                                    <h3>Dog Walker / Pet Groomer</h3>
                                    <p>Caring services for your pets, from walks to grooming.</p>
                                </div>
                            </a>
                        </div>
                        <div class="col">
                            <a href="taskers.php?skills=Tattoo Artist" class="service-card-bootstrap-link">
                                <div class="service-card-bootstrap">
                                    <div class="icon-container">
                                        <i class="fa-solid fa-tattoo"></i>
                                    </div>
                                    <h3>Tattoo Artist</h3>
                                    <p>Creative and professional tattooing services in a hygienic setting.</p>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="mb-5">
                    <h2 id="decoration-art" class="text-start mb-4">Decoration & Art</h2>
                    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
                        <div class="col">
                            <a href="taskers.php?skills=Home Decorator" class="service-card-bootstrap-link">
                                <div class="service-card-bootstrap">
                                    <div class="icon-container">
                                        <i class="fa-solid fa-lightbulb"></i>
                                    </div>
                                    <h3>Home Decorator</h3>
                                    <p>Styling and decorating services to beautify your home.</p>
                                </div>
                            </a>
                        </div>
                        <div class="col">
                            <a href="taskers.php?skills=Wallpaper Installation" class="service-card-bootstrap-link">
                                <div class="service-card-bootstrap">
                                    <div class="icon-container">
                                        <i class="fa-solid fa-paint-brush"></i>
                                    </div>
                                    <h3>Wallpaper Installation</h3>
                                    <p>Professional wallpaper hanging and removal services.</p>
                                </div>
                            </a>
                        </div>
                        <div class="col">
                            <a href="taskers.php?skills=Wall Art / Mural Painting" class="service-card-bootstrap-link">
                                <div class="service-card-bootstrap">
                                    <div class="icon-container">
                                        <i class="fa-solid fa-paint-brush-fine"></i>
                                    </div>
                                    <h3>Wall Art / Mural Painting</h3>
                                    <p>Custom art and murals to personalize your living space.</p>
                                </div>
                            </a>
                        </div>
                        <div class="col">
                            <a href="taskers.php?skills=Floral Decorator" class="service-card-bootstrap-link">
                                <div class="service-card-bootstrap">
                                    <div class="icon-container">
                                        <i class="fa-solid fa-flower-tulip"></i>
                                    </div>
                                    <h3>Floral Decorator</h3>
                                    <p>Beautiful floral arrangements for any occasion.</p>
                                </div>
                            </a>
                        </div>
                        <div class="col">
                            <a href="taskers.php?skills=Handicraft Decor Services" class="service-card-bootstrap-link">
                                <div class="service-card-bootstrap">
                                    <div class="icon-container">
                                        <i class="fa-solid fa-palette"></i>
                                    </div>
                                    <h3>Handicraft Decor Services</h3>
                                    <p>Unique, handmade decorations to add a personal touch to your home.</p>
                                </div>
                            </a>
                        </div>
                        <div class="col">
                            <a href="taskers.php?skills=Light Installation" class="service-card-bootstrap-link">
                                <div class="service-card-bootstrap">
                                    <div class="icon-container">
                                        <i class="fa-solid fa-lightbulb-on"></i>
                                    </div>
                                    <h3>Light Installation (Decor)</h3>
                                    <p>Ambiance and event lighting solutions for your home.</p>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="mb-5">
                    <h2 id="event-services" class="text-start mb-4">Event Services</h2>
                    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
                        <div class="col">
                            <a href="taskers.php?skills=Event Planner" class="service-card-bootstrap-link">
                                <div class="service-card-bootstrap">
                                    <div class="icon-container">
                                        <i class="fa-solid fa-calendar-days"></i>
                                    </div>
                                    <h3>Event Planner</h3>
                                    <p>Comprehensive planning and coordination for events.</p>
                                </div>
                            </a>
                        </div>
                        <div class="col">
                            <a href="taskers.php?skills=Birthday Decorator" class="service-card-bootstrap-link">
                                <div class="service-card-bootstrap">
                                    <div class="icon-container">
                                        <i class="fa-solid fa-birthday-cake"></i>
                                    </div>
                                    <h3>Birthday Decorator</h3>
                                    <p>Creative and fun decorations for birthday parties.</p>
                                </div>
                            </a>
                        </div>
                        <div class="col">
                            <a href="taskers.php?skills=Balloon Artist" class="service-card-bootstrap-link">
                                <div class="service-card-bootstrap">
                                    <div class="icon-container">
                                        <i class="fa-solid fa-balloon"></i>
                                    </div>
                                    <h3>Balloon Artist</h3>
                                    <p>Creative balloon decorations and installations for any event.</p>
                                </div>
                            </a>
                        </div>
                        <div class="col">
                            <a href="taskers.php?skills=DJ / Sound System" class="service-card-bootstrap-link">
                                <div class="service-card-bootstrap">
                                    <div class="icon-container">
                                        <i class="fa-solid fa-volume-high"></i>
                                    </div>
                                    <h3>DJ & Sound System</h3>
                                    <p>Professional DJs and high-quality sound equipment for parties and weddings.</p>
                                </div>
                            </a>
                        </div>
                        <div class="col">
                            <a href="taskers.php?skills=Caterer / Halwai" class="service-card-bootstrap-link">
                                <div class="service-card-bootstrap">
                                    <div class="icon-container">
                                        <i class="fa-solid fa-burger-cheese"></i>
                                    </div>
                                    <h3>Caterer / Halwai</h3>
                                    <p>Delicious food and professional catering for all gatherings.</p>
                                </div>
                            </a>
                        </div>
                        <div class="col">
                            <a href="taskers.php?skills=Dhol / Tasha Party" class="service-card-bootstrap-link">
                                <div class="service-card-bootstrap">
                                    <div class="icon-container">
                                        <i class="fa-solid fa-drum"></i>
                                    </div>
                                    <h3>Dhol / Tasha Party</h3>
                                    <p>Traditional music and energetic performances for festive events.</p>
                                </div>
                            </a>
                        </div>
                        <div class="col">
                            <a href="taskers.php?skills=Tent House" class="service-card-bootstrap-link">
                                <div class="service-card-bootstrap">
                                    <div class="icon-container">
                                        <i class="fa-solid fa-tent"></i>
                                    </div>
                                    <h3>Tent House</h3>
                                    <p>Tents, lighting, and seating for outdoor events and functions.</p>
                                </div>
                            </a>
                        </div>
                        <div class="col">
                            <a href="taskers.php?skills=Photography / Videography" class="service-card-bootstrap-link">
                                <div class="service-card-bootstrap">
                                    <div class="icon-container">
                                        <i class="fa-solid fa-camera-retro"></i>
                                    </div>
                                    <h3>Photography & Videography</h3>
                                    <p>Capture your special moments with professional media services.</p>
                                </div>
                            </a>
                        </div>
                        <div class="col">
                            <a href="taskers.php?skills=Anchor" class="service-card-bootstrap-link">
                                <div class="service-card-bootstrap">
                                    <div class="icon-container">
                                        <i class="fa-solid fa-microphone"></i>
                                    </div>
                                    <h3>Anchor</h3>
                                    <p>Engaging hosts and speakers for a memorable event.</p>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="mb-5">
                    <h2 id="movers-transport" class="text-start mb-4">Movers & Transport</h2>
                    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
                        <div class="col">
                            <a href="taskers.php?skills=Home Shifting" class="service-card-bootstrap-link">
                                <div class="service-card-bootstrap">
                                    <div class="icon-container">
                                        <i class="fa-solid fa-boxes-packing"></i>
                                    </div>
                                    <h3>Home Shifting (Local)</h3>
                                    <p>Efficient and affordable moving services within the city.</p>
                                </div>
                            </a>
                        </div>
                        <div class="col">
                            <a href="taskers.php?skills=Intercity Movers / Packers" class="service-card-bootstrap-link">
                                <div class="service-card-bootstrap">
                                    <div class="icon-container">
                                        <i class="fa-solid fa-city"></i>
                                    </div>
                                    <h3>Intercity Movers & Packers</h3>
                                    <p>Reliable and secure long-distance moving solutions.</p>
                                </div>
                            </a>
                        </div>
                        <div class="col">
                            <a href="taskers.php?skills=Truck / Tempo on Hire" class="service-card-bootstrap-link">
                                <div class="service-card-bootstrap">
                                    <div class="icon-container">
                                        <i class="fa-solid fa-truck"></i>
                                    </div>
                                    <h3>Truck / Tempo on Hire</h3>
                                    <p>Rent trucks and tempos for all your transportation needs.</p>
                                </div>
                            </a>
                        </div>
                        <div class="col">
                            <a href="taskers.php?skills=Bike / Car Transport" class="service-card-bootstrap-link">
                                <div class="service-card-bootstrap">
                                    <div class="icon-container">
                                        <i class="fa-solid fa-car-side"></i>
                                    </div>
                                    <h3>Bike / Car Transport</h3>
                                    <p>Safe and secure transport of your vehicles across locations.</p>
                                </div>
                            </a>
                        </div>
                        <div class="col">
                            <a href="taskers.php?skills=Goods Transport Help" class="service-card-bootstrap-link">
                                <div class="service-card-bootstrap">
                                    <div class="icon-container">
                                        <i class="fa-solid fa-box-open"></i>
                                    </div>
                                    <h3>Goods Transport Help</h3>
                                    <p>Assistance with moving and transporting your goods.</p>
                                </div>
                            </a>
                        </div>
                        <div class="col">
                            <a href="taskers.php?skills=Driver on Demand" class="service-card-bootstrap-link">
                                <div class="service-card-bootstrap">
                                    <div class="icon-container">
                                        <i class="fa-solid fa-car"></i>
                                    </div>
                                    <h3>Driver on Demand</h3>
                                    <p>Book a professional driver for a few hours or for a full day.</p>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <?php
    include('footer.php');
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        // Service list
        const services = [
            "Mehandi Artist", "Makeup Artist", "House Cleaning", "Electrician", "Plumber",
            "Movers / Packers", "Painter", "Beautician", "Cook / Tiffin Services",
            "Housemaid / Househelp", "Pest Control", "Washing Machine Repair",
            "AC Servicing", "Geyser Repair", "Refrigerator Technician", "RO Water Purifier Services",
            "Kitchen / Bathroom Cleaning", "Civil Contractor", "Interior Designer", "POP / False Ceiling Work",
            "Fabrication / Welding", "Tiling / Marble Work", "Painter / Whitewash", "Vastu Consultant",
            "Hair Stylist / Barber", "Mehndi Artist", "Massage Therapist", "Tailor / Stitching",
            "Physiotherapist", "Gym Trainer",
            "Dog Walker / Pet Groomer", "Tattoo Artist", "Home Decorator", "Wallpaper Installation",
            "Wall Art / Mural Painting", "Floral Decorator", "Handicraft Decor Services",
            "Light Installation (Decor)", "Wedding Stage Setup", "Event Planner", "Birthday Decorator",
            "Balloon Artist", "DJ / Sound System", "Caterer / Halwai", "Dhol / Tasha Party",
            "Tent House", "Photography / Videography", "Anchor", "Home Shifting (Local)",
            "Intercity Movers & Packers", "Truck / Tempo on Hire", "Bike / Car Transport", "Goods Transport Help",
            "Driver on Demand"
        ];

        const searchInput = document.getElementById("serviceSearch");
        const suggestionsList = document.getElementById("suggestionsList");

        // Show suggestions while typing
        searchInput.addEventListener("input", function() {
            const query = this.value.toLowerCase();
            suggestionsList.innerHTML = "";

            if (query.trim() === "") {
                suggestionsList.style.display = "none";
                return;
            }

            const filteredServices = services.filter(service => service.toLowerCase().includes(query));

            if (filteredServices.length > 0) {
                suggestionsList.style.display = "block";
                filteredServices.forEach(service => {
                    const li = document.createElement("li");
                    li.classList.add("list-group-item", "border-0", "py-3", "hover-bg-light");
                    li.style.cursor = "pointer";
                    li.style.transition = "all 0.2s ease";
                    li.innerHTML = `<i class="fa-solid fa-magnifying-glass me-2 text-muted"></i> ${service}`;
                    li.addEventListener("click", function() {
                        window.location.href = `taskers.php?skills=${encodeURIComponent(service)}`;
                    });
                    suggestionsList.appendChild(li);
                });
            } else {
                suggestionsList.style.display = "none";
            }
        });

        // Redirect when search button clicked or form submitted
        document.getElementById("searchForm").addEventListener("submit", function(e) {
            e.preventDefault(); // Prevent default form submission
            const service = searchInput.value.trim();
            if (service !== "") {
                window.location.href = `taskers.php?skills=${encodeURIComponent(service)}`;
            }
        });

        // Hide suggestions when clicking outside
        document.addEventListener("click", function(e) {
            if (!searchInput.contains(e.target) && !suggestionsList.contains(e.target)) {
                suggestionsList.style.display = "none";
            }
        });
    </script>
</body>

</html>