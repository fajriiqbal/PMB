<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1,viewport-fit=cover" />
  <title>PMB MTs Sunan Kalijaga - App View</title>
  <link rel="icon" type="image/png" href="assets/LOGOMADA.png">
  <meta name="theme-color" content="#2563eb">

  <!-- Tailwind (optional utilities) + Chart.js -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <style>
    /* Mobile-app fullscreen look (mobile-first) */
    :root {
      --accent: #2563eb;
      --bg: #f3f6fb;
      --card: #ffffff;
      --muted: #64748b;
    }

    html, body {
      height: 100%;
      margin: 0;
      -webkit-font-smoothing:antialiased;
      font-family: Inter, system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
      background: var(--bg);
      color: #0f172a;
    }

    /* App container: header fixed, footer fixed, main scrollable */
    header.appbar {
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      height: 64px;
      padding: 12px 16px;
      background: linear-gradient(90deg, #ffffff, #f8fbff);
      display:flex;
      align-items:center;
      justify-content:space-between;
      box-shadow: 0 4px 16px rgba(2,6,23,0.06);
      z-index: 40;
      border-bottom: 1px solid rgba(15,23,42,0.03);
    }
    header.appbar .title { font-weight:700; font-size:16px; }
    header.appbar .subtitle { font-size:12px; color:var(--muted); }

    main.app-main {
      padding-top: 80px; /* space for fixed header */
      padding-bottom: 86px; /* space for bottom nav */
      max-width: 1000px;
      margin: 0 auto;
    }

    .container { padding-left: 16px; padding-right: 16px; }

    /* Cards */
    .cards {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 12px;
    }
    .card {
      background: var(--card);
      border-radius: 14px;
      padding: 12px;
      box-shadow: 0 6px 18px rgba(2,6,23,0.05);
    }
    .card .label { font-weight:700; color:var(--muted); font-size:12px; }
    .card .value { font-weight:800; font-size:20px; margin-top:6px; }

    /* charts */
    .charts {
      margin-top:10px;
      display:grid;
      grid-template-columns: 1fr;
      gap:12px;
    }
    .chart-card {
      background: var(--card);
      border-radius: 12px;
      padding: 12px;
      min-height: 220px;
      box-shadow: 0 6px 18px rgba(2,6,23,0.05);
    }
    .chart-card .head { display:flex; justify-content:space-between; align-items:center; margin-bottom:8px; }
    .chart-card canvas { width:100% !important; height:200px !important; }

    /* filter + search */
    .controls {
      margin-top:12px;
      display:flex;
      gap:8px;
      align-items:center;
      flex-wrap:wrap;
    }
    .controls input, .controls select {
      padding:10px 12px;
      border-radius:10px;
      border:1px solid #e6edf6;
      background:white;
      min-width: calc(50% - 8px);
    }

    /* table */
    .table-wrap {
      margin-top:12px;
      border-radius:12px;
      overflow:hidden;
      box-shadow: 0 8px 24px rgba(2,6,23,0.04);
    }
    .table-scroll { overflow-x:auto; }
    table { width:100%; border-collapse: collapse; min-width:760px; }
    thead th { background: var(--accent); color:white; padding:10px 12px; text-align:left; font-size:12px; }
    tbody td { padding:10px 12px; background:var(--card); border-bottom:1px solid #f1f5f9; font-size:13px; }
    tbody tr:hover td { background:#f8fbff; }

    /* bottom navigation (app-like) */
    nav.bottom-nav {
      position: fixed;
      left: 12px;
      right: 12px;
      bottom: 12px;
      height: 64px;
      background: linear-gradient(180deg, #ffffff, #fbfdff);
      border-radius: 16px;
      box-shadow: 0 12px 30px rgba(2,6,23,0.12);
      display:flex;
      align-items:center;
      justify-content:space-around;
      z-index:50;
      border: 1px solid rgba(15,23,42,0.03);
    }
    nav.bottom-nav a {
      display:flex;
      flex-direction:column;
      align-items:center;
      justify-content:center;
      gap:4px;
      color:#475569;
      text-decoration:none;
      font-size:12px;
      width: 20%;
    }
    nav.bottom-nav a.active { color: var(--accent); font-weight:700; }

    /* FAB */
    .fab {
      position: fixed;
      right: 28px;
      bottom: 86px;
      width:56px;
      height:56px;
      border-radius:14px;
      background: var(--accent);
      color:white;
      display:flex;
      align-items:center;
      justify-content:center;
      box-shadow: 0 12px 30px rgba(37,99,235,0.18);
      z-index:55;
      text-decoration:none;
      font-size:22px;
    }

    /* responsive adjustments */
    @media (min-width: 768px) {
      .cards { grid-template-columns: repeat(4, 1fr); }
      .charts { grid-template-columns: repeat(2, 1fr); }
      .chart-card canvas { height: 260px !important; }
      nav.bottom-nav { left: calc(50% - 240px); right: calc(50% - 240px); width: 480px; }
      .fab { right: calc(50% - 240px); bottom: 86px; }
    }

  </style>
</head>
<body>

  <!-- header (fixed) -->
  <header class="appbar">
    <div>
      <div class="title">PMB MTs Sunan Kalijaga</div>
      <div class="subtitle">Admin Dashboard • Tampilan Aplikasi</div>
    </div>
    <div>
      <img src="assets/LOGOMADA.png" alt="logo" class="h-10 w-10 rounded-full object-cover" />
    </div>
  </header>

  <!-- main scrollable content -->
  <main class="app-main">
    <div class="container">

      <!-- cards -->
      <section class="cards" aria-label="stat-cards">
        <div class="card">
          <div class="label">Total Siswa Terdaftar</div>
          <div id="totalSiswa" class="value">0</div>
          <div class="text-sm text-gray-400 mt-2">Jumlah pendaftar saat ini</div>
        </div>

        <div class="card">
          <div class="label">Kuota per Gelombang</div>
          <div class="value">30</div>
          <div class="text-sm text-gray-400 mt-2">Setiap gelombang 30 siswa</div>
        </div>

        <div class="card">
          <div class="label">Terhubung via WA</div>
          <div id="waCount" class="value">0</div>
          <div class="text-sm text-gray-400 mt-2">Jumlah kontak yang ditandai</div>
        </div>

        <div class="card">
          <div class="label">Pilihan Pondok Teratas</div>
          <div id="topPonpes" class="value">-</div>
          <div class="text-sm text-gray-400 mt-2">Pondok dengan pendaftar terbanyak</div>
        </div>
      </section>

      <!-- charts -->
      <section class="charts" id="stats">
        <div class="chart-card" role="region" aria-label="chart-gender">
          <div class="head">
            <div>
              <div class="font-semibold">Jenis Kelamin</div>
              <div class="text-sm text-gray-400">Distribusi pendaftar</div>
            </div>
          </div>
          <canvas id="genderChart"></canvas>
        </div>

        <div class="chart-card" role="region" aria-label="chart-ponpes">
          <div class="head">
            <div>
              <div class="font-semibold">Pilihan Pondok</div>
              <div class="text-sm text-gray-400">Preferensi pondok pesantren</div>
            </div>
          </div>
          <canvas id="ponpesChart"></canvas>
        </div>
      </section>

      <!-- filter + search -->
      <section id="pendaftar" class="mt-4">
        <div class="flex items-start justify-between mb-4 gap-3 flex-wrap">
          <div class="controls" style="flex:1;">
            <input type="text" id="searchInput" placeholder="Cari siswa, asal sekolah, alamat, pondok..." />
          </div>

          <div style="display:flex; gap:8px; align-items:center;">
            <label class="text-sm text-gray-600">Pilih Gelombang</label>
            <select id="gelombangFilter">
              <option value="all">Semua Gelombang</option>
              <option value="1">Gelombang 1 (1–30)</option>
              <option value="2">Gelombang 2 (31–60)</option>
              <option value="3">Gelombang 3 (61–90)</option>
            </select>
          </div>
        </div>

        <!-- table -->
        <div class="table-scroll">
          <div class="table-wrap">
            <table aria-describedby="Data pendaftar">
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

    </div>
  </main>

  <!-- Floating Action Button -->
  <a href="https://docs.google.com/forms" target="_blank" class="fab" title="Form Pendaftaran">＋</a>

  <!-- Bottom navigation -->
  <nav class="bottom-nav" aria-label="bottom-navigation">
    <a href="#" id="navHome" class="active" onclick="scrollToSection('stats'); return false;">
      <div>🏠</div><div>Home</div>
    </a>
    <a href="#" id="navStats" onclick="scrollToSection('stats'); return false;">
      <div>📊</div><div>Statistik</div>
    </a>
    <a href="#" id="navData" onclick="scrollToSection('pendaftar'); return false;">
      <div>🧾</div><div>Data</div>
    </a>
    <a href="#" id="navMore" onclick="alert('Menu tambahan'); return false;">
      <div>⚙️</div><div>Lainnya</div>
    </a>
  </nav>

  <!-- ====== SCRIPT: data + charts (preserve fitur Anda) ====== -->
  <script>
  const sheetURL = "https://docs.google.com/spreadsheets/d/e/2PACX-1vTkWDi-X_jfYIUpR04AupM-ubJ-hBT-RO6W9HSyIN5_n15SN_AD1vDNM4CW-GV_4EpIm-9MTgW1iLvl/pub?gid=1123091940&single=true&output=csv";

  let globalData = [];
  let genderChartInstance = null;
  let ponpesChartInstance = null;

  // Escape text helper
  function escapeHtml(text) {
      if (!text && text !== 0) return "";
      return String(text)
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
  }

  // Load CSV data and parse
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

          globalData = [];
          let total = 0;

          for (let i = 1; i < rows.length; i++) {
              const row = rows[i];
              if (!row) continue;

              const tanggal = row[colTanggal] || "";
              const sekolah = row[colSekolah] || "";
              const nama    = row[colNama] || "";
              const alamat  = row[colAlamat] || "";
              const gender  = (row[colGender] || "").trim();
              const pondok  = row[colPonpes] || "";
              const hpRaw   = row[colHp] || "";

              if (!nama) continue;
              if (!alamat) continue;

              total++;

              let gelombang = Math.ceil(total / 30);

              let hp = (hpRaw || "").replace(/[^0-9]/g, "");
              if (hp.startsWith("0")) hp = "62" + hp.substring(1);

              const kk   = row[colKK] || "";
              const akte = row[colAkte] || "";

              let statusBerkas = `<span style="color:#ef4444;font-weight:700">❌ Belum Lengkap</span>`;
              if (kk && akte) statusBerkas = `<span style="color:#16a34a;font-weight:700">✅ Lengkap</span>`;

              const pesan = `Selamat ${nama}, Anda DITERIMA sebagai calon siswa baru.`;
              const linkWA = hp ? `https://wa.me/${hp}?text=${encodeURIComponent(pesan)}` : "";

              globalData.push({
                  nomor: total,
                  gelombang,
                  tanggal,
                  sekolah,
                  nama,
                  alamat,
                  gender: (gender || ""),
                  pondok: (pondok || ""),
                  hp,
                  hpRaw,
                  linkWA,
                  statusBerkas
              });
          }

          // update stat cards
          document.getElementById("totalSiswa").textContent = globalData.length;
          const waCount = globalData.reduce((acc,d)=> acc + (localStorage.getItem("contacted_"+d.hp) ? 1 : 0), 0);
          document.getElementById("waCount").textContent = waCount || 0;

          const ponpesCounts = {};
          globalData.forEach(d => { if (d.pondok) ponpesCounts[d.pondok] = (ponpesCounts[d.pondok] || 0) + 1; });
          const topPonpes = Object.entries(ponpesCounts).sort((a,b)=>b[1]-a[1])[0];
          document.getElementById("topPonpes").textContent = topPonpes ? `${topPonpes[0]} (${topPonpes[1]})` : "-";

          // render initial
          renderTable(globalData);
          drawCharts(globalData);
          setupFilter(globalData);
          setupSearch(globalData);

      } catch (err) {
          console.error("Gagal memuat data:", err);
      }
  }

  // mark contacted
  function markContacted(num) {
      localStorage.setItem("contacted_" + num, true);
      const waCount = globalData.reduce((acc,d) => acc + (localStorage.getItem("contacted_"+d.hp) ? 1 : 0), 0);
      document.getElementById("waCount").textContent = waCount;
  }

  // draw bar charts
  function drawCharts(data) {
      let male = 0, female = 0;
      let ponpesCounts = {};

      data.forEach(d => {
          const g = (d.gender || "").toLowerCase();
          if (g.includes("laki")) male++;
          else if (g.includes("perempuan")) female++;

          const key = d.pondok && d.pondok.trim() ? d.pondok : "Non Pondok";
          ponpesCounts[key] = (ponpesCounts[key] || 0) + 1;
      });

      if (genderChartInstance) genderChartInstance.destroy();
      if (ponpesChartInstance) ponpesChartInstance.destroy();

      const ctxG = document.getElementById("genderChart").getContext("2d");
      genderChartInstance = new Chart(ctxG, {
          type: "bar",
          data: {
              labels: ["Laki-Laki", "Perempuan"],
              datasets: [{
                  label: "Jumlah",
                  data: [male, female],
                  backgroundColor: ["#2563eb", "#ec4899"],
                  borderRadius: 8
              }]
          },
          options: {
              responsive: true,
              maintainAspectRatio: false,
              scales: { y: { beginAtZero: true, ticks: { precision:0 } } },
              plugins: { legend: { display: false } }
          }
      });

      const ctxP = document.getElementById("ponpesChart").getContext("2d");
      ponpesChartInstance = new Chart(ctxP, {
          type: "bar",
          data: {
              labels: Object.keys(ponpesCounts),
              datasets: [{
                  label: "Pendaftar",
                  data: Object.values(ponpesCounts),
                  backgroundColor: Object.keys(ponpesCounts).map((_,i) => {
                    const palette = ["#10b981","#f59e0b","#3b82f6","#ef4444","#8b5cf6","#06b6d4","#f97316"];
                    return palette[i % palette.length];
                  }),
                  borderRadius: 6
              }]
          },
          options: {
              responsive: true,
              maintainAspectRatio: false,
              scales: { y: { beginAtZero: true, ticks: { precision:0 } } },
              plugins: { legend: { display: false } }
          }
      });
  }

  // render table; nomor start from 1 per view
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
              <td>${escapeHtml(d.hpRaw || d.hp)}</td>
              <td>${d.statusBerkas}</td>
              <td>${d.hp ? `<a href="${d.linkWA}" target="_blank" class="inline-block px-3 py-1 rounded bg-green-500 text-white text-xs" onclick="markContacted('${d.hp}')">Hubungi</a>` : "-"} ${contacted}</td>
          `;
          tbody.appendChild(tr);
      });
  }

  // gelombang filter
  function setupFilter(allData) {
      const filter = document.getElementById("gelombangFilter");
      if (!filter) return;
      filter.addEventListener("change", () => {
          const val = filter.value;
          const filtered = val === "all" ? allData : allData.filter(d => String(d.gelombang) === String(val));
          renderTable(filtered);
          drawCharts(filtered);
          // smooth scroll to table on mobile
          document.getElementById('pendaftar').scrollIntoView({behavior:'smooth', block:'start'});
      });
  }

  // search input (live)
  function setupSearch(allData) {
      const search = document.getElementById("searchInput");
      if (!search) return;
      search.addEventListener("input", () => {
          const q = search.value.trim().toLowerCase();
          const rows = allData.filter(d => {
              return (d.nama || "").toLowerCase().includes(q)
                  || (d.sekolah || "").toLowerCase().includes(q)
                  || (d.alamat || "").toLowerCase().includes(q)
                  || (d.pondok || "").toLowerCase().includes(q);
          });
          renderTable(rows);
          drawCharts(rows);
      });
  }

  // bottom nav scroll helper
  function scrollToSection(id) {
      const el = document.getElementById(id);
      if (el) el.scrollIntoView({behavior:'smooth', block:'start'});
      // update active nav style
      document.querySelectorAll('nav.bottom-nav a').forEach(a => a.classList.remove('active'));
      if (id === 'pendaftar') document.getElementById('navData').classList.add('active');
      else document.getElementById('navStats').classList.add('active');
  }

  // initial
  loadStats();
  </script>

</body>
</html>
