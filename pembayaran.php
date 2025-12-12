<?php
// maintenance.php
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
<meta name="viewport" content="width=device-width,initial-scale=1,viewport-fit=cover" />
<title>PMB MTs Sunan Kalijaga - App</title>
<link rel="icon" type="image/png" href="assets/LOGOMADA.png">
<meta name="theme-color" content="#2563eb">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="text-center p-8 bg-white rounded-xl shadow-xl max-w-md relative overflow-hidden">
        <!-- Ilustrasi orang membongkar PC -->
        <div class="mb-6">
            <svg class="w-40 h-40 mx-auto animate-bounce" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 64 64" stroke="currentColor">
                <circle cx="32" cy="32" r="30" stroke="#F87171" stroke-width="4" class="animate-pulse"/>
                <path stroke="#F87171" stroke-width="2" d="M20 40 L44 40 L44 36 L20 36 Z" class="animate-ping"/>
                <path stroke="#F87171" stroke-width="2" d="M32 24 L32 32" />
                <path stroke="#F87171" stroke-width="2" d="M28 28 L32 32 L36 28" />
            </svg>
        </div>

        <h1 class="text-3xl font-bold mb-4 text-gray-800">Sedang Dalam Perawatan</h1>
        <p class="text-gray-600 mb-6">Fitur pembayaran sedang diperbaiki oleh tim teknisi kami. Mohon kembali lagi nanti.</p>
        
        <a href="index.php" class="inline-block bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg hover:bg-red-600 transition duration-300 ease-in-out">
            Kembali ke Beranda
        </a>
    </div>
</body>
</html>
