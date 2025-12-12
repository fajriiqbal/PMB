<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width,initial-scale=1,viewport-fit=cover" />
<title>PMB MTs Sunan Kalijaga - App (dengan Pembayaran)</title>
<link rel="icon" type="image/png" href="assets/LOGOMADA.png">
<meta name="theme-color" content="#2563eb">

<!-- Tailwind + Chart.js + SheetJS -->
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

  <!-- Pembayaran Section -->
  <section id="pembayaran" class="mt-6">
    <div class="flex items-center justify-between mb-3">
      <div>
        <h2 class="text-lg font-semibold">Pembayaran Daftar Ulang</h2>
        <div class="text-xs muted">Kelola pembayaran siswa (CRUD) dan unduh laporan.</div>
      </div>
      <div class="flex gap-2 items-center">
        <button onclick="openAddPaymentModal()" class="px-3 py-2 bg-blue-600 text-white rounded">Tambah Pembayaran</button>
        <button onclick="downloadPaymentsExcel()" class="px-3 py-2 bg-green-600 text-white rounded">Download Laporan</button>
      </div>
    </div>

    <div class="cards mb-4">
      <div class="card">
        <div class="label">Total Pembayaran</div>
        <div id="totalPayments" class="value">0</div>
        <div class="text-xs muted mt-2">Semua record pembayaran</div>
      </div>
      <div class="card">
        <div class="label">Sudah Lunas</div>
        <div id="paidCount" class="value">0</div>
        <div class="text-xs muted mt-2">Jumlah pembayaran bertatus Lunas</div>
      </div>
      <div class="card">
        <div class="label">Belum Lunas</div>
        <div id="unpaidCount" class="value">0</div>
        <div class="text-xs muted mt-2">Jumlah pembayaran bertatus Belum</div>
      </div>
      <div class="card">
        <div class="label">Total Nominal</div>
        <div id="totalNominal" class="value">0</div>
        <div class="text-xs muted mt-2">Total semua nominal</div>
      </div>
    </div>

    <!-- Filter + Search Pembayaran -->
    <div class="flex items-center justify-between gap-3 mb-3 flex-wrap">
      <div style="flex:1;" class="controls">
        <input id="searchPayment" placeholder="Cari pembayaran: nama, nomor, jenis..." />
        <select id="filterStatus">
          <option value="all">Semua Status</option>
          <option value="Lunas">Lunas</option>
          <option value="Belum">Belum</option>
        </select>
      </div>
    </div>

    <!-- Mobile Cards for payments -->
    <div id="paymentsMobileContainer"></div>

    <!-- Desktop Table -->
    <div class="desktop-only table-scroll mt-2">
      <div class="table-wrap">
        <table aria-describedby="Data pembayaran">
          <thead>
            <tr>
              <th>ID</th>
              <th>Nomor</th>
              <th>Nama</th>
              <th>Tanggal</th>
              <th>Jenis</th>
              <th>Nominal</th>
              <th>Status</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody id="paymentsTable"></tbody>
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
    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7m-9 5v6m0-6h6m-6 0H3"/>
    </svg>
    <div>Home</div>
  </a>

  <a href="#" id="navStats" onclick="scrollToSection('stats');return false;">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 11V3m4 8V7m4 8v-2m-8 6h8M5 21h14"/>
    </svg>
    <div>Statistik</div>
  </a>

  <a href="#" id="navData" onclick="scrollToSection('pendaftar');return false;">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
    </svg>
    <div>Data</div>
  </a>

  <a href="#" id="navPay" onclick="scrollToSection('pembayaran');return false;">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 1.343-3 3v3h6v-3c0-1.657-1.343-3-3-3zM12 2v2m0 16v2m8-10h2M2 12H0M19.778 4.222l1.414-1.414M3.808 20.192l1.414-1.414"/>
    </svg>
    <div>Pembayaran</div>
  </a>

  <a href="#" id="navMore" onclick="confirmDownload();return false;">
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

