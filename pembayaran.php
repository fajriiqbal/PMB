<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width,initial-scale=1,viewport-fit=cover" />
<title>Manajemen Pembayaran - PMB MTs Sunan Kalijaga</title>

<link rel="icon" type="image/png" href="assets/LOGOMADA.png">

<!-- Tailwind CSS -->
<script src="https://cdn.tailwindcss.com"></script>

<style>
:root{
  --accent:#2563eb;
  --bg:#f3f6fb;
  --card:#ffffff;
  --muted:#64748b;
}
html,body{
    height:100%;margin:0;
    font-family:Inter,system-ui,-apple-system,Segoe UI,Roboto;
    background:var(--bg);
}
</style>

</head>
<body>

<!-- ===================================== -->
<!-- APP BAR -->
<!-- ===================================== -->
<header class="appbar fixed left-0 right-0 top-0 h-16 px-4 bg-white shadow flex items-center justify-between z-40">
    <div>
        <div class="font-bold">Manajemen Pembayaran</div>
        <div class="text-xs text-gray-500">PMB MTs Sunan Kalijaga</div>
    </div>
    <img src="assets/LOGOMADA.png" class="w-10 h-10 rounded-lg">
</header>

<main class="pt-20 pb-28 max-w-5xl mx-auto px-4">


<!-- ===================================== -->
<!-- BUTTON TAMBAH + SYNC -->
<!-- ===================================== -->
<div class="flex justify-between mb-4">
    <button onclick="showForm()" class="px-4 py-2 bg-blue-600 text-white rounded-lg shadow">
        + Tambah Pembayaran
    </button>

    <button onclick="syncGelombang1()" class="px-4 py-2 bg-emerald-600 text-white rounded-lg shadow">
        🔄 Sync Gelombang 1
    </button>
</div>


<!-- ===================================== -->
<!-- TABLE PEMBAYARAN -->
<!-- ===================================== -->
<div class="bg-white shadow rounded-lg overflow-hidden">
<table class="w-full text-sm">
    <thead class="bg-blue-600 text-white">
        <tr>
            <th class="p-2">No</th>
            <th class="p-2">ID</th>
            <th class="p-2">Nomor</th>
            <th class="p-2">Nama</th>
            <th class="p-2">Tanggal</th>
            <th class="p-2">Jenis</th>
            <th class="p-2">Nominal</th>
            <th class="p-2">Status</th>
            <th class="p-2">Aksi</th>
        </tr>
    </thead>
    <tbody id="tbody"></tbody>
</table>
</div>



<!-- ===================================== -->
<!-- FORM INPUT PEMBAYARAN -->
<!-- ===================================== -->
<div id="formBox" class="hidden mt-4 bg-white p-4 rounded-lg shadow">
    <h2 id="formTitle" class="font-bold mb-3">Tambah Pembayaran</h2>

    <label class="text-sm font-semibold">Nomor Pendaftar</label>
    <input id="nomor" class="w-full p-2 border rounded mb-2">

    <label class="text-sm font-semibold">Nama</label>
    <input id="nama" class="w-full p-2 border rounded mb-2">

    <label class="text-sm font-semibold">Tanggal</label>
    <input type="date" id="tanggal" class="w-full p-2 border rounded mb-2">

    <label class="text-sm font-semibold">Jenis Pembayaran</label>
    <input id="jenis" class="w-full p-2 border rounded mb-2">

    <label class="text-sm font-semibold">Nominal</label>
    <input type="number" id="nominal" class="w-full p-2 border rounded mb-2">

    <label class="text-sm font-semibold">Status</label>
    <select id="status" class="w-full p-2 border rounded mb-2">
        <option>Belum</option>
        <option>Sudah</option>
    </select>

    <label class="text-sm font-semibold">Bukti (URL Gambar)</label>
    <input id="bukti" class="w-full p-2 border rounded mb-3">

    <button onclick="saveData()" class="px-4 py-2 bg-blue-600 text-white rounded-lg">Simpan</button>
</div>

</main>



