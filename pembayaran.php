<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Manajemen Pembayaran</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<style>
    body { font-family: Arial, sans-serif; padding: 15px; background: #f4f4f4; }
    h1 { text-align: center; margin-bottom: 20px; }
    table { width: 100%; border-collapse: collapse; background: white; }
    th, td { padding: 10px; border: 1px solid #ddd; text-align: left; }
    th { background: #007bff; color: white; }
    tr:nth-child(even) { background: #f9f9f9; }
    button { padding: 8px 12px; margin: 5px; cursor: pointer; border: none; border-radius: 5px; }
    .add-btn { background: #28a745; color: white; }
    .edit-btn { background: #ffc107; color: black; }
    .delete-btn { background: #dc3545; color: white; }
    .sync-btn { background: #17a2b8; color: white; }
    .download-btn { background: #6f42c1; color: white; }
    #formBox { background: white; padding: 20px; margin-top: 20px; border-radius: 10px; display: none; }
    label { font-weight: bold; }
    input, select { width: 100%; padding: 8px; margin: 5px 0 15px; }
</style>

<script>
const API_URL = "https://script.google.com/macros/s/AKfycbzr1ElBgZGXk5VcAWV7PHifa3gYozlB7iUAZso0Q82vNkxdOI9Im1hjRYZi_MN2XMQFkQ/exec";

let editingId = "";

// -------------------------------
// LOAD DATA PEMBAYARAN
// -------------------------------
async function loadData() {
    const res = await fetch(API_URL + "?action=read");
    const data = await res.json();

    let html = "";
    data.forEach((row, i) => {
        html += `
        <tr>
            <td>${i+1}</td>
            <td>${row.nama}</td>
            <td>${row.kelas}</td>
            <td>${row.jumlah}</td>
            <td>${row.tanggal}</td>
            <td>
                <button class="edit-btn" onclick='edit("${row.id}", "${row.nama}", "${row.kelas}", "${row.jumlah}")'>Edit</button>
                <button class="delete-btn" onclick='hapus("${row.id}")'>Hapus</button>
            </td>
        </tr>`;
    });

    document.getElementById("dataTable").innerHTML = html;
}
window.onload = loadData;

// -------------------------------
// FORM TAMBAH PEMBAYARAN
// -------------------------------
function showForm() {
    editingId = "";
    document.getElementById("formBox").style.display = "block";
    document.getElementById("judulForm").innerHTML = "Tambah Pembayaran";

    document.getElementById("nama").value = "";
    document.getElementById("kelas").value = "";
    document.getElementById("jumlah").value = "";
}

// -------------------------------
// EDIT PEMBAYARAN
// -------------------------------
function edit(id, nama, kelas, jumlah) {
    editingId = id;
    document.getElementById("formBox").style.display = "block";
    document.getElementById("judulForm").innerHTML = "Edit Pembayaran";

    document.getElementById("nama").value = nama;
    document.getElementById("kelas").value = kelas;
    document.getElementById("jumlah").value = jumlah;
}

// -------------------------------
// SIMPAN PEMBAYARAN
// -------------------------------
async function saveData() {
    const formData = new FormData();
    formData.append("id", editingId);
    formData.append("nama", document.getElementById("nama").value);
    formData.append("kelas", document.getElementById("kelas").value);
    formData.append("jumlah", document.getElementById("jumlah").value);

    await fetch(API_URL + "?action=save", { method: "POST", body: formData });

    alert("Data berhasil disimpan!");
    location.reload();
}

// -------------------------------
// HAPUS PEMBAYARAN
// -------------------------------
async function hapus(id) {
    if (!confirm("Hapus data ini?")) return;

    await fetch(API_URL + "?action=delete&id=" + id);
    alert("Data dihapus.");
    loadData();
}

// -------------------------------
// SINKRONISASI DATA DU_gelombang1
// -------------------------------
async function syncData() {
    if (!confirm("Sinkron data DU_gelombang1 ke pembayaran?")) return;

    const res = await fetch(API_URL + "?action=sync&gel=1");
    const data = await res.text();

    alert("Sinkronisasi selesai:\n" + data);
    loadData();
}

// -------------------------------
// DOWNLOAD LAPORAN EXCEL
// -------------------------------
function downloadExcel() {
    window.open(API_URL + "?action=download");
}
</script>

</head>
<body>

<h1>Manajemen Pembayaran</h1>

<button class="add-btn" onclick="showForm()">+ Tambah Pembayaran</button>
<button class="sync-btn" onclick="syncData()">Sinkron Gelombang 1</button>
<button class="download-btn" onclick="downloadExcel()">Download Excel</button>

<br><br>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Kelas</th>
            <th>Jumlah</th>
            <th>Tanggal</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody id="dataTable"></tbody>
</table>

<div id="formBox">
    <h2 id="judulForm">Tambah Pembayaran</h2>

    <label>Nama Siswa</label>
    <input type="text" id="nama" required>

    <label>Kelas</label>
    <input type="text" id="kelas" required>

    <label>Jumlah</label>
    <input type="number" id="jumlah" required>

    <button class="add-btn" onclick="saveData()">Simpan</button>
</div>

</body>
</html>
