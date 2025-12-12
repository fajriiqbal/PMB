<?php
// pembyaran.php
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Pembayaran</title>

<style>
body {
    margin: 0;
    padding-bottom: 80px; /* ruang untuk navbar bawah */
    font-family: Arial, sans-serif;
    background: #f5f6fa;
}

/* Container utama */
.wrapper {
    max-width: 900px;
    margin: auto;
    padding: 10px;
}

/* Judul */
h2 {
    text-align: center;
    margin-bottom: 15px;
}

/* Tombol */
.button {
    background: #3498db;
    color: #fff;
    padding: 8px 14px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
}
.button:hover { background: #2980b9; }

/* TABLE */
.table-container {
    width: 100%;
    overflow-x: auto;
    background: white;
    border-radius: 10px;
    padding: 10px;
}

table {
    border-collapse: collapse;
    width: 100%;
}

table th, table td {
    padding: 8px;
    border-bottom: 1px solid #ddd;
    font-size: 14px;
}

table th {
    background: #3498db;
    color: #fff;
    position: sticky;
    top: 0;
}

/* FORM POPUP BOX */
#formBox {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0,0,0,0.4);
    padding-top: 40px;
}

.form-content {
    width: 90%;
    max-width: 400px;
    margin: auto;
    background: white;
    padding: 20px;
    border-radius: 12px;
    animation: fadeIn 0.3s ease;
}

@keyframes fadeIn {
    from { transform: scale(0.9); opacity: 0; }
    to   { transform: scale(1); opacity: 1; }
}

input, select {
    width: 100%;
    padding: 10px;
    margin-top: 6px;
    margin-bottom: 10px;
    border-radius: 6px;
    border: 1px solid #ccc;
}

/* Bottom NAV */
.bottom-nav {
    position: fixed;
    bottom: 0;
    left: 0; right: 0;
    background: #fff;
    display: flex;
    justify-content: space-around;
    padding: 12px 0;
    border-radius: 15px 15px 0 0;
    box-shadow: 0 -4px 15px rgba(0,0,0,0.15);
    z-index: 9999;
}

.nav-item {
    width: 25%;
    text-align: center;
    text-decoration: none;
    color: #333;
    font-size: 14px;
}

/* Mobile tuning */
@media (max-width: 600px) {
    table th, table td { font-size: 12px; padding: 6px; }
}
</style>

<script>
const API_URL = "https://script.google.com/macros/s/AKfycbzr1ElBgZGXk5VcAWV7PHifa3gYozlB7iUAZso0Q82vNkxdOI9Im1hjRYZi_MN2XMQFkQ/exec";

let editing = false;
let editingId = "";

// ----------------------------- LOAD DATA -----------------------------
async function loadData(){
    const res = await fetch(API_URL);
    const data = await res.json();

    let html = "";
    data.forEach((r,i) => {
        html += `
        <tr>
            <td>${i+1}</td>
            <td>${r.NomorPendaftar}</td>
            <td>${r.Nama}</td>
            <td>${r.Tanggal}</td>
            <td>${r.Jenis}</td>
            <td>${r.Nominal}</td>
            <td>${r.Status}</td>
            <td>
                <button onclick='editRow(${JSON.stringify(r)})' class="button" style="padding:4px 8px;">Edit</button>
            </td>
        </tr>`;
    });

    document.getElementById("tbody").innerHTML = html;
}
window.onload = loadData;

// ----------------------------- FORM CONTROL -----------------------------
function showForm(){
    editing = false;
    editingId = "";
    document.getElementById("formBox").style.display = "block";

    document.getElementById("nomor").value = "";
    document.getElementById("nama").value = "";
    document.getElementById("tanggal").value = "";
    document.getElementById("jenis").value = "";
    document.getElementById("nominal").value = "";
    document.getElementById("status").value = "Belum";
}

function closeForm(){
    document.getElementById("formBox").style.display = "none";
}

function editRow(r){
    editing = true;
    editingId = r.ID;
    document.getElementById("formBox").style.display="block";

    document.getElementById("nomor").value = r.NomorPendaftar;
    document.getElementById("nama").value = r.Nama;
    document.getElementById("tanggal").value = r.Tanggal;
    document.getElementById("jenis").value = r.Jenis;
    document.getElementById("nominal").value = r.Nominal;
    document.getElementById("status").value = r.Status;
}

async function saveData(){
    const body = {
        action: editing ? "update" : "add",
        id: editingId,
        nomor: nomor.value,
        nama: nama.value,
        tanggal: tanggal.value,
        jenis: jenis.value,
        nominal: nominal.value,
        status: status.value
    };

    await fetch(API_URL, { method:"POST", body: JSON.stringify(body) });
    closeForm();
    loadData();
}
</script>
</head>

<body>

<div class="wrapper">

    <h2>Data Pembayaran</h2>

    <button class="button" onclick="showForm()">+ Tambah Pembayaran</button>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>No. Pend.</th>
                    <th>Nama</th>
                    <th>Tanggal</th>
                    <th>Jenis</th>
                    <th>Nominal</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody id="tbody"></tbody>
        </table>
    </div>

</div>

<!-- FORM -->
<div id="formBox">
    <div class="form-content">
        <h3>Form Pembayaran</h3>

        <input id="nomor" placeholder="Nomor Pendaftar">
        <input id="nama" placeholder="Nama">
        <input type="date" id="tanggal">
        <select id="jenis">
            <option value="Daftar Ulang">Daftar Ulang</option>
            <option value="DSP">DSP</option>
            <option value="Seragam">Seragam</option>
        </select>
        <input id="nominal" placeholder="Nominal">
        <select id="status">
            <option value="Belum">Belum</option>
            <option value="Lunas">Lunas</option>
        </select>

        <button class="button" onclick="saveData()">Simpan</button>
        <button class="button" style="background:#e74c3c;" onclick="closeForm()">Tutup</button>
    </div>
</div>

<!-- NAVBAR BAWAH -->
<nav class="bottom-nav">
    <a href="index.php" class="nav-item">Home</a>
    <a href="pembyaran.php" class="nav-item">Pembayaran</a>
    <a href="data.php" class="nav-item">Data</a>
    <a href="print-all.php" class="nav-item">Print All</a>
</nav>

</body>
</html>
