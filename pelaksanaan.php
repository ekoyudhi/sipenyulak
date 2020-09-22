<?php
session_start();
?>
<div class="row">
<div class="col">
<input type="hidden" id="id_penyuluhan">
<input type="hidden" id="id_peserta">
<input type="hidden" id="id_presensi">
<input type="hidden" id="id_materi">
<input type="hidden" id="nip" value="<?php echo $_SESSION['nip']; ?>">
<div id="pelaksanaan-main">
<button type="button" class="btn btn-outline-primary btn-lg" id="btnRefresh">Refresh</button>

<table  id="table_3" 
            data-search="true">
    <thead class="text-uppercase" style="background-color:#afafaf;">
        <tr>
            <th scope="col" data-field="no">No</th>
            <th scope="col" data-field="nama">Nama</th>
            <th scope="col" data-field="lokasi">Lokasi</th>
            <th scope="col" data-field="waktu">Tanggal/Waktu</th>
            <th scope="col" data-field="tema">Tema</th>
            <th scope="col" data-field="target">Target</th>
            <th scope="col" data-field="peserta">Peserta</th>
            <th scope="col" data-width="120" data-field="status">Status</th>
            <th scope="col" data-width="110" data-field="action">Action</th>
        </tr>
    </thead>
</table>
</div>
<div class="collapse" id="collapseExample">
<button type="button" class="btn btn-outline-primary btn-lg" id="btnX">Kembali</button>
<button type="button" class="btn btn-outline-primary btn-lg" data-toggle="modal" data-target="#modalSelesai" id="btnSelesai">Selesai Dilaksanakan</button>
<div id="modalSelesai" class="modal fade bd-example-modal-lg" data-backdrop="static">
<div class="modal-dialog modal-md">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Selesai Dilaksanakan</h5>
            <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
        </div>
        <div class="modal-body">
        <p>Apakah penyuluhan telah selesai dilaksanakan?</p>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal" >Tutup</button>
            <button type="button" class="btn btn-primary" id="btnModSelesai">Selesai</button>
        </div>
    </div>
</div>
</div>
<div class="d-flex flex-wrap" id="identitas">
<div class="d-flex flex-column">
    <div class="d-flex flex-row">
        <div class="p-2" style=" width:75px;">ID</div>
        <div class="p-2" style=" width:15px;">:</div>
        <div class="p-2" style=" width:200px;" id="tb-id"></div>
    </div>
    <div class="d-flex flex-row">
        <div class="p-2" style=" width:75px;">Nama</div>
        <div class="p-2" style=" width:15px;">:</div>
        <div class="p-2" style=" width:200px;" id="tb-nama"></div>
    </div>
    <div class="d-flex flex-row">
        <div class="p-2" style=" width:75px;">Lokasi</div>
        <div class="p-2" style=" width:15px;">:</div>
        <div class="p-2" style=" width:200px;" id="tb-lokasi"></div>
    </div>
    <div class="d-flex flex-row">
        <div class="p-2" style=" width:75px;">Waktu</div>
        <div class="p-2" style=" width:15px;">:</div>
        <div class="p-2" style=" width:200px;" id="tb-waktu"></div>
    </div>
    </div>
    <div class="d-flex flex-column">
    <div class="d-flex flex-row">
        <div class="p-2" style=" width:75px;">Tema</div>
        <div class="p-2" style=" width:15px;">:</div>
        <div class="p-2" style=" width:200px;" id="tb-tema"></div>
    </div>
    <div class="d-flex flex-row">
        <div class="p-2" style=" width:75px;">Target</div>
        <div class="p-2" style=" width:15px;">:</div>
        <div class="p-2" style=" width:200px;" id="tb-target"></div>
    </div>
    <div class="d-flex flex-row">
        <div class="p-2" style=" width:75px;">Anggaran</div>
        <div class="p-2" style=" width:15px;">:</div>
        <div class="p-2" style=" width:200px;" id="tb-anggaran"></div>
    </div>
    <div class="d-flex flex-row">
        <div class="p-2" style=" width:75px;">Link Feedback</div>
        <div class="p-2" style=" width:15px;">:</div>
        <div class="p-2" style=" width:200px;" id="tb-link"></div>
    </div>
    </div>
