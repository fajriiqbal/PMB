<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Manajemen Pembayaran</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<style>
    body { font-family: Arial; background:#f4f4f4; padding:20px; }
    h1 { text-align:center; margin-bottom:20px; }
    table { width:100%; border-collapse:collapse; background:white; }
    th, td { padding:10px; border:1px solid #ddd; }
    th { background:#007bff; color:white; }
    tr:nth-child(even){ background:#f9f9f9; }

    button { padding:8px 12px; border:none; border-radius:5px; cursor:pointer; }
    .add-btn { background:#28a745; color:white; }
    .edit-btn { background:#ffc107; }
    .delete-btn { background:#dc3545; color:white; }
    .sync-btn { background:#17a2b8; color:white; }
    .download-btn { background:#6f42c1; color:white; }

    #formBox { display:none; background:white; padding:20px; margin-top:20px;
               border-radius:10px; }
    label { font-weight:bold; display:block; margin-top:10px; }
    input, select { width:100%; padding:8px; margin-top:5px; }
</style>

<script>
const API_URL = "https://script.google.com/macros/s/AKfycbzr1ElBgZGXk5VcAWV7PHifa3gYozlB7iUAZso0Q82vNkxdOI9Im1hjRYZi_MN2XMQFkQ/exec";

let editing = false;
let editingId = "";

// ------------------------------------------------------------
// LOAD DATA
// ------------------------------------------------------------
async function loadData(){
    const res = await fetch(API_URL);
    const data = await res.json();

    let html = "";
    data.forEach((r,i)=>{
        html += `
        <tr>
            <td>${i+1}</td>
            <td>${r.ID}</td>
            <td>${r.NomorPendaftar}</td>
            <td>${r.Nama}</td>
            <td>${r.Tanggal}</td>
            <td>${r.Jenis}</td>
            <td>${r.Nominal}</td>
            <td>${r.Status}</td>
            <td>${r.Bukti}</td>
            <td>
                <button class="edit-btn" onclick='editRow(${JSON.stringify(r)})'>Edit</button>
                <button class="delete-btn" onclick='deleteRow("${r.ID}")'>Hapus</button>
            </td>
        </tr>`;
    });

    document.getElementById("tbody").innerHTML = html;
}
window.onload = loadData;

// ------------------------------------------------------------
// SHOW FORM
// ------------------------------------------------------------
function showForm(){
    editing = false;
    editingId = "";
    document.getElementById("formBox").style.display = "block";
    document.getElementById("formTitle").innerText = "Tambah Pembayaran";

    document.getElementById("nomor").value = "";
    document.getElementById("nama").value = "";
    document.getElementById("tanggal").value = "";
    document.getElementById("jenis").value = "";
    document.getElementById("nominal").value = "";
    document.getElementById("status").value = "Belum";
    document.getElementById("bukti").value = "";
}

// ------------------------------------------------------------
// EDIT
// ------------------------------------------------------------
function editRow(r){
    editing = true;
    editingId = r.ID;

    document.getElementById("formBox").style.display = "block";
    document.getElementById("formTitle").innerText = "Edit Pembayaran";

    document.getElementById("nomor").value = r.NomorPendaftar;
    document.getElementById("nama").value = r.Nama;
    document.getElementById("tanggal").value = r.Tanggal;
    document.getElementById("jenis").value = r.Jenis;
    document.getElementById("nominal").value = r.Nominal;
    document.getElementById("status").value = r.Status;
    document.getElementById("bukti").value = r.Bukti;
}

// ------------------------------------------------------------
// SAVE (ADD + UPDATE)
// ------------------------------------------------------------
async function saveData(){
    const body = {
        action: editing ? "update" : "add",
        id: editingId,
        nomor: document.getElementById("nomor").value,
        nama: document.getElementById("nama").value,
        tanggal: document.getElementById("tanggal").value,
        jenis: document.getElementById("jenis").value,
        nominal: document.getElementById("nominal").value,
        status: document.getElementById("status").value,
        bukti: document.getElementById("bukti").value
    };

    await fetch(API_URL, {
        method: "POST",
        body: JSON.stringify(body)
    });

    alert("Data disimpan!");
    location.reload();
}

// ------------------------------------------------------------
// DELETE
// ------------------------------------------------------------
async function deleteRow(id){
    if(!confirm("Hapus data ini?")) return;

    await fetch(API_URL, {
        method:"POST",
        body: JSON.stringify({ action:"delete", id:id })
    });

    alert("Dihapus!");
    loadData();
}

// ------------------------------------------------------------
// SINKRON DU_GELOMBANG1
// ------------------------------------------------------------
async function syncData(){
    if(!confirm("Sinkron DU_gelombang1?")) return;

    const res = await fetch(API_URL+"?action=sync&gel=1");
    const data = await res.json();

    alert("Sinkronisasi selesai.\nDitambahkan: "+data.inserted+"\nDilewati: "+data.skipped);
    loadData();
}

</script>
</head>

<body>

<h1>Manajemen Pembayaran</h1>

<button class="add-btn" onclick="showForm()">+ Tambah Pembayaran</button>
<button class="sync-btn" onclick="syncData()">Sync Gelombang 1</button>

<table>
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
    <tbody id="tbody"></tbody>
</table>

<div id="formBox">
    <h2 id="formTitle">Tambah Pembayaran</h2>

    <label>Nomor Pendaftar</label>
    <input id="nomor">

    <label>Nama</label>
    <input id="nama">

    <label>Tanggal</label>
    <input type="date" id="tanggal">

    <label>Jenis Pembayaran</label>
    <input id="jenis">

    <label>Nominal</label>
    <input type="number" id="nominal">

    <label>Status</label>
    <select id="status">
        <option>Belum</option>
        <option>Sudah</option>
    </select>

    <label>Bukti Bayar (opsional: link gambar)</label>
    <input id="bukti">

    <button class="add-btn" onclick="saveData()">Simpan</button>
</div>

</body>
</html>
