<!DOCTYPE html>
<html>
<head>
    <title>Sistem Informasi Akademik::Daftar Mahasiswa</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="bootstrap4/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="css/styleku.css">
    <script src="bootstrap4/jquery/3.3.1/jquery-3.3.1.js"></script>
    <script src="bootstrap4/js/bootstrap.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <style>
        .pagination .disabled a {
            color: #6c757d;
            pointer-events: none;
            cursor: not-allowed;
        }

        .pagination .active a {
            font-weight: bold;
            color: red;
            background-color: #e9ecef;
        }
    </style>
</head>
<body>
<?php require "head.html"; // Ensure sidebar is included ?>
<div class="utama">
    <h2 class="text-center">Daftar Matkul</h2>
    <div class="text-center"><a href="prnMhsPdf.php"><span class="fas fa-print">&nbsp;Print</span></a></div>
    <span class="float-left">
        <a class="btn btn-success" href="addMhs.php">Tambah Data</a>
    </span>
    <span class="float-right">
        <form id="searchForm" class="form-inline" method="post">
            <button class="btn btn-success" type="submit">Cari</button>
            <input id="searchkeyword" class="form-control mr-2 ml-2" type="text" name="cari" placeholder="cari data mahasiswa..." autofocus autocomplete="off">
        </form>
    </span>
    <br><br>
    <div id="hasil"></div>
</div>
<script>
$(document).ready(function(){
    function fetchData(page = 1, searchKeyword = ''){
        $.ajax({
            url: 'fetch_data_matkul.php',
            method: 'POST',
            data: {hal: page, cari: searchKeyword},
            dataType: 'json',
            success: function(response){
                let html = `
                <ul class="pagination">
                    <li class='page-item ${response.halAktif > 1 ? '' : 'disabled'}'>
                        <a class='page-link' href='#' data-page='${response.halAktif > 1 ? response.halAktif - 1 : '#'}'>&laquo;</a>
                    </li>
                    ${[...Array(response.jmlHal)].map((_, i) => i + 1).map(pageNum => `
                        <li class='page-item ${pageNum === response.halAktif ? 'active' : ''}'><a class='page-link' href='#' data-page='${pageNum}'>${pageNum}</a></li>
                    `).join('')}
                    <li class='page-item ${response.halAktif < response.jmlHal ? '' : 'disabled'}'>
                        <a class='page-link' href='#' data-page='${response.halAktif < response.jmlHal ? response.halAktif + 1 : '#'}'>&raquo;</a>
                    </li>
                </ul>
                <table class='table table-hover'>
                    <thead class='thead-light'>
                        <tr>
                            <th>No.</th>
                            <th>Kode Matkul</th>
                            <th>Nama</th>
                            <th>SKS</th>
                            <th>Jenis Matkul</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${response.data.length > 0 ? response.data.map((row, index) => `
                            <tr>
                                <td>${index + 1 + (response.halAktif - 1) * 3}</td>
                                <td>${row.idmatkul}</td>
                                <td>${row.namamatkul}</td>
                                <td>${row.sks}</td>
                                <td>${row.jns}</td>
                                <td>
                                    <button id='${row.nim}' class='btn btn-outline-primary btn-sm edit-button'>Edit</button>
                                    <button id='${row.idmatkul}' class='btn btn-outline-danger btn-sm delete-button' data-foto='${row.foto}'>Hapus</button>
                                </td>
                            </tr>
                        `).join('') : `<tr><th colspan='6'><div class='alert alert-info alert-dismissible fade show text-center'>Data tidak ada</div></th></tr>`}
                    </tbody>
                </table>
                `;
                $('#hasil').html(html);
            }
        });
    }

    fetchData();

    $('#searchForm').keyup(function(event){
        event.preventDefault();
        const keyword = $('#searchkeyword').val();
        fetchData(1, keyword); // Pass the keyword to fetchData
    });

    $(document).on('click', '.pagination a', function(event){
        event.preventDefault();
        const page = $(this).data('page');
        const keyword = $('#searchkeyword').val();
        fetchData(page, keyword); // Pass the keyword to fetchData
    });

    let deleteId, deleteFoto;

    $(document).on('click', '.delete-button', function() {
        deleteId = $(this).attr('idmatkul');
        deleteFoto = $(this).data('foto');
        $('#confirmDeleteModal').modal('show');

        $('#confirmDeleteBtn').click(function() {
            $.ajax({
                url: 'hpsmatkul.php',
                method: 'POST',
                data: {kode: deleteId},
                success: function() {
                    fetchData();
                    $('#confirmDeleteModal').modal('hide');
                }
            });
        });
    });


    $(document).on('click', '.edit-button', function() {
        $.ajax({
            url: "detailMatkul.php",
            method: "POST",
            data: {
                kode: this.idmatkul
            },
            success: function(response) {
                let data = JSON.parse(response);

                $('#modal').html('\
                    <h2 class="mb-3 text-center">EDIT DATA MATA KULIAH</h2>\
                    <div class="row">\
                        <div class="col-sm-9">\
                            <form id="edit-form" enctype="multipart/form-data" method="post" action="sv_editMhs.php">\
                                <div class="form-group">\
                                    <label for="nim">KODE MATA KULIAH:</label>\
                                    <input class="form-control" type="text" name="nim" id="nim" value="' + data.idmatkul + '" readonly>\
                                </div>\
                                <div class="form-group">\
                                    <label for="nama">Nama:</label>\
                                    <input class="form-control" type="text" name="nama" id="nama" value="' + data.namamatkul + '">\
                                </div>\
                                <div class="form-group">\
                                    <label for="sks">SKS:</label>\
                                    <input class="form-control" type="email" name="sks" id="sks" value="' + data.sks + '">\
                                </div>\
                                <div class="form-group">\
                                    <label for="jns">JENIS MATAKULIAH:</label>\
                                    <input class="form-control" type="text" name="jns" id="jns" value="' + data.jns + '">\
                                </div>\
                                <div>\
                                    <button class="btn btn-primary" id="close">Tutup</button>\
                                    <button class="btn btn-primary" type="submit" id="simpan">Simpan</button>\
                                </div>\
                                <input type="hidden" name="id" id="id" value="id">\
                            </form>\
                        </div>\
                    </div>\
                ');

                $('#edit-form').on('submit', function(e) {
                    e.preventDefault();
                })

                $('#close').on('click', function(e) {
                    $('#modal').hide();
                })

                $('#simpan').on('click', function(e) {
                    $.ajax({
                        type: 'POST',
                        url: 'sv_editMhs.php',
                        data: $('#edit-form').serializeArray(),
                        processData: false,
                        contentType: false,
                        success: function() {
                            alert('berhasil edit');
                        }
                    })
                })
            }
        })

        $('#modal').show();
    })
});
</script>
<!-- Confirmation Modal -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteModalLabel">Konfirmasi Hapus</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Anda yakin ingin menghapus data ini?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Hapus</button>
            </div>
        </div>
    </div>
</div>

<div id="modal" class="utama">
</div>
</body>
</html>	
