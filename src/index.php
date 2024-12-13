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
  <Title>Home</Title>
</head>

<body>

  <div class="text-white">
    <div class="md:grid grid-cols-2 my-auto w-full md:mt-0 bg-sky-50 pt-20">
      <div class="my-auto md:ml-14 ml-6 px-3 md:mb-auto mb-36 mr-10 pb-24 pt-20">
        <p class="font-extrabold text-6xl text-gray-800 text-left mb-4">
          Together, We Can Make a Difference
        </p>
        <p class="mt-1 text-gray-800 text-left">
          Every act of kindness matters. Join us in transforming lives,
          empowering communities, and building a better future for those in
          need. Whether through education, healthcare, or support for
          vulnerable groups, your generosity fuels real change.
        </p>
      </div>
      <div class="relative w-full">
        <div class="absolute inset-0 z-0 flex -mt-20">
          <div class="w-1/2 bg-sky-50"></div>
          <div class="w-1/2 bg-sky-800 pt-16"></div>
        </div>
        <div class="relative z-10 w-full">
          <img src="./img/img1.png" alt="Your Image" class="object-cover" />
        </div>
      </div>
    </div>
    <div class="md:flex w-[100%]">
      <div class="bg-green-600 w-full text-left p-6 py-auto pt-16">
        <img src="./img/icons/icon1.png" alt="" class="w-10">
        <p class="text-lg font-semibold pt-2 pb-2">
          Education Projects in Ethiopia.
        </p>
        <p class="font-extralight text-sm">Donate Now</p>
      </div>
      <div class="bg-yellow-500 w-full text-left p-6 pt-16">
        <img src="./img/icons/icon3.png" alt="" class="w-9" />
        <p class="text-lg font-semibold pt-2 pb-2">
          Health access for refugees programme.
        </p>
        <p class="font-extralight text-sm">Donate Now</p>
      </div>
      <div class="bg-red-600 w-full text-left p-6 pt-16">
        <img src="./img/icons/icon2.png" alt="" class="text-white w-9" />
        <p class="text-lg font-semibold pt-2 pb-2">
          Food assistannce for refugees.
        </p>
        <p class="font-extralight text-sm">Donate Now</p>
      </div>
    </div>
    <div class="grid md:grid-cols-7 w-full text-black pt-20 pb-6">
      <div class="col-span-1"></div>
      <div class="col-span-3 my-auto mx-auto">
        <p class="font-serif font-bold text-2xl pb-3">Our Mission</p>
        <p class="md:pr-20">
          Our mission is to bring lasting change by empowering individuals and
          communities to overcome poverty, access quality education,
          healthcare, and resources.
        </p>
      </div>
      <img src="./img/img3.jpeg" alt="" class="h-48 rounded-xl col-span-2" />
      <div class="col-span-1"></div>
    </div>

    <div class="grid md:grid-cols-7 w-full text-black pt-16 mb-24 md:px-0 md:pb-0 bg-red-600">
      <div class="md:col-span-1"></div>
      <img src="./img/img2.jpeg" alt="" class="h-48 rounded-xl col-span-2" />
      <div class="col-span-3 my-auto mx-auto">
        <p class="font-serif font-bold text-2xl pb-3 md:text-left text-right">Our vision</p>
        <p class="md:pr-20 md:text-left text-right">
          We envision a world where every person has the opportunity to live a
          life of dignity, purpose, and hope. Through collaborative efforts,
          sustainable programs, and unwavering support.
        </p>
      </div>
      <div class="md:col-span-1"></div>
    </div>

    <div>
      <p class="text-3xl font-bold text-gray-700 text-left px-6 pb-4 w-full">Our Projects</p>
      <div class="flex justify-between">
        <img src="./img/img4.jpeg" alt="" class="w-1/3 h-64 object-cover object-center mb-20 pr-6" />
        <img src="./img/img5.jpg" alt="" class="w-1/3 h-64 object-cover object-center mb-20" />
        <img src="./img/img6.jpg" alt="" class="w-1/3 h-64 object-cover object-center mb-20 pl-6" />
      </div>
    </div>
  </div>



  <!-- footer -->
  <div class="bg-blue-600 text-white pt-3 pb-6 md:flex md:items-center">
    <div class="container mx-auto px-4">
        <!-- Logo and Title -->
        <div class="flex justify-center items-center pt-0 mt-0">
            <img src="./img/logo.png" alt="Logo" class="md:w-24 w-10" />
            <h2 class="text-white font-bold md:text-xl">Bright Futures</h2>
        </div>

        <!-- Main Content Area -->
        <div class="flex flex-col md:flex-row justify-between w-full mb-16">
            <div class="w-full md:w-1/3 mb-4 md:mb-0 text-center">
                <h4 class="md:text-xl font-bold pb-1">Navigation</h4>
                <a href="/" class="text-white hover:underline block">Home</a>
                <a href="/projects" class="text-white hover:underline block">Our Projects</a>
                <a href="/about" class="text-white hover:underline block">About Us</a>
                <a href="/about#contact-us" class="text-white hover:underline block">Contact Us</a>
            </div>

            <div class="w-full md:w-1/3 mb-4 md:mb-0 text-center">
                <h4 class="md:text-xl font-bold pb-2">Get Involved</h4>
                <p>Join us in our mission to support the community. <b>Together, we can make a difference!</b></p>
                <a href="/about" class="hover:underline text-white">Learn More</a>
            </div>

            <div class="w-full md:w-1/3 text-center">
                <h4 class="text-xl font-bold pb-2">Contact Us</h4>
                <p><b>Email:</b> <a href="mailto:info@brightfutures.org" class="underline">info@brightfutures.org</a></p>
                <p><b>Phone:</b> <a href="tel:+1234567890" class="underline">+1 (234) 567-890</a></p>
                <p><b>Address:</b> 123 Bright St, City, State, ZIP</p>
                <div class="flex justify-center mt-2">
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
            <p>© <?php echo date('Y'); ?> Bright Futures. All rights reserved.</p>
        </div>
    </div>
</div>

  <script>
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


    const [isScrolled, setIsScrolled] = useState(false);

    useEffect(() => {
      const handleScroll = () => {
        if (window.scrollY > 50) {
          setIsScrolled(true);
        } else {
          setIsScrolled(false);
        }
      };

      window.addEventListener("scroll", handleScroll);
      return () => window.removeEventListener("scroll", handleScroll);
    }, []);

    document.getElementById('notificationButton').onclick = function(event) {
        event.stopPropagation(); // Prevent click event from bubbling up
        var popup = document.getElementById('notificationPopup');
        popup.classList.toggle('hidden'); // Toggle visibility
        console.log("Notification button clicked");

      };

      document.getElementById('closePopup').onclick = function(event) {
        event.stopPropagation(); // Prevent click event from bubbling up
        document.getElementById('notificationPopup').classList.add('hidden'); // Hide popup
        console.log("Notification button clicked");

      };

      // Close the popup when clicking outside of it
      window.onclick = function(event) {
        var popup = document.getElementById('notificationPopup');
        var button = document.getElementById('notificationButton');
        if (event.target !== popup && event.target !== button && !popup.contains(event.target)) {
          popup.classList.add('hidden'); // Hide popup
          console.log("Notification button clicked");

        }
      };

  </script>
</body>

</html>

<?php
} else {
  header("Location: login.php");
}
?>