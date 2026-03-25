<?php
session_start();
include('header.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Udyami Services</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link rel="stylesheet" href="Services2.css" />
</head>

<body>

    <!-- HERO -->
    <section class="hero-section">
        <div class="container text-center hero-main-content">
            <h1 class="fw-bold">Find Trusted Services Near You</h1>
            <p>Book reliable professionals for home, personal & event services</p>

            <div class="hero-search-bar mt-4 position-relative mx-auto" style="max-width:600px;">
                <form id="searchForm" class="d-flex rounded-pill overflow-hidden">
                    <input type="search" id="serviceSearch" name="skills"
                        placeholder="Search for a service (e.g., AC repair)"
                        class="form-control border-0 py-3 ps-4">

                    <button class="search-button btn position-absolute end-0 top-50 translate-middle-y me-2"
                        type="submit">
                       <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                </form>

                <ul id="suggestionsList"
                    class="list-group position-absolute mt-1 w-100 rounded-3 overflow-hidden"
                    style="z-index:1000; display:none;"></ul>
            </div>
        </div>
    </section>

    <!-- MAIN -->
    <main class="services-grid-section">
        <div class="container">

            <!-- ================= POPULAR ================= -->
            <div class="mb-5">
                <h2 id="popular-services" class="section-heading">Popular Services</h2>

                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">

                    <!-- REUSABLE CARD STYLE -->

                    <!-- CARD 1 -->
                    <div class="col">
                        <a href="taskers.php?skills=Mehandi Artist" class="service-card-bootstrap-link">
                            <div class="card service-card-bootstrap" style="background-image: url('images/mehandi-artist.png'); background-size: cover; background-position: center;">
                                <div style="position:absolute; bottom:0; left:0; right:0; height:80%; background:linear-gradient(to top, rgba(0,0,0,1), rgba(0,0,0,0.6), transparent);"></div>
                                <div class="card-body" style="position:absolute; bottom:0; color:white;">
                                    <h3>Mehandi Artist</h3>
                                    <p style="opacity:0.8;">Beautiful henna designs</p>
                                </div>
                            </div>
                        </a>
                    </div>

                    <!-- CARD 2 -->
                    <div class="col">
                        <a href="taskers.php?skills=Makeup Artist" class="service-card-bootstrap-link">
                            <div class="card service-card-bootstrap" style="background-image: url('images/makeup_artist.png'); background-size: cover; background-position: center;">
                                <div style="position:absolute; bottom:0; left:0; right:0; height:80%; background:linear-gradient(to top, rgba(0,0,0,1), rgba(0,0,0,0.6), transparent);"></div>
                                <div class="card-body" style="position:absolute; bottom:0; color:white;">
                                    <h3>Makeup Artist</h3>
                                    <p style="opacity:0.8;">Professional makeup services</p>
                                </div>
                            </div>
                        </a>
                    </div>

                    <!-- CARD 3 -->
                    <div class="col">
                        <a href="taskers.php?skills=Photography / Videography" class="service-card-bootstrap-link">
                            <div class="card service-card-bootstrap" style="background-image: url('images/photography&videography.png'); background-size: cover; background-position: center;">
                                <div style="position:absolute; bottom:0; left:0; right:0; height:80%; background:linear-gradient(to top, rgba(0,0,0,1), rgba(0,0,0,0.6), transparent);"></div>
                                <div class="card-body" style="position:absolute; bottom:0; color:white;">
                                    <h3>Photography & Videography</h3>
                                    <p style="opacity:0.8;">Capture your special moments</p>
                                </div>
                            </div>
                        </a>
                    </div>

                    <!-- CARD 4 -->
                    <div class="col">
                        <a href="taskers.php?skills=Tour Agent" class="service-card-bootstrap-link">
                            <div class="card service-card-bootstrap" style="background-image: url('images/tour-agent.png'); background-size: cover; background-position: center;">
                                <div style="position:absolute; bottom:0; left:0; right:0; height:80%; background:linear-gradient(to top, rgba(0,0,0,1), rgba(0,0,0,0.6), transparent);"></div>
                                <div class="card-body" style="position:absolute; bottom:0; color:white;">
                                    <h3>Tour Agent</h3>
                                    <p style="opacity:0.8;">Plan your travel easily</p>
                                </div>
                            </div>
                        </a>
                    </div>

                    <!-- CARD 5 -->
                    <div class="col">
                        <a href="taskers.php?skills=Caterer / Halwai" class="service-card-bootstrap-link">
                            <div class="card service-card-bootstrap" style="background-image: url('images/caterer-halwai.png'); background-size: cover; background-position: center;">
                                <div style="position:absolute; bottom:0; left:0; right:0; height:80%; background:linear-gradient(to top, rgba(0,0,0,1), rgba(0,0,0,0.6), transparent);"></div>
                                <div class="card-body" style="position:absolute; bottom:0; color:white;">
                                    <h3>Caterer / Halwai</h3>
                                    <p style="opacity:0.8;">Delicious food and professional catering for all gatherings.</p>
                                </div>
                            </div>
                        </a>
                    </div>

                    <!-- CARD 6 -->
                    <div class="col">
                        <a href="taskers.php?skills=Home Decorator" class="service-card-bootstrap-link">
                            <div class="card service-card-bootstrap" style="background-image: url('images/home-decoretor.png'); background-size: cover; background-position: center;">
                                <div style="position:absolute; bottom:0; left:0; right:0; height:80%; background:linear-gradient(to top, rgba(0,0,0,1), rgba(0,0,0,0.6), transparent);"></div>
                                <div class="card-body" style="position:absolute; bottom:0; color:white;">
                                    <h3>Home Decorator</h3>
                                    <p style="opacity:0.8;">Styling and decorating services to beautify your home.</p>
                                </div>
                            </div>
                        </a>
                    </div>

                    <!-- CARD 7 -->
                    <div class="col">
                        <a href="taskers.php?skills=Movers / Packers" class="service-card-bootstrap-link">
                            <div class="card service-card-bootstrap" style="background-image: url('images/movers-packers.png'); background-size: cover; background-position: center;">
                                <div style="position:absolute; bottom:0; left:0; right:0; height:80%; background:linear-gradient(to top, rgba(0,0,0,1), rgba(0,0,0,0.6), transparent);"></div>
                                <div class="card-body" style="position:absolute; bottom:0; color:white;">
                                    <h3>Movers & Packers</h3>
                                    <p style="opacity:0.8;">Safe and reliable shifting for your home or office.</p>
                                </div>
                            </div>
                        </a>
                    </div>

                    <!-- CARD 8 -->
                    <div class="col">
                        <a href="taskers.php?skills=Painter" class="service-card-bootstrap-link">
                            <div class="card service-card-bootstrap" style="background-image: url('images/painter.png'); background-size: cover; background-position: center;">
                                <div style="position:absolute; bottom:0; left:0; right:0; height:80%; background:linear-gradient(to top, rgba(0,0,0,1), rgba(0,0,0,0.6), transparent);"></div>
                                <div class="card-body" style="position:absolute; bottom:0; color:white;">
                                    <h3>Painter</h3>
                                    <p style="opacity:0.8;">Interior and exterior painting for a fresh new look.</p>
                                </div>
                            </div>
                        </a>
                    </div>

                    <!-- CARD 9 -->
                    <div class="col">
                        <a href="taskers.php?skills=Beautician" class="service-card-bootstrap-link">
                            <div class="card service-card-bootstrap" style="background-image: url('images/Beautician.png'); background-size: cover; background-position: center;">
                                <div style="position:absolute; bottom:0; left:0; right:0; height:80%; background:linear-gradient(to top, rgba(0,0,0,1), rgba(0,0,0,0.6), transparent);"></div>
                                <div class="card-body" style="position:absolute; bottom:0; color:white;">
                                    <h3>Beautician</h3>
                                    <p style="opacity:0.8;">At-home beauty services including facials and waxing.</p>
                                </div>
                            </div>
                        </a>
                    </div>

                    <!-- CARD 10 -->
                    <div class="col">
                        <a href="taskers.php?skills=Tattoo Artist" class="service-card-bootstrap-link">
                            <div class="card service-card-bootstrap" style="background-image: url('images/tatoo-artist.png'); background-size: cover; background-position: center;">
                                <div style="position:absolute; bottom:0; left:0; right:0; height:80%; background:linear-gradient(to top, rgba(0,0,0,1), rgba(0,0,0,0.6), transparent);"></div>
                                <div class="card-body" style="position:absolute; bottom:0; color:white;">
                                    <h3>Tattoo Artist</h3>
                                    <p style="opacity:0.8;">Creative and professional tattooing services in a hygienic setting.</p>
                                </div>
                            </div>
                        </a>
                    </div>

                </div>
            </div>
            <hr class="section-divider">
            <div class="mb-5">
                <h2 id="household-maintenance" class="section-heading mb-4">Household & Maintenance</h2>
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
                    <div class="col">
                        <a href="taskers.php?skills=Housemaid / Househelp" class="service-card-bootstrap-link">
                            <div class="card service-card-bootstrap" style="background-image: url('images/housemaid.png'); background-size: cover; background-position: center;">
                                <div style="position:absolute; bottom:0; left:0; right:0; height:80%; background:linear-gradient(to top, rgba(0,0,0,1), rgba(0,0,0,0.6), transparent);"></div>
                                <div class="card-body" style="position:absolute; bottom:0; color:white;">
                                    <h3>Housemaid / Househelp</h3>
                                    <p style="opacity:0.8;">Daily chores, deep cleaning, and domestic assistance.</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col">
                        <a href="taskers.php?skills=Pest Control" class="service-card-bootstrap-link">
                            <div class="card service-card-bootstrap" style="background-image: url('images/pest-control.png'); background-size: cover; background-position: center;">
                                <div style="position:absolute; bottom:0; left:0; right:0; height:80%; background:linear-gradient(to top, rgba(0,0,0,1), rgba(0,0,0,0.6), transparent);"></div>
                                <div class="card-body" style="position:absolute; bottom:0; color:white;">
                                    <h3>Pest Control</h3>
                                    <p style="opacity:0.8;">Effective solutions for termites, rodents, and other pests.</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col">
                        <a href="taskers.php?skills=Washing Machine Repair" class="service-card-bootstrap-link">
                            <div class="card service-card-bootstrap" style="background-image: url('images/washing-machine.png'); background-size: cover; background-position: center;">
                                <div style="position:absolute; bottom:0; left:0; right:0; height:80%; background:linear-gradient(to top, rgba(0,0,0,1), rgba(0,0,0,0.6), transparent);"></div>
                                <div class="card-body" style="position:absolute; bottom:0; color:white;">
                                    <h3>Washing Machine Repair</h3>
                                    <p style="opacity:0.8;">Fixes for all washing machine brands and models.</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col">
                        <a href="taskers.php?skills=AC Servicing" class="service-card-bootstrap-link">
                            <div class="card service-card-bootstrap" style="background-image: url('images/ac-repair.png'); background-size: cover; background-position: center;">
                                <div style="position:absolute; bottom:0; left:0; right:0; height:80%; background:linear-gradient(to top, rgba(0,0,0,1), rgba(0,0,0,0.6), transparent);"></div>
                                <div class="card-body" style="position:absolute; bottom:0; color:white;">
                                    <h3>AC Servicing</h3>
                                    <p style="opacity:0.8;">Keep cool with our expert AC maintenance and repair.</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col">
                        <a href="taskers.php?skills=Geyser Repair" class="service-card-bootstrap-link">
                            <div class="card service-card-bootstrap" style="background-image: url('images/geyser.png'); background-size: cover; background-position: center;">
                                <div style="position:absolute; bottom:0; left:0; right:0; height:80%; background:linear-gradient(to top, rgba(0,0,0,1), rgba(0,0,0,0.6), transparent);"></div>
                                <div class="card-body" style="position:absolute; bottom:0; color:white;">
                                    <h3>Geyser Repair</h3>
                                    <p style="opacity:0.8;">Timely repair and installation of all types of geysers.</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col">
                        <a href="taskers.php?skills=Refrigerator Technician" class="service-card-bootstrap-link">
                            <div class="card service-card-bootstrap" style="background-image: url('images/Refrigerator.png'); background-size: cover; background-position: center;">
                                <div style="position:absolute; bottom:0; left:0; right:0; height:80%; background:linear-gradient(to top, rgba(0,0,0,1), rgba(0,0,0,0.6), transparent);"></div>
                                <div class="card-body" style="position:absolute; bottom:0; color:white;">
                                    <h3>Refrigerator Technician</h3>
                                    <p style="opacity:0.8;">Fast solutions for cooling issues and part replacements.</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col">
                        <a href="taskers.php?skills=RO Water Purifier Services" class="service-card-bootstrap-link">
                            <div class="card service-card-bootstrap" style="background-image: url('images/RO-water.png'); background-size: cover; background-position: center;">
                                <div style="position:absolute; bottom:0; left:0; right:0; height:80%; background:linear-gradient(to top, rgba(0,0,0,1), rgba(0,0,0,0.6), transparent);"></div>
                                <div class="card-body" style="position:absolute; bottom:0; color:white;">
                                    <h3>RO Water Purifier Services</h3>
                                    <p style="opacity:0.8;">Installation, repair, and maintenance of RO systems.</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col">
                        <a href="taskers.php?skills=Kitchen / Bathroom Cleaning" class="service-card-bootstrap-link">
                            <div class="card service-card-bootstrap" style="background-image: url('images/kitchen-bathroom.png'); background-size: cover; background-position: center;">
                                <div style="position:absolute; bottom:0; left:0; right:0; height:80%; background:linear-gradient(to top, rgba(0,0,0,1), rgba(0,0,0,0.6), transparent);"></div>
                                <div class="card-body" style="position:absolute; bottom:0; color:white;">
                                    <h3>Kitchen / Bathroom Cleaning</h3>
                                    <p style="opacity:0.8;">Specialized deep cleaning for your kitchen and bathrooms.</p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <hr class="section-divider">
            <div class="mb-5">
                <h2 id="construction-renovation" class="section-heading mb-4">Construction & Renovation</h2>
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
                    <div class="col">
                        <a href="taskers.php?skills=Civil Contractor" class="service-card-bootstrap-link">
                            <div class="card service-card-bootstrap" style="background-image: url('images/Civil Contractor.png'); background-size: cover; background-position: center;">
                                <div style="position:absolute; bottom:0; left:0; right:0; height:80%; background:linear-gradient(to top, rgba(0,0,0,1), rgba(0,0,0,0.6), transparent);"></div>
                                <div class="card-body" style="position:absolute; bottom:0; color:white;">
                                    <h3>Civil Contractor</h3>
                                    <p style="opacity:0.8;">Comprehensive services for new construction and major renovations.</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col">
                        <a href="taskers.php?skills=Interior Designer" class="service-card-bootstrap-link">
                            <div class="card service-card-bootstrap" style="background-image: url('images/Interior Designer.png'); background-size: cover; background-position: center;">
                                <div style="position:absolute; bottom:0; left:0; right:0; height:80%; background:linear-gradient(to top, rgba(0,0,0,1), rgba(0,0,0,0.6), transparent);"></div>
                                <div class="card-body" style="position:absolute; bottom:0; color:white;">
                                    <h3>Interior Designer</h3>
                                    <p style="opacity:0.8;">Space planning, design, and project management.</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col">
                        <a href="taskers.php?skills=POP / False Ceiling Work" class="service-card-bootstrap-link">
                            <div class="card service-card-bootstrap" style="background-image: url('images/POP  False Ceiling Work.png'); background-size: cover; background-position: center;">
                                <div style="position:absolute; bottom:0; left:0; right:0; height:80%; background:linear-gradient(to top, rgba(0,0,0,1), rgba(0,0,0,0.6), transparent);"></div>
                                <div class="card-body" style="position:absolute; bottom:0; color:white;">
                                    <h3>POP / False Ceiling Work</h3>
                                    <p style="opacity:0.8;">Professional false ceiling and plaster of Paris installation.</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col">
                        <a href="taskers.php?skills=Fabrication / Welding" class="service-card-bootstrap-link">
                            <div class="card service-card-bootstrap" style="background-image: url('images/Fabrication  Welding.png'); background-size: cover; background-position: center;">
                                <div style="position:absolute; bottom:0; left:0; right:0; height:80%; background:linear-gradient(to top, rgba(0,0,0,1), rgba(0,0,0,0.6), transparent);"></div>
                                <div class="card-body" style="position:absolute; bottom:0; color:white;">
                                    <h3>Fabrication & Welding</h3>
                                    <p style="opacity:0.8;">Custom metal work, repairs, and structural fabrication.</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col">
                        <a href="taskers.php?skills=Tiling / Marble Work" class="service-card-bootstrap-link">
                            <div class="card service-card-bootstrap" style="background-image: url('images/Tiling & Marble Work.png'); background-size: cover; background-position: center;">
                                <div style="position:absolute; bottom:0; left:0; right:0; height:80%; background:linear-gradient(to top, rgba(0,0,0,1), rgba(0,0,0,0.6), transparent);"></div>
                                <div class="card-body" style="position:absolute; bottom:0; color:white;">
                                    <h3>Tiling & Marble Work</h3>
                                    <p style="opacity:0.8;">Expert installation and repair for floors, walls, and countertops.</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col">
                        <a href="taskers.php?skills=Painter" class="service-card-bootstrap-link">
                            <div class="card service-card-bootstrap" style="background-image: url('images/painter.png'); background-size: cover; background-position: center;">
                                <div style="position:absolute; bottom:0; left:0; right:0; height:80%; background:linear-gradient(to top, rgba(0,0,0,1), rgba(0,0,0,0.6), transparent);"></div>
                                <div class="card-body" style="position:absolute; bottom:0; color:white;">
                                    <h3>Painter</h3>
                                    <p style="opacity:0.8;">Professional painting services for interiors and exteriors.</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col">
                        <a href="taskers.php?skills=Vastu Consultant" class="service-card-bootstrap-link">
                            <div class="card service-card-bootstrap" style="background-image: url('images/Vastu Consultant.png'); background-size: cover; background-position: center;">
                                <div style="position:absolute; bottom:0; left:0; right:0; height:80%; background:linear-gradient(to top, rgba(0,0,0,1), rgba(0,0,0,0.6), transparent);"></div>
                                <div class="card-body" style="position:absolute; bottom:0; color:white;">
                                    <h3>Vastu Consultant</h3>
                                    <p style="opacity:0.8;">Expert advice on architectural and interior design principles.</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col">
                        <a href="taskers.php?skills=Carpenter" class="service-card-bootstrap-link">
                            <div class="card service-card-bootstrap" style="background-image: url('images/Carpenter.png'); background-size: cover; background-position: center;">
                                <div style="position:absolute; bottom:0; left:0; right:0; height:80%; background:linear-gradient(to top, rgba(0,0,0,1), rgba(0,0,0,0.6), transparent);"></div>
                                <div class="card-body" style="position:absolute; bottom:0; color:white;">
                                    <h3>Carpenter</h3>
                                    <p style="opacity:0.8;">Furniture assembly, custom shelves, and door repairs.</p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <hr class="section-divider">
            <div class="mb-5">
                <h2 id="personal-lifestyle" class="section-heading mb-4">Personal & Lifestyle</h2>
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
                    <div class="col">
                        <a href="taskers.php?skills=Hair Stylist / Barber" class="service-card-bootstrap-link">
                            <div class="card service-card-bootstrap" style="background-image: url('images/Hair Stylist  Barber.png'); background-size: cover; background-position: center;">
                                <div style="position:absolute; bottom:0; left:0; right:0; height:80%; background:linear-gradient(to top, rgba(0,0,0,1), rgba(0,0,0,0.6), transparent);"></div>
                                <div class="card-body" style="position:absolute; bottom:0; color:white;">
                                    <h3>Hair Stylist / Barber</h3>
                                    <p style="opacity:0.8;">Professional hair care and styling at your doorstep.</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col">
                        <a href="taskers.php?skills=Mehandi Artist" class="service-card-bootstrap-link">
                            <div class="card service-card-bootstrap" style="background-image: url('images/mehandi-artist.png'); background-size: cover; background-position: center;">
                                <div style="position:absolute; bottom:0; left:0; right:0; height:80%; background:linear-gradient(to top, rgba(0,0,0,1), rgba(0,0,0,0.6), transparent);"></div>
                                <div class="card-body" style="position:absolute; bottom:0; color:white;">
                                    <h3>Mehandi Artist</h3>
                                    <p style="opacity:0.8;">Beautiful and intricate henna designs for all occasions.</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col">
                        <a href="taskers.php?skills=Massage Therapist" class="service-card-bootstrap-link">
                            <div class="card service-card-bootstrap" style="background-image: url('images/Massage Therapist.png'); background-size: cover; background-position: center;">
                                <div style="position:absolute; bottom:0; left:0; right:0; height:80%; background:linear-gradient(to top, rgba(0,0,0,1), rgba(0,0,0,0.6), transparent);"></div>
                                <div class="card-body" style="position:absolute; bottom:0; color:white;">
                                    <h3>Massage Therapist</h3>
                                    <p style="opacity:0.8;">Relaxing and therapeutic massages at your home.</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col">
                        <a href="taskers.php?skills=Physiotherapist" class="service-card-bootstrap-link">
                            <div class="card service-card-bootstrap" style="background-image: url('images/Physiotherapist.png'); background-size: cover; background-position: center;">
                                <div style="position:absolute; bottom:0; left:0; right:0; height:80%; background:linear-gradient(to top, rgba(0,0,0,1), rgba(0,0,0,0.6), transparent);"></div>
                                <div class="card-body" style="position:absolute; bottom:0; color:white;">
                                    <h3>Physiotherapist</h3>
                                    <p style="opacity:0.8;">Expert physiotherapy for pain relief, injury recovery, and mobility improvement at home.</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col">
                        <a href="taskers.php?skills=Gym Trainer" class="service-card-bootstrap-link">
                            <div class="card service-card-bootstrap" style="background-image: url('images/Gym Trainer.png'); background-size: cover; background-position: center;">
                                <div style="position:absolute; bottom:0; left:0; right:0; height:80%; background:linear-gradient(to top, rgba(0,0,0,1), rgba(0,0,0,0.6), transparent);"></div>
                                <div class="card-body" style="position:absolute; bottom:0; color:white;">
                                    <h3>Gym Trainer</h3>
                                    <p style="opacity:0.8;">Personalized fitness training and workout plans for your goals.</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col">
                        <a href="taskers.php?skills=Tailor / Stitching" class="service-card-bootstrap-link">
                            <div class="card service-card-bootstrap" style="background-image: url('images/Tailor  Stitching.png'); background-size: cover; background-position: center;">
                                <div style="position:absolute; bottom:0; left:0; right:0; height:80%; background:linear-gradient(to top, rgba(0,0,0,1), rgba(0,0,0,0.6), transparent);"></div>
                                <div class="card-body" style="position:absolute; bottom:0; color:white;">
                                    <h3>Tailor / Stitching</h3>
                                    <p style="opacity:0.8;">Custom tailoring and clothing alterations delivered to your door.</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col">
                        <a href="taskers.php?skills=Dog Walker / Pet Groomer" class="service-card-bootstrap-link">
                            <div class="card service-card-bootstrap" style="background-image: url('images/Dog Walker  Pet Groomer.png'); background-size: cover; background-position: center;">
                                <div style="position:absolute; bottom:0; left:0; right:0; height:80%; background:linear-gradient(to top, rgba(0,0,0,1), rgba(0,0,0,0.6), transparent);"></div>
                                <div class="card-body" style="position:absolute; bottom:0; color:white;">
                                    <h3>Dog Walker / Pet Groomer</h3>
                                    <p style="opacity:0.8;">Caring services for your pets, from walks to grooming.</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col">
                        <a href="taskers.php?skills=Tattoo Artist" class="service-card-bootstrap-link">
                            <div class="card service-card-bootstrap" style="background-image: url('images/tatoo-artist.png'); background-size: cover; background-position: center;">
                                <div style="position:absolute; bottom:0; left:0; right:0; height:80%; background:linear-gradient(to top, rgba(0,0,0,1), rgba(0,0,0,0.6), transparent);"></div>
                                <div class="card-body" style="position:absolute; bottom:0; color:white;">
                                    <h3>Tattoo Artist</h3>
                                    <p style="opacity:0.8;">Creative and professional tattooing services in a hygienic setting.</p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <hr class="section-divider">

            <div class="mb-5">
                <h2 id="decoration-art" class="section-heading mb-4">Decoration & Art</h2>
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
                    <div class="col">
                        <a href="taskers.php?skills=Home Decorator" class="service-card-bootstrap-link">
                            <div class="card service-card-bootstrap" style="background-image: url('images/home-decoretor.png'); background-size: cover; background-position: center;">
                                <div style="position:absolute; bottom:0; left:0; right:0; height:80%; background:linear-gradient(to top, rgba(0,0,0,1), rgba(0,0,0,0.6), transparent);"></div>
                                <div class="card-body" style="position:absolute; bottom:0; color:white;">
                                    <h3>Home Decorator</h3>
                                    <p style="opacity:0.8;">Styling and decorating services to beautify your home.</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col">
                        <a href="taskers.php?skills=Wallpaper Installation" class="service-card-bootstrap-link">
                            <div class="card service-card-bootstrap" style="background-image: url('images/Wallpaper Installation.png'); background-size: cover; background-position: center;">
                                <div style="position:absolute; bottom:0; left:0; right:0; height:80%; background:linear-gradient(to top, rgba(0,0,0,1), rgba(0,0,0,0.6), transparent);"></div>
                                <div class="card-body" style="position:absolute; bottom:0; color:white;">
                                    <h3>Wallpaper Installation</h3>
                                    <p style="opacity:0.8;">Professional wallpaper hanging and removal services.</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col">
                        <a href="taskers.php?skills=Wall Art / Mural Painting" class="service-card-bootstrap-link">
                            <div class="card service-card-bootstrap" style="background-image: url('images/Wall Art  Mural Painting.png'); background-size: cover; background-position: center;">
                                <div style="position:absolute; bottom:0; left:0; right:0; height:80%; background:linear-gradient(to top, rgba(0,0,0,1), rgba(0,0,0,0.6), transparent);"></div>
                                <div class="card-body" style="position:absolute; bottom:0; color:white;">
                                    <h3>Wall Art / Mural Painting</h3>
                                    <p style="opacity:0.8;">Custom art and murals to personalize your living space.</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col">
                        <a href="taskers.php?skills=Floral Decorator" class="service-card-bootstrap-link">
                            <div class="card service-card-bootstrap" style="background-image: url('images/Floral Decorator.png'); background-size: cover; background-position: center;">
                                <div style="position:absolute; bottom:0; left:0; right:0; height:80%; background:linear-gradient(to top, rgba(0,0,0,1), rgba(0,0,0,0.6), transparent);"></div>
                                <div class="card-body" style="position:absolute; bottom:0; color:white;">
                                    <h3>Floral Decorator</h3>
                                    <p style="opacity:0.8;">Beautiful floral arrangements for any occasion.</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col">
                        <a href="taskers.php?skills=Handicraft Decor Services" class="service-card-bootstrap-link">
                            <div class="card service-card-bootstrap" style="background-image: url('images/Handicraft Decor Services.png'); background-size: cover; background-position: center;">
                                <div style="position:absolute; bottom:0; left:0; right:0; height:80%; background:linear-gradient(to top, rgba(0,0,0,1), rgba(0,0,0,0.6), transparent);"></div>
                                <div class="card-body" style="position:absolute; bottom:0; color:white;">
                                    <h3>Handicraft Decor Services</h3>
                                    <p style="opacity:0.8;">Unique, handmade decorations to add a personal touch to your home.</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col">
                        <a href="taskers.php?skills=Light Installation" class="service-card-bootstrap-link">
                            <div class="card service-card-bootstrap" style="background-image: url('images/Light Installation.png'); background-size: cover; background-position: center;">
                                <div style="position:absolute; bottom:0; left:0; right:0; height:80%; background:linear-gradient(to top, rgba(0,0,0,1), rgba(0,0,0,0.6), transparent);"></div>
                                <div class="card-body" style="position:absolute; bottom:0; color:white;">
                                    <h3>Light Installation (Decor)</h3>
                                    <p style="opacity:0.8;">Ambiance and event lighting solutions for your home.</p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <hr class="section-divider">
            <div class="mb-5">
                <h2 id="event-services" class="section-heading mb-4">Event Services</h2>
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
                    <div class="col">
                        <a href="taskers.php?skills=Event Planner" class="service-card-bootstrap-link">
                            <div class="card service-card-bootstrap" style="background-image: url('images/Light Installation.png'); background-size: cover; background-position: center;">
                                <div style="position:absolute; bottom:0; left:0; right:0; height:80%; background:linear-gradient(to top, rgba(0,0,0,1), rgba(0,0,0,0.6), transparent);"></div>
                                <div class="card-body" style="position:absolute; bottom:0; color:white;">
                                    <h3>Light Installation</h3>
                                    <p style="opacity:0.8;">Comprehensive planning and coordination for events.</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col">
                        <a href="taskers.php?skills=Birthday Decorator" class="service-card-bootstrap-link">
                            <div class="card service-card-bootstrap" style="background-image: url('images/Birthday Decorator.png'); background-size: cover; background-position: center;">
                                <div style="position:absolute; bottom:0; left:0; right:0; height:80%; background:linear-gradient(to top, rgba(0,0,0,1), rgba(0,0,0,0.6), transparent);"></div>
                                <div class="card-body" style="position:absolute; bottom:0; color:white;">
                                    <h3>Birthday Decorator</h3>
                                    <p style="opacity:0.8;">Creative and fun decorations for birthday parties.</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col">
                        <a href="taskers.php?skills=Balloon Artist" class="service-card-bootstrap-link">
                            <div class="card service-card-bootstrap" style="background-image: url('images/Balloon Artist.png'); background-size: cover; background-position: center;">
                                <div style="position:absolute; bottom:0; left:0; right:0; height:80%; background:linear-gradient(to top, rgba(0,0,0,1), rgba(0,0,0,0.6), transparent);"></div>
                                <div class="card-body" style="position:absolute; bottom:0; color:white;">
                                    <h3>Balloon Artist</h3>
                                    <p style="opacity:0.8;">Creative balloon decorations and installations for any event.</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col">
                        <a href="taskers.php?skills=DJ / Sound System" class="service-card-bootstrap-link">
                            <div class="card service-card-bootstrap" style="background-image: url('images/DJ  Sound System.png'); background-size: cover; background-position: center;">
                                <div style="position:absolute; bottom:0; left:0; right:0; height:80%; background:linear-gradient(to top, rgba(0,0,0,1), rgba(0,0,0,0.6), transparent);"></div>
                                <div class="card-body" style="position:absolute; bottom:0; color:white;">
                                    <h3>DJ & Sound System</h3>
                                    <p style="opacity:0.8;">Professional DJs and high-quality sound equipment for parties and weddings.</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col">
                        <a href="taskers.php?skills=Caterer / Halwai" class="service-card-bootstrap-link">
                            <div class="card service-card-bootstrap" style="background-image: url('images/caterer-halwai.png'); background-size: cover; background-position: center;">
                                <div style="position:absolute; bottom:0; left:0; right:0; height:80%; background:linear-gradient(to top, rgba(0,0,0,1), rgba(0,0,0,0.6), transparent);"></div>
                                <div class="card-body" style="position:absolute; bottom:0; color:white;">
                                    <h3>Caterer / Halwai</h3>
                                    <p style="opacity:0.8;">Delicious food and professional catering for all gatherings.</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col">
                        <a href="taskers.php?skills=Dhol / Tasha Party" class="service-card-bootstrap-link">
                            <div class="card service-card-bootstrap" style="background-image: url('images/Dhol  Tasha Party.png'); background-size: cover; background-position: center;">
                                <div style="position:absolute; bottom:0; left:0; right:0; height:80%; background:linear-gradient(to top, rgba(0,0,0,1), rgba(0,0,0,0.6), transparent);"></div>
                                <div class="card-body" style="position:absolute; bottom:0; color:white;">
                                    <h3>Dhol / Tasha Party</h3>
                                    <p style="opacity:0.8;">Traditional music and energetic performances for festive events.</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col">
                        <a href="taskers.php?skills=Tent House" class="service-card-bootstrap-link">
                            <div class="card service-card-bootstrap" style="background-image: url('images/Tent House.png'); background-size: cover; background-position: center;">
                                <div style="position:absolute; bottom:0; left:0; right:0; height:80%; background:linear-gradient(to top, rgba(0,0,0,1), rgba(0,0,0,0.6), transparent);"></div>
                                <div class="card-body" style="position:absolute; bottom:0; color:white;">
                                    <h3>Tent House</h3>
                                    <p style="opacity:0.8;">Tents, lighting, and seating for outdoor events and functions.</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col">
                        <a href="taskers.php?skills=Photography / Videography" class="service-card-bootstrap-link">
                            <div class="card service-card-bootstrap" style="background-image: url('images/photography&videography.png'); background-size: cover; background-position: center;">
                                <div style="position:absolute; bottom:0; left:0; right:0; height:80%; background:linear-gradient(to top, rgba(0,0,0,1), rgba(0,0,0,0.6), transparent);"></div>
                                <div class="card-body" style="position:absolute; bottom:0; color:white;">
                                    <h3>Photography & Videography</h3>
                                    <p style="opacity:0.8;">Capture your special moments with professional media services.</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col">
                        <a href="taskers.php?skills=Tour Agent" class="service-card-bootstrap-link">
                            <div class="card service-card-bootstrap" style="background-image: url('images/tour-agent.png'); background-size: cover; background-position: center;">
                                <div style="position:absolute; bottom:0; left:0; right:0; height:80%; background:linear-gradient(to top, rgba(0,0,0,1), rgba(0,0,0,0.6), transparent);"></div>
                                <div class="card-body" style="position:absolute; bottom:0; color:white;">
                                    <h3>Tour Agent</h3>
                                    <p style="opacity:0.8;">Plan a tour with Tour & Travel Agent.</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col">
                        <a href="taskers.php?skills=Anchor" class="service-card-bootstrap-link">
                            <div class="card service-card-bootstrap" style="background-image: url('images/Anchor.png'); background-size: cover; background-position: center;">
                                <div style="position:absolute; bottom:0; left:0; right:0; height:80%; background:linear-gradient(to top, rgba(0,0,0,1), rgba(0,0,0,0.6), transparent);"></div>
                                <div class="card-body" style="position:absolute; bottom:0; color:white;">
                                    <h3>Anchor</h3>
                                    <p style="opacity:0.8;">Engaging hosts and speakers for a memorable event.</p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <hr class="section-divider">
            <div class="mb-5">
                <h2 id="movers-transport" class="section-heading mb-4">Movers & Transport</h2>
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
                    <div class="col">
                        <a href="taskers.php?skills=Home Shifting" class="service-card-bootstrap-link">
                            <div class="card service-card-bootstrap" style="background-image: url('images/Home Shifting.png'); background-size: cover; background-position: center;">
                                <div style="position:absolute; bottom:0; left:0; right:0; height:80%; background:linear-gradient(to top, rgba(0,0,0,1), rgba(0,0,0,0.6), transparent);"></div>
                                <div class="card-body" style="position:absolute; bottom:0; color:white;">
                                    <h3>Home Shifting (Local)</h3>
                                    <p style="opacity:0.8;">Efficient and affordable moving services within the city.</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col">
                        <a href="taskers.php?skills=Intercity Movers / Packers" class="service-card-bootstrap-link">
                            <div class="card service-card-bootstrap" style="background-image: url('images/Intercity Movers & Packers.png'); background-size: cover; background-position: center;">
                                <div style="position:absolute; bottom:0; left:0; right:0; height:80%; background:linear-gradient(to top, rgba(0,0,0,1), rgba(0,0,0,0.6), transparent);"></div>
                                <div class="card-body" style="position:absolute; bottom:0; color:white;">
                                    <h3>Intercity Movers & Packers</h3>
                                    <p style="opacity:0.8;">Reliable and secure long-distance moving solutions.</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col">
                        <a href="taskers.php?skills=Truck / Tempo on Hire" class="service-card-bootstrap-link">
                            <div class="card service-card-bootstrap" style="background-image: url('images/Truck  Tempo on Hire.png'); background-size: cover; background-position: center;">
                                <div style="position:absolute; bottom:0; left:0; right:0; height:80%; background:linear-gradient(to top, rgba(0,0,0,1), rgba(0,0,0,0.6), transparent);"></div>
                                <div class="card-body" style="position:absolute; bottom:0; color:white;">
                                    <h3>Truck / Tempo on Hire</h3>
                                    <p style="opacity:0.8;">Rent trucks and tempos for all your transportation needs.</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col">
                        <a href="taskers.php?skills=Bike / Car Transport" class="service-card-bootstrap-link">
                            <div class="card service-card-bootstrap" style="background-image: url('images/Bike  Car Transport.png'); background-size: cover; background-position: center;">
                                <div style="position:absolute; bottom:0; left:0; right:0; height:80%; background:linear-gradient(to top, rgba(0,0,0,1), rgba(0,0,0,0.6), transparent);"></div>
                                <div class="card-body" style="position:absolute; bottom:0; color:white;">
                                    <h3>Bike / Car Transport</h3>
                                    <p style="opacity:0.8;">Safe and secure transport of your vehicles across locations.</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col">
                        <a href="taskers.php?skills=Goods Transport Help" class="service-card-bootstrap-link">
                            <div class="card service-card-bootstrap" style="background-image: url('images/Goods Transport Help.png'); background-size: cover; background-position: center;">
                                <div style="position:absolute; bottom:0; left:0; right:0; height:80%; background:linear-gradient(to top, rgba(0,0,0,1), rgba(0,0,0,0.6), transparent);"></div>
                                <div class="card-body" style="position:absolute; bottom:0; color:white;">
                                    <h3>Goods Transport Help</h3>
                                    <p style="opacity:0.8;">Assistance with moving and transporting your goods.</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col">
                        <a href="taskers.php?skills=Driver on Demand" class="service-card-bootstrap-link">
                            <div class="card service-card-bootstrap" style="background-image: url('images/Driver on Demand.png'); background-size: cover; background-position: center;">
                                <div style="position:absolute; bottom:0; left:0; right:0; height:80%; background:linear-gradient(to top, rgba(0,0,0,1), rgba(0,0,0,0.6), transparent);"></div>
                                <div class="card-body" style="position:absolute; bottom:0; color:white;">
                                <h3>Driver on Demand</h3>
                                <p style="opacity:0.8;">Book a professional driver for a few hours or for a full day.</p>
                            </div>
                    </div>
                    </a>
                </div>
            </div>
        </div>
        </div>
        </div>

        </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        <script>
            // Service list
            const services = [
                "Mehandi Artist", "Makeup Artist", "House Cleaning", "Electrician", "Plumber",
                "Movers / Packers", "Painter", "Beautician", "Cook / Tiffin Services",
                "Housemaid / Househelp", "Pest Control", "Washing Machine Repair",
                "AC Servicing", "Geyser Repair", "Refrigerator Technician", "RO Water Purifier Services",
                "Kitchen / Bathroom Cleaning", "Civil Contractor", "Interior Designer", "POP / False Ceiling Work",
                "Fabrication / Welding", "Tiling / Marble Work", "Vastu Consultant",
                "Hair Stylist / Barber", "Mehndi Artist", "Massage Therapist", "Tailor / Stitching",
                "Physiotherapist", "Gym Trainer",
                "Dog Walker / Pet Groomer", "Tattoo Artist", "Home Decorator", "Wallpaper Installation",
                "Wall Art / Mural Painting", "Floral Decorator", "Handicraft Decor Services",
                "Light Installation (Decor)", "Wedding Stage Setup", "Event Planner", "Birthday Decorator",
                "Balloon Artist", "DJ / Sound System", "Caterer / Halwai", "Dhol / Tasha Party",
                "Tent House", "Photography / Videography", "Tour Agent", "Anchor", "Home Shifting (Local)",
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
                        li.innerHTML = `="fa-solid fa-magnifying-glass me-2 text-muted"> ${service}`;
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
        <?php
        include('footer.php');
        ?>