<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width,initial-scale=1,viewport-fit=cover" />
<title>PMB MTs Sunan Kalijaga - App</title>
<link rel="icon" type="image/png" href="assets/LOGOMADA.png">
<meta name="theme-color" content="#2563eb">

<!-- Tailwind + Chart.js -->
<script src="https://cdn.tailwindcss.com"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.sheetjs.com/xlsx-latest/package/dist/xlsx.full.min.js"></script>


<style>
:root{
  --accent:#2563eb;
  --bg:#f3f6fb;
  --card:#ffffff;
  --muted:#64748b;
}
html,body{height:100%;margin:0;font-family:Inter,system-ui,-apple-system,Segoe UI,Roboto,Helvetica,Arial;background:var(--bg);color:#0f172a;-webkit-font-smoothing:antialiased;}

/* Appbar */
header.appbar{
  position:fixed;left:0;right:0;top:0;height:64px;padding:12px 16px;background:linear-gradient(90deg,#ffffff,#f8fbff);
  display:flex;align-items:center;justify-content:space-between;z-index:40;border-bottom:1px solid rgba(15,23,42,0.03);
  box-shadow:0 4px 16px rgba(2,6,23,0.06);
}
header .title{font-weight:700;font-size:16px}
header .subtitle{font-size:12px;color:var(--muted)}

/* Main */
main.app-main{padding-top:80px;padding-bottom:96px;max-width:1100px;margin:0 auto}
.container{padding-left:14px;padding-right:14px}

/* Cards */
.cards{display:grid;grid-template-columns:repeat(2,1fr);gap:10px}
.card{background:var(--card);border-radius:12px;padding:12px;box-shadow:0 6px 18px rgba(2,6,23,0.05)}
.card .label{color:var(--muted);font-weight:700;font-size:12px}
.card .value{font-weight:800;font-size:20px;margin-top:6px}

/* Charts */
.charts{display:grid;grid-template-columns:1fr;gap:12px;margin-top:10px}
.chart-card{background:var(--card);border-radius:12px;padding:12px;min-height:220px;box-shadow:0 6px 18px rgba(2,6,23,0.05);display:flex;flex-direction:column}
.chart-card .head{display:flex;justify-content:space-between;align-items:center;margin-bottom:8px}
.chart-card canvas{width:100% !important;height:200px !important}

/* Controls + Table */
.controls{margin-top:12px;display:flex;gap:8px;align-items:center;flex-wrap:wrap}
.controls input,.controls select{padding:10px 12px;border-radius:10px;border:1px solid #e6edf6;background:white;min-width:48%}
.table-wrap{margin-top:12px;border-radius:12px;overflow:hidden;box-shadow:0 8px 24px rgba(2,6,23,0.04)}
.table-scroll{overflow-x:auto}
table{width:100%;border-collapse:collapse;min-width:760px;background:var(--card)}
thead th{background:var(--accent);color:white;padding:10px 12px;text-align:left;font-size:12px}
tbody td{padding:10px 12px;background:var(--card);border-bottom:1px solid #f1f5f9;font-size:13px}
tbody tr:hover td{background:#f8fbff}

/* Mobile Cards */
.mobile-card{background:var(--card);border-radius:12px;box-shadow:0 4px 16px rgba(2,6,23,0.05);margin-bottom:12px;padding:12px}

/* Bottom nav */
nav.bottom-nav{
  position:fixed;left:12px;right:12px;bottom:12px;height:64px;background:linear-gradient(180deg,#ffffff,#fbfdff);
  border-radius:16px;display:flex;align-items:center;justify-content:space-around;box-shadow:0 12px 30px rgba(2,6,23,0.12);z-index:50;border:1px solid rgba(15,23,42,0.03)
}
nav.bottom-nav a{display:flex;flex-direction:column;align-items:center;justify-content:center;gap:4px;color:#475569;text-decoration:none;font-size:12px;width:20%}
nav.bottom-nav a.active{color:var(--accent);font-weight:700}

/* FAB */
.fab{position:fixed;right:28px;bottom:86px;width:56px;height:56px;border-radius:14px;background:var(--accent);color:white;display:flex;align-items:center;justify-content:center;box-shadow:0 12px 30px rgba(37,99,235,0.18);z-index:55;text-decoration:none;font-size:22px}

/* Responsive */
@media (min-width:768px){
  .cards{grid-template-columns:repeat(4,1fr)}
  .charts{grid-template-columns:repeat(2,1fr)}
  .chart-card canvas{height:260px !important}
  nav.bottom-nav{left:calc(50% - 240px);right:calc(50% - 240px);width:480px}
  .fab{right:calc(50% - 240px);bottom:86px}
  .desktop-only{display:block}
}
@media (max-width:767px){
  .desktop-only{display:none}
  .cards{grid-template-columns:repeat(2,1fr)}
  .charts{grid-template-columns:1fr}
}

/* Helpers */
.muted{color:var(--muted);font-size:13px}
.text-xs{font-size:12px}
</style>
</head>

<body>
<header class="appbar" role="banner">
  <div>
    <div class="title">PMB MTs Sunan Kalijaga</div>
    <div class="subtitle">Tim PMB Madsuka</div>
  </div>
  <div>
    <img src="assets/LOGOMADA.png" alt="logo" style="width:40px;height:40px;border-radius:10px;object-fit:cover">
  </div>
</header>

<main class="app-main" role="main">
<div class="container">
  <!-- Stat Cards -->
  <section class="cards" aria-label="stat-cards">
    <div class="card">
      <div class="label">Total Siswa Terdaftar</div>
      <div id="totalSiswa" class="value">0</div>
      <div class="text-xs muted mt-2">Jumlah pendaftar saat ini</div>
    </div>
    <div class="card">
      <div class="label">Kuota per Gelombang</div>
      <div class="value">30</div>
      <div class="text-xs muted mt-2">Setiap gelombang 30 siswa</div>
    </div>
    <div class="card">
      <div class="label">Terhubung via WA</div>
      <div id="waCount" class="value">0</div>
      <div class="text-xs muted mt-2">Jumlah kontak yang ditandai</div>
    </div>
    <div class="card">
      <div class="label">Pilihan Pondok Teratas</div>
      <div id="topPonpes" class="value">-</div>
      <div class="text-xs muted mt-2">Pondok dengan pendaftar terbanyak</div>
    </div>
  </section>

  <!-- Charts -->
  <section class="charts" id="stats">
    <div class="chart-card" role="region" aria-label="chart-gender">
      <div class="head">
        <div>
          <div class="font-semibold">Jenis Kelamin</div>
          <div class="text-xs muted">Distribusi pendaftar</div>
        </div>
      </div>
      <canvas id="genderChart"></canvas>
    </div>
    <div class="chart-card" role="region" aria-label="chart-ponpes">
      <div class="head">
        <div>
          <div class="font-semibold">Pilihan Pondok</div>
          <div class="text-xs muted">Preferensi pondok pesantren</div>
        </div>
      </div>
      <canvas id="ponpesChart"></canvas>
    </div>
  </section>

  <!-- Controls + Cards -->
  <section id="pendaftar" class="mt-4">
    <div class="flex items-start justify-between mb-4 gap-3 flex-wrap">
      <div class="controls" style="flex:1;">
        <input type="text" id="searchInput" placeholder="Cari: nama, sekolah, alamat, pondok..." />
      </div>
      <div style="display:flex;gap:8px;align-items:center;">
        <label class="text-xs muted">Pilih Gelombang</label>
        <select id="gelombangFilter">
          <option value="all">Semua Gelombang</option>
          <option value="1">Gelombang 1 (1–30)</option>
          <option value="2">Gelombang 2 (31–60)</option>
          <option value="3">Gelombang 3 (61–90)</option>
        </select>
      </div>
    </div>

    <!-- Mobile Cards -->
    <div id="pendaftarCardContainer"></div>

    <!-- Desktop Table -->
    <div class="desktop-only table-scroll mt-2">
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
          <tbody id="pendaftarTable"></tbody>
        </table>
      </div>
    </div>
  </section>

</div>
</main>

<!-- FAB -->
<a href="https://docs.google.com/forms" target="_blank" class="fab" title="Form Pendaftaran">＋</a>

<!-- Bottom nav -->
<nav class="bottom-nav" aria-label="navigation">
  <a href="#" id="navHome" class="active" onclick="scrollToSection('stats');return false;">
    <!-- Home Icon -->
    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7m-9 5v6m0-6h6m-6 0H3"/>
    </svg>
    <div>Home</div>
  </a>

  <a href="#" id="navStats" onclick="scrollToSection('stats');return false;">
    <!-- Chart Icon -->
    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 11V3m4 8V7m4 8v-2m-8 6h8M5 21h14"/>
    </svg>
    <div>Statistik</div>
  </a>

  <a href="#" id="navData" onclick="scrollToSection('pendaftar');return false;">
    <!-- Table Icon -->
    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
    </svg>
    <div>Data</div>
  </a>

  <a href="#" id="navMore" onclick="confirmDownload();return false;">
    <!-- Download Icon -->
    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2m-6-6v6m0 0l-3-3m3 3l3-3"/>
    </svg>
    <div>Download</div>
  </a>
</nav>

<!-- Modal Konfirmasi Download -->
<div id="confirmModal" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center hidden z-50">
  <div class="bg-white rounded-xl p-6 w-80 shadow-lg flex flex-col gap-4">
    <div class="text-lg font-semibold text-gray-800">Konfirmasi Download</div>
    <div class="text-sm text-gray-600">Yakin mau download data pendaftar?</div>
    <div class="flex justify-end gap-3 mt-4">
      <button id="cancelDownload" class="px-4 py-2 rounded-lg bg-gray-200 text-gray-700 font-semibold hover:bg-gray-300">Batal</button>
      <button id="confirmDownload" class="px-4 py-2 rounded-lg bg-blue-600 text-white font-semibold hover:bg-blue-700">Download</button>
    </div>
  </div>
</div>

<script>
// --- Data + Charts (sama seperti sebelumnya) ---
const sheetURL = "https://docs.google.com/spreadsheets/d/e/2PACX-1vTkWDi-X_jfYIUpR04AupM-ubJ-hBT-RO6W9HSyIN5_n15SN_AD1vDNM4CW-GV_4EpIm-9MTgW1iLvl/pub?gid=1123091940&single=true&output=csv";

let globalData = [];
let genderChartInstance = null;
let ponpesChartInstance = null;

function escapeHtml(text){
  if(!text && text!==0) return "";
  return String(text).replace(/&/g,"&amp;").replace(/</g,"&lt;").replace(/>/g,"&gt;").replace(/"/g,"&quot;").replace(/'/g,"&#039;");
}

async function loadStats(){
  try{
    const response = await fetch(sheetURL);
    const csvText = await response.text();
    const rows = csvText.split("\n").map(r=>r.split(",").map(c=>c.replace(/^"|"$/g,'').trim()));
    if(!rows || rows.length<2) return;

    const headers = rows[0].map(h=>h.trim().toLowerCase());
    const colTanggal = headers.findIndex(h=>h.includes("timestamp"));
    const colSekolah = headers.findIndex(h=>"asal sekolah"===h);
    const colNama = headers.findIndex(h=>"nama siswa"===h);
    const colAlamat = headers.findIndex(h=>"alamat"===h);
    const colGender = headers.findIndex(h=>"jenis kelamin"===h);
    const colPonpes = headers.findIndex(h=>"pilihan pondok pesantren"===h);
    const colHp = headers.findIndex(h=>"nomor hp orang tua"===h);
    const colKK = headers.findIndex(h=>h.includes("kartu keluarga"));
    const colAkte = headers.findIndex(h=>h.includes("akte"));

    globalData=[];
    let total=0;
    for(let i=1;i<rows.length;i++){
      const row=rows[i];
      if(!row) continue;
      const tanggal=row[colTanggal]||"";
      const sekolah=row[colSekolah]||"";
      const nama=row[colNama]||"";
      const alamat=row[colAlamat]||"";
      const gender=(row[colGender]||"").trim();
      const pondok=row[colPonpes]||"";
      const hpRaw=row[colHp]||"";
      if(!nama||!alamat) continue;
      total++;
      let gelombang=Math.ceil(total/30);
      let hp=(hpRaw||"").replace(/[^0-9]/g,'');
      if(hp.startsWith("0")) hp="62"+hp.substring(1);
      const kk=row[colKK]||"";
      const akte=row[colAkte]||"";
      let statusBerkas=`<span style="color:#ef4444;font-weight:700">❌ Belum Lengkap</span>`;
      if(kk && akte) statusBerkas=`<span style="color:#16a34a;font-weight:700">✅ Lengkap</span>`;
      const pesan=`
      اَلْحَمْدُ لِلَّهِ رَبِّ الْعَالَمِينَ
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

⏳ Daftar ulang dilaksanakan Bulan Desember 2025.
      `;
      const linkWA=hp?`https://wa.me/${hp}?text=${encodeURIComponent(pesan)}`:"";

      globalData.push({nomor:total,gelombang,tanggal,sekolah,nama,alamat,gender,pondok,hp,hpRaw,linkWA,statusBerkas});
    }

    document.getElementById("totalSiswa").textContent=globalData.length;
    const waCount=globalData.reduce((acc,d)=>acc+(localStorage.getItem("contacted_"+d.hp)?1:0),0);
    document.getElementById("waCount").textContent=waCount||0;

    const ponpesCounts={};
    globalData.forEach(d=>{if(d.pondok) ponpesCounts[d.pondok]=(ponpesCounts[d.pondok]||0)+1;});
    const topPonpes=Object.entries(ponpesCounts).sort((a,b)=>b[1]-a[1])[0];
    document.getElementById("topPonpes").textContent=topPonpes?`${topPonpes[0]} (${topPonpes[1]})`:"-";

    renderTable(globalData);
    renderMobileCards(globalData);
    drawCharts(globalData);
    setupFilter(globalData);
    setupSearch(globalData);
  }catch(err){console.error("Gagal load:",err);}
}

function markContacted(num){
  localStorage.setItem("contacted_"+num,true);
  const waCount=globalData.reduce((acc,d)=>acc+(localStorage.getItem("contacted_"+d.hp)?1:0),0);
  document.getElementById("waCount").textContent=waCount;
}

function drawCharts(data){
  let male=0,female=0;
  let ponpesCounts={};
  data.forEach(d=>{
    const g=(d.gender||"").toLowerCase();
    if(g.includes("laki")) male++;
    else if(g.includes("perempuan")) female++;
    const key=d.pondok&&d.pondok.trim()?d.pondok:"Non Pondok";
    ponpesCounts[key]=(ponpesCounts[key]||0)+1;
  });

  if(genderChartInstance) genderChartInstance.destroy();
  if(ponpesChartInstance) ponpesChartInstance.destroy();

  const ctxG=document.getElementById("genderChart").getContext("2d");
  genderChartInstance=new Chart(ctxG,{
    type:"bar",
    data:{labels:["Laki-Laki","Perempuan"],datasets:[{label:"Jumlah",data:[male,female],backgroundColor:["#2563eb","#ec4899"],borderRadius:8}]},
    options:{responsive:true,maintainAspectRatio:false,scales:{y:{beginAtZero:true,ticks:{precision:0}}},plugins:{legend:{display:false}}}
  });

  const ctxP=document.getElementById("ponpesChart").getContext("2d");
  ponpesChartInstance=new Chart(ctxP,{
    type:"bar",
    data:{labels:Object.keys(ponpesCounts),datasets:[{label:"Pendaftar",data:Object.values(ponpesCounts),backgroundColor:Object.keys(ponpesCounts).map((_,i)=>{const p=["#10b981","#f59e0b","#3b82f6","#ef4444","#8b5cf6","#06b6d4","#f97316"];return p[i%p.length];}),borderRadius:6}]},
    options:{responsive:true,maintainAspectRatio:false,scales:{y:{beginAtZero:true,ticks:{precision:0}}},plugins:{legend:{display:false}}}
  });
}

function renderTable(data){
  const tbody=document.getElementById("pendaftarTable");
  tbody.innerHTML="";
  data.forEach((d,i)=>{
    const contacted=localStorage.getItem("contacted_"+d.hp)?"✔️":"";
    const tr=document.createElement("tr");
    tr.innerHTML=`
      <td>${i+1}</td>
      <td>${escapeHtml(d.sekolah)}</td>
      <td>${escapeHtml(d.nama)}</td>
      <td>${escapeHtml(d.alamat)}</td>
      <td>${escapeHtml(d.gender)}</td>
      <td>${escapeHtml(d.pondok)}</td>
      <td>${escapeHtml(d.hpRaw||d.hp)}</td>
      <td>${d.statusBerkas}</td>
      <td>${d.hp?`<a href="${d.linkWA}" target="_blank" class="inline-block px-3 py-1 rounded bg-green-500 text-white text-xs" onclick="markContacted('${d.hp}')">Hubungi</a>`:"-"} ${contacted}</td>
    `;
    tbody.appendChild(tr);
  });
}

function renderMobileCards(data){
  const container=document.getElementById("pendaftarCardContainer");
  container.innerHTML="";
  data.forEach((d,i)=>{
    const contacted=localStorage.getItem("contacted_"+d.hp)?"✔️":"";
    const card=document.createElement("div");
    card.classList.add("mobile-card");
    card.innerHTML=`
      <div class="flex justify-between mb-2"><div class="font-semibold text-sm">#${i+1}</div><div class="text-xs text-gray-500">Gel: ${d.gelombang}</div></div>
      <div class="mb-1"><span class="font-semibold text-xs">Nama:</span> ${d.nama}</div>
      <div class="mb-1"><span class="font-semibold text-xs">Sekolah:</span> ${d.sekolah}</div>
      <div class="mb-1"><span class="font-semibold text-xs">Alamat:</span> ${d.alamat}</div>
      <div class="mb-1"><span class="font-semibold text-xs">Gender:</span> ${d.gender}</div>
      <div class="mb-1"><span class="font-semibold text-xs">Pondok:</span> ${d.pondok}</div>
      <div class="mb-1"><span class="font-semibold text-xs">HP:</span> ${d.hpRaw||d.hp}</div>
      <div class="mb-1"><span class="font-semibold text-xs">Status Berkas:</span> ${d.statusBerkas}</div>
      <div class="flex justify-between items-center mt-2">
        ${d.hp?`<a href="${d.linkWA}" target="_blank" class="px-3 py-1 bg-green-500 text-white rounded text-xs" onclick="markContacted('${d.hp}')">WA</a>`:"-"}
        <span>${contacted}</span>
      </div>
    `;
    container.appendChild(card);
  });
}

function setupFilter(allData){
  const filter=document.getElementById("gelombangFilter");
  filter?.addEventListener("change",()=>{
    const val=filter.value;
    const filtered=val==="all"?allData:allData.filter(d=>String(d.gelombang)===String(val));
    renderTable(filtered);
    renderMobileCards(filtered);
    drawCharts(filtered);
    document.getElementById('pendaftar').scrollIntoView({behavior:'smooth',block:'start'});
  });
}

function setupSearch(allData){
  const search=document.getElementById("searchInput");
  search?.addEventListener("input",()=>{
    const q=search.value.trim().toLowerCase();
    const rows=allData.filter(d=>{
      return (d.nama||"").toLowerCase().includes(q)||
             (d.sekolah||"").toLowerCase().includes(q)||
             (d.alamat||"").toLowerCase().includes(q)||
             (d.pondok||"").toLowerCase().includes(q);
    });
    renderTable(rows);
    renderMobileCards(rows);
    drawCharts(rows);
  });
}

function scrollToSection(id){
  const el=document.getElementById(id);
  if(el) el.scrollIntoView({behavior:'smooth',block:'start'});
  document.querySelectorAll('nav.bottom-nav a').forEach(a=>a.classList.remove('active'));
  if(id==='pendaftar') document.getElementById('navData').classList.add('active');
  else document.getElementById('navStats').classList.add('active');
}
// ===== Fungsi download CSV =====
// ===== Fungsi download Excel =====
function downloadExcelAdvanced() {
    if (!globalData || globalData.length === 0) {
        alert("Data kosong, tidak ada yang bisa diunduh.");
        return;
    }

    const wb = XLSX.utils.book_new();

    // --- 1. Sheet per Gelombang ---
    [1,2,3].forEach(g => {
        const gelData = globalData.filter(d => d.gelombang === g)
                                  .sort((a,b)=>a.nomor-b.nomor);
        if (gelData.length === 0) return;

        const wsData = [
            ["Nomor","Asal Sekolah","Nama","Alamat","Jenis Kelamin","Pilihan Pondok","Nomor HP","Status Berkas","Gelombang"]
        ];
        gelData.forEach(d => {
            wsData.push([
                d.nomor,
                d.sekolah,
                d.nama,
                d.alamat,
                d.gender,
                d.pondok,
                d.hpRaw || d.hp,
                d.statusBerkas.replace(/<[^>]+>/g,''), // Bersihkan HTML
                d.gelombang
            ]);
        });
        const ws = XLSX.utils.aoa_to_sheet(wsData);
        XLSX.utils.book_append_sheet(wb, ws, `Gelombang ${g}`);
    });

    // --- 2. Sheet per Daerah (misal kolom alamat) ---
    const daerahMap = {};
    globalData.forEach(d => {
        // Ambil kata pertama di alamat sebagai daerah sederhana
        const daerah = (d.alamat || "Unknown").split(" ")[0];
        if (!daerahMap[daerah]) daerahMap[daerah] = [];
        daerahMap[daerah].push(d);
    });

    Object.keys(daerahMap).forEach(daerah => {
        const wsData = [
            ["Nomor","Asal Sekolah","Nama","Alamat","Jenis Kelamin","Pilihan Pondok","Nomor HP","Status Berkas","Gelombang"]
        ];
        daerahMap[daerah].forEach(d => {
            wsData.push([
                d.nomor,
                d.sekolah,
                d.nama,
                d.alamat,
                d.gender,
                d.pondok,
                d.hpRaw || d.hp,
                d.statusBerkas.replace(/<[^>]+>/g,''),
                d.gelombang
            ]);
        });
        const ws = XLSX.utils.aoa_to_sheet(wsData);
        XLSX.utils.book_append_sheet(wb, ws, `Daerah ${daerah}`);
    });

    // --- Download workbook ---
    XLSX.writeFile(wb, "pendaftar_multi_sheet.xlsx");
}

// Tautkan ke tombol Lainnya
const navMore = document.getElementById("navMore");
const modal = document.getElementById("confirmModal");
const cancelBtn = document.getElementById("cancelDownload");
const confirmBtn = document.getElementById("confirmDownload");

// Klik tombol Download → tampilkan modal
navMore.addEventListener("click", function(e){
    e.preventDefault();
    modal.classList.remove("hidden");
});

// Klik Batal → tutup modal
cancelBtn.addEventListener("click", function(){
    modal.classList.add("hidden");
});

// Klik Download → tutup modal & panggil fungsi download
confirmBtn.addEventListener("click", function(){
    modal.classList.add("hidden");
    downloadExcelAdvanced(); // pastikan ini adalah fungsi download Excel yang sudah dibuat
});

// Opsional: klik di luar modal untuk menutupnya
modal.addEventListener("click", function(e){
    if(e.target === modal) modal.classList.add("hidden");
});



// initial load
loadStats();
</script>
</body>
</html>
