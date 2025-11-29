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

  <!-- ======= SCRIPT: data + charts (dipertahankan & disesuaikan dari script kamu) ======= -->
  <script>
  const sheetURL = "https://docs.google.com/spreadsheets/d/e/2PACX-1vTkWDi-X_jfYIUpR04AupM-ubJ-hBT-RO6W9HSyIN5_n15SN_AD1vDNM4CW-GV_4EpIm-9MTgW1iLvl/pub?gid=1123091940&single=true&output=csv";

  let globalData = [];
  let genderChartInstance = null;
  let ponpesChartInstance = null;

  async function loadStats() {
      try {
          const response = await fetch(sheetURL);
          const csvText = await response.text();

          const rows = csvText.split("\n").map(r =>
              r.split(",").map(c => c.replace(/^"|"$/g, '').trim())
          );

          if (!rows || rows.length < 2) {
              console.warn("CSV kosong atau tidak valid");
              return;
          }

          const headers = rows[0].map(h => h.trim().toLowerCase());

          const colTanggal  = headers.findIndex(h => h.includes("timestamp"));
          const colSekolah   = headers.findIndex(h => h === "asal sekolah");
          const colNama      = headers.findIndex(h => h === "nama siswa");
          const colAlamat    = headers.findIndex(h => h === "alamat");
          const colGender    = headers.findIndex(h => h === "jenis kelamin");
          const colPonpes    = headers.findIndex(h => h === "pilihan pondok pesantren");
          const colHp        = headers.findIndex(h => h === "nomor hp orang tua");
          const colKK        = headers.findIndex(h => h.includes("kartu keluarga"));
          const colAkte      = headers.findIndex(h => h.includes("akte"));

          const tbody = document.getElementById("pendaftarTable");
          if (tbody) tbody.innerHTML = "";
          globalData = [];

          let total = 0;
          let male = 0, female = 0;
          let ponpesCounts = {};

          for (let i = 1; i < rows.length; i++) {
              const row = rows[i];
              if (!row) continue;

              const tanggal = row[colTanggal] || "";
              const sekolah = row[colSekolah] || "";
              const nama    = row[colNama] || "";
              const alamat  = row[colAlamat] || "";
              const gender  = (row[colGender] || "").trim().toLowerCase();
              const pondok  = row[colPonpes] || "";
              const hpRaw   = row[colHp] || "";

              if (!nama) continue;
              if (!alamat) continue;

              total++;

              // gelombang per 30 pendaftar
              let gelombang = Math.ceil(total / 30);

              let hp = hpRaw.replace(/[^0-9]/g, "");
              if (hp.startsWith("0")) hp = "62" + hp.substring(1);

              const kk   = row[colKK] || "";
              const akte = row[colAkte] || "";

              if (gender.includes("laki")) male++;
              if (gender.includes("perempuan")) female++;

              if (pondok) ponpesCounts[pondok] = (ponpesCounts[pondok] || 0) + 1;

              let statusBerkas = `<span class="text-red-500 font-bold">❌ Belum Lengkap</span>`;
              if (kk && akte) statusBerkas = `<span class="text-green-600 font-bold">✅ Lengkap</span>`;

              const pesan = `
Selamat ${nama}, Anda DITERIMA sebagai calon siswa baru.
`.trim();

              const linkWA = hp ? `https://wa.me/${hp}?text=${encodeURIComponent(pesan)}` : "";
              const contacted = localStorage.getItem("contacted_" + hp) ? "✔️" : "";

              // buat row di table global (sementara semua rows ditampilkan, filtering akan atur ulang)
              if (tbody) {
                // we will render only filtered display later; keep global table empty now to avoid duplicates
              }

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

          // update total
          document.getElementById("totalSiswa").textContent = total;

          // optional: count WA marked
          const waCount = Array.from({length: globalData.length}).reduce((acc, _, idx) => {
            const h = globalData[idx]?.hp || "";
            return acc + (localStorage.getItem("contacted_" + h) ? 1 : 0);
          }, 0);
          document.getElementById("waCount").textContent = waCount;

          // top pondok
          const topPonpes = Object.entries(ponpesCounts).sort((a,b)=>b[1]-a[1])[0];
          document.getElementById("topPonpes").textContent = topPonpes ? `${topPonpes[0]} (${topPonpes[1]})` : "-";

          // initial render: show all
          renderTable(globalData);
          drawCharts(globalData);
          setupFilter(globalData);

      } catch (err) {
          console.error("Gagal memuat data:", err);
      }
  }

  function markContacted(num) {
      localStorage.setItem("contacted_" + num, true);
      // refresh WA count
      const waCount = globalData.reduce((acc, d) => acc + (localStorage.getItem("contacted_"+d.hp) ? 1 : 0), 0);
      document.getElementById("waCount").textContent = waCount;
  }

  function drawCharts(data) {
      let male = 0, female = 0;
      let ponpesCounts = {};

      data.forEach(d => {
          const g = d.gender || "";
          if (g.includes("laki")) male++;
          if (g.includes("perempuan")) female++;

          if (d.pondok) ponpesCounts[d.pondok] = (ponpesCounts[d.pondok] || 0) + 1;
      });

      if (genderChartInstance) genderChartInstance.destroy();
      if (ponpesChartInstance) ponpesChartInstance.destroy();

      const ctxG = document.getElementById("genderChart").getContext("2d");
      genderChartInstance = new Chart(ctxG, {
          type: "doughnut",
          data: {
              labels: ["Laki-Laki", "Perempuan"],
              datasets: [{ data: [male, female], backgroundColor: ["#2563eb","#ec4899"] }]
          },
          options: { responsive:true, maintainAspectRatio:false }
      });

      const ctxP = document.getElementById("ponpesChart").getContext("2d");
      ponpesChartInstance = new Chart(ctxP, {
          type: "doughnut",
          data: {
              labels: Object.keys(ponpesCounts),
              datasets: [{ data: Object.values(ponpesCounts), backgroundColor: ["#10b981","#f59e0b","#3b82f6","#ef4444","#8b5cf6"] }]
          },
          options: { responsive:true, maintainAspectRatio:false }
      });
  }

  // render table with nomor reset per view
  function renderTable(data) {
      const tbody = document.getElementById("pendaftarTable");
      tbody.innerHTML = "";

      data.forEach((d, i) => {
          const contacted = localStorage.getItem("contacted_" + d.hp) ? "✔️" : "";
          const tr = document.createElement("tr");
          tr.innerHTML = `
              <td>${i + 1}</td>
              <td>${escapeHtml(d.sekolah)}</td>
              <td>${escapeHtml(d.nama)}</td>
              <td>${escapeHtml(d.alamat)}</td>
              <td>${escapeHtml(d.gender)}</td>
              <td>${escapeHtml(d.pondok)}</td>
              <td>${escapeHtml(d.hp)}</td>
              <td>${d.statusBerkas}</td>
              <td>${d.hp ? `<a href="${d.linkWA}" target="_blank" class="inline-block px-2 py-1 rounded bg-green-500 text-white text-xs" onclick="markContacted('${d.hp}')">Hubungi</a>` : "-"} ${contacted}</td>
          `;
          tbody.appendChild(tr);
      });

      // update filtered total display (card or elsewhere)
      const totalFiltered = data.length;
      // if you want to show total filtered in a separate element, you can add it; currently totalAll is totalSiswa
  }

  function setupFilter(allData) {
      const filter = document.getElementById("gelombangFilter");
      if (!filter) return;
      filter.addEventListener("change", () => {
          const val = filter.value;
          const filtered = val === "all" ? allData : allData.filter(d => String(d.gelombang) === String(val));
          renderTable(filtered);
          drawCharts(filtered);
      });

      // also setup search
      const search = document.getElementById("searchInput");
      if (search) {
          search.addEventListener("keyup", () => {
              const q = search.value.trim().toLowerCase();
              const rows = allData.filter(d => {
                  return (d.nama || "").toLowerCase().includes(q) ||
                         (d.sekolah || "").toLowerCase().includes(q) ||
                         (d.alamat || "").toLowerCase().includes(q) ||
                         (d.pondok || "").toLowerCase().includes(q);
              });
              renderTable(rows);
              drawCharts(rows);
          });
      }
  }

  // small helper to avoid XSS injection when injecting plain text into table cells
  function escapeHtml(text) {
      if (!text) return "";
      return String(text)
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
  }

  // initial load
  loadStats();
  </script>

</body>
</html>