</div>
<!-- nav tab start -->
<div class="mt-5">
    <div class="card">
        <div class="card-body">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link" id="presensi-tab" data-toggle="tab" href="#presensi" role="tab" aria-controls="presensi" aria-selected="false">Presensi</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="feedback-tab" data-toggle="tab" href="#feedback" role="tab" aria-controls="feedback" aria-selected="false">Feedback</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="materi-tab" data-toggle="tab" href="#materi" role="tab" aria-controls="materi" aria-selected="false">Materi</a>
                </li>
            </ul>
            <div class="tab-content mt-3" id="myTabContent">
                <div class="tab-pane fade" id="presensi" role="tabpanel" aria-labelledby="presensi-tab">
                    <h5>Presensi Peserta</h5>
                    <button type="button" class="btn btn-outline-primary btn-lg" id="btnTambahHadir" data-toggle="modal" data-act="insertcapes" data-target="#modalFormCapes">Tambah Peserta Hadir</button>
                    <button type="button" class="btn btn-outline-primary btn-lg" id="btnRefreshHadir">Refresh</button>
                    <div id="notif-peshadir"></div>
                    <table  id="table_4" 
                            data-search="true">
                        <thead class="text-uppercase" style="background-color:#afafaf;">
                            <tr>
                                <th scope="col" data-field="no">No</th>
                                <th scope="col" data-field="nama">Nama</th>
                                <th scope="col" data-field="nik">NIK</th>
                                <th scope="col" data-field="npwp">NPWP</th>
                                <th scope="col" data-field="alamat">Alamat Lengkap</th>
                                <th scope="col" data-field="kehadiran">Kehadiran</th>
                                <th scope="col" data-field="action">Action</th>
                            </tr>
                        </thead>
                    </table>
                    <div id="modalFormCapes" class="modal fade bd-example-modal-lg" data-backdrop="static">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Tambah Peserta Hadir</h5>
                                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                </div>
                                <div class="modal-body">
                                <div id="notif-services"></div>
                                <div class="form-group">
                                <label for="txt-radio" class="col-form-label">Pilih Identitas</label>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="radioNPWP" name="radioIdentitas" value="npwp" class="custom-control-input">
                                        <label class="custom-control-label" for="radioNPWP">NPWP</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="radioNIK" name="radioIdentitas" value="nik" class="custom-control-input">
                                        <label class="custom-control-label" for="radioNIK">NIK</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="txt-identitas" class="col-form-label">Identitas</label>
                                    <div class="form-inline">
                                    <input class="form-control" type="text" name="txt-identitas" id="txt-identitas" required>&nbsp;&nbsp;
                                    <button type="button" id="btnCek" class="btn btn-primary">Cek</button>
                                    <input class="form-control" type="hidden" name="txt-npwp" id="txt-npwp">
                                    <input class="form-control" type="hidden" name="txt-nik" id="txt-nik">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="txt-capes" class="col-form-label">Nama Peserta</label>
                                    <input class="form-control" type="text" name="txt-capes" id="txt-capes" required>
                                </div>
                                <div class="form-group">
                                    <label for="txt-alamat" class="col-form-label">Alamat</label>
                                    <input class="form-control" type="text" name="txt-alamat" id="txt-alamat" required>
                                </div>
                                <div class="row">
                                    <div class="col-sm">
                                    <div class="form-group">
                                        <label for="txt-kota" class="col-form-label">Kota</label>
                                        <input class="form-control" type="text" name="txt-kota" id="txt-kota" required>
                                    </div>
                                </div>
                                <div class="col-sm">
                                    <div class="form-group">
                                        <label for="txt-kecamatan" class="col-form-label">Kecamatan</label>
                                        <input class="form-control" type="txt" name="txt-kecamatan" id="txt-kecamatan" required>
                                    </div>
                                </div>
                                <div class="col-sm">
                                    <div class="form-group">
                                        <label for="txt-kelurahan" class="col-form-label">Kelurahan</label>
                                        <input class="form-control" type="txt" name="txt-kelurahan" id="txt-kelurahan" required>
                                    </div>
                                </div>
                                </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal" id='btnCapesTutup'>Tutup</button>
                                    <button type="button" class="btn btn-primary" id="btnCapesSimpan">Simpan</button>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    <div id="modalHadir" class="modal fade bd-example-modal-lg" data-backdrop="static">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Presensi Hadir</h5>
                                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                </div>
                                <div class="modal-body">
                                <p></p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal" >Tutup</button>
                                    <button type="button" class="btn btn-primary" id="btnPresensiHadir">Presensi</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="feedback" role="tabpanel" aria-labelledby="feedback-tab">
                    <table  id="table_feed" 
                            data-search="true">
                        <thead class="text-uppercase" style="background-color:#afafaf;">
                            <tr>
                                <th scope="col" data-field="no" data-width="80">No</th>
                                <th scope="col" data-field="feedback">FeedBack</th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <div class="tab-pane fade" id="materi" role="tabpanel" aria-labelledby="materi-tab">
                    <button type="button" class="btn btn-outline-primary btn-lg" id="btnUploadMateri" data-toggle="modal" data-act="insert" data-target="#modalFormMateri">Upload Materi</button>
                   <div id="notif-materi"></div>
                    <table  id="table_materi" 
                                data-search="true">
                        <thead class="text-uppercase" style="background-color:#afafaf;">
                            <tr>
                                <th scope="col" data-field="no">No</th>
                                <th scope="col" data-field="nama">Nama</th>
                                <th scope="col" data-field="deskripsi">Deskripsi</th>
                                <th scope="col" data-field="file">File</th>
                                <th scope="col" data-width="110" data-field="action">Action</th>
                            </tr>
                        </thead>
                    </table>
                    <div id="modalFormMateri" class="modal fade bd-example-modal-lg" data-backdrop="static">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Upload Materi</h5>
                                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                </div>
                                <div class="modal-body">
                                <form id="fupForm" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label for="txt-materi">Nama Materi</label>
                                        <input type="text" class="form-control" id="txt-materi" name="txt-materi" placeholder="Nama Materi...." required />
                                    </div>
                                    <div class="form-group">
                                        <label for="txt-deskripsi">Deskripsi Materi</label>
                                        <input type="text" class="form-control" id="txt-deskripsi" name="txt-deskripsi" placeholder="Deskripsi Materi...." required />
                                    </div>
                                    <div class="form-group">
                                        <label for="file">File Materi</label>
                                        <input type="file" class="form-control-file" id="file" name="file" required />
                                    </div>
                                    <input type="submit" name="submit" class="btn btn-primary" value="SUBMIT"/>
                                </form>
                                </div>                                
                            </div>
                        </div>
                    </div>
                    <div id="modalMateriDelete" class="modal fade bd-example-modal-lg" data-backdrop="static">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Hapus Materi</h5>
                                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                </div>
                                <div class="modal-body">
                                <p></p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                    <button type="button" class="btn btn-primary" id="btnMateriHapus">Hapus</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- nav tab end -->
