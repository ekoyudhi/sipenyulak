<?php session_start(); ?>
<div class="row">
<div class="col">
    <input type="hidden" id="id_penyuluhan">
    <input type="hidden" id="id_peserta">
    <input type="hidden" id="nip" value="<?php echo $_SESSION['nip']; ?>">
    <div id="perencanaan-main">
    <button type="button" class="btn btn-outline-primary btn-lg" data-toggle="modal" data-act="insert" data-target="#modalFormPerencanaan">Rekam
    </button>
    <button type="button" class="btn btn-outline-primary btn-lg" id="btnRefresh">Refresh</button>
    <div id="modalFormPerencanaan" class="modal fade bd-example-modal-lg" data-backdrop="static">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Rekam Rencana/Usulan</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                <div class="form-group">
                    <label for="txt-nama" class="col-form-label">Nama Penyuluhan</label>
                    <input class="form-control" type="text" name="txt-nama" id="txt-nama" required>
                </div>
                <div class="form-group">
                    <label for="date-waktu" class="col-form-label">Waktu Penyuluhan</label>
                    <input class="form-control" type="datetime-local" name="date-waktu" id="date-waktu" required>
                </div>
                <div class="form-group">
                    <label for="txt-lokasi" class="col-form-label">Lokasi Penyuluhan</label>
                    <input class="form-control" type="text" name="txt-lokasi" id="txt-lokasi" required>
                </div>
                <div class="form-group">
                    <label for="txt-tema" class="col-form-label">Tema Penyuluhan</label>
                    <input class="form-control" type="text" name="txt-tema" id="txt-tema" required>
                </div>
                <div class="form-group">
                    <label for="num-target" class="col-form-label">Target Penyuluhan</label>
                    <input class="form-control" type="number" name="num-target" id="num-target" required>
                </div>
                <div class="form-group">
                    <label for="num-anggaran" class="col-form-label">Anggaran Penyuluhan</label>
                    <input class="form-control" type="number" name="num-anggaran" id="num-anggaran" required>
                </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" id='btnFormTutup'>Tutup</button>
                    <button type="button" class="btn btn-primary" id="btnSimpan">Simpan</button>
                </div>
                
            </div>
        </div>
    </div>
    <div id="modalFormPerencanaanDelete" class="modal fade bd-example-modal-lg" data-backdrop="static">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Hapus</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                <p></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"id="btnDelTutup">Tutup</button>
                    <button type="button" class="btn btn-primary" id="btnHapus">Hapus</button>
                </div>
            </div>
        </div>
    </div>
    <div id="notif-perencanaan"></div>
    <table  id="table_1" 
            data-search="true"
			data-pagination="true"
			data-toggle="table">
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
    <div class="collapse" id="collapseCapes">
        <button type="button" class="btn btn-outline-primary btn-lg" id="btnTambahCapes" data-toggle="modal" data-act="insertcapes" data-target="#modalFormCapes">Tambah</button>
        <button type="button" class="btn btn-outline-primary btn-lg" id="btnRefreshCapes">Refresh</button>
        <button type="button" class="btn btn-outline-primary btn-lg" id="btnKembaliCapes">Kembali</button>
        <div id="notif-peserta"></div>
        <table  id="table_capes" data-search="true">
            <thead class="text-uppercase" style="background-color:#afafaf;">
                <tr>
                    <th scope="col" data-field="no">No</th>
                    <th scope="col" data-field="nama">Nama</th>
                    <th scope="col" data-field="npwp">NPWP</th>
                    <th scope="col" data-field="alamat">Alamat</th>
                    <th scope="col" data-field="kelurahan">Kelurahan</th>
                    <th scope="col" data-field="kecamatan">Kecamatan</th>
                    <th scope="col" data-field="kota">Kota</th>
                    <th scope="col" data-field="action">Action</th>
                </tr>
            </thead>
        </table>
        <div id="modalFormCapes" class="modal fade bd-example-modal-lg" data-backdrop="static">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Calon Peserta Penyuluhan</h5>
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
                        <!--div class="custom-control custom-radio">
                            <input type="radio" id="radioNIK" name="radioIdentitas" value="nik" class="custom-control-input">
                            <label class="custom-control-label" for="radioNIK">NIK</label>
                        </div-->
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
        <div id="modalCapesHapus" class="modal fade bd-example-modal-lg" data-backdrop="static">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Hapus Calon Peserta Penyuluhan</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                    </div>
                    <div class="modal-body">
                    <p></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" >Tutup</button>
                        <button type="button" class="btn btn-primary" id="btnCapesHapus">Hapus</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<style>
