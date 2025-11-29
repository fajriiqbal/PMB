<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>PMB MTs Sunan Kalijaga - Dashboard</title>
  <link rel="icon" type="image/png" href="assets/LOGOMADA.png">

  <!-- Tailwind + Chart.js -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <style>
    /* --- Global --- */
    body { font-family: Inter, ui-sans-serif, system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial; background: #f3f6fb; }
    .app-container { min-height: 100vh; display: flex; }

    /* --- Sidebar --- */
    .sidebar {
      width: 260px;
      background: linear-gradient(180deg,#ffffff 0%, #f8fbff 100%);
      box-shadow: 0 8px 30px rgba(2,6,23,0.06);
      border-right: 1px solid rgba(15,23,42,0.03);
    }
    .sidebar .brand { padding: 20px; }
    .sidebar .nav a { display:flex; gap:12px; align-items:center; padding:12px 18px; border-radius:10px; color:#1f2937; text-decoration:none; font-weight:600; }
    .sidebar .nav a:hover { background:#eef2ff; color:#1e3a8a; }

    /* --- Topbar --- */
    .topbar { background: white; padding: 14px 20px; display:flex; justify-content:space-between; align-items:center; box-shadow: 0 4px 18px rgba(2,6,23,0.04); }

    /* --- Main content --- */
    .main { flex:1; padding:22px; }

    /* --- Cards grid --- */
    .cards { display:grid; grid-template-columns: repeat(4,1fr); gap:18px; margin-bottom:18px; }
    .card {
      background:white; padding:18px; border-radius:12px;
      box-shadow: 0 6px 18px rgba(2,6,23,0.06);
      transition: transform .18s ease, box-shadow .18s ease;
    }
    .card:hover { transform: translateY(-6px); box-shadow: 0 10px 26px rgba(2,6,23,0.08); }
    .card .label { color:#475569; font-weight:700; font-size:13px; }
    .card .value { font-weight:800; font-size:26px; color:#0f172a; margin-top:8px; }

    /* --- Chart area --- */
    .charts { display:grid; grid-template-columns: 1fr 1fr; gap:18px; margin-bottom:18px; }
    .chart-card { background:white; padding:18px; border-radius:12px; box-shadow: 0 6px 18px rgba(2,6,23,0.06); }

    /* --- Filter/Search --- */
    .controls { display:flex; gap:12px; align-items:center; flex-wrap:wrap; margin-bottom:14px; }
    .controls input, .controls select { padding:10px 12px; border-radius:8px; border:1px solid #e6edf6; background:white; min-width:200px; }

    /* --- Table --- */
    .table-wrap { background:transparent; border-radius:12px; overflow:hidden; box-shadow: 0 8px 24px rgba(2,6,23,0.04); }
    .table-scroll { overflow-x:auto; }
    table { width:100%; border-collapse:collapse; min-width:980px; }
    thead th { background: linear-gradient(90deg,#2563eb,#7c3aed); color:white; padding:12px 14px; text-align:left; font-size:13px; }
    tbody td { padding:12px 14px; background:white; border-bottom:1px solid #f1f5f9; color:#0f172a; font-size:14px; }
    tbody tr:hover td { background:#f8fbff; }

    /* --- Mobile responsive --- */
    @media (max-width: 1024px) {
      .cards { grid-template-columns: repeat(2,1fr); }
      .charts { grid-template-columns: 1fr; }
    }
    @media (max-width: 640px) {
      .sidebar { position:fixed; left:-100%; top:0; bottom:0; z-index:40; transition: left .22s ease; }
      .sidebar.open { left:0; }
      .cards { grid-template-columns: 1fr; }
      .topbar { padding:10px; }
      .main { padding:12px; }
      table { min-width: 800px; }
      .controls input, .controls select { min-width: 100%; }
    }

    /* floating action */
    .floating-button {
      position: fixed; bottom:24px; right:24px; z-index:60;
      width:56px; height:56px; border-radius:12px; background:#2563eb; color:white;
      display:flex; align-items:center; justify-content:center; box-shadow: 0 8px 24px rgba(37,99,235,0.18);
    }

  </style>
</head>

<body>
  <div class="app-container">
    <!-- SIDEBAR -->
    <aside id="sidebar" class="sidebar hidden md:block">
      <div class="brand border-b">
        <div class="px-6 py-5">
          <div class="flex items-center gap-3">
            <img src="assets/LOGOMADA.png" alt="logo" class="h-10 w-10 rounded-full object-cover" />
            <div>
              <div class="text-lg font-bold text-blue-700">PMB MTs Sunan Kalijaga</div>
              <div class="text-xs text-slate-400">Admin Dashboard</div>
            </div>
          </div>
        </div>
      </div>

      <nav class="nav p-4 space-y-2">
        <a href="#stats" class="block">📊 Statistik</a>
        <a href="#pendaftar" class="block">🧾 Data Pendaftar</a>
        <a href="#" class="block">⚙️ Pengaturan</a>
      </nav>

      <div class="px-6 py-4 border-t mt-6 text-sm text-slate-500">
        <div>Kontak: 082241509229</div>
        <div class="mt-2">Email: mtssunankalijaga01@gmail.com</div>
      </div>
    </aside>

    <!-- MAIN -->
    <div class="flex-1 md:ml-64">
      <!-- TOPBAR -->
      <header class="topbar">
        <div class="flex items-center gap-3">
          <button id="menuBtn" class="md:hidden p-2 rounded bg-white shadow" aria-label="menu">
            ☰
          </button>
          <div>
            <div class="text-sm text-slate-500">Selamat datang, Admin</div>
            <div class="text-lg font-bold text-slate-800">Dashboard Penerimaan Siswa</div>
          </div>
        </div>

        <div class="flex items-center gap-3">
          <div class="hidden sm:block text-sm text-slate-600">Pengelolaan Penerimaan</div>
        </div>
      </header>

      <main class="main">

        <!-- CARDS -->
        <section class="cards">
          <div class="card">
            <div class="label">Total Siswa Terdaftar</div>
            <div id="totalSiswa" class="value">0</div>
            <div class="text-xs text-slate-400 mt-2">Jumlah pendaftar saat ini</div>
          </div>

          <div class="card">
            <div class="label">Kuota per Gelombang</div>
            <div class="value">30</div>
            <div class="text-xs text-slate-400 mt-2">Setiap gelombang 30 siswa</div>
          </div>

          <div class="card">
            <div class="label">Terhubung via WA</div>
            <div id="waCount" class="value">0</div>
            <div class="text-xs text-slate-400 mt-2">Jumlah kontak yang ditandai</div>
          </div>

          <div class="card">
            <div class="label">Pilihan Pondok Teratas</div>
            <div id="topPonpes" class="value">-</div>
            <div class="text-xs text-slate-400 mt-2">Pondok dengan pendaftar terbanyak</div>
          </div>
        </section>

        <!-- CHARTS -->
        <section id="stats" class="charts">
          <div class="chart-card">
            <div class="flex items-center justify-between mb-3">
              <div>
                <div class="font-semibold text-slate-700">Jenis Kelamin</div>
                <div class="text-sm text-slate-400">Distribusi pendaftar</div>
              </div>
            </div>
            <canvas id="genderChart"></canvas>
          </div>

          <div class="chart-card">
            <div class="flex items-center justify-between mb-3">
              <div>
                <div class="font-semibold text-slate-700">Pilihan Pondok</div>
                <div class="text-sm text-slate-400">Preferensi pondok pesantren</div>
              </div>
            </div>
            <canvas id="ponpesChart"></canvas>
          </div>
        </section>

        <!-- FILTER + SEARCH -->
        <section id="pendaftar" class="mt-6">
          <div class="flex items-start justify-between mb-4 gap-4 flex-wrap">
            <div class="controls">
              <input type="text" id="searchInput" placeholder="Cari siswa..." class="border p-2 rounded-md shadow-sm" />
            </div>

            <div class="flex gap-3 items-center">
              <label class="text-sm text-slate-600">Pilih Gelombang</label>
              <select id="gelombangFilter" class="border p-2 rounded-md">
                <option value="all">Semua Gelombang</option>
                <option value="1">Gelombang 1 (1–30)</option>
                <option value="2">Gelombang 2 (31–60)</option>
                <option value="3">Gelombang 3 (61–90)</option>
              </select>
            </div>
          </div>

          <!-- TABLE -->
          <div class="table-scroll">
            <div class="table-wrap">
              <table>
                <thead>
                  <tr>
                    <th>Nomor</th>
                    <th>Asal Sekolah</th>
                    <th>Nama</th>
                    <th>Alamat</th>
                    <th>Jenis Kelamin</th>
                    <th>Pilihan Pondok</th>
                    <th>Nomor HP</th>
                    <th>Status Berkas</th>
                    <th>Kontak</th>
                  </tr>
                </thead>
                <tbody id="pendaftarTable">
                  <!-- Data diisi oleh JS -->
                </tbody>
              </table>
            </div>
          </div>

        </section>

      </main>
    </div>
  </div>

  <!-- Floating button (contoh: cepat ke form pendaftaran) -->
  <a href="https://docs.google.com/forms" target="_blank" class="floating-button hidden md:flex" title="Form Pendaftaran">
    ✚
  </a>

  <!-- Mobile menu overlay / script -->
  <script>
    const sidebar = document.getElementById('sidebar');
    const menuBtn = document.getElementById('menuBtn');
    if (menuBtn) {
      menuBtn.addEventListener('click', () => {
        sidebar.classList.toggle('open');
      });
      // close when clicking outside on mobile
      document.addEventListener('click', (e) => {
        if (window.innerWidth <= 640) {
          if (!sidebar.contains(e.target) && !menuBtn.contains(e.target) && sidebar.classList.contains('open')) {
            sidebar.classList.remove('open');
          }
        }
      });
    }
  </script>
  <script>
const sheetURL = "https://docs.google.com/spreadsheets/d/e/2PACX-1vTkWDi-X_jfYIUpR04AupM-ubJ-hBT-RO6W9HSyIN5_n15SN_AD1vDNM4CW-GV_4EpIm-9MTgW1iLvl/pub?gid=1123091940&single=true&output=csv";

let globalData = []; 
let genderChartInstance = null;
let ponpesChartInstance = null;

async function loadStats() {
    const response = await fetch(sheetURL);
    const csvText = await response.text();

    const rows = csvText.split("\n").map(r =>
        r.split(",").map(c => c.replace(/^"|"$/g, '').trim())
    );

    const headers = rows[0].map(h => h.trim());

    const colTanggal  = headers.findIndex(h => h.toLowerCase().includes("timestamp"));
    const colSekolah   = headers.findIndex(h => h.toLowerCase() === "asal sekolah");
    const colNama      = headers.findIndex(h => h.toLowerCase() === "nama siswa");
    const colAlamat    = headers.findIndex(h => h.toLowerCase() === "alamat");
    const colGender    = headers.findIndex(h => h.toLowerCase() === "jenis kelamin");
    const colPonpes    = headers.findIndex(h => h.toLowerCase() === "pilihan pondok pesantren");
    const colHp        = headers.findIndex(h => h.toLowerCase() === "nomor hp orang tua");
    const colKK        = headers.findIndex(h => h.toLowerCase().includes("kartu keluarga"));
    const colAkte      = headers.findIndex(h => h.toLowerCase().includes("akte"));

    let total = 0;
    let male = 0, female = 0;
    let ponpesCounts = {};

    const tbody = document.getElementById("pendaftarTable");
    if (tbody) tbody.innerHTML = "";
    globalData = [];

    for (let i = 1; i < rows.length; i++) {

        const tanggal = rows[i][colTanggal] || "";
        const sekolah = rows[i][colSekolah] || "";
        const nama    = rows[i][colNama] || "";
        const alamat  = rows[i][colAlamat] || "";
        const gender  = (rows[i][colGender] || "").trim().toLowerCase();
        const pondok  = rows[i][colPonpes] || "";
        const hpRaw   = rows[i][colHp] || "";

        if (!nama) continue;
        if (!alamat) continue;

        total++;

        // Tentukan gelombang berdasarkan nomor urut (per 30)
        let gelombang = Math.ceil(total / 30);

        let hp = hpRaw.replace(/[^0-9]/g, "");
        if (hp.startsWith("0")) hp = "62" + hp.substring(1);

        const kk   = rows[i][colKK] || "";
        const akte = rows[i][colAkte] || "";

        if (gender.includes("laki")) male++;
        if (gender.includes("perempuan")) female++;

        if (pondok) {
            ponpesCounts[pondok] = (ponpesCounts[pondok] || 0) + 1;
        }

        let statusBerkas = `<span class="text-red-500 font-bold">❌ Belum Lengkap</span>`;
        if (kk && akte) statusBerkas = `<span class="text-green-600 font-bold">✅ Lengkap</span>`;

        // Pesan WA
        const pesan = `
        Selamat ${nama}, Anda DITERIMA sebagai calon siswa baru.
        `.trim();

        const linkWA = hp ? `https://wa.me/${hp}?text=${encodeURIComponent(pesan)}` : "";
        const contacted = localStorage.getItem("contacted_" + hp) ? "✔️" : "";

        if (tbody) {
            let tr = document.createElement("tr");
            tr.innerHTML = `
                <td class="border px-4 py-2">${total}</td>
                <td class="border px-4 py-2">${sekolah}</td>
                <td class="border px-4 py-2">${nama}</td>
                <td class="border px-4 py-2">${alamat}</td>
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

        // Simpan data lengkap + gelombang
        globalData.push({
            nomor: total,
            gelombang,
            tanggal,
            sekolah,
            nama,
            alamat,
            gender,
            pondok,
            hp,
            linkWA,
            statusBerkas
        });
    }

    document.getElementById("totalSiswa").textContent = `Total Siswa Terdaftar: ${total}`;

    drawCharts(globalData); 
    setupFilter(globalData);
}

function markContacted(num) {
    localStorage.setItem("contacted_" + num, true);
}

function drawCharts(data) {
    let male = 0, female = 0;
    let ponpesCounts = {};

    data.forEach(d => {
        const g = d.gender.toLowerCase();
        if (g.includes("laki")) male++;
        if (g.includes("perempuan")) female++;

        ponpesCounts[d.pondok] = (ponpesCounts[d.pondok] || 0) + 1;
    });

    if (genderChartInstance) genderChartInstance.destroy();
    if (ponpesChartInstance) ponpesChartInstance.destroy();

    genderChartInstance = new Chart(document.getElementById("genderChart"), {
        type: "doughnut",
        data: {
            labels: ["Laki-Laki", "Perempuan"],
            datasets: [{
                data: [male, female],
                backgroundColor: ["#3b82f6", "#ec4899"]
            }]
        }
    });

    ponpesChartInstance = new Chart(document.getElementById("ponpesChart"), {
        type: "doughnut",
        data: {
            labels: Object.keys(ponpesCounts),
            datasets: [{
                data: Object.values(ponpesCounts),
                backgroundColor: ["#10b981", "#f59e0b", "#3b82f6", "#ef4444", "#8b5cf6"]
            }]
        }
    });
}

function setupFilter(allData) {
    document.getElementById("gelombangFilter").addEventListener("change", function () {
        const val = this.value;

        let filtered = 
            val === "all" 
            ? allData 
            : allData.filter(d => d.gelombang == val);

        renderTable(filtered);
        drawCharts(filtered); 
    });
}

function renderTable(data) {
    const tbody = document.getElementById("pendaftarTable");
    tbody.innerHTML = "";

    data.forEach((d, i) => {
        const contacted = localStorage.getItem("contacted_" + d.hp) ? "✔️" : "";

        const tr = document.createElement("tr");
        tr.innerHTML = `
            <td class="border px-4 py-2">${i + 1}</td>
            <td class="border px-4 py-2">${d.sekolah}</td>
            <td class="border px-4 py-2">${d.nama}</td>
            <td class="border px-4 py-2">${d.alamat}</td>
            <td class="border px-4 py-2">${d.gender}</td>
            <td class="border px-4 py-2">${d.pondok}</td>
            <td class="border px-4 py-2">${d.hp}</td>
            <td class="border px-4 py-2">${d.statusBerkas}</td>
            <td class="border px-4 py-2">
                ${d.hp ? `<a href="${d.linkWA}" target="_blank" class="bg-green-500 text-white px-3 py-1 rounded" onclick="markContacted('${d.hp}')">Hubungi</a>` : "-"} ${contacted}
            </td>
        `;
        tbody.appendChild(tr);
    });
}

loadStats();
</script>





</body>
</html>
