<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width,initial-scale=1,viewport-fit=cover" />
<title>Manajemen Pembayaran - PMB MTs Sunan Kalijaga</title>
<link rel="icon" type="image/png" href="assets/LOGOMADA.png">

<!-- Tailwind + Chart.js -->
<script src="https://cdn.tailwindcss.com"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
:root{--accent:#2563eb;--bg:#f3f6fb;--card:#ffffff;--muted:#64748b}
html,body{height:100%;margin:0;font-family:Inter,system-ui,-apple-system,Segoe UI,Roboto;background:var(--bg);color:#0f172a;-webkit-font-smoothing:antialiased;}
.appbar{position:fixed;left:0;right:0;top:0;height:64px;padding:12px 16px;background:linear-gradient(90deg,#fff,#f8fbff);display:flex;align-items:center;justify-content:space-between;z-index:40;border-bottom:1px solid rgba(15,23,42,0.03);box-shadow:0 4px 16px rgba(2,6,23,0.06)}
.container{padding-top:80px;max-width:1100px;margin:0 auto;padding-left:14px;padding-right:14px}
.card{background:var(--card);border-radius:12px;padding:12px;box-shadow:0 6px 18px rgba(2,6,23,0.05);margin-bottom:12px}
.table-scroll{overflow-x:auto}
.table{width:100%;border-collapse:collapse;min-width:760px;background:var(--card)}
thead th{background:var(--accent);color:white;padding:10px 12px;text-align:left;font-size:12px}
tbody td{padding:10px 12px;background:var(--card);border-bottom:1px solid #f1f5f9;font-size:13px}
.controls{display:flex;gap:8px;flex-wrap:wrap;margin-bottom:12px;align-items:center}
.btn{padding:8px 12px;border-radius:8px;background:var(--accent);color:white;border:none;cursor:pointer}
.btn.ghost{background:white;color:var(--accent);border:1px solid rgba(37,99,235,0.12)}
.hidden{display:none}
.bottom-fixed{position:fixed;left:12px;right:12px;bottom:12px;height:64px;background:linear-gradient(180deg,#ffffff,#fbfdff);border-radius:16px;display:flex;align-items:center;justify-content:space-around;box-shadow:0 12px 30px rgba(2,6,23,0.12);z-index:50;border:1px solid rgba(15,23,42,0.03)}
.mobile-card{background:var(--card);border-radius:12px;padding:12px;margin-bottom:12px}
.label-xs{font-size:12px;color:var(--muted)}
.stats-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:10px}
@media(max-width:767px){.stats-grid{grid-template-columns:repeat(2,1fr)}}

/* MOBILE RESPONSIVE FIX */
@media(max-width: 640px){
  .controls { flex-direction: column; align-items:stretch; }
  .controls input, .controls select, .controls button { width:100%; }
  .table-scroll { display: none; }
  #paymentsMobile { display: block; }
  .bottom-fixed { left:8px; right:8px; bottom:8px; height:68px; }
}

/* default desktop hide mobile list */
#paymentsMobile { display: none; }
</style>
</head>
<body>

<header class="appbar" role="banner">
  <div>
    <div class="title font-bold">PMB MTs Sunan Kalijaga</div>
    <div class="subtitle text-xs" style="color:var(--muted)">Manajemen Pembayaran & Laporan</div>
  </div>
  <div><img src="assets/LOGOMADA.png" alt="logo" style="width:40px;height:40px;border-radius:8px;object-fit:cover"></div>
</header>

<main class="container" role="main">

  <!-- Controls -->
  <div class="card">
    <div class="flex items-center justify-between gap-4 flex-wrap">
      <div style="flex:1">
        <div class="controls">
          <input id="globalSearch" type="text" placeholder="Cari nama / nomor / jenis..." class="p-2 rounded border" />
          <select id="filterStatus" class="p-2 rounded border">
            <option value="all">Semua Status</option>
            <option value="Belum">Belum</option>
            <option value="Sudah">Sudah</option>
          </select>
          <select id="filterJenis" class="p-2 rounded border">
            <option value="all">Semua Jenis</option>
            <option value="Seragam">Seragam</option>
            <option value="Administrasi">Administrasi</option>
            <option value="Pangkal">Pangkal</option>
            <option value="Daftar Ulang">Daftar Ulang</option>
          </select>
          <input id="dateFrom" type="date" class="p-2 rounded border" />
          <input id="dateTo" type="date" class="p-2 rounded border" />
          <button class="btn" onclick="applyFilters()">Terapkan</button>
          <button class="btn ghost" onclick="resetFilters()">Reset</button>
        </div>
      </div>

      <!-- cek pembayaran siswa -->
      <div style="min-width:260px">
        <div class="label-xs">Cek Pembayaran Siswa</div>
        <div class="flex gap-2 mt-1">
          <input id="cekNomor" placeholder="Nomor Pendaftar (mis: P0001)" class="p-2 rounded border flex-1" />
          <button class="btn" onclick="cekSiswa()">Cek</button>
        </div>
        <div id="cekResult" class="mt-2 label-xs" style="min-height:20px;color:var(--muted)"></div>
      </div>
    </div>
  </div>

  <!-- Stats -->
  <section class="card">
    <div class="stats-grid">
      <div>
        <div class="label-xs">Total Transaksi</div>
        <div id="statTotal" class="text-2xl font-bold">0</div>
      </div>
      <div>
        <div class="label-xs">Total Nominal (Rp)</div>
        <div id="statAmount" class="text-2xl font-bold">0</div>
      </div>
      <div>
        <div class="label-xs">Sudah Bayar</div>
        <div id="statPaid" class="text-2xl font-bold">0</div>
      </div>
      <div>
        <div class="label-xs">Belum Bayar</div>
        <div id="statUnpaid" class="text-2xl font-bold">0</div>
      </div>
    </div>

    <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
      <canvas id="chartStatus" style="min-height:220px"></canvas>
      <canvas id="chartJenis" style="min-height:220px"></canvas>
    </div>
  </section>

  <!-- Table (desktop) -->
  <section class="card mt-4">
    <div class="table-scroll">
      <table class="table" aria-describedby="Data pembayaran">
        <thead>
          <tr>
            <th>No</th>
            <th>ID</th>
            <th>Nomor</th>
            <th>Nama</th>
            <th>Tanggal</th>
            <th>Jenis</th>
            <th>Nominal</th>
            <th>Status</th>
            <th>Bukti</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody id="paymentsTable"></tbody>
      </table>
    </div>

    <!-- Mobile list (cards) -->
    <div id="paymentsMobile" class="mt-2"></div>
  </section>

  <!-- Form inline -->
  <section id="formSection" class="card hidden">
    <h3 class="font-semibold mb-2" id="formHeading">Tambah Pembayaran</h3>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
      <input id="f_nomor" placeholder="Nomor Pendaftar" class="p-2 border rounded" />
      <input id="f_nama" placeholder="Nama" class="p-2 border rounded" />
      <input id="f_tanggal" type="date" class="p-2 border rounded" />
      <input id="f_jenis" placeholder="Jenis (Seragam/Administrasi...)" class="p-2 border rounded" />
      <input id="f_nominal" type="number" placeholder="Nominal" class="p-2 border rounded" />
      <select id="f_status" class="p-2 border rounded"><option>Belum</option><option>Sudah</option></select>
      <input id="f_bukti" placeholder="Link bukti (opsional)" class="p-2 border rounded col-span-2" />
    </div>
    <div class="mt-3 flex gap-2">
      <button class="btn" onclick="saveForm()">Simpan</button>
      <button class="btn ghost" onclick="closeForm()">Batal</button>
    </div>
  </section>

</main>

<!-- bottom nav (buttons, no href '#') -->
<nav class="bottom-fixed" aria-label="navigation">
  <button onclick="window.location='index.html'" class="text-center text-xs">Home</button>
  <button onclick="window.location='pembayaran.php'" class="text-center text-xs">Pembayaran</button>
  <button onclick="window.location='pendaftar.html'" class="text-center text-xs">Data</button>
  <button onclick="openPrintAll()" class="text-center text-xs">Print All</button>
</nav>

<!-- SCRIPT -->
<script>
/* CONFIG: ganti API_URL dengan URL Web App Anda bila berbeda */
const API_URL = "https://script.google.com/macros/s/AKfycbzr1ElBgZGXk5VcAWV7PHifa3gYozlB7iUAZso0Q82vNkxdOI9Im1hjRYZi_MN2XMQFkQ/exec";

/* State */
let payments = [];
let filtered = [];
let statusChart = null;
let jenisChart = null;
let editingId = "";

/* Helpers */
function fmtRp(n){ return Number(n||0).toLocaleString('id-ID'); }
function escapeHtml(s){ if(s===null||s===undefined) return ""; return String(s).replace(/&/g,"&amp;").replace(/</g,"&lt;").replace(/>/g,"&gt;").replace(/\"/g,"&quot;"); }
function escapeJS(s){ return (s+"").replace(/'/g,"\\'").replace(/"/g,'\\"'); }
function isBetween(dateStr, fromStr, toStr){
  if(!dateStr) return false;
  const d = new Date(dateStr);
  if(fromStr){ const f = new Date(fromStr); if(d < f) return false; }
  if(toStr){ const t = new Date(toStr); t.setHours(23,59,59); if(d > t) return false; }
  return true;
}

/* Load payments from API */
async function loadPayments(){
  try{
    const res = await fetch(API_URL);
    const data = await res.json();
    // normalize keys
    payments = data.map(r=>{
      const mapKey = key => {
        if(r[key] !== undefined) return r[key];
        const lower = Object.keys(r).find(k=>k.toLowerCase()===key.toLowerCase());
        return lower? r[lower] : "";
      };
      return {
        ID: mapKey("ID") || mapKey("Id") || mapKey("id") || "",
        NomorPendaftar: mapKey("NomorPendaftar") || mapKey("nomor") || mapKey("nomorpendaftar") || "",
        Nama: mapKey("Nama") || mapKey("nama") || "",
        Tanggal: mapKey("Tanggal") || mapKey("tanggal") || "",
        Jenis: mapKey("Jenis") || mapKey("jenis") || "",
        Nominal: mapKey("Nominal") || mapKey("nominal") || 0,
        Status: mapKey("Status") || mapKey("status") || "",
        Bukti: mapKey("Bukti") || mapKey("bukti") || ""
      };
    });

    filtered = payments.slice();
    renderTable(filtered);
    renderStats(filtered);
    drawCharts(filtered);
  }catch(err){
    console.error("loadPayments error",err);
    alert("Gagal memuat data. Pastikan API_URL benar dan Web App sudah dideploy.");
  }
}

/* Render table (desktop) + mobile cards */
function renderTable(arr){
  const tbody = document.getElementById("paymentsTable");
  const mobile = document.getElementById("paymentsMobile");
  tbody.innerHTML = "";
  mobile.innerHTML = "";

  if(!arr || arr.length===0){
    tbody.innerHTML = `<tr><td colspan="10" style="padding:14px;text-align:center;color:var(--muted)">Tidak ada data</td></tr>`;
    mobile.innerHTML = `<div style="text-align:center;color:var(--muted);padding:16px">Tidak ada data</div>`;
    return;
  }

  arr.forEach((p,i)=>{
    // desktop row
    const tr = document.createElement("tr");
    tr.innerHTML = `
      <td>${i+1}</td>
      <td>${escapeHtml(p.ID)}</td>
      <td>${escapeHtml(p.NomorPendaftar)}</td>
      <td>${escapeHtml(p.Nama)}</td>
      <td>${escapeHtml(p.Tanggal)}</td>
      <td>${escapeHtml(p.Jenis)}</td>
      <td>Rp ${fmtRp(p.Nominal)}</td>
      <td>${escapeHtml(p.Status)}</td>
      <td>${p.Bukti?`<a href="${escapeHtml(p.Bukti)}" target="_blank" class="label-xs">Lihat</a>`:"-"}</td>
      <td>
        <button class="btn ghost" onclick='openEdit("${escapeJS(p.ID)}")'>Edit</button>
        <button class="btn" onclick='deletePayment("${escapeJS(p.ID)}")'>Hapus</button>
        <button class="btn ghost" onclick='printReceipt("${escapeJS(p.ID)}")'>Kwitansi</button>
      </td>
    `;
    tbody.appendChild(tr);

    // mobile card
    mobile.innerHTML += `
      <div class="mobile-card">
        <div class="flex justify-between">
          <div>
            <div class="font-semibold">${escapeHtml(p.Nama)}</div>
            <div class="label-xs">${escapeHtml(p.NomorPendaftar)} • ${escapeHtml(p.Jenis)}</div>
          </div>
          <div class="text-sm">Rp ${fmtRp(p.Nominal)}</div>
        </div>
        <div class="mt-2 text-sm text-gray-700">
          Tanggal: ${escapeHtml(p.Tanggal)}<br>
          Status: <b>${escapeHtml(p.Status)}</b><br>
          Bukti: ${p.Bukti?`<a href="${escapeHtml(p.Bukti)}" target="_blank">Lihat</a>`:"Tidak ada"}
        </div>
        <div class="mt-3 flex gap-2">
          <button class="btn ghost" style="flex:1" onclick='openEdit("${escapeJS(p.ID)}")'>Edit</button>
          <button class="btn" style="flex:1" onclick='deletePayment("${escapeJS(p.ID)}")'>Hapus</button>
        </div>
        <button class="btn ghost mt-2 w-full" onclick='printReceipt("${escapeJS(p.ID)}")'>Cetak Kwitansi</button>
      </div>
    `;
  });
}

/* Stats rendering */
function renderStats(arr){
  const total = arr.length;
  const totalNom = arr.reduce((s,p)=> s + (Number(String(p.Nominal).replace(/[^0-9]/g,''))||0),0);
  const paid = arr.filter(p=>String(p.Status).toLowerCase()==="sudah").length;
  const unpaid = total - paid;
  document.getElementById("statTotal").textContent = total;
  document.getElementById("statAmount").textContent = fmtRp(totalNom);
  document.getElementById("statPaid").textContent = paid;
  document.getElementById("statUnpaid").textContent = unpaid;
}

/* Charts */
function drawCharts(arr){
  const ctxS = document.getElementById("chartStatus").getContext("2d");
  const ctxJ = document.getElementById("chartJenis").getContext("2d");

  const statusCounts = arr.reduce((m,p)=>{
    const k = p.Status || "Belum";
    m[k] = (m[k]||0)+1; return m;
  },{});
  const sLabels = Object.keys(statusCounts);
  const sData = Object.values(statusCounts);

  const jenisCounts = arr.reduce((m,p)=>{
    const k = p.Jenis || "Lainnya";
    m[k] = (m[k]||0)+1; return m;
  },{});
  const jLabels = Object.keys(jenisCounts);
  const jData = Object.values(jenisCounts);

  if(statusChart) statusChart.destroy();
  if(jenisChart) jenisChart.destroy();

  statusChart = new Chart(ctxS, {
    type: 'doughnut',
    data: { labels: sLabels, datasets: [{ data: sData }] },
    options: { responsive:true, plugins:{legend:{position:'bottom'}}}
  });

  jenisChart = new Chart(ctxJ, {
    type: 'bar',
    data: { labels: jLabels, datasets: [{ label:'Jumlah', data: jData, borderRadius:6 }] },
    options: { responsive:true, plugins:{legend:{display:false}}, scales:{y:{beginAtZero:true}}}
  });
}

/* Filters */
function applyFilters(){
  const q = (document.getElementById("globalSearch").value||"").trim().toLowerCase();
  const status = document.getElementById("filterStatus").value;
  const jenis = document.getElementById("filterJenis").value;
  const from = document.getElementById("dateFrom").value;
  const to = document.getElementById("dateTo").value;

  filtered = payments.filter(p=>{
    if(q){
      const inq = (p.Nama||"").toLowerCase().includes(q) || (p.NomorPendaftar||"").toLowerCase().includes(q) || (p.Jenis||"").toLowerCase().includes(q);
      if(!inq) return false;
    }
    if(status!=="all" && (p.Status||"")!==status) return false;
    if(jenis!=="all" && (p.Jenis||"")!==jenis) return false;
    if(from && !isBetween(p.Tanggal, from, to || from)) return false;
    return true;
  });

  renderTable(filtered);
  renderStats(filtered);
  drawCharts(filtered);
}
function resetFilters(){
  document.getElementById("globalSearch").value = "";
  document.getElementById("filterStatus").value = "all";
  document.getElementById("filterJenis").value = "all";
  document.getElementById("dateFrom").value = "";
  document.getElementById("dateTo").value = "";
  filtered = payments.slice();
  renderTable(filtered);
  renderStats(filtered);
  drawCharts(filtered);
}

/* Form - open edit */
function openEdit(id){
  const row = payments.find(p=>String(p.ID)===String(id));
  if(!row){ alert("Data tidak ditemukan"); return; }
  editingId = id;
  document.getElementById("formSection").classList.remove("hidden");
  document.getElementById("formHeading").textContent = "Edit Pembayaran";
  document.getElementById("f_nomor").value = row.NomorPendaftar;
  document.getElementById("f_nama").value = row.Nama;
  document.getElementById("f_tanggal").value = row.Tanggal;
  document.getElementById("f_jenis").value = row.Jenis;
  document.getElementById("f_nominal").value = row.Nominal;
  document.getElementById("f_status").value = row.Status;
  document.getElementById("f_bukti").value = row.Bukti;
}
function closeForm(){ editingId=""; document.getElementById("formSection").classList.add("hidden"); document.getElementById("formHeading").textContent="Tambah Pembayaran"; }

/* Save (add/update) */
async function saveForm(){
  const body = {
    action: editingId? "update":"add",
    id: editingId,
    nomor: document.getElementById("f_nomor").value,
    nama: document.getElementById("f_nama").value,
    tanggal: document.getElementById("f_tanggal").value || new Date().toISOString().slice(0,10),
    jenis: document.getElementById("f_jenis").value,
    nominal: document.getElementById("f_nominal").value,
    status: document.getElementById("f_status").value,
    bukti: document.getElementById("f_bukti").value
  };

  try{
    const res = await fetch(API_URL, { method:"POST", headers:{'Content-Type':'application/json'}, body: JSON.stringify(body) });
    const j = await res.json();
    await loadPayments();
    closeForm();
    alert("Simpan berhasil");
  }catch(err){ console.error(err); alert("Gagal simpan"); }
}

/* Delete */
async function deletePayment(id){
  if(!confirm("Yakin hapus?")) return;
  try{
    const res = await fetch(API_URL, { method:"POST", headers:{'Content-Type':'application/json'}, body: JSON.stringify({ action:"delete", id })});
    const j = await res.json();
    await loadPayments();
    alert("Terhapus");
  }catch(err){ console.error(err); alert("Gagal hapus"); }
}

/* Sync Gelombang 1 - triggers Apps Script sync */
async function syncGelombang1(){
  if(!confirm("Sinkron semua data dari Form Responses 1 ke DU_gelombang1?")) return;
  try{
    const res = await fetch(API_URL, { method:"POST", headers:{'Content-Type':'application/json'}, body: JSON.stringify({ action: "sync", gel: 1 })});
    const j = await res.json();
    await loadPayments();
    alert(j.message || ("Insert: "+(j.inserted||0)));
  }catch(err){ console.error(err); alert("Gagal sinkron"); }
}

/* Print receipt (single) */
function printReceipt(id){
  const p = payments.find(x=>String(x.ID)===String(id));
  if(!p){ alert("Data tidak ditemukan"); return; }
  const qrText = `ID:${p.ID}|Nomor:${p.NomorPendaftar}|Nama:${p.Nama}|Nominal:${p.Nominal}|Tanggal:${p.Tanggal}`;
  const qrUrl = `https://chart.googleapis.com/chart?cht=qr&chs=200x200&chl=${encodeURIComponent(qrText)}`;
  const win = window.open("","_blank","width=600,height=700");
  const html = `
    <html><head><title>Kwitansi - ${escapeHtml(p.NomorPendaftar)}</title>
    <style>body{font-family:Arial;padding:20px} .box{border:1px solid #ddd;padding:16px;border-radius:8px} .h{font-weight:700;font-size:18px;margin-bottom:6px}</style>
    </head><body>
    <div class="box">
      <div class="h">KWITANSI PEMBAYARAN</div>
      <div>No: ${escapeHtml(p.ID)}</div>
      <div>Nomor Pendaftar: <b>${escapeHtml(p.NomorPendaftar)}</b></div>
      <div>Nama: <b>${escapeHtml(p.Nama)}</b></div>
      <div>Tanggal: ${escapeHtml(p.Tanggal)}</div>
      <div>Jenis: ${escapeHtml(p.Jenis)}</div>
      <div>Nominal: Rp ${fmtRp(p.Nominal)}</div>
      <div>Status: ${escapeHtml(p.Status)}</div>
      <div style="margin-top:12px"><img src="${qrUrl}" alt="QR" /></div>
      <div style="margin-top:12px;font-size:12px;color:#666">Dicetak: ${new Date().toLocaleString()}</div>
    </div>
    <script>window.onload=function(){window.print();}</script>
    </body></html>
  `;
  win.document.open();
  win.document.write(html);
  win.document.close();
}

/* Print All simple report */
function openPrintAll(){
  let rows = payments.map((p,i)=>`<tr><td>${i+1}</td><td>${escapeHtml(p.NomorPendaftar)}</td><td>${escapeHtml(p.Nama)}</td><td>${escapeHtml(p.Tanggal)}</td><td>Rp ${fmtRp(p.Nominal)}</td><td>${escapeHtml(p.Status)}</td></tr>`).join("");
  const win = window.open("","_blank","width=900,height=700");
  const doc = `
    <html><head><title>Laporan Pembayaran</title><style>table{width:100%;border-collapse:collapse}th,td{border:1px solid #ccc;padding:6px}</style></head><body>
    <h3>Laporan Pembayaran - ${new Date().toLocaleDateString()}</h3>
    <table><thead><tr><th>No</th><th>Nomor</th><th>Nama</th><th>Tanggal</th><th>Nominal</th><th>Status</th></tr></thead><tbody>${rows}</tbody></table>
    <script>window.onload=function(){window.print();}</script>
    </body></html>
  `;
  win.document.open(); win.document.write(doc); win.document.close();
}

/* Cek siswa by nomor */
function cekSiswa(){
  const nomor = (document.getElementById("cekNomor").value||"").trim();
  const elem = document.getElementById("cekResult");
  if(!nomor){ elem.textContent = "Masukkan nomor pendaftar."; return; }
  const list = payments.filter(p => String(p.NomorPendaftar).toLowerCase()===nomor.toLowerCase());
  if(list.length===0){ elem.textContent = "Tidak ditemukan pembayaran untuk nomor ini."; return; }
  elem.innerHTML = `Ditemukan ${list.length} transaksi — total: Rp ${fmtRp(list.reduce((s,p)=>s+(Number(String(p.Nominal).replace(/[^0-9]/g,''))||0),0))}. <button class="btn ghost" onclick="showStudentDetails('${escapeJS(nomor)}')">Lihat</button>`;
}
function showStudentDetails(nomor){
  const list = payments.filter(p => String(p.NomorPendaftar).toLowerCase()===nomor.toLowerCase());
  if(list.length===0){ alert("Tidak ditemukan"); return; }
  let html = `Transaksi untuk <b>${nomor}</b>:<br/><ul>`;
  list.forEach(p => html += `<li>${escapeHtml(p.Tanggal)} — ${escapeHtml(p.Jenis)} — Rp ${fmtRp(p.Nominal)} — ${escapeHtml(p.Status)} <button onclick="printReceipt('${escapeJS(p.ID)}')">Kwitansi</button></li>`);
  html += "</ul>";
  const w = window.open("","_blank","width=600,height=500");
  w.document.write(`<html><body style="font-family:Arial;padding:20px"><h3>Riwayat Pembayaran ${nomor}</h3>${html}</body></html>`);
  w.document.close();
}

/* Init */
loadPayments();

</script>
</body>
</html>
