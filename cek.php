<header class="sticky top-0 z-50 bg-white shadow-sm">
            <div class="container mx-auto px-4 py-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        
                           <?php echo '<img src="assets/LOGOMADA.png" alt="Logo" width="100">'; ?>

                       
                        <h1 class="ml-3 text-xl font-bold text-gray-800"><?php echo $schoolName; ?></h1>
                    </div>

                    <!-- Desktop Navigation -->
                    <nav class="hidden md:flex items-center space-x-6">
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
                    </nav>

                    <!-- Mobile menu button -->
                    <button 
                        class="md:hidden text-gray-600 mobile-menu-btn"
                        onclick="toggleMobileMenu()"
                    >
                        <?php echo renderIcon('menu'); ?>
                    </button>
                </div>

                <!-- Mobile Navigation -->
                <div id="mobileMenu" class="hidden mt-4 md:hidden border-t pt-4">
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
                </div>
            </div>
        </header>

        <!-- Hero Section -->
        <section class="py-12 md:py-20 animate-fade-in">
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
        </section>

        <!-- Information Section -->
        <section id="info" class="py-12 bg-white">
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
        </section>

        <!-- Key Dates Section -->
        <section id="dates" class="py-12 bg-gray-50">
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
        </section>

        <!-- Announcements Section -->
        <section id="announcements" class="py-12 bg-white">
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
        </section>

        <!-- CTA Section -->
        <section class="py-16 bg-blue-600 text-white">
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
                const sheetURL = "https://docs.google.com/spreadsheets/d/e/2PACX-1vTkWDi-X_jfYIUpR04AupM-ubJ-hBT-RO6W9HSyIN5_n15SN_AD1vDNM4CW-GV_4EpIm-9MTgW1iLvl/pub?gid=1123091940&single=true&output=csv";
        </section>