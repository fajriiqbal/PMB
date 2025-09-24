<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Fitur Dalam Pengembangan</title>
  <style>
    body {
      margin: 0;
      padding: 0;
      font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
      background: linear-gradient(135deg, #667eea, #764ba2);
      color: white;
      height: 100vh;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      text-align: center;
    }

    h1 {
      font-size: 3rem;
      margin-bottom: 10px;
      animation: fadeIn 1.5s ease-in-out;
    }

    p {
      font-size: 1.2rem;
      margin-bottom: 20px;
      animation: fadeIn 2s ease-in-out;
    }

    .loader {
      border: 8px solid rgba(255, 255, 255, 0.3);
      border-top: 8px solid #fff;
      border-radius: 50%;
      width: 70px;
      height: 70px;
      animation: spin 1.5s linear infinite;
      margin-bottom: 20px;
    }

    @keyframes spin {
      0%   { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to   { opacity: 1; transform: translateY(0); }
    }

    .btn-home {
      padding: 10px 20px;
      font-size: 1rem;
      background: #fff;
      color: #764ba2;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      text-decoration: none;
      transition: 0.3s;
    }

    .btn-home:hover {
      background: #f1f1f1;
      transform: scale(1.05);
    }
  </style>
</head>
<body>
  <div class="loader"></div>
  <h1>🚧 Fitur Dalam Pengembangan 🚧</h1>
  <p>Halaman ini sedang dalam tahap pengembangan.<br>
     Nantikan update terbaru dari sistem pendaftaran MTs Sunan Kalijaga Tulung.</p>
  <a href="index.html" class="btn-home">⬅ Kembali ke Beranda</a>
</body>
</html>
