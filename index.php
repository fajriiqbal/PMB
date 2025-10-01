<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>PMB-MTs Sunan Kalijaga</title>
    <link rel="icon" type="image/png" href="assets/LOGOMADA.png">

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        /* Custom mobile-app like styling */
        @media (max-width: 768px) {
            body {
                -webkit-tap-highlight-color: transparent;
            }
            
            .mobile-app-container {
                max-width: 100%;
                margin: 0 auto;
                padding: 0;
                background: #f8fafc;
                min-height: 100vh;
            }
            
            .floating-button {
                position: fixed;
                bottom: 24px;
                right: 24px;
                z-index: 50;
                width: 60px;
                height: 60px;
                border-radius: 50%;
                background: #2563eb;
                color: white;
                display: flex;
                align-items: center;
                justify-content: center;
                box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
                transition: all 0.3s ease;
            }
            
            .floating-button:hover {
                transform: scale(1.05);
                box-shadow: 0 6px 16px rgba(37, 99, 235, 0.4);
            }
        }
        
        /* Custom animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .animate-fade-in {
            animation: fadeIn 0.5s ease-out;
        }
    </style>
</head>
<body class="bg-gradient-to-b from-blue-50 to-white">
    <?php
    // PHP variables and data
    $schoolName = "PMB MTs Sunan Kalijaga Tulung";
    $schoolAddress = "Jl. Raya Tulung - Ngangkruk,KM 0.1 , Tulung, Klaten";
    $schoolPhone = "082241509229";
    $schoolEmail = "mtssunankalijaga01@gmail.com";
    
    $announcements = [
        [
            "title" => "Registration Deadline Approaching",
            "date" => "August 15, 2023",
            "content" => "Final day to submit registration forms is August 30th. Late submissions may be subject to waiting list placement."
        ],
        [
            "title" => "New Student Orientation",
            "date" => "September 5, 2023",
            "content" => "All newly registered students are required to attend orientation on September 5th at 9:00 AM in the main auditorium."
        ],
        [
            "title" => "Transportation Services Available",
            "date" => "August 10, 2023",
            "content" => "Bus route information and registration for transportation services is now available through the parent portal."
        ]
    ];
    
    $keyDates = [
        ["date" => "Aug 15, 2023", "event" => "Registration Opens", "icon" => "calendar"],
        ["date" => "Aug 30, 2023", "event" => "Registration Deadline", "icon" => "clock"],
        ["date" => "Sep 1, 2023", "event" => "Class Lists Posted", "icon" => "users"],
        ["date" => "Sep 5, 2023", "event" => "First Day of School", "icon" => "book-open"]
    ];
    
    // Function to render icon SVG
    function renderIcon($iconName) {
        switch($iconName) {
            case 'calendar':
                return '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>';
            case 'clock':
                return '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>';
            case 'users':
                return '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>';
            case 'book-open':
                return '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>';
            case 'arrow-right':
                return '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>';
            case 'menu':
                return '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" /></svg>';
            case 'x':
                return '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>';
            default:
                return '';
        }
    }
    
    // Check if mobile device
    $isMobile = false;
    if (isset($_SERVER['HTTP_USER_AGENT'])) {
        $userAgent = $_SERVER['HTTP_USER_AGENT'];
        $isMobile = preg_match("/(android|iphone|ipod|ipad|blackberry|windows phone)/i", $userAgent);
    }
    ?>
    
    <div class="<?php echo $isMobile ? 'mobile-app-container' : ''; ?>">
        <!-- Header -->
        <header class="sticky top-0 z-50 bg-white shadow-sm">
            <div class="container mx-auto px-4 py-4">
                <div class="flex items-center justify-between">
                    <!-- <div class="flex items-center">
                        
                           <?php echo '<img src="assets/LOGOMADA.png" alt="Logo" width="100">'; ?>

                       
                        <h1 class="ml-3 text-xl font-bold text-gray-800"><?php echo $schoolName; ?></h1>
                    </div> -->

                    <!-- Desktop Navigation -->
                    <!-- <nav class="hidden md:flex items-center space-x-6">
                        <a href="#info" class="text-gray-600 hover:text-blue-600 transition-colors">Information</a>
                        <a href="#dates" class="text-gray-600 hover:text-blue-600 transition-colors">Key Dates</a>
                        <a href="#announcements" class="text-gray-600 hover:text-blue-600 transition-colors">Announcements</a>
                        <a 
                            href="https://docs.google.com/forms" 
                            target="_blank" 
                            rel="noopener noreferrer"
                            class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors flex items-center"
                        >
                            Register <?php echo renderIcon('arrow-right'); ?>
                        </a>
                    </nav> -->

                    <!-- Mobile menu button -->
                    <button 
                        class="md:hidden text-gray-600 mobile-menu-btn"
                        onclick="toggleMobileMenu()"
                    >
                        <?php echo renderIcon('menu'); ?>
                    </button>
                </div>

                <!-- Mobile Navigation -->
                <!-- <div id="mobileMenu" class="hidden mt-4 md:hidden border-t pt-4">
                    <div class="flex flex-col space-y-3">
                        <a href="#info" class="text-gray-600 hover:text-blue-600 py-2" onclick="closeMobileMenu()">Information</a>
                        <a href="#dates" class="text-gray-600 hover:text-blue-600 py-2" onclick="closeMobileMenu()">Key Dates</a>
                        <a href="#announcements" class="text-gray-600 hover:text-blue-600 py-2" onclick="closeMobileMenu()">Announcements</a>
                        <a 
                            href="https://docs.google.com/forms" 
                            target="_blank" 
                            rel="noopener noreferrer"
                            class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors flex items-center justify-center"
                            onclick="closeMobileMenu()"
                        >
                            Register <?php echo renderIcon('arrow-right'); ?>
                        </a>
                    </div>
                </div> -->
            </div>
        </header>

        <!-- Hero Section -->
        <!-- <section class="py-12 md:py-20 animate-fade-in">
            <div class="container mx-auto px-4">
                <div class="max-w-3xl mx-auto text-center">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">
                        <?php echo $schoolName; ?> Tahun Ajar 2026 - 2027
                    </h2>
                    <p class="text-lg text-gray-600 mb-8">
                        Selamat Datang Portal <?php echo $schoolName; ?> Infromasi Pendaftaran. Bergabung dengan kami belajar bersama di MTs Sunan Kalijaga.
                    </p>
                    <a 
                        href="https://docs.google.com/forms" 
                        target="_blank" 
                        rel="noopener noreferrer"
                        class="inline-flex items-center bg-blue-600 text-white font-medium px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors"
                    >
                        Register Now
                        <?php echo renderIcon('arrow-right'); ?>
                    </a>
                </div>
            </div>
        </section> -->

        <!-- Information Section -->
        <!-- <section id="info" class="py-12 bg-white">
            <div class="container mx-auto px-4">
                <h2 class="text-2xl md:text-3xl font-bold text-center text-gray-800 mb-10">
                    Registration Information
                </h2>
                
                <div class="grid md:grid-cols-2 gap-8 max-w-5xl mx-auto">
                    <div class="bg-blue-50 p-6 rounded-lg">
                        <h3 class="text-xl font-semibold text-gray-800 mb-4">Required Documents</h3>
                        <ul class="space-y-2 text-gray-600">
                            <li class="flex items-start">
                                <div class="h-2 w-2 bg-blue-600 rounded-full mt-2 mr-3"></div>
                                <span>Proof of residence (utility bill or lease agreement)</span>
                            </li>
                            <li class="flex items-start">
                                <div class="h-2 w-2 bg-blue-600 rounded-full mt-2 mr-3"></div>
                                <span>Birth certificate or passport</span>
                            </li>
                            <li class="flex items-start">
                                <div class="h-2 w-2 bg-blue-600 rounded-full mt-2 mr-3"></div>
                                <span>Immunization records</span>
                            </li>
                            <li class="flex items-start">
                                <div class="h-2 w-2 bg-blue-600 rounded-full mt-2 mr-3"></div>
                                <span>Previous school records (if applicable)</span>
                            </li>
                            <li class="flex items-start">
                                <div class="h-2 w-2 bg-blue-600 rounded-full mt-2 mr-3"></div>
                                <span>Parent/guardian photo ID</span>
                            </li>
                        </ul>
                    </div>
                    
                    <div class="bg-blue-50 p-6 rounded-lg">
                        <h3 class="text-xl font-semibold text-gray-800 mb-4">Registration Process</h3>
                        <ol class="space-y-3 text-gray-600">
                            <li class="flex items-start">
                                <span class="bg-blue-600 text-white rounded-full h-6 w-6 flex items-center justify-center text-sm mr-3 flex-shrink-0">1</span>
                                <span>Complete the online registration form</span>
                            </li>
                            <li class="flex items-start">
                                <span class="bg-blue-600 text-white rounded-full h-6 w-6 flex items-center justify-center text-sm mr-3 flex-shrink-0">2</span>
                                <span>Submit required documents electronically</span>
                            </li>
                            <li class="flex items-start">
                                <span class="bg-blue-600 text-white rounded-full h-6 w-6 flex items-center justify-center text-sm mr-3 flex-shrink-0">3</span>
                                <span>Receive confirmation email within 3 business days</span>
                            </li>
                            <li class="flex items-start">
                                <span class="bg-blue-600 text-white rounded-full h-6 w-6 flex items-center justify-center text-sm mr-3 flex-shrink-0">4</span>
                                <span>Attend orientation session (details will be provided)</span>
                            </li>
                        </ol>
                    </div>
                </div>
                
                <div class="text-center mt-10">
                    <p class="text-gray-600 mb-4">Need assistance with registration?</p>
                    <p class="text-blue-600 font-medium">Contact us at <?php echo $schoolEmail; ?> or <?php echo $schoolPhone; ?></p>
                </div>
            </div>
        </section> -->

        <!-- Key Dates Section -->
        <!-- <section id="dates" class="py-12 bg-gray-50">
            <div class="container mx-auto px-4">
                <h2 class="text-2xl md:text-3xl font-bold text-center text-gray-800 mb-10">
                    Important Dates
                </h2>
                
                <div class="max-w-4xl mx-auto">
                    <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <?php foreach ($keyDates as $index => $item): ?>
                        <div class="bg-white p-5 rounded-lg shadow-sm border border-gray-100 text-center">
                            <div class="text-blue-600 flex justify-center mb-3">
                                <?php echo renderIcon($item['icon']); ?>
                            </div>
                            <h3 class="font-semibold text-gray-800"><?php echo $item['event']; ?></h3>
                            <p class="text-blue-600 font-medium mt-2"><?php echo $item['date']; ?></p>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </section> -->

        <!-- Announcements Section -->
        <!-- <section id="announcements" class="py-12 bg-white">
            <div class="container mx-auto px-4">
                <h2 class="text-2xl md:text-3xl font-bold text-center text-gray-800 mb-10">
                    Latest Announcements
                </h2>
                
                <div class="max-w-4xl mx-auto space-y-6">
                    <?php foreach ($announcements as $index => $announcement): ?>
                    <div class="bg-blue-50 p-6 rounded-lg border-l-4 border-blue-600">
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="text-xl font-semibold text-gray-800"><?php echo $announcement['title']; ?></h3>
                            <span class="text-sm text-blue-600 bg-blue-100 px-3 py-1 rounded-full"><?php echo $announcement['date']; ?></span>
                        </div>
                        <p class="text-gray-600"><?php echo $announcement['content']; ?></p>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section> -->

        <!-- CTA Section -->
        <!-- <section class="py-16 bg-blue-600 text-white">
            <div class="container mx-auto px-4 text-center">
                <h2 class="text-2xl md:text-3xl font-bold mb-4">Siap Untuk Bergambung?</h2>
                <p class="max-w-2xl mx-auto mb-8 text-blue-100">
                    Lengkapi dan bergabung dengan kami di <?php echo $schoolName; ?>.
                </p>
                <a 
                    href="https://docs.google.com/forms" 
                    target="_blank" 
                    rel="noopener noreferrer"
                    class="inline-flex items-center bg-white text-blue-600 font-medium px-6 py-3 rounded-lg hover:bg-gray-100 transition-colors"
                >
                    Register Now
                    <?php echo renderIcon('arrow-right'); ?>
                </a>
            </div>
                    </section> -->
        <!-- Statistik dari Google Sheet -->
       <!-- Statistik Pendaftar -->
<section id="stats" class="py-12 bg-gray-50">
  <div class="container mx-auto px-4">
    <h2 class="text-3xl font-bold text-center text-gray-800 mb-10">
      Statistik Pendaftar
    </h2>

    <!-- Grid untuk Chart -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-4xl mx-auto">
      <!-- Card Gender -->
      <div class="bg-white shadow-lg rounded-2xl p-6">
        <h3 class="text-lg font-semibold text-gray-700 mb-4 text-center">
          Jenis Kelamin
        </h3>
        <canvas id="genderChart"></canvas>
      </div>

      <!-- Card Pondok -->
      <div class="bg-white shadow-lg rounded-2xl p-6">
        <h3 class="text-lg font-semibold text-gray-700 mb-4 text-center">
          Pilihan Pondok Pesantren
        </h3>
        <canvas id="ponpesChart"></canvas>
      </div>
    </div>

    <!-- Total -->
    <div class="mt-10 text-center">
      <span
        id="totalSiswa"
        class="inline-block bg-blue-600 text-white font-bold py-3 px-6 rounded-full shadow-md"
      >
        Total Siswa Terdaftar: 0
      </span>
    </div>
  </div>
</section>

<!-- Daftar Pendaftar -->
<section id="pendaftar" class="py-12 bg-white">
  <div class="container mx-auto px-4">
    <h2 class="text-3xl font-bold text-center text-gray-800 mb-10">
      Data Pendaftar
    </h2>

    <!-- 🔎 Search bar -->
    <div class="mb-4 flex flex-col sm:flex-row items-center gap-3">
      <input 
        type="text" 
        id="searchInput" 
        placeholder="Cari siswa..." 
        class="border border-gray-300 px-3 py-2 rounded-lg w-full sm:w-1/2 focus:ring-2 focus:ring-blue-500"
      >
      <!-- <button 
            id="broadcastBtn" 
                class="bg-green-600 text-white px-4 py-2 rounded-lg shadow hover:bg-green-700 transition"
                >
                View Database
        </button> -->
                    </div>

                    
        <div class="relative w-full h-[400px] flex items-center justify-center border bg-gray-100 overflow-hidden">
  <button 
    id="runBtn"
    class="absolute bg-green-600 text-white px-4 py-2 rounded-lg shadow transition-transform duration-300"
    style="top: 50%; left: 50%; transform: translate(-50%, -50%);"
  >
    View Database
  </button>
</div>

    <div class="overflow-x-auto bg-white shadow-lg rounded-2xl">
      <table class="min-w-full border-collapse">
        <thead class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white">
          <tr>
            <th class="px-6 py-3 text-left text-sm font-semibold uppercase tracking-wider">
              Nomor
            </th>
            <th class="px-6 py-3 text-left text-sm font-semibold uppercase tracking-wider">
              Asal Sekolah
            </th>
            <th class="px-6 py-3 text-left text-sm font-semibold uppercase tracking-wider">
              Nama
            </th>
            <th class="px-6 py-3 text-left text-sm font-semibold uppercase tracking-wider">
              Jenis Kelamin
            </th>
            <th class="px-6 py-3 text-left text-sm font-semibold uppercase tracking-wider">
              Pilihan Pondok
            </th>
            <th class="px-6 py-3 text-left text-sm font-semibold uppercase tracking-wider">
              Nomor HP
            </th>
            <th class="px-6 py-3 text-left text-sm font-semibold uppercase tracking-wider">
              Status Berkas
            </th>
            <th class="px-6 py-3 text-left text-sm font-semibold uppercase tracking-wider">
              Kontak
            </th>
          </tr>
        </thead>
        <tbody id="pendaftarTable" class="divide-y divide-gray-200 text-sm">
          <!-- Data dari JavaScript -->
        </tbody>
      </table>
    </div>

    <p id="totalSiswa" class="mt-4 text-lg font-semibold text-gray-700"></p>
  </div>
</section>


        <!-- Footer -->
        <!-- <footer class="bg-gray-800 text-white py-10">
            <div class="container mx-auto px-4">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <div class="mb-6 md:mb-0">
                        <div class="flex items-center">
                            <div class="h-8 w-8 rounded-full bg-blue-600 flex items-center justify-center">
                                <?php echo renderIcon('book-open'); ?>
                            </div>
                            <h3 class="ml-2 text-xl font-bold"><?php echo $schoolName; ?></h3>
                        </div>
                        <p class="mt-2 text-gray-400"><?php echo $schoolAddress; ?></p>
                    </div>
                    
                    <div class="text-center md:text-right">
                        <p class="text-gray-400">Phone: <?php echo $schoolPhone; ?></p>
                        <p class="text-gray-400">Email: <?php echo $schoolEmail; ?></p>
                    </div>
                </div>
                
                <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-400">
                    <p>© 2025 <?php echo $schoolName; ?>. IT Madsuka.</p>
                </div>
            </div>
        </footer> -->

        <!-- Floating Register Button for Mobile -->
        <!-- <?php if ($isMobile): ?>
        <div class="floating-button">
            <a 
                href="https://docs.google.com/forms" 
                target="_blank" 
                rel="noopener noreferrer"
                class="w-full h-full flex items-center justify-center"
            >
                <?php echo renderIcon('book-open'); ?>
            </a>
        </div>
        <?php endif; ?>
    </div> -->

    <script>
        // Mobile menu functionality
        function toggleMobileMenu() {
            const menu = document.getElementById('mobileMenu');
            const menuBtn = document.querySelector('.mobile-menu-btn');
            
            if (menu.classList.contains('hidden')) {
                menu.classList.remove('hidden');
                menuBtn.innerHTML = `<?php echo renderIcon('x'); ?>`;
            } else {
                menu.classList.add('hidden');
                menuBtn.innerHTML = `<?php echo renderIcon('menu'); ?>`;
            }
        }
        
        function closeMobileMenu() {
            const menu = document.getElementById('mobileMenu');
            const menuBtn = document.querySelector('.mobile-menu-btn');
            
            menu.classList.add('hidden');
            menuBtn.innerHTML = `<?php echo renderIcon('menu'); ?>`;
        }
        
        // Close menu when clicking outside
        document.addEventListener('click', function(event) {
            const menu = document.getElementById('mobileMenu');
            const menuBtn = document.querySelector('.mobile-menu-btn');
            
            if (!menu.contains(event.target) && !menuBtn.contains(event.target) && !menu.classList.contains('hidden')) {
                closeMobileMenu();
            }
        });
    </script>
  <script>
const sheetURL = "https://docs.google.com/spreadsheets/d/e/2PACX-1vTkWDi-X_jfYIUpR04AupM-ubJ-hBT-RO6W9HSyIN5_n15SN_AD1vDNM4CW-GV_4EpIm-9MTgW1iLvl/pub?gid=1123091940&single=true&output=csv";

let globalData = []; // simpan data untuk search & broadcast

async function loadStats() {
    const response = await fetch(sheetURL);
    const csvText = await response.text();

    const rows = csvText.split("\n").map(r =>
        r.split(",").map(c => c.replace(/^"|"$/g, '').trim())
    );

    const headers = rows[0].map(h => h.trim());
    console.log("Headers:", headers);

    const colSekolah   = headers.findIndex(h => h.toLowerCase() === "asal sekolah");
    const colNama   = headers.findIndex(h => h.toLowerCase() === "nama siswa");
    const colGender = headers.findIndex(h => h.toLowerCase() === "jenis kelamin");
    const colPonpes = headers.findIndex(h => h.toLowerCase() === "pilihan pondok pesantren");
    const colHp     = headers.findIndex(h => h.toLowerCase() === "nomor hp orang tua");
    const colKK   = headers.findIndex(h => h.toLowerCase().includes("upload berkas kartu keluarga"));
    const colAkte = headers.findIndex(h => h.toLowerCase().includes("upload berkas akte kelahiran"));
    
    let total = 0;
    let male = 0, female = 0;
    let ponpesCounts = {};

    const tbody = document.getElementById("pendaftarTable");
    if (tbody) tbody.innerHTML = "";
    globalData = [];

    for (let i = 1; i < rows.length; i++) {
        const sekolah   = rows[i][colSekolah]   || "";
        const nama   = rows[i][colNama]   || "";
        const gender = (rows[i][colGender] || "").trim().toLowerCase();
        const pondok = rows[i][colPonpes] || "";
        const hpRaw  = rows[i][colHp]     || "";
        let hp = hpRaw.replace(/[^0-9]/g, "");
        if (hp.startsWith("0")) {
            hp = "62" + hp.substring(1);
        }

        const kk   = rows[i][colKK]  || "";
        const akte = rows[i][colAkte]|| "";
       

        const statusKK   = kk && kk.includes("http") ? "✅" : "❌";
        const statusAkte = akte && akte.includes("http") ? "✅" : "❌";
        

        if (!nama) continue;
        total++;

        if (gender.includes("laki")) male++;
        else if (gender.includes("perempuan")) female++;

        if (pondok) {
            ponpesCounts[pondok] = (ponpesCounts[pondok] || 0) + 1;
        }

        // status berkas
        let statusBerkas = `<span class="text-red-500 font-bold">❌ Belum Lengkap</span>`;
        if (kk && akte) {
            statusBerkas = `<span class="text-green-600 font-bold">✅ Lengkap</span>`;
        }

        // teks pesan default
        const pesan = `
        اَلْحَمْدُ لِلَّهِ رَبِّ الْعَالَمِينَ
        `.`
        Kami ucapkan : 
        " SELAMAT DITERIMA "
        Atas Nama : ${nama} 
        Sebagai 
        CALON SISWA BARU 
        TP. 2026/2027

        ________________
        Untuk selanjutnya ,mohon dipersiapkan berkas sebagai persyaratan daftar ulang  sbb:
        1. Fc.KK ( 4 lb ) 
        2. Fc. Akte Kelahiran ( 4 lb ) 
        3. Fc. KTP Ayah ( 4lb ) 
        4. Fc. KTP Ibu ( 4 lb ) 
        5. Pas Photo ukuran 3X4  background  merah / biru ( 2 lb ) 
        6. Administrasi Keuangan Seragam

        ⏳ Daftar ulang dilaksanakan Bulan Desember 2025.`;
        const linkWA = hp ? `https://wa.me/${hp}?text=${encodeURIComponent(pesan)}` : "";

        // cek riwayat kontak
        let contacted = localStorage.getItem("contacted_" + hp) ? "✔️" : "";

        if (tbody) {
            let tr = document.createElement("tr");
            tr.innerHTML = `
                <td class="border px-4 py-2">${i}</td>
                <td class="border px-4 py-2">${sekolah}</td>
                <td class="border px-4 py-2">${nama}</td>
                <td class="border px-4 py-2">${rows[i][colGender] || ""}</td>
                <td class="border px-4 py-2">${pondok}</td>
                <td class="border px-4 py-2">${hpRaw}</td>
                <td class="border px-4 py-2">${statusBerkas}</td>
                <td class="border px-4 py-2">
                    ${hp ? `<a href="${linkWA}" target="_blank" class="bg-green-500 text-white px-3 py-1 rounded" onclick="markContacted('${hp}')">Hubungi</a>` : "-"} ${contacted}
                </td>
            `;
            tbody.appendChild(tr);
        }

        globalData.push({nama, gender, pondok, hp, linkWA});
    }

    document.getElementById("totalSiswa").textContent = `Total Siswa Terdaftar: ${total}`;

    new Chart(document.getElementById("genderChart"), {
        type: "doughnut",
        data: {
            labels: ["Laki-Laki", "Perempuan"],
            datasets: [{
                data: [male, female],
                backgroundColor: ["#3b82f6", "#ec4899"]
            }]
        }
    });

    const ponpesLabels = Object.keys(ponpesCounts);
    const ponpesValues = Object.values(ponpesCounts);

    new Chart(document.getElementById("ponpesChart"), {
        type: "doughnut",
        data: {
            labels: ponpesLabels,
            datasets: [{
                data: ponpesValues,
                backgroundColor: [
                    "#10b981", "#f59e0b", "#3b82f6", "#ef4444", "#8b5cf6",
                    "#ec4899", "#22c55e", "#eab308", "#06b6d4", "#f97316"
                ]
            }]
        }
    });
}

// tandai sudah dihubungi
function markContacted(num) {
    localStorage.setItem("contacted_" + num, true);
}

// fitur search
document.getElementById("searchInput").addEventListener("keyup", function() {
    const filter = this.value.toLowerCase();
    const rows = document.querySelectorAll("#pendaftarTable tr");
    rows.forEach(r => {
        const text = r.innerText.toLowerCase();
        r.style.display = text.includes(filter) ? "" : "none";
    });
});

// tombol broadcast
// document.getElementById("broadcastBtn").addEventListener("click", function() {
//     window.open("tabel.php", "_blank"); // buka tabel siswa di tab baru
// });

    const btn = document.getElementById("runBtn");
    const container = btn.parentElement;
    const offset = 120; // jarak "zona bahaya" di sekitar tombol

    container.addEventListener("mousemove", function(e) {
    const rect = btn.getBoundingClientRect();
    const containerRect = container.getBoundingClientRect();

    const mouseX = e.clientX;
    const mouseY = e.clientY;

    const btnX = rect.left + rect.width / 2;
    const btnY = rect.top + rect.height / 2;

    const distX = mouseX - btnX;
    const distY = mouseY - btnY;
    const distance = Math.sqrt(distX ** 2 + distY ** 2);

    if (distance < offset) {
        // Tentukan arah lari menjauhi cursor
        let moveX = (rect.left - containerRect.left) + (distX > 0 ? -100 : 100);
        let moveY = (rect.top - containerRect.top) + (distY > 0 ? -100 : 100);

        // Batas agar nggak keluar container
        moveX = Math.max(0, Math.min(containerRect.width - rect.width, moveX));
        moveY = Math.max(0, Math.min(containerRect.height - rect.height, moveY));

        btn.style.left = moveX + "px";
        btn.style.top = moveY + "px";
        btn.style.transform = "translate(0,0)";
    }
    });

    // Hapus klik total (nggak bisa dipencet meski kejar pakai inspect element)
    btn.addEventListener("click", (e) => {
    e.preventDefault();
    alert("😜 Tombol ini tidak bisa kamu klik!");
    });

loadStats();
</script>

</script>



</body>
</html>
