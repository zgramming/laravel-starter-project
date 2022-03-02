[![GitHub followers](https://img.shields.io/github/followers/zgramming.svg?style=social&label=Follow&maxAge=2592000)](https://github.com/zgramming?tab=followers)

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

<p align="center">
  <img src="github/screenshot/logo.jpg">
</p>

# Starter Laravel Project

Dibuatnya project ini karena saya membutuhkan starter project yang didalamnya sudah terdapat fungsi dan template.
Beberapa fitur yang ada di starter project ini yaitu : 


### 1. <a href="https://yajrabox.com/docs/laravel-datatables/master/installation" target="_blank">Laravel Yajra Datatable</a>
Beberapa fitur yang sudah ada untuk datatable yaitu :

* Search + Debounce
<img src="github/gif/datatable/1.gif">
* Filter by Combo box
<img src="github/gif/datatable/2.gif">
* Sorting Asc / Desc
* Custom column (show image, show badge, show button action)

### 2. CRUD Operation
Pada project ini sudah disediakan contoh form dan fungsi-fungsi yang biasanya sering digunakan, diantaranya : 

#### a. Form Create & Update

<img src="github/gif/crud_operation/1.gif">

Fitur yang ada dalam form ini yaitu : 
* Validasi pada sisi client menggunakan <a href="https://jqueryvalidation.org/" target="_blank">Jquery Validation</a>
* Validasi pada sisi server
* Preview gambar sebelum upload file

#### b. Delete data + image if exists
Menghapus data pada database dan memeriksa apakah data terkait mempunyai file/image, jika ada image yang terkait hapus juga image/filenya

<img src="github/gif/crud_operation/2.gif">

#### c. Export Data
Export data dengan menentukan tipe file yang diinginkan, untuk saat ini mensupport XLSX & CSV.

<img src="github/gif/crud_operation/export.gif">

#### d. Import Data
Import data untuk saat ini baru mensupport XLSX, dengan menentukan tiap field yang ada di XLSX dan codingan kamu.

<img src="github/gif/crud_operation/import.gif">

#### e. Preview Document
Menampilkan isi dokumen dalam modal.
Untuk menampilkan isi dari PDF menggunakan plugin <a href="https://mozilla.github.io/pdf.js/" target="_blank">PDFJS</a>

<img src="github/gif/crud_operation/preview-document.gif">

#### f. Preview Image
Menampilkan gambar di dalam modal, berguna ketika ingin melihat gambar dalam ukuran yang lebih besar.

<img src="github/gif/crud_operation/preview-image.gif">
