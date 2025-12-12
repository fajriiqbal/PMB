<?php
// maintenance.php
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maintenance</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="text-center p-8 bg-white rounded-xl shadow-lg animate-fadeIn">
        <!-- Icon atau ilustrasi -->
        <div class="mb-6">
            <svg class="w-20 h-20 mx-auto text-red-500 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M12 20c4.418 0 8-1.79 8-4s-3.582-4-8-4-8 1.79-8 4 3.582 4 8 4z"></path>
            </svg>
        </div>

        <h1 class="text-3xl font-bold mb-4 text-gray-800">Sedang Dalam Perawatan</h1>
        <p class="text-gray-600 mb-6">Fitur pembayaran sedang dalam pemeliharaan. Mohon kembali lagi nanti.</p>
        
        <!-- Tombol kembali ke homepage -->
        <a href="index.php" class="inline-block bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg hover:bg-red-600 transition duration-300 ease-in-out">
            Kembali ke Beranda
        </a>
    </div>
</body>
</html>
