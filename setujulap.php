<?php session_start(); ?>
<div class="row">
<div class="col">
<input type="hidden" id="id_penyuluhan">
<input type="hidden" id="nip" value="<?php echo $_SESSION['nip']; ?>">
<button type="button" class="btn btn-outline-primary btn-lg" id="btnSetujuLapRefresh">Refresh</button>
<div id="notif-setujulap"></div>
<table  id="table_setujulap" 
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
<div id="modalSetujuLapPDF" class="modal fade bd-example-modal-lg" data-backdrop="static">
    <div class="modal-dialog modal-lg">
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
                <button type="button" class="btn btn-primary" id="btnPDF">Simpan</button>
            </div>
        </div>
    </div>
</div>
<div id="modalSetujuLap" class="modal fade bd-example-modal-lg" data-backdrop="static">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Persetujuan Laporan Penyuluhan</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
            <p></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" >Tutup</button>
                <button type="button" class="btn btn-primary" id="btnSetujuLap">Simpan</button>
            </div>
        </div>
    </div>
</div>
</div>
</div>
<style>
#notif-setujulap {
    margin:8px;
}
#notif-setujulap .alert {
    font-size:16px;
}
</style>
<script type="text/javascript">
$(function() {

    $.getJSON('app-setujulap.php?action=get', function(catalog) {
        $('#table_setujulap').bootstrapTable({data: catalog});
    });

    $('#modalSetujuLap').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var recipient = button.data('act');
        var modal = $(this);
        $('#id_penyuluhan').val(button.data('id'));

        if (recipient == 'setuju') {

            modal.find(".modal-body p").text("Apakah laporan penyuluhan akan disetujui?");
            $("#btnSetujuLap").text("Setuju");

            $("#btnSetujuLap").click(function(event) {
                event.preventDefault();
                let id = $('#id_penyuluhan').val();
                let nip = $('#nip').val();
                $.post('app-setujulap.php?action=setuju',
                {
                    'id' : id,
                    'nip' : nip
                },
                function(data, status) {
                    if (data == 'sukses') {
                        $("#notif-setujulap").fadeIn(function(){
                            $(this).html('<div class="alert alert-success" role="alert">Laporan penyuluhan berhasil disetujui</div>')
                            .fadeOut(2000, function() { $(this).html(''); }); // Removed the .hide()
                        });
                    } else {
                        $("#notif-setujulap").fadeIn(function(){
                            $(this).html('<div class="alert alert-danger" role="alert">Laporan penyuluhan gagal disetujui <b>'+data+'</b></div>')
                            .fadeOut(2000, function() { $(this).html(''); }); // Removed the .hide()
                        });
                    }
                    modal.modal('toggle');
                    $("#table_setujulap").bootstrapTable('refreshOptions', {
                        search: true,
                        url: 'app-setujulap.php?action=get'
                    });
                })
            })
        } else if (recipient == 'tolak') {
            
            modal.find(".modal-body p").text("Apakah laporan penyuluhan akan ditolak?");
            $("#btnSetujuLap").text("Tolak");

            $("#btnSetujuLap").click(function(event) {
                event.preventDefault();
                let id = $('#id_penyuluhan').val();
                let nip = $('#nip').val();
                $.post('app-setujulap.php?action=tolak',
                {
                    'id' : id,
                    'nip' : nip
                },
                function(data, status) {
                    if (data == 'sukses') {
                        $("#notif-setujulap").fadeIn(function(){
                            $(this).html('<div class="alert alert-success" role="alert">Laporan penyuluhan berhasil ditolak</div>')
                            .fadeOut(2000, function() { $(this).html(''); }); // Removed the .hide()
                        });
                    } else {
                        $("#notif-setujulap").fadeIn(function(){
                            $(this).html('<div class="alert alert-danger" role="alert">Laporan penyuluhan gagal ditolak <b>'+data+'</b></div>')
                            .fadeOut(2000, function() { $(this).html(''); }); // Removed the .hide()
                        });
                    }
                    modal.modal('toggle');
                    $("#table_setujulap").bootstrapTable('refreshOptions', {
                        search: true,
                        url: 'app-setujulap.php?action=get'
                    });
                })
            })
        }
    });

    $("#btnSetujuLapRefresh").click(function(){
        $("#table_setujulap").bootstrapTable('refreshOptions', {
            search: true,
            url: 'app-setujulap.php?action=get'
        });
    })
});
</script>