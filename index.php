<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>PMB MTs Sunan Kalijaga - Dashboard</title>
<link rel="icon" href="assets/LOGOMADA.png">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
  body { font-family: Inter, ui-sans-serif, system-ui; background:#f3f6fb; margin:0; }
  .appbar { display:flex; justify-content:space-between; align-items:center; padding:12px 16px; background:#2563eb; color:#fff; }
  .appbar .title { font-weight:700; font-size:16px; }
  .appbar .subtitle { font-size:12px; opacity:0.8; }
  .container { padding:16px; max-width:1200px; margin:auto; }
  .cards { display:grid; grid-template-columns: repeat(4,1fr); gap:12px; margin-bottom:16px; }
  .card { background:#fff; border-radius:12px; padding:12px; box-shadow:0 4px 10px rgba(0,0,0,0.05); }
  .card .label { font-size:12px; color:#475569; font-weight:600; }
  .card .value { font-size:20px; font-weight:700; color:#0f172a; margin-top:4px; }
  .charts { display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:16px; }
  .chart-card { background:#fff; border-radius:12px; padding:12px; box-shadow:0 4px 10px rgba(0,0,0,0.05); }
  .chart-card .head { margin-bottom:8px; }
  .chart-card .font-semibold { font-weight:600; font-size:14px; color:#0f172a; }
  .chart-card .text-xs { font-size:12px; color:#64748b; }

  .controls-section { display:flex; flex-wrap:wrap; justify-content:space-between; gap:8px; margin-bottom:12px; }
  .controls-section input, .controls-section select { padding:8px 10px; border-radius:8px; border:1px solid #cbd5e1; font-size:14px; }

  /* Table Desktop */
  .desktop-only { display:block; }
  .mobile-only { display:none; }
  .table-scroll { overflow-x:auto; }
  .table-wrap { min-width:1000px; }
  table { width:100%; border-collapse:collapse; }
  th, td { padding:10px 12px; text-align:left; border-bottom:1px solid #e2e8f0; white-space:nowrap; }
  th { background:linear-gradient(90deg,#2563eb,#7c3aed); color:#fff; font-size:13px; }

  /* Mobile card */
  .mobile-card { background:#fff; border:1px solid #ddd; border-radius:10px; padding:12px; margin-bottom:10px; }
  .mobile-card .row { display:flex; justify-content:space-between; margin-bottom:6px; }
  .mobile-card .label { font-weight:600; color:#333; font-size:13px; }
  .mobile-card .value { color:#555; font-size:13px; }
  .btn-wa { background:#10b981; color:#fff; padding:4px 8px; border-radius:6px; font-size:12px; text-decoration:none; }

  /* Floating button */
  .floating-button {
    position:fixed; bottom:24px; right:24px; z-index:60;
    width:56px; height:56px; border-radius:12px; background:#2563eb; color:white;
    display:flex; align-items:center; justify-content:center; box-shadow: 0 8px 24px rgba(37,99,235,0.18); font-size:24px;
    text-decoration:none;
  }

  @media(max-width:640px){
    .cards { grid-template-columns:1fr; }
    .charts { grid-template-columns:1fr; }
    .desktop-only { display:none; }
    .mobile-only { display:block; }
  }
</style>
</head>
<body>

<!-- Appbar -->
<header class="appbar">
  <div>
    <div class="title">PMB MTs Sunan Kalijaga</div>
    <div class="subtitle">Admin • Tampilan Aplikasi</div>
  </div>
  <div>
    <img src="assets/LOGOMADA.png" alt="logo" style="width:40px;height:40px;border-radius:10px;object-fit:cover">
  </div>
</header>

<main class="app-main">
  <div class="container">

    <!-- Cards -->
    <section class="cards">
      <div class="card">
        <div class="label">Total Siswa Terdaftar</div>
        <div id="totalSiswa" class="value">0</div>
      </div>
      <div class="card">
        <div class="label">Kuota per Gelombang</div>
        <div class="value">30</div>
      </div>
      <div class="card">
        <div class="label">Terhubung via WA</div>
        <div id="waCount" class="value">0</div>
      </div>
      <div class="card">
        <div class="label">Pilihan Pondok Teratas</div>
        <div id="topPonpes" class="value">-</div>
      </div>
    </section>

    <!-- Charts -->
    <section class="charts" id="stats">
      <div class="chart-card">
        <div class="head">
          <div class="font-semibold">Jenis Kelamin</div>
          <div class="text-xs muted">Distribusi pendaftar</div>
        </div>
        <canvas id="genderChart"></canvas>
      </div>
      <div class="chart-card">
        <div class="head">
          <div class="font-semibold">Pilihan Pondok</div>
          <div class="text-xs muted">Preferensi pondok pesantren</div>
        </div>
        <canvas id="ponpesChart"></canvas>
      </div>
    </section>

    <!-- Controls -->
    <section class="controls-section">
      <input type="text" id="searchInput" placeholder="Cari: nama, sekolah, alamat, pondok..." />
      <div style="display:flex;gap:8px;align-items:center;">
        <label class="text-xs muted">Pilih Gelombang</label>
        <select id="gelombangFilter">
          <option value="all">Semua Gelombang</option>
          <option value="1">Gelombang 1 (1–30)</option>
          <option value="2">Gelombang 2 (31–60)</option>
          <option value="3">Gelombang 3 (61–90)</option>
        </select>
      </div>
    </section>

    <!-- Table Desktop -->
    <section class="desktop-only">
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
            <tbody id="pendaftarTable"></tbody>
          </table>
        </div>
      </div>
    </section>

    <!-- Mobile Card -->
    <section class="mobile-only">
      <div id="pendaftarCardContainer"></div>
    </section>

  </div>
</main>

<!-- Floating button -->
<a href="https://docs.google.com/forms" target="_blank" class="floating-button">✚</a>

<script>
const sheetURL = "https://docs.google.com/spreadsheets/d/e/2PACX-1vTkWDi-X_jfYIUpR04AupM-ubJ-hBT-RO6W9HSyIN5_n15SN_AD1vDNM4CW-GV_4EpIm-9MTgW1iLvl/pub?gid=1123091940&single=true&output=csv";
let globalData=[],genderChartInstance=null,ponpesChartInstance=null;

async function loadStats(){
  const res = await fetch(sheetURL);
  const csvText = await res.text();
  const rows = csvText.split("\n").map(r=>r.split(",").map(c=>c.replace(/^"|"$/g,'').trim()));
  const headers = rows[0].map(h=>h.trim());
  const colNama=headers.findIndex(h=>h.toLowerCase().includes("nama"));
  const colSekolah=headers.findIndex(h=>h.toLowerCase().includes("asal sekolah"));
  const colAlamat=headers.findIndex(h=>h.toLowerCase().includes("alamat"));
  const colGender=headers.findIndex(h=>h.toLowerCase().includes("jenis kelamin"));
  const colPonpes=headers.findIndex(h=>h.toLowerCase().includes("pilihan pondok"));
  const colHp=headers.findIndex(h=>h.toLowerCase().includes("nomor hp"));
  const colKK=headers.findIndex(h=>h.toLowerCase().includes("kartu keluarga"));
  const colAkte=headers.findIndex(h=>h.toLowerCase().includes("akte"));
  
  let total=0;
  const tbody=document.getElementById("pendaftarTable");
  tbody.innerHTML=""; globalData=[];
  
  for(let i=1;i<rows.length;i++){
    const nama=rows[i][colNama]||"", sekolah=rows[i][colSekolah]||"", alamat=rows[i][colAlamat]||"";
    if(!nama||!alamat) continue;
    total++;
    const gender=(rows[i][colGender]||"").toLowerCase();
    const pondok=rows[i][colPonpes]||"";
    let hp=(rows[i][colHp]||"").replace(/[^0-9]/g,""); if(hp.startsWith("0")) hp="62"+hp.substring(1);
    const kk=rows[i][colKK]||"", akte=rows[i][colAkte]||"";
    const statusBerkas=(kk&&akte)?`✅ Lengkap`:`❌ Belum Lengkap`;
    const pesan=`Selamat ${nama}, Anda DITERIMA sebagai calon siswa baru.`;
    const linkWA = hp?`https://wa.me/${hp}?text=${encodeURIComponent(pesan)}`:"";

    const tr=document.createElement("tr");
    const contacted = localStorage.getItem("contacted_"+hp)?"✔️":"";
    tr.innerHTML=`<td>${total}</td><td>${sekolah}</td><td>${nama}</td><td>${alamat}</td><td>${rows[i][colGender]||""}</td><td>${pondok}</td><td>${hp}</td><td>${statusBerkas}</td><td>${hp?`<a href="${linkWA}" target="_blank" onclick="markContacted('${hp}')">WA</a>`:"-"} ${contacted}</td>`;
    tbody.appendChild(tr);

    globalData.push({nomor:total,nama,sekolah,alamat,gender,pondok,hp,linkWA,statusBerkas});
  }

  document.getElementById("totalSiswa").textContent=total;
  drawCharts(globalData); renderMobileCards(globalData); setupFilter(globalData);
}

function markContacted(num){ localStorage.setItem("contacted_"+num,true); }

function drawCharts(data){
  let male=0,female=0,ponpesCounts={};
  data.forEach(d=>{
    const g=d.gender.toLowerCase(); if(g.includes("laki")) male++; if(g.includes("perempuan")) female++;
    ponpesCounts[d.pondok]=(ponpesCounts[d.pondok]||0)+1;
  });
  if(genderChartInstance) genderChartInstance.destroy();
  if(ponpesChartInstance) ponpesChartInstance.destroy();
  genderChartInstance=new Chart(document.getElementById("genderChart"),{type:"doughnut",data:{labels:["Laki-Laki","Perempuan"],datasets:[{data:[male,female],backgroundColor:["#3b82f6","#ec4899"]}]},options:{responsive:true,plugins:{legend:{position:"bottom"}}}});
  ponpesChartInstance=new Chart(document.getElementById("ponpesChart"),{type:"doughnut",data:{labels:Object.keys(ponpesCounts),datasets:[{data:Object.values(ponpesCounts),backgroundColor:["#10b981","#f59e0b","#3b82f6","#ef4444","#8b5cf6"]}]},options:{responsive:true,plugins:{legend:{position:"bottom"}}}});
}

function setupFilter(allData){
  document.getElementById("gelombangFilter").addEventListener("change",function(){
    const val=this.value;
    let filtered = val==="all"?allData:allData.filter((d,i)=>Math.ceil((i+1)/30)==val);
    renderTable(filtered); renderMobileCards(filtered); drawCharts(filtered);
  });
}

function renderTable(data){
  const tbody=document.getElementById("pendaftarTable"); tbody.innerHTML="";
  data.forEach((d,i)=>{
    const contacted = localStorage.getItem("contacted_"+d.hp)?"✔️":"";
    const tr=document.createElement("tr");
    tr.innerHTML=`<td>${i+1}</td><td>${d.sekolah}</td><td>${d.nama}</td><td>${d.alamat}</td><td>${d.gender}</td><td>${d.pondok}</td><td>${d.hp}</td><td>${d.statusBerkas}</td><td>${d.hp?`<a href="${d.linkWA}" target="_blank" onclick="markContacted('${d.hp}')">WA</a>`:"-"} ${contacted}</td>`;
    tbody.appendChild(tr);
  });
}

function renderMobileCards(data){
  const container=document.getElementById("pendaftarCardContainer"); container.innerHTML="";
  data.forEach((d,i)=>{
    const card=document.createElement("div"); card.classList.add("mobile-card");
    card.innerHTML=`
      <div class="row"><div class="label">#</div><div class="value">${i+1}</div></div>
      <div class="row"><div class="label">Nama</div><div class="value">${d.nama}</div></div>
      <div class="row"><div class="label">Sekolah</div><div class="value">${d.sekolah}</div></div>
      <div class="row"><div class="label">Alamat</div><div class="value">${d.alamat}</div></div>
      <div class="row"><div class="label">Gender</div><div class="value">${d.gender}</div></div>
      <div class="row"><div class="label">Pondok</div><div class="value">${d.pondok}</div></div>
      <div class="row"><div class="label">HP</div><div class="value">${d.hp}</div></div>
      <div class="row"><div class="label">Status</div><div class="value">${d.statusBerkas}</div></div>
      <div class="row"><div class="label">Kontak</div><div class="value">${d.hp?`<a href="${d.linkWA}" target="_blank" class="btn-wa" onclick="markContacted('${d.hp}')">WA</a>`:"-"}</div></div>
    `;
    container.appendChild(card);
  });
}

loadStats();
</script>
</body>
</html>