#notif-perencanaan,
#notif-peserta,
#notif-services  {
    margin: 8px;
}
#notif-perencanaan .alert,
#notif-peserta .alert,
#notif-services .alert {
    font-size: 14px;
}
</style>
<script type="text/javascript">
$(function() {
    
    $.getJSON('app-perencanaan.php?action=get', function (catalog) {
        $("#table_1").bootstrapTable({data: catalog});
    });

    $('[data-toggle="tooltip"]').tooltip()
    
    $('#btnRefresh').click(function() {
        $("#table_1").bootstrapTable('refreshOptions', {
            search: true,
            url: 'app-perencanaan.php?action=get'
        })
    });

    $('#modalFormPerencanaan').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var recipient = button.data('act') // Extract info from data-* attributes
        var modal = $(this)
        $("#id_penyuluhan").val(button.data('id'))
        //console.log(event);
        if (recipient == 'insert') {
            modal.find('.modal-title').html('Rekam Rencana Penyuluhan');
            modal.find('#txt-nama').val('')
            modal.find('#date-waktu').val('')
            modal.find('#txt-lokasi').val('')
            modal.find('#txt-tema').val('')
            modal.find('#num-target').val('0')
            modal.find('#num-anggaran').val('0')

            $('#btnSimpan').one('click', function(event) {
                event.preventDefault();
                let id = $("#id_penyuluhan").val();
                let nama = $('#txt-nama').val()
                let waktu = $('#date-waktu').val()
                let lokasi = $('#txt-lokasi').val()
                let tema = $('#txt-tema').val()
                let target = $('#num-target').val()
                let anggaran = $('#num-anggaran').val()
                let nip = $('#nip').val();

                $.post('app-perencanaan.php?action=insert',
                {
                    'nama': nama,
                    'waktu': waktu,
                    'lokasi': lokasi,
                    'tema': tema,
                    'target': target,
                    'anggaran': anggaran,
                    'nip' : nip
                },
                function(data, status) {
                    if (data == 'sukses') {
                        $("#notif-perencanaan").fadeIn(function(){
                            $(this).html('<div class="alert alert-success" role="alert">Rencana penyuluhan berhasil disimpan</div>')
                            .fadeOut(5000, function() { $(this).html(''); }); // Removed the .hide()
                        });
                    } else {
                        $("#notif-perencanaan").fadeIn(function(){
                            $(this).html('<div class="alert alert-danger" role="alert">Rencana penyuluhan gagal disimpan <b>'+data+'</b></div>')
                            .fadeOut(5000, function() { $(this).html(''); }); // Removed the .hide()
                        });
                    }
                    modal.modal('toggle');
					
                    $("#table_1").bootstrapTable('refreshOptions', {
						search: true,
						url: 'app-perencanaan.php?action=get'
					})
					
					document.getElementById("sidebar-perencanaan").click();
                });
            });

        } else if (recipient == 'update') {
            modal.find('.modal-title').html('Ubah Rencana Penyuluhan');
			let id = $("#id_penyuluhan").val();
            $.getJSON('app-perencanaan.php?action=get&id='+id, function (catalog) {
                    //$("#table_1").bootstrapTable({data: catalog});
                    modal.find('#txt-nama').val(catalog.nama)
                    modal.find('#date-waktu').val(catalog.waktu)
                    modal.find('#txt-lokasi').val(catalog.lokasi)
                    modal.find('#txt-tema').val(catalog.tema)
                    modal.find('#num-target').val(catalog.target)
                    modal.find('#num-anggaran').val(catalog.anggaran)
            })

            $('#btnSimpan').one('click', function(event) {
                event.preventDefault();
                let id = $("#id_penyuluhan").val();
                let nama = $('#txt-nama').val()
                let waktu = $('#date-waktu').val()
                let lokasi = $('#txt-lokasi').val()
                let tema = $('#txt-tema').val()
                let target = $('#num-target').val()
                let anggaran = $('#num-anggaran').val()
                let nip = $('#nip').val();

                $.post('app-perencanaan.php?action=update',
                {
                    'id': id,
                    'nama': nama,
                    'waktu': waktu,
                    'lokasi': lokasi,
                    'tema': tema,
                    'target': target,
                    'anggaran': anggaran,
                    'nip' : nip
                },
                function(data, status) {
                    if (data == 'sukses') {
                        $("#notif-perencanaan").fadeIn(function(){
                            $(this).html('<div class="alert alert-success" role="alert">Rencana penyuluhan berhasil diubah</div>')
                            .fadeOut(2000, function() { $(this).html(''); }); // Removed the .hide()
                        });
                    } else {
                        $("#notif-perencanaan").fadeIn(function(){
                            $(this).html('<div class="alert alert-danger" role="alert">Rencana penyuluhan gagal diubah <b>'+data+'</b></div>')
                            .fadeOut(2000, function() { $(this).html(''); }); // Removed the .hide()
                        });
                    }
                    modal.modal('toggle');
                    $('#btnRefresh').click();
                });
            });
            
        }
    });

    $('#modalFormPerencanaanDelete').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var recipient = button.data('act');
        var modal = $(this);
        $("#id_penyuluhan").val(button.data('id'));
        if (recipient == 'delete') {
            let id = $("#id_penyuluhan").val();
            modal.find('.modal-title').html('Hapus Rencana Penyuluhan');
            $.getJSON('app-perencanaan.php?action=getpenyuluhan&id='+id, function(response) {
                modal.find('.modal-body').html('<p>Apakah Anda akan menghapus rencana penyuluhan '+response.data.nama+'</p>');
            })
            
            $('#btnHapus').click(function() {
                let id = $("#id_penyuluhan").val();
                let nip = $('#nip').val();
                $.post('app-perencanaan.php?action=delete',
                {
                    'id': id,
                    'nip': nip
                },
                function(data, status) {
                    if (data == 'sukses') {
                    $("#notif-perencanaan").fadeIn(function(){
                        $(this).html('<div class="alert alert-success" role="alert">Rencana penyuluhan berhasil dihapus</div>')
                        .fadeOut(5000, function() { $(this).html(''); }); // Removed the .hide()
                    });
                } else {
                    $("#notif-perencanaan").fadeIn(function(){
                        $(this).html('<div class="alert alert-danger" role="alert">Rencana penyuluhan gagal dihapus <b>'+data+'</b></div>')
                        .fadeOut(5000, function() { $(this).html(''); }); // Removed the .hide()
                    });
                }
                    modal.modal('toggle');
                    $('#btnRefresh').click();
                });

            })
        } else if (recipient == 'send') {
            let id = $("#id_penyuluhan").val();
            modal.find('.modal-title').html('Kirim Rencana Penyuluhan Untuk Disetujui');
            $.getJSON('app-perencanaan.php?action=getpenyuluhan&id='+id, function(response) {
                modal.find('.modal-body').html('<p>Apakah Anda akan mengirim penyuluhan '+response.data.nama+' untuk disetujui?</p>');
            })
            
            $('#btnHapus').text('Kirim');

            $('#btnHapus').click(function(event) {
                event.preventDefault();
                let id = $("#id_penyuluhan").val();
                let nip = $('#nip').val();
                $.post('app-perencanaan.php?action=send',
                {
                    'id': id,
                    'nip':nip
                },
                function(data, status) {
                    if (data == 'sukses') {
                        $("#notif-perencanaan").fadeIn(function(){
                            $(this).html('<div class="alert alert-success" role="alert">Rencana penyuluhan berhasil dikirim untuk disetujui</div>')
                            .fadeOut(5000, function() { $(this).html(''); }); // Removed the .hide()
                        });
                    } else {
                        $("#notif-perencanaan").fadeIn(function(){
                            $(this).html('<div class="alert alert-danger" role="alert">Rencana penyuluhan gagal dikirim untuk disetujui<b>'+data+'</b></div>')
                            .fadeOut(5000, function() { $(this).html(''); }); // Removed the .hide()
                        });
                    }
                    modal.modal('toggle');
                    $('#btnRefresh').click();
                });

            })
        }
    });

    $('#collapseCapes').on('show.bs.collapse', function () {
        $('#perencanaan-main').hide();
    });

    $('#collapseCapes').on('shown.bs.collapse', function (e) {
        var a = $(e.target).data('bs.collapse');
        var id = a._config.id;
        var collapse = $(this);
        $("#id_penyuluhan").val(a._config.id);

        $.getJSON('app-perencanaan.php?action=get&id='+id, function (response) {
            document.getElementById('title-page').textContent = 'Calon Peserta Penyuluhan '+response.nama;
        });
        $('#btnTambahCapes').attr('data-id', ''+id+'');
        $('#btnRefreshCapes').attr('data-id', ''+id+'');
        $.getJSON('app-perencanaan.php?action=getcapes&id='+id, function (catalog) {
            $("#table_capes").bootstrapTable({data: catalog});
        });

        $('#btnKembaliCapes').click(function() {
            document.getElementById('sidebar-perencanaan').click();
            collapse.collapse('toggle');
        })
    });

    $('#modalFormCapes').on('show.bs.modal', function(event) {
		//event.preventDefault();
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

            $("#btnCek").one('click', function(event) {
				event.preventDefault();
				event.stopPropagation();
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

            $('#btnCapesSimpan').one('click', function(event) {
                event.preventDefault();
				event.stopPropagation();
                let id = $("#id_penyuluhan").val();
                let npwp = $('#txt-npwp').val();
                let nik = $('#txt-nik').val();
                let nama = $('#txt-capes').val();
                let alamat = $("#txt-alamat").val();
                let kelurahan = $("#txt-kelurahan").val();
                let kecamatan = $('#txt-kecamatan').val();
                let kota = $('#txt-kota').val();

                $.post('app-perencanaan.php?action=insertcapes',
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
                            $(this).html('<div class="alert alert-success" role="alert">Calon peserta penyuluhan berhasil disimpan</div>')
                            .fadeOut(2000, function() { $(this).html(''); }); // Removed the .hide()
                        });
                    } else {
                        $("#notif-peserta").fadeIn(function(){
                            $(this).html('<div class="alert alert-danger" role="alert">Calon pesera penyuluhan gagal disimpan <b>'+data+'</b></div>')
                            .fadeOut(2000, function() { $(this).html(''); }); // Removed the .hide()
                        });
                    }
                    modal.modal('toggle');
                    $('#btnRefreshCapes').click();
                });
            });
        }
    });

    $('#modalCapesHapus').on('show.bs.modal', function(event) {

        let button = $(event.relatedTarget) // Button that triggered the modal
        let recipient = button.data('act') // Extract info from data-* attributes
        let modal = $(this)
        if (recipient == 'deletecapes') {
            let id = button.data('id')
            $('#id_penyuluhan').val(id);
            let idpes = button.data('capes')
            $('#id_peserta').val(idpes);
            let nama = ''
            $.getJSON('app-perencanaan.php?action=getcapes&id='+id+'&idpes='+idpes, function(response) {
                modal.find('.modal-body').html('<p>Apakah Anda akan menghapus calon peserta penyuluhan '+response.nama+'</p>');
            })
        

        $('#btnCapesHapus').on('click', function(event){
                event.preventDefault();
				event.stopPropagation();
                let id_pes = $('#id_peserta').val();
                $.post('app-perencanaan.php?action=deletecapes',
                {
                    'idpes' : id_pes
                },
                function(data, status) {
                    if (data == 'sukses') {
                        $("#notif-peserta").fadeIn(function(){
                            $(this).html('<div class="alert alert-success" role="alert">Calon peserta penyuluhan berhasil dihapus</div>')
                            .fadeOut(5000, function() { $(this).html(''); }); // Removed the .hide()
                        });
                    } else {
                        $("#notif-peserta").fadeIn(function(){
                            $(this).html('<div class="alert alert-danger" role="alert">Calon pesera penyuluhan gagal hapus <b>'+data+'</b></div>')
                            .fadeOut(5000, function() { $(this).html(''); }); // Removed the .hide()
                        });
                    }
                    modal.modal('toggle');
                    $('#btnRefreshCapes').click();
                });
            });
			
			//event.preventDefault();
			//event.stopPropagation();
		}
				
    });

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

    $('#btnRefreshCapes').click(function() {
        let id = $('#btnRefreshCapes').attr('data-id');
        $("#table_capes").bootstrapTable('refreshOptions', {
            search: true,
            url: 'app-perencanaan.php?action=getcapes&id='+id
        })
    });

});
</script>