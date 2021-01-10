<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CRUD</title>

    <link rel="stylesheet" href="<?= base_url('assets/bootstrap/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/datatables/datatables.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/bootstrap-datepicker/css/bootstrap-datepicker.standalone.min.css') ?>">

</head>

<body>

    <div class="container">
        <div class="row">
            <div class="col-md">
                <h3 class="text-center mt-5 font-weight-bold">Data Mahasiswa</h3>
                <div class="col-lg-3" id="alert"> <strong></strong> </div>
                <button class="btn btn-primary mb-3" onclick="add_mahasiswa()">Tambah Data</button>
                <div class="table-responsive">
                    <table class="table table-bordered table-dark w-100" id="my_table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>NIM</th>
                                <th>Nama</th>
                                <th>Jenis Kelamin</th>
                                <th>Jurusan</th>
                                <th>Tanggal Lahir</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="<?= base_url('assets/jquery/jquery.min.js') ?>"></script>
    <script src="<?= base_url('assets/bootstrap/js/bootstrap.min.js') ?>"></script>
    <script src="<?= base_url('assets/datatables/datatables.min.js') ?>"></script>
    <script src="<?= base_url('assets/bootstrap-datepicker/js/bootstrap-datepicker.min.js') ?>"></script>

    <script>
        var table;
        var save_method;

        // Datatables with server side
        $(document).ready(function() {
            table = $('#my_table').DataTable({
                "processing": true,
                "serverSide": true,
                "order": [],

                "ajax": {
                    "url": "<?= site_url('mahasiswa/ajax_list') ?>",
                    "type": "POST"
                },

                "columnDefs": [{
                    "targets": [0, -1],
                    "orderable": false,
                }],
            });

            table.on('draw.dt', function() {
                var PageInfo = $('#my_table').DataTable().page.info();
                table.column(0, {
                    page: 'current'
                }).nodes().each(function(cell, i) {
                    cell.innerHTML = i + 1 + PageInfo.start;
                });
            });

            // Datepicker
            $('.datepicker').datepicker({
                autoclose: true,
                format: "yyyy-mm-dd",
                todayHighlight: true,
                orientation: "bottom auto",
                todayBtn: true,
            });

            // Hilangkan validasi ketika value bernilai benar
            $("input").change(function() {
                $(this).removeClass('is-invalid');
                $(this).next().empty();
            });
            $("select").change(function() {
                $(this).removeClass('is-invalid');
                $(this).next().empty();
            });
        });

        // Ketika tombol tambah data ditekan
        function add_mahasiswa() {
            save_method = 'add';
            $('#form')[0].reset();
            $('.form-control').removeClass('is-invalid');
            $('.invalid-feedback').empty();
            $('#modal-form').modal('show');
            $('.modal-title').text('Tambah Data Mahasiswa');
        }

        // Ketika tombol edit ditekan dan form akan menampilkan data lama
        function edit_mahasiswa(id) {
            save_method = 'edit';
            $('#form')[0].reset();
            $('.form-control').removeClass('is-invalid');
            $('.invalid-feedback').empty();

            $.ajax({
                url: "<?= site_url('mahasiswa/ajax_edit') ?>/" + id,
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    $('[name="id"]').val(data.id);
                    $('[name="nim"]').val(data.nim);
                    $('[name="nama"]').val(data.nama);
                    $('[name="jenis_kelamin"]').val(data.jenis_kelamin);
                    $('[name="jurusan"]').val(data.jurusan);
                    $('[name="tanggal_lahir"]').val(data.tanggal_lahir);
                    $('#modal-form').modal('show');
                    $('.modal-title').text('Ubah Data Mahasiswa');
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('Error get data from ajax');
                }
            });
        }

        // Ketika tombol delete ditekan
        function delete_mahasiswa(id) {
            $('.modal-title').text('Hapus Data Mahasiswa');
            $('#modal-delete').modal('show');
            $('#btn-delete').click(function() {
                message = "Data berhasil dihapus.";
                $('#btn-delete').text('Menghapus...');
                $('#btn-delete').attr('disabled', true);
                $.ajax({
                    url: "<?php echo site_url('mahasiswa/ajax_delete') ?>/" + id,
                    type: "POST",
                    dataType: "JSON",
                    success: function(data) {
                        $('#modal-delete').modal('hide');
                        $('#alert').html(message).addClass('alert alert-success');
                        $(".alert-success").fadeTo(2000, 500).slideUp(500, function() {
                            $(".alert-success").slideUp(500);
                        });
                        table.ajax.reload(null, false);
                        $('#btn-delete').text('Hapus');
                        $('#btn-delete').attr('disabled', false);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert('Error deleting data');
                    }
                });
            });
        }

        // Simpan data ketika ditambah atau diubah
        function save() {
            $('#btn-save').text('Menyimpan...');
            $('#btn-save').attr('disabled', true);

            if (save_method == 'add') {
                url = "<?= site_url('mahasiswa/ajax_add') ?>";
                message = "Data berhasil ditambahkan.";
            } else {
                url = "<?= site_url('mahasiswa/ajax_update') ?>";
                message = "Data berhasil diubah.";
            }

            $.ajax({
                url: url,
                type: "POST",
                data: $('#form').serialize(),
                dataType: "JSON",
                success: function(data) {
                    if (data.status) {
                        $('#modal-form').modal('hide');
                        $('#alert').html(message).addClass('alert alert-success');
                        $(".alert-success").fadeTo(2000, 500).slideUp(500, function() {
                            $(".alert-success").slideUp(500);
                        });
                        table.ajax.reload(null, false);
                    } else {
                        for (var i = 0; i < data.input_error.length; i++) {
                            $('[name="' + data.input_error[i] + '"]').addClass('is-invalid');
                            $('[name="' + data.input_error[i] + '"]').next().text(data.error_string[i]);
                        }
                    }
                    $('#btn-save').text('Simpan');
                    $('#btn-save').attr('disabled', false);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('Error adding / update data');
                    $('#btn-save').text('Simpan');
                    $('#btn-save').attr('disabled', false);

                }
            });
        }
    </script>

    <!-- Modal form untuk tambah dan edit -->
    <div class="modal" id="modal-form" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body form">
                    <form action="#" id="form">
                        <input type="hidden" value="" name="id">
                        <div class="form-group row">
                            <label for="input_nim" class="col-sm-4 col-form-label">NIM</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="input_nim" name="nim">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="input_nama" class="col-sm-4 col-form-label">Nama</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="input_nama" name="nama">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="input_jenis_kelamin" class="col-sm-4 col-form-label">Jenis Kelamin</label>
                            <div class="col-sm-8">
                                <select id="input_jenis_kelamin" class="form-control custom-select" name="jenis_kelamin">
                                    <option value="">--- Pilih Jenis Kelamin ---</option>
                                    <option value="Pria">Pria</option>
                                    <option value="Wanita">Wanita</option>
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="input_jurusan" class="col-sm-4 col-form-label">Jurusan</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="input_jurusan" name="jurusan">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="input_tanggal_lahir" class="col-sm-4 col-form-label">Tanggal Lahir</label>
                            <div class="col-sm-8">
                                <input id="input_tanggal_lahir" placeholder="yyyy-mm-dd" class="form-control datepicker" type="text" name="tanggal_lahir">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="button" id="btn-save" onclick="save()" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal hapus data -->
    <div class="modal" id="modal-delete" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modal title/h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin untuk menghapus data ini?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="button" id="btn-delete" class="btn btn-primary">Hapus</button>
                </div>
            </div>
        </div>
    </div>
</body>

</html>