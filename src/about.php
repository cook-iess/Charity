<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include("conn.php");

require "./shared/header.php";

if (isset($_SESSION['Username']) && isset($_COOKIE['Username'])) {

?>


    <!doctype html>
    <html>

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        <link href="./output.css" rel="stylesheet">
        <title>About Us</title>
        <style>
            .bg-cover {
                background-size: cover;
            }
        </style>
    </head>

    <body>
        <div class="space-y-16 text-gray-700">
            <!-- History -->
            <div class="px-8 pb-10 flex flex-col lg:flex-row text-left gap-8 justify-center items-start pl-14 text-sky-950 pt-28">
                <div class="lg:w-1/2 px-5">
                    <p class="text-5xl font-sans font-bold text-left text-sky-700 pb-10">
                        About Us
                    </p>
                    <hr class="border-0 h-px bg-sky-800 w-36 mb-10" />
                    <p class="text-lg leading-relaxed">
                        <b class="text-sky-700">Bright Futures </b>was founded with the
                        mission to support communities and provide educational resources to
                        those in need. Since our inception, we have mobilized countless
                        volunteers who share our vision of creating a brighter future for
                        all. Over the years, we have successfully built schools in
                        underserved areas, ensuring that children have access to quality
                        education and a safe learning environment.
                    </p>
                    <p class="text-lg leading-relaxed pt-4">
                        Our programs are designed not only to educate but also to empower
                        individuals and families. We offer workshops that teach essential
                        skills, mentorship programs that guide youth toward their goals, and
                        community initiatives that foster collaboration and growth.
                    </p>
                </div>
                <div class="lg:w-1/2 mx-auto my-auto">
                    <img
                        src="./img/img8.jpg"
                        alt="Our History"
                        class="w-[90%] rounded-lg shadow-xl" />
                </div>
            </div>

            <!-- Counters -->
            <div class="relative">
                <div class="absolute inset-0 bg-cover bg-center py-20" style="background-image: url('./img/img7.jpg');"></div>
                <div class="absolute inset-0 bg-white opacity-65"></div>

                <div class="relative flex justify-around p-8 rounded-lg py-20">
                    <div class="text-center">
                        <div class="flex items-center justify-center">
                            <span id="counter1" class="text-3xl font-bold">0</span>
                            <span class="ml-1"><i class="fas fa-plus"></i></span>
                        </div>
                        <p class="text-gray-900">People Helped</p>
                    </div>
                    <div class="text-center">
                        <div class="flex items-center justify-center">
                            <span id="counter2" class="text-3xl font-bold">0</span>
                            <span class="ml-1"><i class="fas fa-plus"></i></span>
                        </div>
                        <p class="text-gray-900">Schools Built</p>
                    </div>
                    <div class="text-center">
                        <div class="flex items-center justify-center">
                            <span id="counter3" class="text-3xl font-bold">0</span>
                            <span class="ml-1"><i class="fas fa-plus"></i></span>
                        </div>
                        <p class="text-gray-900">Refugee Camps Established</p>
                    </div>
                    <div class="text-center">
                        <div class="flex items-center justify-center">
                            <span id="counter4" class="text-3xl font-bold">0</span>
                            <span class="ml-1"><i class="fas fa-plus"></i></span>
                        </div>
                        <p class="text-gray-900">Community Centers Built</p>
                    </div>
                    <div class="text-center">
                        <div class="flex items-center justify-center">
                            <span id="counter5" class="text-3xl font-bold">0</span>
                            <span class="ml-1"><i class="fas fa-plus"></i></span>
                        </div>
                        <p class="text-gray-900">Scholarships Awarded</p>
                    </div>
                </div>
            </div>

            <!-- Contact Information -->
            <div class="pb-14 rounded-2xl" id="contact-us">
                <div class="max-w-6xl mx-auto relative">
                    <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('./img/img7.jpg');">
                        <div class="absolute inset-0 bg-white/75"></div> <!-- Black overlay -->
                    </div>
                    <div class="rounded-lg drop-shadow-2xl p-8 px-12 relative z-10">
                        <h2 class="text-4xl font-bold text-left pb-12 pt-4">Contact Info</h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-10 mb-10">
                            <div class="p-6 border rounded-lg shadow-sm hover:shadow-lg transition-shadow duration-200 bg-white/40">
                                <h3 class="text-xl font-semibold mb-2">Our Address</h3>
                                <p>123 Main St., Example City, Country</p>
                            </div>

                            <div class="p-6 border rounded-lg shadow-sm hover:shadow-lg transition-shadow duration-200 bg-white/40">
                                <h3 class="text-xl font-semibold mb-2">Email</h3>
                                <p>contact@example.com</p>
                            </div>

                            <div class="p-6 border rounded-lg shadow-sm hover:shadow-lg transition-shadow duration-200 bg-white/40">
                                <h3 class="text-xl font-semibold mb-2">Phone</h3>
                                <p class="hover:underline">+251 956 7890</p>
                                <p class="hover:underline">+251 957 6646</p>
                            </div>

                            <div class="p-6 border rounded-lg shadow-sm hover:shadow-lg transition-shadow duration-200 bg-white/40">
                                <h3 class="text-xl font-semibold mb-2">Follow Us</h3>
                                <p>Stay connected via social media!</p>
                                <div class="flex space-x-2 mt-2">
                                    <button
                                        class="p-2 text-blue-600 hover:bg-blue-100 rounded-full"
                                        aria-label="Facebook"
                                        onclick="window.open('https:/www.facebook.com', '_blank')">
                                        <i class="fab fa-facebook-f"></i>
                                    </button>
                                    <button
                                        class="p-2 text-blue-500 hover:bg-blue-100 rounded-full"
                                        aria-label="Twitter"
                                        onclick="window.open('https:/www.twitter.com', '_blank')">
                                        <i class="fab fa-twitter"></i>
                                    </button>
                                    <button
                                        class="p-2 text-blue-700 hover:bg-blue-100 rounded-full"
                                        aria-label="LinkedIn"
                                        onclick="window.open('https:/www.linkedin.com', '_blank')">
                                        <i class="fab fa-linkedin-in"></i>
                                    </button>
                                    <button
                                        class="p-2 text-pink-500 hover:bg-blue-100 rounded-full"
                                        aria-label="Instagram"
                                        onclick="window.open('https:/www.instagram.com', '_blank')">
                                        <i class="fab fa-instagram"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <a
                                class="bg-blue-600 text-white p-3 text-sm rounded-lg flex items-center hover:bg-blue-700"
                                href="https://t.me/yourusername">
                                SEND MESSAGE
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- footer -->
        <div
            class="bg-blue-600 text-white pt-3 pb-6 flex flex-col items-center">
            <div>
                <!-- Logo and Title -->
                <div class="flex justify-center items-center pt-0 mt-0">
                    <img src="./img/logo.png" alt="Logo" class="w-24" />
                    <h2 class="text-white font-bold text-xl">Bright Futures</h2>
                </div>

                <!-- Main Content Area -->
                <div class="flex flex-1 justify-between w-full mb-16">
                    <div class="w-1/3 mr-4 mx-auto text-center">
                        <h4 class="text-xl font-bold pb-1">Navigation</h4>
                        <a href="/" class="text-white hover:underline block">
                            Home
                        </a>
                        <a
                            href="/projects"
                            class="text-white hover:underline block">
                            Our Projects
                        </a>
                        <a
                            href="/about"
                            class="text-white hover:underline block">
                            About Us
                        </a>
                        <a
                            href="/about#contact-us"
                            class="text-white hover:underline block">
                            Contact Us
                        </a>
                    </div>

                    <div class="text-center w-1/3">
                        <h4 class="text-xl font-bold pb-2">Get Involved</h4>
                        <p class="">
                            Join us in our mission to support the community.
                            <b>Together, we can make a difference!</b>
                        </p>
                        <a href="/about" class="hover:underline text-white">
                            Learn More
                        </a>
                    </div>

                    <div class="w-1/3 text-center">
                        <h4 class="text-xl font-bold pb-2">Contact Us</h4>
                        <p>
                            <b>Email:</b>
                            <a href="mailto:info@brightfutures.org" class="underline">
                                info@brightfutures.org
                            </a>
                        </p>
                        <p>
                            <b>Phone:</b>
                            <a href="tel:+1234567890" class="underline">
                                +1 (234) 567-890
                            </a>
                        </p>
                        <p><b>Address:</b> 123 Bright St, City, State, ZIP</p>
                        <div class="flex justify-center">
                            <a href="https://facebook.com" class="flex items-center justify-center p-2 text-white">
                                <i class="fab fa-facebook-f text-2xl hover:text-3xl duration-500"></i>
                            </a>
                            <a href="https://twitter.com" class="flex items-center justify-center p-2 text-white">
                                <i class="fab fa-twitter text-2xl hover:text-3xl duration-500"></i>
                            </a>
                            <a href="https://instagram.com" class="flex items-center justify-center p-2 text-white">
                                <i class="fab fa-instagram text-2xl hover:text-3xl duration-300"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="my-3 bg-white h-px mb-6"></div>

                <div class="text-center mb-4">
                    <p>
                        © <?php echo date('Y'); ?> Bright Futures. All rights reserved.
                    </p>
                </div>
            </div>
        </div>

        <script>
            function animateCounter(id, target) {
                let count = 0;
                const interval = setInterval(() => {
                    if (count < target) {
                        count++;
                        document.getElementById(id).innerText = count;
                    } else {
                        clearInterval(interval);
                    }
                }, 15); // Adjust speed of increment here
            }

            // Start counting to the target values
            animateCounter('counter1', 300);
            animateCounter('counter2', 150);
            animateCounter('counter3', 30);
            animateCounter('counter4', 75);
            animateCounter('counter5', 200);
            const header = document.getElementById('header');

            window.addEventListener('scroll', () => {
                if (window.scrollY > 50) {
                    header.classList.remove('bg-transparent');
                    header.classList.add('bg-white', 'shadow-lg');
                } else {
                    header.classList.add('bg-transparent');
                    header.classList.remove('bg-white', 'shadow-lg');
                }
            });
        </script>
    </body>

    </html>

<?php
} else {
    header("Location: login.php");
}
?>