<?= $this->extend('layout/main'); ?>
<?= $this->extend('layout/menu'); ?>

<?= $this->section('isi'); ?>

<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5>Jenis Pengeluaran</h5>
                </div>
                <ul class="breadcrumb float-right">
                    <li class="breadcrumb-item"><a href="/home"><i class="feather icon-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="#">Master</a></li>
                    <li class="breadcrumb-item"><a href="#">Jenis Pengeluaran</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<?php if (session()->getFlashdata('pesan')) : ?>
    <div class="alert alert-success icons-alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <i class="icofont icofont-close-line-circled"></i>
        </button>
        <?php echo session()->getFlashdata('pesan'); ?>
    </div>
<?php endif; ?>

<div class="col-xl-12">
    <div class="card">
        <div class="card-header">
            <button class="btn btn-primary" data-toggle="modal" data-target="#addModal"><i class="icofont icofont-plus mr-2"></i>Tambah Data</button>
            <button class="btn btn-success" onclick="reload_table()"><i class="icofont icofont-refresh mr-2"></i>Refresh Tabel</button>
            <a href="/jenispengeluaran/report" class="btn btn-secondary float-right pdf" target="_blank"><i class="icofont icofont-print mr-2"></i> Print</a>
        </div>
        <div class="card-body table-border-style">
            <div class="table-responsive">
                <div id="coba">
                    <table id="datatable" class="table table-striped">
                        <thead>
                            <tr>
                                <th width="10%">No.</th>
                                <th>Nama</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 0;
                            foreach ($jenispengeluaran as $row) : $no++ ?>
                                <tr>
                                    <td> <?= $no; ?></td>
                                    <td> <?= $row['nama']; ?></td>
                                    <td style="text-align: center;">
                                        <a href="#" class="btn-sm btn-primary btn-update" data-id="<?= $row['idp']; ?>" data-nama="<?= $row['nama']; ?>"><i class="icofont icofont-ui-edit"></i></a>
                                        <a href="#" class="btn-sm btn-danger btn-delete" data-id="<?= $row['idp']; ?>"><i class="icofont icofont-ui-delete"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<form id="form_tambah">
    <?= csrf_field(); ?>
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title"> Tambah Jenis Pengeluaran</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col-md-12 mb-2">
                        <label>Nama *</label>
                        <input type="text" class="form-control" placeholder="Masukan Nama" id="nama" name="nama" required autocomplete="off">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary mt-2 mb-2" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary mt-2 mb-2 mr-2" onclick="simpan()">Simpan</button>
                </div>
            </div>
        </div>
    </div>
</form>

<form id="form_edit">
    <?= csrf_field(); ?>
    <div class="modal fade" id="updateModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title"> Edit Jenis Pengeluaran</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col-md-12 mb-3">
                        <label>Nama *</label>
                        <input type="text" class="form-control nama" placeholder="Masukan Nama" id="nama" name="nama" required autocomplete="off">
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="id" class="id">
                    <button type="button" class="btn btn-secondary mt-2 mb-2" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary mt-2 mb-2 mr-2" onclick="edit()">Edit</button>
                </div>
            </div>
        </div>
    </div>
</form>

<form id="form_delete">
    <?= csrf_field(); ?>
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title"> Konfirmasi Hapus Pengeluaran</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-2">
                        <div class="col-md-12 col-lg-12">
                            <label for="userName-2" class="block">Yakin ingin menghapus data ini?</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="id" class="id">
                    <button type="button" class="btn btn-secondary mt-2 mb-2" data-dismiss="modal">Tidak</button>
                    <button type="button" class="btn btn-primary mt-2 mb-2 mr-2" onclick="hapus()">Yakin</button>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    $('.btn-delete').on('click', function() {
        const id = $(this).data('id');
        $('.id').val(id);
        $('#deleteModal').modal('show');
    });

    $('.btn-update').on('click', function() {
        const id = $(this).data('id');
        const nama = $(this).data('nama');
        $('.id').val(id);
        $('.nama').val(nama);
        $('#updateModal').modal('show');
    });

    function hanyaAngka(event) {
        var angka = (event.which) ? event.which : event.keyCode
        if (angka != 46 && angka > 31 && (angka < 48 || angka > 57))
            return false;
        return true;
    }

    function reload_table() {
        $.ajax({
            url: "<?= base_url('jenispengeluaran/table_jenispengeluaran'); ?>",
            beforeSend: function(f) {
                $('#coba').html(`<div class="text-center">
                Mencari data...
                </div>`);
            },
            success: function(data) {
                $('#coba').html(data);
            }
        })
    }

    function simpan() {
        $.ajax({
            url: "<?= base_url('jenispengeluaran/save'); ?>",
            type: "POST",
            data: $("#form_tambah").serialize(),
            success: function(data) {
                swal({
                    title: "Berhasil",
                    text: "Data berhasil disimpan.",
                    icon: "success",
                    button: "Ok",
                });
                $('#addModal').modal('hide');
                $('#nama').val('');
                reload_table();
            }
        });
    }

    function edit() {
        $.ajax({
            url: "<?= base_url('jenispengeluaran/update'); ?>",
            type: "POST",
            data: $("#form_edit").serialize(),
            success: function(data) {
                swal({
                    title: "Berhasil",
                    text: "Data berhasil diedit.",
                    icon: "success",
                    button: "Ok",
                });
                $('#updateModal').modal('hide');
                reload_table();
            }
        });
    }

    function hapus() {
        $.ajax({
            url: "<?= base_url('jenispengeluaran/delete'); ?>",
            type: "POST",
            data: $("#form_delete").serialize(),
            success: function(data) {
                swal({
                    title: "Berhasil",
                    text: "Data berhasil dihapus.",
                    icon: "success",
                    button: "Ok",
                });
                $('#deleteModal').modal('hide');
                reload_table();
            }
        });
    }
</script>

<?= $this->endSection(); ?>