<!-- Modal Add/Edit Payment -->
<div id="paymentModal" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center hidden z-60">
  <div class="bg-white rounded-xl p-6 w-96 shadow-lg">
    <h3 id="paymentModalTitle" class="text-lg font-semibold mb-2">Tambah Pembayaran</h3>
    <div class="grid grid-cols-1 gap-2">
      <input id="pay_nomor" placeholder="Nomor Pendaftar" class="border p-2 rounded" />
      <input id="pay_nama" placeholder="Nama" class="border p-2 rounded" />
      <input id="pay_tanggal" type="date" class="border p-2 rounded" />
      <select id="pay_jenis" class="border p-2 rounded">
        <option>Seragam</option>
        <option>Administrasi</option>
        <option>Pangkal</option>
      </select>
      <input id="pay_nominal" placeholder="Nominal" class="border p-2 rounded" />
      <select id="pay_status" class="border p-2 rounded">
        <option value="Lunas">Lunas</option>
        <option value="Belum">Belum</option>
      </select>
      <input id="pay_bukti" placeholder="Link Bukti (opsional)" class="border p-2 rounded" />
    </div>
    <div class="flex justify-end gap-2 mt-4">
      <button onclick="closePaymentModal()" class="px-3 py-1 rounded bg-gray-200">Batal</button>
      <button id="paymentSaveBtn" onclick="savePayment()" class="px-3 py-1 rounded bg-blue-600 text-white">Simpan</button>
    </div>
  </div>
</div>

<script>
// --- Data + Charts (sama seperti sebelumnya) ---
const sheetURL = "https://docs.google.com/spreadsheets/d/e/2PACX-1vTkWDi-X_jfYIUpR04AupM-ubJ-hBT-RO6W9HSyIN5_n15SN_AD1vDNM4CW-GV_4EpIm-9MTgW1iLvl/pub?gid=1123091940&single=true&output=csv";
// public CSV from your Payment sheet (you provided earlier)
const pembayaranCSV = "https://docs.google.com/spreadsheets/d/e/2PACX-1vRK5S9U1_NFAXW44TO-FtuITk6BGdrH1RPG67iEs3HSER9bBuY15KZGn4KRjSHtQszjNpdz67ibBeAr/pub?gid=0&single=true&output=csv";
// Apps Script Web App URL for CRUD - GANTI dengan URL hasil deploy Anda
const PAY_API_URL = "https://daftar.mtssunankalijagatulung.sch.id/";

let globalData = [];
let paymentsData = [];
let genderChartInstance = null;
let ponpesChartInstance = null;

