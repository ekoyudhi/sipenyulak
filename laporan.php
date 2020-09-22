<?php
session_start();
?>
<div class="row">
<div class="col">
<input type="hidden" id="id_penyuluhan">
<input type="hidden" id="id_laporan">
<input type="hidden" id="nip" value="<?php echo $_SESSION['nip']; ?>">
<button type="button" class="btn btn-outline-primary btn-lg" id="btnLaporanRefresh">Refresh</button>
<div id="notif-laporan"></div>
<table  id="table_laporan" 
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
<div id="modalIsiDes" class="modal fade bd-example-modal-lg" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Isi Deskripsi</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body"> 
            <textarea class="ckeditor" id="ckeditor" name="ckeditor"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" >Tutup</button>
                <button type="button" class="btn btn-primary" id="btnIsiDesSimpan">Simpan</button>
            </div>
        </div>
    </div>
</div>
<div id="modalLaporan" class="modal fade bd-example-modal-lg" data-backdrop="static">
    <div class="modal-dialog modal-md">
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
                <button type="button" class="btn btn-primary" id="btnLap">Simpan</button>
            </div>
        </div>
    </div>
</div>
</div>
</div>
<style>
.ckeditor {
    width : 100%;
    height:200px;
}
#notif-laporan {
    margin:8px;
}
#notif-laporan .alert {
    font-size:16px;
}
</style>

<script type="text/javascript">
$(function() {

    $.getJSON('app-laporan.php?action=get', function(catalog) {
        $('#table_laporan').bootstrapTable({data: catalog});
    });

    $('#btnLaporanRefresh').click(function() {
        $('#table_laporan').bootstrapTable('refreshOptions', {
            search:true,
            url:'app-laporan.php?action=get'
        });
    });

    $('#modalIsiDes').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var recipient = button.data('act');
        $('#id_penyuluhan').val(button.data('id'));
        var modal = $(this);
        if (recipient == 'isi') {
            let id = $('#id_penyuluhan').val();
            $.getJSON('app-laporan.php?action=getdes&id='+id, function(response) {
                $('#id_laporan').val(response.data.id_laporan);
                if (response.status == 1) {
                    modal.find('#ckeditor').val(response.data.deskripsi);
                } else {
                    modal.find('#ckeditor').val("")
                }
            });

            $("#btnIsiDesSimpan").click(function(event) {
                event.preventDefault();
                let id = $('#id_penyuluhan').val();
                let deskripsi = $("#ckeditor").val();
                let id_lap = $("#id_laporan").val();
                $.post('app-laporan.php?action=updatedes',
                {
                    'id':id,
                    'id_lap':id_lap,
                    'deskripsi':deskripsi
                },
                function(data, status) {
                    if (data == 'sukses') {
                        $("#notif-laporan").fadeIn(function(){
                            $(this).html('<div class="alert alert-success" role="alert">Deskripsi laporan berhasil disimpan</div>')
                            .fadeOut(2000, function() { $(this).html(''); }); // Removed the .hide()
                        });
                    } else {
                        $("#notif-laporan").fadeIn(function(){
                            $(this).html('<div class="alert alert-danger" role="alert">Deskripsi laporan gagal disimpan <b>'+data+'</b></div>')
                            .fadeOut(10000, function() { $(this).html(''); }); // Removed the .hide()
                        });
                    }
                    modal.modal('toggle');
                    $("#table_laporan").bootstrapTable('refreshOptions', {
                        search: true,
                        url: 'app-laporan.php?action=get'
                    });
                });
            })
        }
    });

    $('#modalLaporan').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var recipient = button.data('act');
        var modal = $(this);
        $('#id_penyuluhan').val(button.data('id'));
        if (recipient == 'cetak') {
            modal.find('.modal-title').text("Cetak Laporan");
            modal.find('.modal-body p').text("Anda akan mencetak laporan dalam bentuk PDF?");
            modal.find('#btnLap').text('Cetak')
        } else if (recipient == 'send') {
            modal.find('.modal-title').text("Kirim Persetujuan Laporan");
            modal.find('.modal-body p').text("Anda akan mengirim laporan penyuluhan untuk disetujui?");
            modal.find('#btnLap').text('Kirim')
        }

        $("#btnLap").click(function(event) {
            event.preventDefault();
            let id = $('#id_penyuluhan').val();
            let nip = $('#nip').val();
            if (recipient =='send') {
                $.post('app-laporan.php?action=send',
                {
                    'id' : id,
                    'nip' : nip
                },
                function(data, status) {
                    if (data == 'sukses') {
                        $("#notif-laporan").fadeIn(function(){
                            $(this).html('<div class="alert alert-success" role="alert">Laporan peyuluhan berhasil dikirim</div>')
                            .fadeOut(2000, function() { $(this).html(''); }); // Removed the .hide()
                        });
                    } else {
                        $("#notif-laporan").fadeIn(function(){
                            $(this).html('<div class="alert alert-danger" role="alert">Laporan peyuluhan gagal dikirim <b>'+data+'</b></div>')
                            .fadeOut(2000, function() { $(this).html(''); }); // Removed the .hide()
                        });
                    }
                    modal.modal('toggle');
                    $("#table_laporan").bootstrapTable('refreshOptions', {
                        search: true,
                        url: 'app-laporan.php?action=get'
                    });
                })
            }
        });
    });
});
</script>

