<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>PMB MTs Sunan Kalijaga - Dashboard</title>
  <link rel="icon" type="image/png" href="assets/LOGOMADA.png">

  <!-- Tailwind (optional, used for utility classes) + Chart.js -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <style>
    /* Minimal custom CSS to match "Option A" layout */
    :root{
      --bg:#f3f6fb;
      --card:#ffffff;
      --muted:#64748b;
      --accent:#2563eb;
    }
    body{
      margin:0;
      font-family: Inter, system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
      background: var(--bg);
      color:#0f172a;
    }

    header.app-header{
      background: var(--card);
      padding:18px 24px;
      box-shadow: 0 4px 20px rgba(2,6,23,0.06);
      border-bottom: 1px solid rgba(15,23,42,0.03);
    }
    header.app-header .title { font-size:20px; font-weight:700; }
    header.app-header .subtitle { color:var(--muted); font-size:13px; margin-top:4px; }

    main.container {
      max-width:1200px;
      margin:18px auto;
      padding: 0 18px 60px 18px;
    }

    /* cards */
    .cards {
      display:grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap:16px;
      margin-top:18px;
    }
    .card {
      background:var(--card);
      padding:16px;
      border-radius:12px;
      box-shadow: 0 6px 20px rgba(2,6,23,0.04);
    }
    .card .label { color:var(--muted); font-weight:700; font-size:13px; }
    .card .value { font-weight:800; font-size:26px; margin-top:8px; }

    /* charts area */
    .charts {
      display:grid;
      grid-template-columns: repeat(auto-fit, minmax(340px, 1fr));
      gap:18px;
      margin-top:20px;
    }
    .chart-card {
      background:var(--card);
      padding:14px;
      border-radius:12px;
      box-shadow: 0 6px 20px rgba(2,6,23,0.04);
      min-height:340px;
      display:flex;
      flex-direction:column;
    }
    .chart-card .head { display:flex; justify-content:space-between; align-items:center; margin-bottom:8px; }
    .chart-card canvas { flex:1; max-height: 300px; }

    /* filter + table */
    .controls { display:flex; gap:12px; align-items:center; flex-wrap:wrap; margin-top:22px; }
    .controls input, .controls select { padding:10px 12px; border-radius:8px; border:1px solid #e6edf6; background:white; min-width:200px; }

    .table-wrap { margin-top:16px; background:transparent; border-radius:12px; overflow:hidden; box-shadow: 0 8px 24px rgba(2,6,23,0.04); }
    .table-scroll { overflow-x:auto; }
    table { width:100%; border-collapse:collapse; min-width:980px; background:var(--card); }
    thead th { background: linear-gradient(90deg,var(--accent),#7c3aed); color:white; padding:12px 14px; text-align:left; font-size:13px; }
    tbody td { padding:12px 14px; border-bottom:1px solid #f1f5f9; color:#0f172a; font-size:14px; }
    tbody tr:hover td { background:#f8fbff; }

    /* responsive tweaks */
    @media (max-width: 640px) {
      .cards { grid-template-columns: 1fr; }
      .chart-card { min-height:260px; }
      .controls input, .controls select { min-width:100%; }
      table { min-width:760px; }
    }

  </style>
</head>

<body>

  <!-- HEADER -->
  <header class="app-header">
    <div class="max-w-7xl mx-auto">
      <div class="title">PMB MTs Sunan Kalijaga - Dashboard</div>
      <div class="subtitle">Panel admin untuk monitoring pendaftar — fitur: filter, pencarian, WA, status berkas.</div>
    </div>
  </header>

  <!-- MAIN -->
  <main class="container">

    <!-- CARDS -->
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

    <!-- CHARTS -->
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

    <!-- FILTER + SEARCH -->
    <section id="pendaftar" class="mt-6">
      <div class="flex items-start justify-between mb-4 gap-4 flex-wrap">
        <div class="controls">
          <input type="text" id="searchInput" placeholder="Cari siswa, asal sekolah, alamat, pondok..." class="shadow-sm" />
        </div>

        <div class="flex gap-3 items-center">
          <label class="text-sm text-gray-600">Pilih Gelombang</label>
          <select id="gelombangFilter" class="shadow-sm">
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

  </main>

  <!-- Floating register button (ke form) -->
  <a href="https://docs.google.com/forms" target="_blank" class="floating-button hidden md:flex" title="Form Pendaftaran">
    ✚
  </a>

  <!-- ===== SCRIPT: data + charts (mengikuti fungsi & fitur Anda, hanya tampilkan bar chart bukan doughnut) ===== -->
  <script>
  // CSV publik yang Anda pakai
  const sheetURL = "https://docs.google.com/spreadsheets/d/e/2PACX-1vTkWDi-X_jfYIUpR04AupM-ubJ-hBT-RO6W9HSyIN5_n15SN_AD1vDNM4CW-GV_4EpIm-9MTgW1iLvl/pub?gid=1123091940&single=true&output=csv";

  let globalData = []; 
  let genderChartInstance = null;
  let ponpesChartInstance = null;

  // Utility: escape text to avoid accidental HTML injection
  function escapeHtml(text) {
      if (!text && text !== 0) return "";
      return String(text)
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
  }

  // Load CSV (simple parse)
  async function loadStats() {
      try {
          const response = await fetch(sheetURL);
          const csvText = await response.text();

          // quick CSV -> rows (assumes no embedded newlines/commas in fields)
          const rows = csvText.split("\n").map(r =>
              r.split(",").map(c => c.replace(/^"|"$/g, '').trim())
          );

          if (!rows || rows.length < 2) {
              console.warn("CSV kosong atau tidak valid");
              return;
          }

          // headers lowercased
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

          // iterate rows
          for (let i = 1; i < rows.length; i++) {
              const row = rows[i];
              if (!row || row.length === 0) continue;

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

              let hp = hpRaw.replace(/[^0-9]/g, "");
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

          // update card counts
          document.getElementById("totalSiswa").textContent = globalData.length;

          // compute WA count (marked)
          const waCount = globalData.reduce((acc,d)=> acc + (localStorage.getItem("contacted_"+d.hp) ? 1 : 0), 0);
          document.getElementById("waCount").textContent = waCount || 0;

          // top pondok
          const ponpesCounts = {};
          globalData.forEach(d => {
              if (d.pondok) ponpesCounts[d.pondok] = (ponpesCounts[d.pondok] || 0) + 1;
          });
          const topPonpes = Object.entries(ponpesCounts).sort((a,b)=>b[1]-a[1])[0];
          document.getElementById("topPonpes").textContent = topPonpes ? `${topPonpes[0]} (${topPonpes[1]})` : "-";

          // initial render
          renderTable(globalData);
          drawCharts(globalData);
          setupFilter(globalData);
          setupSearch(globalData);

      } catch (err) {
          console.error("Gagal muat data:", err);
      }
  }

  function markContacted(num) {
      localStorage.setItem("contacted_" + num, true);
      // update WA count in card
      const waCount = globalData.reduce((acc,d) => acc + (localStorage.getItem("contacted_"+d.hp) ? 1 : 0), 0);
      document.getElementById("waCount").textContent = waCount;
  }

  // DRAW BAR CHARTS (gender + pondok)
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

      // destroy previous instances to avoid duplicates
      if (genderChartInstance) genderChartInstance.destroy();
      if (ponpesChartInstance) ponpesChartInstance.destroy();

      // gender bar
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
              scales: { y: { beginAtZero: true } },
              plugins: { legend: { display: false } }
          }
      });

      // pondok bar
      const ctxP = document.getElementById("ponpesChart").getContext("2d");
      ponpesChartInstance = new Chart(ctxP, {
          type: "bar",
          data: {
              labels: Object.keys(ponpesCounts),
              datasets: [{
                  label: "Pendaftar",
                  data: Object.values(ponpesCounts),
                  backgroundColor: Object.keys(ponpesCounts).map((_,i)=> {
                    // pick palette based on index
                    const palette = ["#10b981","#f59e0b","#3b82f6","#ef4444","#8b5cf6","#06b6d4","#f97316"];
                    return palette[i % palette.length];
                  }),
                  borderRadius: 6
              }]
          },
          options: {
              responsive: true,
              maintainAspectRatio: false,
              scales: { y: { beginAtZero: true } },
              plugins: { legend: { display: false } }
          }
      });
  }

  // render table — nomor reset to 1..n for current view
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

  // Filter per gelombang dropdown
  function setupFilter(allData) {
      const filter = document.getElementById("gelombangFilter");
      if (!filter) return;
      filter.addEventListener("change", () => {
          const val = filter.value;
          const filtered = val === "all" ? allData : allData.filter(d => String(d.gelombang) === String(val));
          renderTable(filtered);
          drawCharts(filtered);
      });
  }

  // Search input (live)
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

  // initial load
  loadStats();
  </script>

</body>
</html>
