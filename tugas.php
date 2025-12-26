<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Absensi Online</title>

<!-- BOOTSTRAP & ICON -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

<style>
body{margin:0;font-family:Segoe UI;background:#f4f6f9}

/* TOPBAR */
.topbar{
background:#343a40;color:#fff;padding:10px 20px;
display:flex;justify-content:space-between;align-items:center
}

/* SIDEBAR */
.sidebar{
width:230px;position:fixed;top:50px;bottom:0;
background:#212529;color:#adb5bd;padding-top:15px
}
.sidebar a{
display:block;padding:10px 20px;color:#adb5bd;text-decoration:none
}
.sidebar a.active,.sidebar a:hover{
background:#0d6efd;color:#fff
}

/* CONTENT */
.content{
margin-left:230px;padding:25px;margin-top:50px
}

/* STATUS */
.badge-danger{background:#dc3545}

/* AKSI BUTTON */
.btn-aksi{padding:6px 8px}
</style>
</head>

<body>

<!-- TOPBAR -->
<div class="topbar">
<div><i class="fa fa-bars"></i> Absensi Online</div>
<div><i class="fa fa-user-circle"></i></div>
</div>

<!-- SIDEBAR -->
<div class="sidebar">
<a href="#">Dashboard Admin</a>
<div class="px-3 mt-2 text-uppercase small">Menu</div>
<a href="#">Data Kehadiran</a>
<div class="px-3 mt-2 text-uppercase small">Admin</div>
<a href="#">Data Pegawai</a>
<a href="#" class="active">Absensi Pegawai</a>
<a href="#">Settings Aplikasi</a>
<div class="px-3 mt-4 small">Selamat Datang:<br><b>Triannisi Hasan S.Pd</b></div>
</div>

<!-- CONTENT -->
<div class="content">
<h3><i class="fa fa-user-check"></i> Absensi Pegawai</h3>

<div class="card mt-3">
<div class="card-header d-flex justify-content-end gap-2">
<button class="btn btn-danger btn-sm" onclick="clearAll()">
<i class="fa fa-trash"></i> Clear All
</button>
<button class="btn btn-success btn-sm" onclick="exportExcel()">
<i class="fa fa-file-excel"></i> Export Absensi
</button>
<button class="btn btn-primary btn-sm" onclick="refreshTable()">
<i class="fa fa-rotate"></i> Refresh Tabel
</button>
</div>

<div class="card-body">
<div class="d-flex justify-content-between mb-2">
<div>Show
<select class="form-select d-inline w-auto">
<option>10</option>
</select>
entries</div>
<div>Search:
<input type="text" class="form-control d-inline w-auto" id="search" onkeyup="searchTable()">
</div>
</div>

<table class="table table-bordered text-center" id="absensiTable">
<thead class="table-light">
<tr>
<th>No</th>
<th>Tanggal</th>
<th>Nama Pegawai</th>
<th>Waktu Datang</th>
<th>Waktu Pulang</th>
<th>Status</th>
<th>Aksi</th>
</tr>
</thead>
<tbody id="tableBody"></tbody>
</table>

<div class="text-end">Showing 1 to <span id="total"></span> of <span id="total2"></span> entries</div>
</div>
</div>
</div>

<!-- MODAL PREVIEW -->
<div class="modal fade" id="previewModal">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<h5><i class="fa fa-id-card"></i> Preview Absensi</h5>
<button class="btn-close" data-bs-dismiss="modal"></button>
</div>
<div class="modal-body" id="previewContent"></div>
<div class="modal-footer">
<button class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
</div>
</div>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
let data=[
{nama:"Nurul A. Sagama",tanggal:"Jumat, 7 November 2025",datang:"12:46:28",pulang:"12:46:34",status:"Absen Terlambat",ket:"Bekerja Di Kantor"},
{nama:"Triannisi Hasan S.Pd",tanggal:"Jumat, 28 November 2025",datang:"08:56:48",pulang:"-",status:"Absen Terlambat",ket:"Bekerja Di Kantor"}
];

function load(){
let body="";
data.forEach((d,i)=>{
body+=`
<tr>
<td>${i+1}</td>
<td>${d.tanggal}</td>
<td>${d.nama}</td>
<td>${d.datang}</td>
<td>${d.pulang}</td>
<td><span class="badge badge-danger">${d.status}</span></td>
<td>
<button class="btn btn-primary btn-aksi" onclick="preview(${i})"><i class="fa fa-id-card"></i></button>
<button class="btn btn-danger btn-aksi" onclick="hapus(${i})"><i class="fa fa-trash"></i></button>
<button class="btn btn-warning btn-aksi" onclick="printData(${i})"><i class="fa fa-print"></i></button>
</td>
</tr>`;
});
document.getElementById("tableBody").innerHTML=body;
document.getElementById("total").innerText=data.length;
document.getElementById("total2").innerText=data.length;
}

function preview(i){
let d=data[i];
document.getElementById("previewContent").innerHTML=`
<p><b>Nama Pegawai:</b> ${d.nama}</p>
<p><b>Tanggal:</b> ${d.tanggal}</p>
<p><b>Waktu Datang:</b> ${d.datang}</p>
<p><b>Waktu Pulang:</b> ${d.pulang}</p>
<p><b>Status:</b> ${d.status}</p>
<p><b>Keterangan:</b> ${d.ket}</p>`;
new bootstrap.Modal(document.getElementById("previewModal")).show();
}

function hapus(i){
if(confirm("Hapus data ini?")){data.splice(i,1);load();}
}

function clearAll(){
if(confirm("Hapus semua data absensi?")){data=[];load();}
}

function printData(i){
let d=data[i];
let w=window.open("");
w.document.write(`<h3>Data Absensi</h3>
<p>Nama: ${d.nama}</p>
<p>Tanggal: ${d.tanggal}</p>
<p>Datang: ${d.datang}</p>
<p>Pulang: ${d.pulang}</p>
<p>Status: ${d.status}</p>`);
w.print();
}

function exportExcel(){
let table=document.getElementById("absensiTable").outerHTML;
let a=document.createElement("a");
a.href='data:application/vnd.ms-excel,'+encodeURIComponent(table);
a.download='absensi_pegawai.xls';
a.click();
}

function refreshTable(){load();}

function searchTable(){
let q=document.getElementById("search").value.toLowerCase();
document.querySelectorAll("#absensiTable tbody tr").forEach(r=>{
r.style.display=r.innerText.toLowerCase().includes(q)?"":"none";
});
}

load();
</script>

</body>
</html>