<!-- ===================================== -->
<!-- BOTTOM NAVIGATION -->
<!-- ===================================== -->
<nav class="bottom-nav fixed left-3 right-3 bottom-3 bg-white rounded-xl shadow-lg h-20 flex justify-around items-center">

  <a href="index.html" class="flex flex-col items-center text-gray-600">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M3 12l2-2m0 0l7-7 7 7m-9 5v6m0-6h6m-6 0H3"/>
      </svg>
      <div class="text-xs">Home</div>
  </a>

  <a href="pembayaran.php" class="flex flex-col items-center text-blue-600 font-bold">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
           stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-2m0-4h4m0 0l-2-2m2 2l-2 2"/>
      </svg>
      <div class="text-xs">Pembayaran</div>
  </a>

</nav>





<!-- ===================================== -->
<!-- JAVASCRIPT API CONNECTION -->
<!-- ===================================== -->
<script>

const API_URL = "https://script.google.com/macros/s/AKfycbzr1ElBgZGXk5VcAWV7PHifa3gYozlB7iUAZso0Q82vNkxdOI9Im1hjRYZi_MN2XMQFkQ/exec";

let editing = false;
let editingId = "";


// =========================
// LOAD DATA
// =========================
async function loadData(){
    const res = await fetch(API_URL);
    const data = await res.json();

    let html = "";
    data.forEach((r,i)=>{
        html += `
        <tr class="border-b">
            <td class="p-2">${i+1}</td>
            <td class="p-2">${r.ID}</td>
            <td class="p-2">${r.NomorPendaftar}</td>
            <td class="p-2">${r.Nama}</td>
            <td class="p-2">${r.Tanggal}</td>
            <td class="p-2">${r.Jenis}</td>
            <td class="p-2">${r.Nominal}</td>
            <td class="p-2">${r.Status}</td>
            <td class="p-2 flex gap-2">
                <button onclick='editRow(${JSON.stringify(r)})'
                    class="px-2 py-1 bg-yellow-400 text-black rounded">Edit</button>
                <button onclick='deleteRow("${r.ID}")'
                    class="px-2 py-1 bg-red-600 text-white rounded">Hapus</button>
            </td>
        </tr>`;
    });

    document.getElementById("tbody").innerHTML = html;
}
window.onload = loadData;



// =========================
// SHOW FORM
// =========================
function showForm(){
    editing = false;
    editingId = "";
    document.getElementById("formBox").classList.remove("hidden");

    nomor.value = "";
    nama.value = "";
    tanggal.value = "";
    jenis.value = "";
    nominal.value = "";
    status.value = "Belum";
    bukti.value = "";
}



// =========================
// EDIT DATA
// =========================
function editRow(r){
    editing = true;
    editingId = r.ID;
    document.getElementById("formBox").classList.remove("hidden");

    nomor.value = r.NomorPendaftar;
    nama.value = r.Nama;
    tanggal.value = r.Tanggal;
    jenis.value = r.Jenis;
    nominal.value = r.Nominal;
    status.value = r.Status;
    bukti.value = r.Bukti;
}



// =========================
– SIMPAN DATA (ADD / UPDATE)
// =========================
async function saveData(){
    const body = {
        action: editing ? "update" : "add",
        id: editingId,

        nomor: nomor.value,
        nama: nama.value,
        tanggal: tanggal.value,
        jenis: jenis.value,
        nominal: nominal.value,
        status: status.value,
        bukti: bukti.value
    };

    await fetch(API_URL, {
        method: "POST",
        body: JSON.stringify(body)
    });

    alert("Data disimpan!");
    location.reload();
}



// =========================
// HAPUS DATA
// =========================
async function deleteRow(id){
    if(!confirm("Hapus data ini?")) return;

    await fetch(API_URL, {
        method:"POST",
        body: JSON.stringify({ action:"delete", id:id })
    });

    alert("Dihapus!");
    loadData();
}



// =========================
// SYNC GELOMBANG 1
// =========================
async function syncGelombang1(){
    const res = await fetch(API_URL, {
        method: "POST",
        body: JSON.stringify({ action: "syncGel1" })
    });

    const result = await res.json();
    alert(result.message || "Sync selesai!");
}

</script>


</body>
</html>