function escapeHtml(text){
  if(!text && text!==0) return "";
  return String(text).replace(/&/g,"&amp;").replace(/</g,"&lt;").replace(/>/g,"&gt;").replace(/\"/g,"&quot;").replace(/'/g,"&#039;");
}

async function loadStats(){
  try{
    const response = await fetch(sheetURL);
    const csvText = await response.text();
    const rows = csvText.split("
").map(r=>r.split(",").map(c=>c.replace(/^\"|\"$/g,'').trim()));
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

⏳ Daftar ulang dilaksanakan Bulan Maret 2025.
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

// Payment functions
async function loadPayments(){
  try{
    const res = await fetch(pembayaranCSV);
    const csvText = await res.text();
    const rows = csvText.split('
').map(r=>r.split(',').map(c=>c.replace(/^\"|\"$/g,'').trim()));
    if(!rows || rows.length<2){ paymentsData=[]; renderPayments(); return; }

    const headers = rows[0].map(h=>h.trim().toLowerCase());
    const idxId = headers.findIndex(h=>h.includes('id'));
    const idxNomor = headers.findIndex(h=>h.includes('nomorpendaftar')||h.includes('nomor'));
    const idxNama = headers.findIndex(h=>h.includes('nama'));
    const idxTanggal = headers.findIndex(h=>h.includes('tanggal'));
    const idxJenis = headers.findIndex(h=>h.includes('jenis'));
    const idxNominal = headers.findIndex(h=>h.includes('nominal'));
    const idxStatus = headers.findIndex(h=>h.includes('status'));
    const idxBukti = headers.findIndex(h=>h.includes('bukti'));

    paymentsData = [];
    for(let i=1;i<rows.length;i++){
      const r = rows[i];
      if(!r || r.length < 2) continue;
      paymentsData.push({
        id: r[idxId]||('',i),
        nomor: r[idxNomor]||'',
        nama: r[idxNama]||'',
        tanggal: r[idxTanggal]||'',
        jenis: r[idxJenis]||'',
        nominal: r[idxNominal]||'',
        status: r[idxStatus]||'',
        bukti: r[idxBukti]||''
      });
    }

    renderPayments();
  }catch(err){console.error('Gagal load payments',err); paymentsData=[]; renderPayments();}
}

function renderPayments(){
  // stats
  document.getElementById('totalPayments').textContent = paymentsData.length;
  document.getElementById('paidCount').textContent = paymentsData.filter(p=>String(p.status).toLowerCase()==='lunas').length;
  document.getElementById('unpaidCount').textContent = paymentsData.filter(p=>String(p.status).toLowerCase()!=='lunas').length;
  const totalNom = paymentsData.reduce((s,p)=>s + (Number(String(p.nominal).replace(/[^0-9]/g,''))||0),0);
  document.getElementById('totalNominal').textContent = totalNom.toLocaleString('id-ID');

  // desktop table
  const tbody = document.getElementById('paymentsTable');
  if(tbody) tbody.innerHTML = '';
  paymentsData.forEach(p=>{
    if(tbody){
      const tr = document.createElement('tr');
      tr.innerHTML = `
        <td>${escapeHtml(p.id||'')}</td>
        <td>${escapeHtml(p.nomor||'')}</td>
        <td>${escapeHtml(p.nama||'')}</td>
        <td>${escapeHtml(p.tanggal||'')}</td>
        <td>${escapeHtml(p.jenis||'')}</td>
        <td>${escapeHtml(p.nominal||'')}</td>
        <td>${escapeHtml(p.status||'')}</td>
        <td>
          <button onclick="openEditPayment('${p.id}')" class="px-2 py-1 rounded bg-yellow-500 text-white text-xs">Edit</button>
          <button onclick="deletePayment('${p.id}')" class="px-2 py-1 rounded bg-red-500 text-white text-xs">Hapus</button>
        </td>
      `;
      tbody.appendChild(tr);
    }
  });

  // mobile
  const mcont = document.getElementById('paymentsMobileContainer');
  if(mcont) mcont.innerHTML='';
  paymentsData.forEach((p,i)=>{
    const card = document.createElement('div');
    card.classList.add('mobile-card');
    card.innerHTML = `
      <div class="flex justify-between mb-2"><div class="font-semibold text-sm">#${i+1}</div><div class="text-xs text-gray-500">${escapeHtml(p.tanggal||'')}</div></div>
      <div class="mb-1"><span class="font-semibold text-xs">Nama:</span> ${escapeHtml(p.nama||'')}</div>
      <div class="mb-1"><span class="font-semibold text-xs">Nomor:</span> ${escapeHtml(p.nomor||'')}</div>
      <div class="mb-1"><span class="font-semibold text-xs">Jenis:</span> ${escapeHtml(p.jenis||'')}</div>
      <div class="mb-1"><span class="font-semibold text-xs">Nominal:</span> ${escapeHtml(p.nominal||'')}</div>
      <div class="mb-1"><span class="font-semibold text-xs">Status:</span> ${escapeHtml(p.status||'')}</div>
      <div class="flex justify-end items-center mt-2 gap-2">
        <button onclick="openEditPayment('${p.id}')" class="px-3 py-1 bg-yellow-500 text-white rounded text-xs">Edit</button>
        <button onclick="deletePayment('${p.id}')" class="px-3 py-1 bg-red-500 text-white rounded text-xs">Hapus</button>
      </div>
    `;
    mcont.appendChild(card);
  });
}

function openAddPaymentModal(){
  document.getElementById('paymentModalTitle').textContent = 'Tambah Pembayaran';
  document.getElementById('pay_nomor').value = '';
  document.getElementById('pay_nama').value = '';
  document.getElementById('pay_tanggal').value = '';
  document.getElementById('pay_jenis').value = 'Seragam';
  document.getElementById('pay_nominal').value = '';
  document.getElementById('pay_status').value = 'Lunas';
  document.getElementById('pay_bukti').value = '';
  document.getElementById('paymentSaveBtn').dataset.action = 'add';
  document.getElementById('paymentSaveBtn').dataset.id = '';
  document.getElementById('paymentModal').classList.remove('hidden');
}

function closePaymentModal(){ document.getElementById('paymentModal').classList.add('hidden'); }

function openEditPayment(id){
  const p = paymentsData.find(x=>String(x.id)===String(id));
  if(!p) return alert('Data tidak ditemukan');
  document.getElementById('paymentModalTitle').textContent = 'Edit Pembayaran';
  document.getElementById('pay_nomor').value = p.nomor||'';
  document.getElementById('pay_nama').value = p.nama||'';
  document.getElementById('pay_tanggal').value = p.tanggal||'';
  document.getElementById('pay_jenis').value = p.jenis||'Seragam';
  document.getElementById('pay_nominal').value = p.nominal||'';
  document.getElementById('pay_status').value = p.status||'Lunas';
  document.getElementById('pay_bukti').value = p.bukti||'';
  document.getElementById('paymentSaveBtn').dataset.action = 'update';
  document.getElementById('paymentSaveBtn').dataset.id = p.id||'';
  document.getElementById('paymentModal').classList.remove('hidden');
}

async function savePayment(){
  const action = document.getElementById('paymentSaveBtn').dataset.action || 'add';
  const id = document.getElementById('paymentSaveBtn').dataset.id || '';
  const payload = {
    action: action,
    id: id,
    nomor: document.getElementById('pay_nomor').value,
    nama: document.getElementById('pay_nama').value,
    tanggal: document.getElementById('pay_tanggal').value,
    jenis: document.getElementById('pay_jenis').value,
    nominal: document.getElementById('pay_nominal').value,
    status: document.getElementById('pay_status').value,
    bukti: document.getElementById('pay_bukti').value
  };

  if(!PAY_API_URL || PAY_API_URL.includes('PASTE')) return alert('Belum ada API URL Apps Script. Silakan deploy Web App lalu masukkan URL di variabel PAY_API_URL.');

  try{
    const res = await fetch(PAY_API_URL,{
      method:'POST',
      body: JSON.stringify(payload)
    });
    const j = await res.json();
    if(j.status==='success' || j.status==='updated' || j.status==='deleted'){
      closePaymentModal();
      setTimeout(loadPayments,500);
      alert('Sukses: '+j.status);
    } else {
      alert('Gagal: '+JSON.stringify(j));
    }
  }catch(err){console.error(err); alert('Error saat menghubungi API');}
}

async function deletePayment(id){
  if(!confirm('Yakin ingin menghapus pembayaran ini?')) return;
  if(!PAY_API_URL || PAY_API_URL.includes('PASTE')) return alert('Belum ada API URL Apps Script. Silakan deploy Web App lalu masukkan URL di variabel PAY_API_URL.');
  try{
    const res = await fetch(PAY_API_URL,{method:'POST',body:JSON.stringify({action:'delete',id})});
    const j = await res.json();
    if(j.status==='deleted'){
      setTimeout(loadPayments,300);
      alert('Data dihapus');
    } else alert('Gagal: '+JSON.stringify(j));
  } catch(err){console.error(err); alert('Error saat menghapus');}
}

// Download payments as Excel
function downloadPaymentsExcel(){
  if(!paymentsData || paymentsData.length===0){ alert('Data pembayaran kosong'); return; }
  const wb = XLSX.utils.book_new();
  const wsData = [["ID","NomorPendaftar","Nama","Tanggal","Jenis","Nominal","Status","Bukti"]];
  paymentsData.forEach(p=>{
    wsData.push([p.id||'',p.nomor||'',p.nama||'',p.tanggal||'',p.jenis||'',p.nominal||'',p.status||'',p.bukti||'']);
  });
  const ws = XLSX.utils.aoa_to_sheet(wsData);
  XLSX.utils.book_append_sheet(wb,ws,'Pembayaran');
  XLSX.writeFile(wb,'laporan_pembayaran.xlsx');
}

// filters search
function setupPaymentSearch(){
  const s = document.getElementById('searchPayment');
  const f = document.getElementById('filterStatus');
  if(s) s.addEventListener('input',()=>{
    const q = s.value.trim().toLowerCase();
    const rows = paymentsData.filter(p=>{
      return (p.nama||'').toLowerCase().includes(q) || (p.nomor||'').toLowerCase().includes(q) || (p.jenis||'').toLowerCase().includes(q);
    });
    renderPaymentsFiltered(rows);
  });
  if(f) f.addEventListener('change',()=>{
    const v = f.value;
    const rows = v==='all'? paymentsData : paymentsData.filter(p=>String(p.status)===v);
    renderPaymentsFiltered(rows);
  });
}

function renderPaymentsFiltered(rows){
  // reuse rendering logic but with provided rows
  const tbody = document.getElementById('paymentsTable');
  if(tbody) tbody.innerHTML = '';
  rows.forEach(p=>{
    if(tbody){
      const tr = document.createElement('tr');
      tr.innerHTML = `
        <td>${escapeHtml(p.id||'')}</td>
        <td>${escapeHtml(p.nomor||'')}</td>
        <td>${escapeHtml(p.nama||'')}</td>
        <td>${escapeHtml(p.tanggal||'')}</td>
        <td>${escapeHtml(p.jenis||'')}</td>
        <td>${escapeHtml(p.nominal||'')}</td>
        <td>${escapeHtml(p.status||'')}</td>
        <td>
          <button onclick="openEditPayment('${p.id}')" class="px-2 py-1 rounded bg-yellow-500 text-white text-xs">Edit</button>
          <button onclick="deletePayment('${p.id}')" class="px-2 py-1 rounded bg-red-500 text-white text-xs">Hapus</button>
        </td>
      `;
      tbody.appendChild(tr);
    }
  });

  const mcont = document.getElementById('paymentsMobileContainer');
  if(mcont) mcont.innerHTML='';
  rows.forEach((p,i)=>{
    const card = document.createElement('div');
    card.classList.add('mobile-card');
    card.innerHTML = `
      <div class="flex justify-between mb-2"><div class="font-semibold text-sm">#${i+1}</div><div class="text-xs text-gray-500">${escapeHtml(p.tanggal||'')}</div></div>
      <div class="mb-1"><span class="font-semibold text-xs">Nama:</span> ${escapeHtml(p.nama||'')}</div>
      <div class="mb-1"><span class="font-semibold text-xs">Nomor:</span> ${escapeHtml(p.nomor||'')}</div>
      <div class="mb-1"><span class="font-semibold text-xs">Jenis:</span> ${escapeHtml(p.jenis||'')}</div>
      <div class="mb-1"><span class="font-semibold text-xs">Nominal:</span> ${escapeHtml(p.nominal||'')}</div>
      <div class="mb-1"><span class="font-semibold text-xs">Status:</span> ${escapeHtml(p.status||'')}</div>
      <div class="flex justify-end items-center mt-2 gap-2">
        <button onclick="openEditPayment('${p.id}')" class="px-3 py-1 bg-yellow-500 text-white rounded text-xs">Edit</button>
        <button onclick="deletePayment('${p.id}')" class="px-3 py-1 bg-red-500 text-white rounded text-xs">Hapus</button>
      </div>
    `;
    mcont.appendChild(card);
  });
}

function scrollToSection(id){
  const el=document.getElementById(id);
  if(el) el.scrollIntoView({behavior:'smooth',block:'start'});
  document.querySelectorAll('nav.bottom-nav a').forEach(a=>a.classList.remove('active'));
  if(id==='pendaftar') document.getElementById('navData').classList.add('active');
  else if(id==='pembayaran') document.getElementById('navPay').classList.add('active');
  else document.getElementById('navStats').classList.add('active');
}

// ===== Fungsi download Excel pendaftar (tetap ada) =====
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

// Payment search/filter setup
setupPaymentSearch();

// initial load
loadStats();
loadPayments();
</script>
</body>
</html>