</div>
</div>
</div>
<style>
#notif-materi,
#notif-peshadir  {
    margin: 8px;
}
#notif-materi .alert,
#notif-peshadir .alert {
    font-size: 16px;
}
#identitas {
    margin : 16px;
}
#identitas .row {
    padding : 8px;
}
</style>
<script type="text/javascript">
$(function() {
    
    $.getJSON('app-pelaksanaan.php?action=get', function (catalog) {
        $("#table_3").bootstrapTable({data: catalog});
    });
    
    $('[data-toggle="tooltip"]').tooltip()

    $('#btnRefresh').click(function() {
        $("#table_3").bootstrapTable('refreshOptions', {
            search: true,
            url: 'app-pelaksanaan.php?action=get'
        });
    });

    $('#btnX').click(function() {
        $('#pelaksanaan-main').show();
        $('#collapseExample').collapse('toggle');
        document.getElementById("sidebar-pelaksanaan").click();
    });


    $('#collapseExample').on('show.bs.collapse', function () {
        $('#pelaksanaan-main').hide();
    });
    $('#collapseExample').on('shown.bs.collapse', function (e) {
        var a = $(e.target).data('bs.collapse');
        var id = a._config.id;
        var coll = $(this);
        coll.find('#btnUploadMateri').attr('data-id',id);
        coll.find('#btnTambahHadir').attr('data-id',id)
        $('#id_penyuluhan').val(id);
        $.getJSON('app-pelaksanaan.php?action=get&id='+id, function (catalog) {
            coll.find('#tb-id').text(catalog.no); 
            coll.find('#tb-nama').text(catalog.nama);
            coll.find('#tb-lokasi').text(catalog.lokasi);
            coll.find('#tb-waktu').text(catalog.waktu);
            coll.find('#tb-tema').text(catalog.tema);
            coll.find('#tb-target').text(catalog.target);
            coll.find('#tb-anggaran').text(catalog.anggaran);
            coll.find('#tb-link').html("<a href='feedback.php/"+catalog.link+" target='_blank'>"+catalog.link+"</a>");
        })

        //isi table peserta
        $.getJSON('app-pelaksanaan.php?action=getpeserta&id='+id, function (catalog) {
            $("#table_4").bootstrapTable({data: catalog});
        });

        //isi feedback
        $.getJSON('app-pelaksanaan.php?action=getfeedback&id='+id, function (catalog) {
            $("#table_feed").bootstrapTable({data: catalog});
        });

        //isi tabel materi
        $.getJSON('app-pelaksanaan.php?action=getmateri&id='+id, function (catalog) {
            $("#table_materi").bootstrapTable({data: catalog});
        });
    });

    $('#modalSelesai').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var recipient = button.data('act');
        var modal = $(this);

        $("#btnModSelesai").click(function(event) {
            event.preventDefault();
            let id = $("#id_penyuluhan").val();
            let nip =$("#nip").val();
            $.post('app-pelaksanaan.php?action=insertselesai',
            {
                'id' : id,
                'nip' : nip
            },
            function(data, status){
                modal.modal('toggle');
            })
        })
    })

    $('#modalSelesai').on('hidden.bs.modal', function(event) {
        document.getElementById("sidebar-pelaksanaan").click();
    });
    $('#modalFormMateri').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var recipient = button.data('act');
        var modal = $(this);
        if (recipient == 'insert') {
            
            modal.find('#txt-materi').val('');
            modal.find('#txt-deskripsi').val('');
            //modal.find('#file-materi').empty();

            $("#fupForm").on('submit', function(e){
                var id = button.data('id');
                e.preventDefault();
                $.ajax({
                    type: 'POST',
                    url: 'app-pelaksanaan.php?action=insertmateri&id='+id,
                    data: new FormData(this),
                    dataType: 'json',
                    contentType: false,
                    cache: false,
                    processData:false,
                    beforeSend: function(){
                    },
                    success: function(response){ //console.log(response);
                        //alert(response.message);
                        if (response.status === 1) {
                            $("#notif-materi").fadeIn(function(){
                                    $(this).html('<div class="alert alert-success" role="alert">Materi berhasil disimpan</div>')
                                    .fadeOut(5000, function() { $(this).html(''); }); // Removed the .hide()
                                });
                        } else {
                                $("#notif-materi").fadeIn(function(){
                                    $(this).html('<div class="alert alert-danger" role="alert">Materi gagal disimpan <b>'+data+'</b></div>')
                                    .fadeOut(5000, function() { $(this).html(''); }); // Removed the .hide()
                                });
                        }
                        modal.modal('toggle');
                        $("#table_materi").bootstrapTable('refreshOptions', {
                            search: true,
                            url: 'app-pelaksanaan.php?action=getmateri&id='+id
                        });
                    }
                });
                
            });
        } 
    });

    $('#modalMateriDelete').on('show.bs.modal', function(event) {
        //event.preventDefault();
        var button = $(event.relatedTarget);
        var recipient = button.data('act');
        var modal = $(this);
        $("#id_materi").val(button.data('materi'));
        $("#id_penyuluhan").val(button.data('id'));

        if (recipient == 'delete') {
            let id_materi = $("#id_materi").val();
            modal.find('.modal-body p').html('Anda akan menghapus file materi dengan id : '+ id_materi)

            $('#btnMateriHapus').click(function(event) {
                event.preventDefault();
                let id_materi = $("#id_materi").val();
                let id = $("#id_penyuluhan").val();
                $.post('app-pelaksanaan.php?action=deletemateri',
                {
                    'id_materi': id_materi
                },
                function(data, status) {
                    if (data == 'sukses') {
                        $("#notif-materi").fadeIn(function(){
                                $(this).html('<div class="alert alert-success" role="alert">Materi berhasil dihapus</div>')
                                .fadeOut(5000, function() { $(this).html(''); }); // Removed the .hide()
                            });
                    } else {
                            $("#notif-materi").fadeIn(function(){
                                $(this).html('<div class="alert alert-danger" role="alert">Materi gagal dihapus <b>'+data+'</b></div>')
                                .fadeOut(5000, function() { $(this).html(''); }); // Removed the .hide()
                            });
                    }
                    modal.modal('toggle');
                    $("#table_materi").bootstrapTable('refreshOptions', {
                        search: true,
                        url: 'app-pelaksanaan.php?action=getmateri&id='+id
                    });
                });
            });
        }
    });

    $('#modalFormCapes').on('show.bs.modal', function(event) {

        var button = $(event.relatedTarget) // Button that triggered the modal
        var recipient = button.data('act') // Extract info from data-* attributes
        var modal = $(this)
        $("#id_penyuluhan").val(button.data('id'));
        if (recipient == 'insertcapes') {

            $("input[type=radio]").prop("checked", false);
            $("#txt-identitas").val("");
            $('#txt-npwp').val("");
            $('#txt-nik').val("");
            $('#txt-capes').val("");
            $("#txt-alamat").val("");
            $("#txt-kelurahan").val("");
            $('#txt-kecamatan').val("");
            $('#txt-kota').val("");

            $("#txt-identitas").prop('disabled', true);
            $("#btnCek").prop('disabled', true);
            $('#txt-capes').prop('disabled', true);
            $("#txt-alamat").prop('disabled', true);
            $("#txt-kelurahan").prop('disabled', true);
            $('#txt-kecamatan').prop('disabled', true);
            $('#txt-kota').prop('disabled', true);
            $('#btnCapesSimpan').prop('disabled', true);

            $("input[type=radio]").on( "click", function() {
                var identitas = $("input[type=radio]:checked").val();
                $("#txt-identitas").prop('disabled', false);
                $("#btnCek").prop('disabled', false);
                if (identitas === "npwp"){
                    $("label[for=txt-identitas").text("Masukkan NPWP");
                    $("#txt-identitas").attr("maxlength", "15");
                } else if (identitas === "nik") {
                    $("label[for=txt-identitas").text("Masukkan NIK");
                    $("#txt-identitas").attr("maxlength", "16");
                }

            });

            $("#btnCek").click(function() {
                var identitas = $("input[type=radio]:checked").val();
                var val = $("#txt-identitas").val();
                $.getJSON('app-services.php?name='+identitas+'&val='+val, function (response) {
                    $("#btnCek").prop('disabled', true);
                    if (response.status === 1) {
                        $('#txt-npwp').val(response.data.npwp);
                        $('#txt-nik').val(response.data.nik);
                        $('#txt-capes').val(response.data.nama);
                        $("#txt-alamat").val(response.data.alamat);
                        $("#txt-kelurahan").val(response.data.kelurahan);
                        $('#txt-kecamatan').val(response.data.kecamatan);
                        $('#txt-kota').val(response.data.kota);
                        $('#btnCapesSimpan').prop('disabled', false);

                    } else {
                        $("#notif-services").fadeIn(function(){
                            $(this).html('<div class="alert alert-danger" role="alert">Data gagal ditemukan <b>'+response.message+'</b></div>')
                            .fadeOut(1600, function() { 
                                $(this).html(''); 
                                $("#btnCek").prop('disabled', false);
                            }); // Removed the .hide()
                        });
                    }
                });
            });

            $('#btnCapesSimpan').click(function() {
                let id = $('#id_penyuluhan').val();
                let npwp = $('#txt-npwp').val();
                let nik = $('#txt-nik').val();
                let nama = $('#txt-capes').val();
                let alamat = $("#txt-alamat").val();
                let kelurahan = $("#txt-kelurahan").val();
                let kecamatan = $('#txt-kecamatan').val();
                let kota = $('#txt-kota').val();

                $.post('app-pelaksanaan.php?action=insertpeshadir',
                {
                    'id' : id,
                    'npwp' : npwp,
                    'nik' : nik,
                    'nama' : nama,
                    'alamat' : alamat,
                    'kelurahan' : kelurahan,
                    'kecamatan' : kecamatan,
                    'kota' : kota
                },
                function(data, status) {
                    if (data == 'sukses') {
                        $("#notif-peserta").fadeIn(function(){
                            $(this).html('<div class="alert alert-success" role="alert">Berhasil menambahkan peserta hadir</div>')
                            .fadeOut(2000, function() { $(this).html(''); }); // Removed the .hide()
                        });
                    } else {
                        $("#notif-peserta").fadeIn(function(){
                            $(this).html('<div class="alert alert-danger" role="alert">Gagal menambahkan peserta hadir <b>'+data+'</b></div>')
                            .fadeOut(2000, function() { $(this).html(''); }); // Removed the .hide()
                        });
                    }
                    modal.modal('toggle');
                    $("#table_4").bootstrapTable('refreshOptions', {
                        search: true,
                        url: 'app-pelaksanaan.php?action=getpeserta&id='+id
                    });
                    
                });
            });
        }
    });

    $('#modalHadir').on('show.bs.modal', function(event){
        var button = $(event.relatedTarget) // Button that triggered the modal
        var recipient = button.data('act') // Extract info from data-* attributes
        var modal = $(this)
        $('#id_penyuluhan').val(button.data('id'));
        $('#id_peserta').val(button.data('pes'));
        if (recipient == 'presensi') {
            let id = $('#id_penyuluhan').val();
            let idpes = $('#id_peserta').val();
            $.getJSON('app-pelaksanaan.php?action=getpeserta&id='+id+'&idpes='+idpes, function(response) {
                modal.find('.modal-body p').html('Apakah '+response.data.nama+' akan melakukan presensi kehadiran?');
            });

            $('#btnPresensiHadir').click(function(event) {
                event.preventDefault();

                $.post('app-pelaksanaan.php?action=inserthadir',
                {
                    'id':id,
                    'idpes':idpes
                },
                function(data, status){
                    if (data == 'sukses') {
                        $("#notif-peserta").fadeIn(function(){
                            $(this).html('<div class="alert alert-success" role="alert">Berhasil melakukan presensi hadir</div>')
                            .fadeOut(2000, function() { $(this).html(''); }); // Removed the .hide()
                        });
                    } else {
                        $("#notif-peserta").fadeIn(function(){
                            $(this).html('<div class="alert alert-danger" role="alert">Gagal melakukan presensi hadir <b>'+data+'</b></div>')
                            .fadeOut(2000, function() { $(this).html(''); }); // Removed the .hide()
                        });
                    }
                    modal.modal('toggle');
                    $("#table_4").bootstrapTable('refreshOptions', {
                        search: true,
                        url: 'app-pelaksanaan.php?action=getpeserta&id='+id
                    });
                });
            })

        }
    });

    $('#btnRefreshHadir').click(function(){
        let id = $("#id_penyuluhan").val();
        $("#table_4").bootstrapTable('refreshOptions', {
            search : true,
            url: 'app-pelaksanaan.php?action=getpeserta&id='+id
        });
    });
});
</script>