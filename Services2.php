<?php
$page_css = "services2.css";
include('header.php');
?>

<link rel="stylesheet" href="Servies2.css">
    <section>
        <section class="hero-section"></section>
        <div class="hero-main-content">
            <div class="container">
                <h1 class="display-4 fw-bold">Our Services</h1>
                <p class="lead">Explore a wide range of services tailored to your needs, from home repairs to personal care.</p>
              
                <div class="hero-search-bar mt-4">
                    <div class="position-relative">
                        <input type="search" placeholder="Search for a service (e.g., 'AC repair')" class="form-control rounded-pill border-2 border-light py-3 ps-4 pe-5">
                        <button class="search-button btn position-absolute end-0 top-50 translate-middle-y rounded-circle me-1" type="button">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
           
        </div>
    </section>

    <main>
       <div class="services-grid-section">
    <div class="container">
        <div class="mb-5"><br><br><br>
            <h2 class="text-start mb-4">Popular Services</h2>
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
                <div class="col">
                    <a href="taskers.html?category=Mehandi Artist" class="service-card-bootstrap-link">
                        <div class="service-card-bootstrap">
                            <div class="icon-container">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 10a8 8 0 10-16 0 8 8 0 0016 0zm-8-3h.01M10 16a6 6 0 110-12 6 6 0 010 12zM12 21v-4M12 3v4M5 12H1m22 0h-4M16.95 7.05L14.828 9.172M7.05 16.95L9.172 14.828" /></svg>
                            </div>
                            <h3>Mehandi Artist</h3>
                            <p>Beautiful and intricate henna designs for all occasions.</p>
                        </div>
                    </a>
                </div>
                <div class="col">
                    <a href="taskers.html?category=Makeup Artist" class="service-card-bootstrap-link">
                        <div class="service-card-bootstrap">
                            <div class="icon-container">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                            </div>
                            <h3>Makeup Artist</h3>
                            <p>Professional makeup for events, weddings, and photoshoots.</p>
                        </div>
                    </a>
                </div>
                <div class="col">
                    <a href="taskers.html?category=Cleaning" class="service-card-bootstrap-link">
                        <div class="service-card-bootstrap">
                            <div class="icon-container">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M19 3v4M17 5h4M12 19a7 7 0 100-14 7 7 0 000 14z" /><path d="M12 15a3 3 0 100-6 3 3 0 000 6z" /></svg>
                            </div>
                            <h3>House Cleaning</h3>
                            <p>Home, deep, tank, sofa/carpet cleaning.</p>
                        </div>
                    </a>
                </div>
                <div class="col">
                    <a href="taskers.html?category=Electrician" class="service-card-bootstrap-link">
                        <div class="service-card-bootstrap">
                            <div class="icon-container">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                            </div>
                            <h3>Electrician</h3>
                            <p>Wiring, fixture installation, and safety checks.</p>
                        </div>
                    </a>
                </div>
                <div class="col">
                    <a href="taskers.html?category=Plumber" class="service-card-bootstrap-link">
                        <div class="service-card-bootstrap">
                            <div class="icon-container">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                            </div>
                            <h3>Plumber</h3>
                            <p>Leaky faucets, pipe repairs, and drain cleaning.</p>
                        </div>
                    </a>
                </div>
                <div class="col">
                    <a href="taskers.html?category=Movers & Packers" class="service-card-bootstrap-link">
                        <div class="service-card-bootstrap">
                            <div class="icon-container">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4m16 0l-4 4m4-4l-4-4M4 12l4 4M4 12l4-4" /><path d="M20 12H4" /></svg>
                            </div>
                            <h3>Movers & Packers</h3>
                            <p>Safe and reliable shifting for your home or office.</p>
                        </div>
                    </a>
                </div>
                <div class="col">
                    <a href="taskers.html?category=Painter" class="service-card-bootstrap-link">
                        <div class="service-card-bootstrap">
                            <div class="icon-container">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" /><path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd" /></svg>
                            </div>
                            <h3>Painter</h3>
                            <p>Interior and exterior painting for a fresh new look.</p>
                        </div>
                    </a>
                </div>
                <div class="col">
                    <a href="taskers.html?category=Beautician" class="service-card-bootstrap-link">
                        <div class="service-card-bootstrap">
                            <div class="icon-container">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M19 3v4M17 5h4M12 19a7 7 0 100-14 7 7 0 000 14z" /><path d="M12 15a3 3 0 100-6 3 3 0 000 6z" /></svg>
                            </div>
                            <h3>Beautician</h3>
                            <p>At-home beauty services including facials and waxing.</p>
                        </div>
                    </a>
                </div>
                <div class="col">
                    <a href="taskers.html?category=Cook / Tiffin Services" class="service-card-bootstrap-link">
                        <div class="service-card-bootstrap">
                            <div class="icon-container">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0zM7 21v-2a6 6 0 1112 0v2M12 11a4 4 0 100-8 4 4 0 000 8z" /></svg>
                            </div>
                            <h3>Cook / Tiffin Services</h3>
                            <p>Freshly cooked meals delivered or prepared at home.</p>
                        </div>
                    </a>
                </div>
                <div class="col">
                    <a href="taskers.html?category=Driver on Call" class="service-card-bootstrap-link">
                        <div class="service-card-bootstrap">
                            <div class="icon-container">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" /><path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-5.998 12.078 12.078 0 01.665-6.479L12 14z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-5.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222 4 2.222V20" /></svg>
                            </div>
                            <h3>Driver on Call</h3>
                            <p>Professional and reliable drivers for your daily needs.</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <div class="mb-5">
            <h2 class="text-start mb-4">Household & Maintenance</h2>
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
                <div class="col">
                    <a href="taskers.html?category=Housemaid / Househelp" class="service-card-bootstrap-link">
                        <div class="service-card-bootstrap">
                            <div class="icon-container">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 12v4a2 2 0 002 2h10a2 2 0 002-2v-4M7 12h10" /></svg>
                            </div>
                            <h3>Housemaid / Househelp</h3>
                            <p>Daily chores, deep cleaning, and domestic assistance.</p>
                        </div>
                    </a>
                </div>
                <div class="col">
                    <a href="taskers.html?category=Elderly Care / Nurse" class="service-card-bootstrap-link">
                        <div class="service-card-bootstrap">
                            <div class="icon-container">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c1.657 0 3 1.343 3 3v2a3 3 0 01-3 3m0 0a3 3 0 01-3-3v-2a3 3 0 013-3m0 0v-2.5a.5.5 0 011 0V8z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 21v-2a6 6 0 0112 0v2M12 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                            </div>
                            <h3>Elderly Care / Nurse</h3>
                            <p>Compassionate care for the elderly in their home.</p>
                        </div>
                    </a>
                </div>
                <div class="col">
                    <a href="taskers.html?category=Pest Control" class="service-card-bootstrap-link">
                        <div class="service-card-bootstrap">
                            <div class="icon-container">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2h10a2 2 0 002-2v-1a2 2 0 012-2h1.945M7.8 13.8a.5.5 0 00-.707 0l-1.414 1.414a.5.5 0 000 .707l1.414 1.414a.5.5 0 00.707 0L9.192 16a.5.5 0 000-.707l-1.414-1.414a.5.5 0 00-.707 0zM16.2 13.8a.5.5 0 00-.707 0l-1.414 1.414a.5.5 0 000 .707l1.414 1.414a.5.5 0 00.707 0L17.586 16a.5.5 0 000-.707l-1.414-1.414a.5.5 0 00-.707 0zM12 20.25c.966 0 1.75-.784 1.75-1.75S12.966 16.75 12 16.75s-1.75.784-1.75 1.75.784 1.75 1.75 1.75z" /><path d="M10 9V5a2 2 0 114 0v4" /><path d="M12 14.25c-1.24 0-2.25-1.01-2.25-2.25S10.76 9.75 12 9.75s2.25 1.01 2.25 2.25S13.24 14.25 12 14.25z" /></svg>
                            </div>
                            <h3>Pest Control</h3>
                            <p>Effective solutions for termites, rodents, and other pests.</p>
                        </div>
                    </a>
                </div>
                <div class="col">
                    <a href="taskers.html?category=Washing Machine Repair" class="service-card-bootstrap-link">
                        <div class="service-card-bootstrap">
                            <div class="icon-container">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 21a9 9 0 01-9-9c0-1.756.54-3.415 1.5-4.819M12 21a9 9 0 009-9c0-1.756-.54-3.415-1.5-4.819M12 21a9 9 0 00-7.5-16.181M12 3a9 9 0 019 9c0 1.756-.54 3.415-1.5 4.819M12 3a9 9 0 00-9 9c0 1.756.54 3.415 1.5 4.819M12 3a9 9 0 007.5 16.181" /></svg>
                            </div>
                            <h3>Washing Machine Repair</h3>
                            <p>Fixes for all washing machine brands and models.</p>
                        </div>
                    </a>
                </div>
                <div class="col">
                    <a href="taskers.html?category=AC Servicing" class="service-card-bootstrap-link">
                        <div class="service-card-bootstrap">
                            <div class="icon-container">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 16l4-4-4-4M12 20h4a2 2 0 002-2V6a2 2 0 00-2-2h-4m-3 12h.01M8 8h.01" /></svg>
                            </div>
                            <h3>AC Servicing</h3>
                            <p>Keep cool with our expert AC maintenance and repair.</p>
                        </div>
                    </a>
                </div>
                <div class="col">
                    <a href="taskers.html?category=Geyser Repair" class="service-card-bootstrap-link">
                        <div class="service-card-bootstrap">
                            <div class="icon-container">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11v6m0-6V7a2 2 0 012-2h2M12 11H8a2 2 0 00-2 2v2a2 2 0 002 2h4" /><path d="M5 10v4a2 2 0 002 2h10a2 2 0 002-2v-4" /></svg>
                            </div>
                            <h3>Geyser Repair</h3>
                            <p>Timely repair and installation of all types of geysers.</p>
                        </div>
                    </a>
                </div>
                <div class="col">
                    <a href="taskers.html?category=Refrigerator Technician" class="service-card-bootstrap-link">
                        <div class="service-card-bootstrap">
                            <div class="icon-container">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" /></svg>
                            </div>
                            <h3>Refrigerator Technician</h3>
                            <p>Fast solutions for cooling issues and part replacements.</p>
                        </div>
                    </a>
                </div>
                <div class="col">
                    <a href="taskers.html?category=RO Water Purifier Services" class="service-card-bootstrap-link">
                        <div class="service-card-bootstrap">
                            <div class="icon-container">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v18m0 0a9 9 0 01-9-9h18a9 9 0 01-9-9" /><path d="M12 3v18" /></svg>
                            </div>
                            <h3>RO Water Purifier Services</h3>
                            <p>Installation, repair, and maintenance of RO systems.</p>
                        </div>
                    </a>
                </div>
                <div class="col">
                    <a href="taskers.html?category=Kitchen / Bathroom Cleaning" class="service-card-bootstrap-link">
                        <div class="service-card-bootstrap">
                            <div class="icon-container">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M19 3v4M17 5h4M12 19a7 7 0 100-14 7 7 0 000 14z" /><path d="M12 15a3 3 0 100-6 3 3 0 000 6z" /></svg>
                            </div>
                            <h3>Kitchen / Bathroom Cleaning</h3>
                            <p>Specialized deep cleaning for your kitchen and bathrooms.</p>
                        </div>
                    </a>
                </div>
                <div class="col">
                    <a href="taskers.html?category=Water Tank Cleaning" class="service-card-bootstrap-link">
                        <div class="service-card-bootstrap">
                            <div class="icon-container">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10.78a2 2 0 00-2 2V19m4-11a2 2 0 00-2-2H8a2 2 0 00-2 2v6a2 2 0 002 2h8a2 2 0 002-2v-6m-6-10v2a2 2 0 002 2h2a2 2 0 002-2V4m-6 6h6m-6 4h6m-4 4h2" /></svg>
                            </div>
                            <h3>Water Tank Cleaning</h3>
                            <p>Thorough cleaning to ensure your water is safe and clean.</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <div class="mb-5">
            <h2 class="text-start mb-4">Construction & Renovation</h2>
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
                <div class="col">
                    <a href="taskers.html?category=Civil Contractor" class="service-card-bootstrap-link">
                        <div class="service-card-bootstrap">
                            <div class="icon-container">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c1.657 0 3 1.343 3 3v2a3 3 0 01-3 3m0 0a3 3 0 01-3-3v-2a3 3 0 013-3m0 0v-2.5a.5.5 0 011 0V8z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 21v-2a6 6 0 0112 0v2M12 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                            </div>
                            <h3>Civil Contractor</h3>
                            <p>Comprehensive services for new construction and major renovations.</p>
                        </div>
                    </a>
                </div>
                <div class="col">
                    <a href="taskers.html?category=Interior Designer" class="service-card-bootstrap-link">
                        <div class="service-card-bootstrap">
                            <div class="icon-container">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.539 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.196-1.539-1.118l1.518-4.674a1 1 0 00-.363-1.118L2.05 10.1c-.783-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" /></svg>
                            </div>
                            <h3>Interior Designer</h3>
                            <p>Space planning, design, and project management.</p>
                        </div>
                    </a>
                </div>
                <div class="col">
                    <a href="taskers.html?category=POP / False Ceiling Work" class="service-card-bootstrap-link">
                        <div class="service-card-bootstrap">
                            <div class="icon-container">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21h18M4 21V10.729a1 1 0 01.243-.658l7.143-8.571a1 1 0 011.228 0l7.143 8.571A1 1 0 0120 10.729V21M8 21v-8a2 2 0 012-2h4a2 2 0 012 2v8" /></svg>
                            </div>
                            <h3>POP / False Ceiling Work</h3>
                            <p>Professional false ceiling and plaster of Paris installation.</p>
                        </div>
                    </a>
                </div>
                <div class="col">
                    <a href="taskers.html?category=Fabrication & Welding" class="service-card-bootstrap-link">
                        <div class="service-card-bootstrap">
                            <div class="icon-container">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                            </div>
                            <h3>Fabrication & Welding</h3>
                            <p>Custom metal work, repairs, and structural fabrication.</p>
                        </div>
                    </a>
                </div>
                <div class="col">
                    <a href="taskers.html?category=Tiling & Marble Work" class="service-card-bootstrap-link">
                        <div class="service-card-bootstrap">
                            <div class="icon-container">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 21v-4M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                            </div>
                            <h3>Tiling & Marble Work</h3>
                            <p>Expert installation and repair for floors, walls, and countertops.</p>
                        </div>
                    </a>
                </div>
                <div class="col">
                    <a href="taskers.html?category=Painter / Whitewash" class="service-card-bootstrap-link">
                        <div class="service-card-bootstrap">
                            <div class="icon-container">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" /><path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd" /></svg>
                            </div>
                            <h3>Painter / Whitewash</h3>
                            <p>Interior and exterior painting for a fresh new look.</p>
                        </div>
                    </a>
                </div>
                <div class="col">
                    <a href="taskers.html?category=Modular Kitchen Setup" class="service-card-bootstrap-link">
                        <div class="service-card-bootstrap">
                            <div class="icon-container">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 1.343-3 3v2a3 3 0 003 3h2a3 3 0 003-3v-2a3 3 0 00-3-3m0 0a3 3 0 00-3 3v2a3 3 0 003 3h2a3 3 0 003-3v-2a3 3 0 00-3-3m0 0v-2.5a.5.5 0 011 0V8z" /><path d="M12 11a4 4 0 100-8 4 4 0 000 8z" /></svg>
                            </div>
                            <h3>Modular Kitchen Setup</h3>
                            <p>Design and installation of modern, custom kitchens.</p>
                        </div>
                    </a>
                </div>
                <div class="col">
                    <a href="taskers.html?category=Vastu Consultant" class="service-card-bootstrap-link">
                        <div class="service-card-bootstrap">
                            <div class="icon-container">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" /><path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-5.998 12.078 12.078 0 01.665-6.479L12 14z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-5.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222 4 2.222V20" /></svg>
                            </div>
                            <h3>Vastu Consultant</h3>
                            <p>Expert advice on architectural and interior design principles.</p>
                        </div>
                    </a>
                </div>
                <div class="col">
                    <a href="taskers.html?category=Architect" class="service-card-bootstrap-link">
                        <div class="service-card-bootstrap">
                            <div class="icon-container">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21h18M4 21V10.729a1 1 0 01.243-.658l7.143-8.571a1 1 0 011.228 0l7.143 8.571A1 1 0 0120 10.729V21M8 21v-8a2 2 0 012-2h4a2 2 0 012 2v8" /></svg>
                            </div>
                            <h3>Architect</h3>
                            <p>Creative and professional architectural design services.</p>
                        </div>
                    </a>
                </div>
                <div class="col">
                    <a href="taskers.html?category=Carpenter" class="service-card-bootstrap-link">
                        <div class="service-card-bootstrap">
                            <div class="icon-container">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21h18M4 21V10.729a1 1 0 01.243-.658l7.143-8.571a1 1 0 011.228 0l7.143 8.571A1 1 0 0120 10.729V21M8 21v-8a2 2 0 012-2h4a2 2 0 012 2v8" /></svg>
                            </div>
                            <h3>Carpenter</h3>
                            <p>Furniture assembly, custom shelves, and door repairs.</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <div class="mb-5">
            <h2 class="text-start mb-4">Personal & Lifestyle</h2>
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
                <div class="col">
                    <a href="taskers.html?category=Hair Stylist / Barber" class="service-card-bootstrap-link">
                        <div class="service-card-bootstrap">
                            <div class="icon-container">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11a4 4 0 100-8 4 4 0 000 8z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-2a4 4 0 014-4h10a4 4 0 014 4v2" /></svg>
                            </div>
                            <h3>Hair Stylist / Barber</h3>
                            <p>Professional hair care and styling at your doorstep.</p>
                        </div>
                    </a>
                </div>
                <div class="col">
                    <a href="taskers.html?category=Mehndi Designer" class="service-card-bootstrap-link">
                        <div class="service-card-bootstrap">
                            <div class="icon-container">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 10a8 8 0 10-16 0 8 8 0 0016 0zm-8-3h.01M10 16a6 6 0 110-12 6 6 0 010 12zM12 21v-4M12 3v4M5 12H1m22 0h-4M16.95 7.05L14.828 9.172M7.05 16.95L9.172 14.828" /></svg>
                            </div>
                            <h3>Mehndi Designer</h3>
                            <p>Beautiful and intricate henna designs for all occasions.</p>
                        </div>
                    </a>
                </div>
                <div class="col">
                    <a href="taskers.html?category=Personal Trainer" class="service-card-bootstrap-link">
                        <div class="service-card-bootstrap">
                            <div class="icon-container">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" /></svg>
                            </div>
                            <h3>Personal Trainer</h3>
                            <p>Customized fitness plans and training at your home.</p>
                        </div>
                    </a>
                </div>
                <div class="col">
                    <a href="taskers.html?category=Yoga Instructor" class="service-card-bootstrap-link">
                        <div class="service-card-bootstrap">
                            <div class="icon-container">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" /></svg>
                            </div>
                            <h3>Yoga Instructor</h3>
                            <p>Personalized yoga sessions and wellness guidance.</p>
                        </div>
                    </a>
                </div>
                <div class="col">
                    <a href="taskers.html?category=Massage Therapist" class="service-card-bootstrap-link">
                        <div class="service-card-bootstrap">
                            <div class="icon-container">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c1.657 0 3 1.343 3 3v2a3 3 0 01-3 3m0 0a3 3 0 01-3-3v-2a3 3 0 013-3m0 0v-2.5a.5.5 0 011 0V8z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 21v-2a6 6 0 0112 0v2M12 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                            </div>
                            <h3>Massage Therapist</h3>
                            <p>Relaxing and therapeutic massages at your home.</p>
                        </div>
                    </a>
                </div>
                <div class="col">
                    <a href="taskers.html?category=Tailor / Stitching" class="service-card-bootstrap-link">
                        <div class="service-card-bootstrap">
                            <div class="icon-container">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                            </div>
                            <h3>Tailor / Stitching</h3>
                            <p>Custom tailoring and clothing alterations delivered to your door.</p>
                        </div>
                    </a>
                </div>
                <div class="col">
                    <a href="taskers.html?category=Dog Walker / Pet Groomer" class="service-card-bootstrap-link">
                        <div class="service-card-bootstrap">
                            <div class="icon-container">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 1.343-3 3v2a3 3 0 003 3h2a3 3 0 003-3v-2a3 3 0 00-3-3m0 0a3 3 0 00-3 3v2a3 3 0 003 3h2a3 3 0 003-3v-2a3 3 0 00-3-3m0 0v-2.5a.5.5 0 011 0V8z" /><path d="M12 11a4 4 0 100-8 4 4 0 000 8z" /></svg>
                            </div>
                            <h3>Dog Walker / Pet Groomer</h3>
                            <p>Caring services for your pets, from walks to grooming.</p>
                        </div>
                    </a>
                </div>
                <div class="col">
                    <a href="taskers.html?category=Tattoo Artist" class="service-card-bootstrap-link">
                        <div class="service-card-bootstrap">
                            <div class="icon-container">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 1.343-3 3v2a3 3 0 003 3h2a3 3 0 003-3v-2a3 3 0 00-3-3m0 0a3 3 0 00-3 3v2a3 3 0 003 3h2a3 3 0 003-3v-2a3 3 0 00-3-3m0 0v-2.5a.5.5 0 011 0V8z" /><path d="M12 11a4 4 0 100-8 4 4 0 000 8z" /></svg>
                            </div>
                            <h3>Tattoo Artist</h3>
                            <p>Creative and professional tattooing services in a hygienic setting.</p>
                        </div>
                    </a>
                </div>
                <div class="col">
                    <a href="taskers.html?category=Astrologer / Numerologist" class="service-card-bootstrap-link">
                        <div class="service-card-bootstrap">
                            <div class="icon-container">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 1.343-3 3v2a3 3 0 003 3h2a3 3 0 003-3v-2a3 3 0 00-3-3m0 0a3 3 0 00-3 3v2a3 3 0 003 3h2a3 3 0 003-3v-2a3 3 0 00-3-3m0 0v-2.5a.5.5 0 011 0V8z" /><path d="M12 11a4 4 0 100-8 4 4 0 000 8z" /></svg>
                            </div>
                            <h3>Astrologer / Numerologist</h3>
                            <p>Guidance and predictions for personal and professional life.</p>
                        </div>
                    </a>
                </div>
                <div class="col">
                    <a href="taskers.html?category=Spa & Wellness Expert" class="service-card-bootstrap-link">
                        <div class="service-card-bootstrap">
                            <div class="icon-container">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 1.343-3 3v2a3 3 0 003 3h2a3 3 0 003-3v-2a3 3 0 00-3-3m0 0a3 3 0 00-3 3v2a3 3 0 003 3h2a3 3 0 003-3v-2a3 3 0 00-3-3m0 0v-2.5a.5.5 0 011 0V8z" /><path d="M12 11a4 4 0 100-8 4 4 0 000 8z" /></svg>
                            </div>
                            <h3>Spa & Wellness Expert</h3>
                            <p>Holistic health and wellness services in the comfort of your home.</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <div class="mb-5">
            <h2 class="text-start mb-4">Decoration & Art</h2>
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
                <div class="col">
                    <a href="taskers.html?category=Home Decorator" class="service-card-bootstrap-link">
                        <div class="service-card-bootstrap">
                            <div class="icon-container">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M19 3v4M17 5h4M12 19a7 7 0 100-14 7 7 0 000 14z" /><path d="M12 15a3 3 0 100-6 3 3 0 000 6z" /></svg>
                            </div>
                            <h3>Home Decorator</h3>
                            <p>Styling and decorating services to beautify your home.</p>
                        </div>
                    </a>
                </div>
                <div class="col">
                    <a href="taskers.html?category=Wallpaper Installation" class="service-card-bootstrap-link">
                        <div class="service-card-bootstrap">
                            <div class="icon-container">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M19 3v4M17 5h4M12 19a7 7 0 100-14 7 7 0 000 14z" /><path d="M12 15a3 3 0 100-6 3 3 0 000 6z" /></svg>
                            </div>
                            <h3>Wallpaper Installation</h3>
                            <p>Professional wallpaper hanging and removal services.</p>
                        </div>
                    </a>
                </div>
                <div class="col">
                    <a href="taskers.html?category=Wall Art / Mural Painting" class="service-card-bootstrap-link">
                        <div class="service-card-bootstrap">
                            <div class="icon-container">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 1.343-3 3v2a3 3 0 003 3h2a3 3 0 003-3v-2a3 3 0 00-3-3m0 0a3 3 0 00-3 3v2a3 3 0 003 3h2a3 3 0 003-3v-2a3 3 0 00-3-3m0 0v-2.5a.5.5 0 011 0V8z" /><path d="M12 11a4 4 0 100-8 4 4 0 000 8z" /></svg>
                            </div>
                            <h3>Wall Art / Mural Painting</h3>
                            <p>Custom art and murals to personalize your living space.</p>
                        </div>
                    </a>
                </div>
                <div class="col">
                    <a href="taskers.html?category=Floral Decorator" class="service-card-bootstrap-link">
                        <div class="service-card-bootstrap">
                            <div class="icon-container">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M19 3v4M17 5h4M12 19a7 7 0 100-14 7 7 0 000 14z" /><path d="M12 15a3 3 0 100-6 3 3 0 000 6z" /></svg>
                            </div>
                            <h3>Floral Decorator</h3>
                            <p>Beautiful floral arrangements for any occasion.</p>
                        </div>
                    </a>
                </div>
                <div class="col">
                    <a href="taskers.html?category=Indoor Plants & Setup" class="service-card-bootstrap-link">
                        <div class="service-card-bootstrap">
                            <div class="icon-container">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 1.343-3 3v2a3 3 0 003 3h2a3 3 0 003-3v-2a3 3 0 00-3-3m0 0a3 3 0 00-3 3v2a3 3 0 003 3h2a3 3 0 003-3v-2a3 3 0 00-3-3m0 0v-2.5a.5.5 0 011 0V8z" /><path d="M12 11a4 4 0 100-8 4 4 0 000 8z" /></svg>
                            </div>
                            <h3>Indoor Plants & Setup</h3>
                            <p>Bring nature indoors with our plant selection and arrangement services.</p>
                        </div>
                    </a>
                </div>
                <div class="col">
                    <a href="taskers.html?category=Handicraft Decor Services" class="service-card-bootstrap-link">
                        <div class="service-card-bootstrap">
                            <div class="icon-container">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 1.343-3 3v2a3 3 0 003 3h2a3 3 0 003-3v-2a3 3 0 00-3-3m0 0a3 3 0 00-3 3v2a3 3 0 003 3h2a3 3 0 003-3v-2a3 3 0 00-3-3m0 0v-2.5a.5.5 0 011 0V8z" /><path d="M12 11a4 4 0 100-8 4 4 0 000 8z" /></svg>
                            </div>
                            <h3>Handicraft Decor Services</h3>
                            <p>Unique, handmade decorations to add a personal touch to your home.</p>
                        </div>
                    </a>
                </div>
                <div class="col">
                    <a href="taskers.html?category=Light Installation (Decor)" class="service-card-bootstrap-link">
                        <div class="service-card-bootstrap">
                            <div class="icon-container">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            </div>
                            <h3>Light Installation (Decor)</h3>
                            <p>Ambiance and event lighting solutions for your home.</p>
                        </div>
                    </a>
                </div>
                <div class="col">
                    <a href="taskers.html?category=Wedding Stage Setup" class="service-card-bootstrap-link">
                        <div class="service-card-bootstrap">
                            <div class="icon-container">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 1.343-3 3v2a3 3 0 003 3h2a3 3 0 003-3v-2a3 3 0 00-3-3m0 0a3 3 0 00-3 3v2a3 3 0 003 3h2a3 3 0 003-3v-2a3 3 0 00-3-3m0 0v-2.5a.5.5 0 011 0V8z" /><path d="M12 11a4 4 0 100-8 4 4 0 000 8z" /></svg>
                            </div>
                            <h3>Wedding Stage Setup</h3>
                            <p>Professional and creative wedding stage decoration.</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <div class="mb-5">
            <h2 class="text-start mb-4">Event Services</h2>
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
                <div class="col">
                    <a href="taskers.html?category=Event Planner" class="service-card-bootstrap-link">
                        <div class="service-card-bootstrap">
                            <div class="icon-container">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h.01M17 11h.01M9 15h.01M15 15h.01M12 19h.01M6 21h12a2 2 0 002-2V7a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                            </div>
                            <h3>Event Planner</h3>
                            <p>Comprehensive planning and coordination for events.</p>
                        </div>
                    </a>
                </div>
                <div class="col">
                    <a href="taskers.html?category=Birthday Decorator" class="service-card-bootstrap-link">
                        <div class="service-card-bootstrap">
                            <div class="icon-container">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /><path d="M14.828 14.828L12 17.657l-2.828-2.829m-.707-.707L8.464 12l-2.828-2.828m8.485 8.485L12 12l-2.828 2.828M12 7.07l2.828 2.829-2.828 2.828L9.172 7.07A4.5 4.5 0 0012 3.536l-2.828 2.828m0 0a4.5 4.5 0 00-6.364 0L3.536 7.07l2.828 2.828M12 16.929l-2.828-2.828L7.07 16.929M12 7.07l2.828 2.828L16.929 7.07" /></svg>
                            </div>
                            <h3>Birthday Decorator</h3>
                            <p>Creative and fun decorations for birthday parties.</p>
                        </div>
                    </a>
                </div>
                <div class="col">
                    <a href="taskers.html?category=Balloon Artist" class="service-card-bootstrap-link">
                        <div class="service-card-bootstrap">
                            <div class="icon-container">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /><path d="M14.828 14.828L12 17.657l-2.828-2.829m-.707-.707L8.464 12l-2.828-2.828m8.485 8.485L12 12l-2.828 2.828M12 7.07l2.828 2.829-2.828 2.828L9.172 7.07A4.5 4.5 0 0012 3.536l-2.828 2.828m0 0a4.5 4.5 0 00-6.364 0L3.536 7.07l2.828 2.828M12 16.929l-2.828-2.828L7.07 16.929M12 7.07l2.828 2.828L16.929 7.07" /></svg>
                            </div>
                            <h3>Balloon Artist</h3>
                            <p>Creative balloon decorations and installations for any event.</p>
                        </div>
                    </a>
                </div>
                <div class="col">
                    <a href="taskers.html?category=DJ & Sound System" class="service-card-bootstrap-link">
                        <div class="service-card-bootstrap">
                            <div class="icon-container">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                            </div>
                            <h3>DJ & Sound System</h3>
                            <p>Professional DJs and high-quality sound equipment for parties and weddings.</p>
                        </div>
                    </a>
                </div>
                <div class="col">
                    <a href="taskers.html?category=Caterer / Halwai" class="service-card-bootstrap-link">
                        <div class="service-card-bootstrap">
                            <div class="icon-container">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M3 19l6 3v-9L3 10v9z" /><path d="M16 11.37V21.78l-2.44-1.22M15.542 4.16L12 2.94M5.618 6.096L3 7.056M12 12v6m-3-6H6" /></svg>
                            </div>
                            <h3>Caterer / Halwai</h3>
                            <p>Delicious food and professional catering for all gatherings.</p>
                        </div>
                    </a>
                </div>
                <div class="col">
                    <a href="taskers.html?category=Dhol / Tasha Party" class="service-card-bootstrap-link">
                        <div class="service-card-bootstrap">
                            <div class="icon-container">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                            </div>
                            <h3>Dhol / Tasha Party</h3>
                            <p>Traditional music and energetic performances for festive events.</p>
                        </div>
                    </a>
                </div>
                <div class="col">
                    <a href="taskers.html?category=Tent House" class="service-card-bootstrap-link">
                        <div class="service-card-bootstrap">
                            <div class="icon-container">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 1.343-3 3v2a3 3 0 003 3h2a3 3 0 003-3v-2a3 3 0 00-3-3m0 0a3 3 0 00-3 3v2a3 3 0 003 3h2a3 3 0 003-3v-2a3 3 0 00-3-3m0 0v-2.5a.5.5 0 011 0V8z" /><path d="M12 11a4 4 0 100-8 4 4 0 000 8z" /></svg>
                            </div>
                            <h3>Tent House</h3>
                            <p>Tents, lighting, and seating for outdoor events and functions.</p>
                        </div>
                    </a>
                </div>
                <div class="col">
                    <a href="taskers.html?category=Photography & Videography" class="service-card-bootstrap-link">
                        <div class="service-card-bootstrap">
                            <div class="icon-container">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9v6m0 0v6a2 2 0 002 2h14a2 2 0 002-2v-6m-9 6l3-3m0 0l3 3m-3-3v9M3 13h18" /></svg>
                            </div>
                            <h3>Photography & Videography</h3>
                            <p>Capture your special moments with professional media services.</p>
                        </div>
                    </a>
                </div>
                <div class="col">
                    <a href="taskers.html?category=Invitation Card Designer" class="service-card-bootstrap-link">
                        <div class="service-card-bootstrap">
                            <div class="icon-container">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 1.343-3 3v2a3 3 0 003 3h2a3 3 0 003-3v-2a3 3 0 00-3-3m0 0a3 3 0 00-3 3v2a3 3 0 003 3h2a3 3 0 003-3v-2a3 3 0 00-3-3m0 0v-2.5a.5.5 0 011 0V8z" /><path d="M12 11a4 4 0 100-8 4 4 0 000 8z" /></svg>
                            </div>
                            <h3>Invitation Card Designer</h3>
                            <p>Custom-designed invitations for weddings, parties, and events.</p>
                        </div>
                    </a>
                </div>
                <div class="col">
                    <a href="taskers.html?category=Emcee / Anchor" class="service-card-bootstrap-link">
                        <div class="service-card-bootstrap">
                            <div class="icon-container">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 1.343-3 3v2a3 3 0 003 3h2a3 3 0 003-3v-2a3 3 0 00-3-3m0 0a3 3 0 00-3 3v2a3 3 0 003 3h2a3 3 0 003-3v-2a3 3 0 00-3-3m0 0v-2.5a.5.5 0 011 0V8z" /><path d="M12 11a4 4 0 100-8 4 4 0 000 8z" /></svg>
                            </div>
                            <h3>Emcee / Anchor</h3>
                            <p>Engaging hosts and speakers for a memorable event.</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <div class="mb-5">
            <h2 class="text-start mb-4">Movers & Transport</h2>
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
                <div class="col">
                    <a href="taskers.html?category=Home Shifting (Local)" class="service-card-bootstrap-link">
                        <div class="service-card-bootstrap">
                            <div class="icon-container">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4m16 0l-4 4m4-4l-4-4M4 12l4 4M4 12l4-4" /><path d="M20 12H4" /></svg>
                            </div>
                            <h3>Home Shifting (Local)</h3>
                            <p>Efficient and affordable moving services within the city.</p>
                        </div>
                    </a>
                </div>
                <div class="col">
                    <a href="taskers.html?category=Intercity Movers & Packers" class="service-card-bootstrap-link">
                        <div class="service-card-bootstrap">
                            <div class="icon-container">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4m16 0l-4 4m4-4l-4-4M4 12l4 4M4 12l4-4" /><path d="M20 12H4" /></svg>
                            </div>
                            <h3>Intercity Movers & Packers</h3>
                            <p>Reliable and secure long-distance moving solutions.</p>
                        </div>
                    </a>
                </div>
                <div class="col">
                    <a href="taskers.html?category=Truck / Tempo on Hire" class="service-card-bootstrap-link">
                        <div class="service-card-bootstrap">
                            <div class="icon-container">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4m16 0l-4 4m4-4l-4-4M4 12l4 4M4 12l4-4" /><path d="M20 12H4" /></svg>
                            </div>
                            <h3>Truck / Tempo on Hire</h3>
                            <p>Rent trucks and tempos for all your transportation needs.</p>
                        </div>
                    </a>
                </div>
                <div class="col">
                    <a href="taskers.html?category=Bike / Car Transport" class="service-card-bootstrap-link">
                        <div class="service-card-bootstrap">
                            <div class="icon-container">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4m16 0l-4 4m4-4l-4-4M4 12l4 4M4 12l4-4" /><path d="M20 12H4" /></svg>
                            </div>
                            <h3>Bike / Car Transport</h3>
                            <p>Safe and secure transport of your vehicles across locations.</p>
                        </div>
                    </a>
                </div>
                <div class="col">
                    <a href="taskers.html?category=Furniture Delivery" class="service-card-bootstrap-link">
                        <div class="service-card-bootstrap">
                            <div class="icon-container">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4m16 0l-4 4m4-4l-4-4M4 12l4 4M4 12l4-4" /><path d="M20 12H4" /></svg>
                            </div>
                            <h3>Furniture Delivery</h3>
                            <p>Reliable delivery and setup of new and old furniture.</p>
                        </div>
                    </a>
                </div>
                <div class="col">
                    <a href="taskers.html?category=Goods Transport Help" class="service-card-bootstrap-link">
                        <div class="service-card-bootstrap">
                            <div class="icon-container">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4m16 0l-4 4m4-4l-4-4M4 12l4 4M4 12l4-4" /><path d="M20 12H4" /></svg>
                            </div>
                            <h3>Goods Transport Help</h3>
                            <p>Assistance with moving and transporting your goods.</p>
                        </div>
                    </a>
                </div>
                <div class="col">
                    <a href="taskers.html?category=Office Relocation" class="service-card-bootstrap-link">
                        <div class="service-card-bootstrap">
                            <div class="icon-container">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4m16 0l-4 4m4-4l-4-4M4 12l4 4M4 12l4-4" /><path d="M20 12H4" /></svg>
                            </div>
                            <h3>Office Relocation</h3>
                            <p>Smooth and organized office shifting and setup services.</p>
                        </div>
                    </a>
                </div>
                <div class="col">
                    <a href="taskers.html?category=Driver on Demand" class="service-card-bootstrap-link">
                        <div class="service-card-bootstrap">
                            <div class="icon-container">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" /><path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-5.998 12.078 12.078 0 01.665-6.479L12 14z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-5.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222 4 2.222V20" /></svg>
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

</body>
</html>