<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>PMB MTs Sunan Kalijaga – Dashboard</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="icon" type="image/png" href="assets/LOGOMADA.png">
<script src="https://cdn.tailwindcss.com"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
    /* sidebar animation */
    .sidebar {
        transition: all 0.3s ease-in-out;
    }
</style>
</head>
<body class="bg-gray-100 flex">

<!-- SIDEBAR -->
<aside id="sidebar" class="sidebar w-64 bg-white shadow-xl h-screen fixed md:relative transform -translate-x-full md:translate-x-0">
    <div class="p-6 border-b">
        <h1 class="font-bold text-xl text-blue-700">PMB Dashboard</h1>
        <p class="text-sm text-gray-500">MTs Sunan Kalijaga</p>
    </div>

    <nav class="p-4 space-y-3">
        <a href="#" class="block px-4 py-2 rounded-lg bg-blue-600 text-white font-medium">Dashboard</a>
        <a href="#stats" class="block px-4 py-2 rounded-lg hover:bg-blue-100">Statistik</a>
        <a href="#pendaftar" class="block px-4 py-2 rounded-lg hover:bg-blue-100">Data Pendaftar</a>
    </nav>
</aside>

<!-- MAIN CONTENT -->
<div class="flex-1 ml-0 md:ml-64">

    <!-- TOP NAVBAR -->
    <header class="bg-white shadow p-4 flex items-center justify-between">
        <button onclick="toggleSidebar()" class="md:hidden bg-blue-600 text-white px-3 py-2 rounded">
            Menu
        </button>
        <h2 class="text-xl font-semibold">Dashboard Penerimaan</h2>
    </header>

    <!-- MAIN CONTENT -->
    <main class="p-6 space-y-10">

        <!-- ==================== -->
        <!--  STATISTIK SECTION   -->
        <!-- ==================== -->
        <section id="stats" class="mt-6">
            <h2 class="text-2xl font-bold mb-6">Statistik Pendaftar</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Card Gender -->
                <div class="bg-white p-6 shadow rounded-xl">
                    <h3 class="font-semibold mb-4 text-gray-700">Jenis Kelamin</h3>
                    <canvas id="genderChart"></canvas>
                </div>

                <!-- Card Ponpes -->
                <div class="bg-white p-6 shadow rounded-xl">
                    <h3 class="font-semibold mb-4 text-gray-700">Pilihan Pondok</h3>
                    <canvas id="ponpesChart"></canvas>
                </div>

            </div>

            <div class="mt-6 text-center">
                <span id="totalSiswa"
                    class="bg-blue-600 text-white px-6 py-3 rounded-full font-semibold shadow">
                    Total Siswa Terdaftar: 0
                </span>
            </div>
        </section>

        <!-- ==================== -->
        <!--   DATA PENDAFTAR     -->
        <!-- ==================== -->
        <section id="pendaftar" class="mt-10">
            <h2 class="text-2xl font-bold mb-6">Data Pendaftar</h2>

            <div class="flex flex-col md:flex-row gap-4 items-center mb-4">

                <input id="searchInput" placeholder="Cari siswa..."
                    class="border p-2 rounded w-full md:w-1/2">

                <select id="gelombangFilter" class="border p-2 rounded">
                    <option value="all">Semua Gelombang</option>
                    <option value="1">Gelombang 1</option>
                    <option value="2">Gelombang 2</option>
                    <option value="3">Gelombang 3</option>
                </select>
            </div>

            <div class="overflow-x-auto bg-white shadow rounded-xl">
                <table class="min-w-full text-sm">
                    <thead class="bg-blue-600 text-white">
                        <tr>
                            <th class="px-4 py-2">No</th>
                            <th class="px-4 py-2">Asal Sekolah</th>
                            <th class="px-4 py-2">Nama</th>
                            <th class="px-4 py-2">Alamat</th>
                            <th class="px-4 py-2">Gender</th>
                            <th class="px-4 py-2">Pondok</th>
                            <th class="px-4 py-2">HP</th>
                            <th class="px-4 py-2">Status</th>
                            <th class="px-4 py-2">Kontak</th>
                        </tr>
                    </thead>
                    <tbody id="pendaftarTable" class="divide-y"></tbody>
                </table>
            </div>

        </section>

    </main>
</div>

<script>
function toggleSidebar() {
    document.getElementById("sidebar").classList.toggle("-translate-x-full");
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
