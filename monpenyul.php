<div class="row">
<div class="col">
<input type="hidden" id="id_penyuluhan">
<input type="hidden" id="id_peserta">
<input type="hidden" id="id_presensi">
<input type="hidden" id="id_materi">
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
                            </tr>
                        </thead>
                    </table>                   
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
    
    $.getJSON('app-monitoring.php?action=get', function (catalog) {
        $("#table_3").bootstrapTable({data: catalog});
    });
    
    $('[data-toggle="tooltip"]').tooltip()

    $('#btnRefresh').click(function() {
        $("#table_3").bootstrapTable('refreshOptions', {
            search: true,
            url: 'app-monitoring.php?action=get'
        });
    });

    $('#btnX').click(function() {
        $('#pelaksanaan-main').show();
        $('#collapseExample').collapse('toggle');
        document.getElementById("sidebar-monpenyul").click();
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
        $.getJSON('app-monitoring.php?action=get&id='+id, function (catalog) {
            coll.find('#tb-id').text(catalog.no); 
            coll.find('#tb-nama').text(catalog.nama);
            coll.find('#tb-lokasi').text(catalog.lokasi);
            coll.find('#tb-waktu').text(catalog.waktu);
            coll.find('#tb-tema').text(catalog.tema);
            coll.find('#tb-target').text(catalog.target);
            coll.find('#tb-anggaran').text(catalog.anggaran);
        })

        //isi table peserta
        $.getJSON('app-monitoring.php?action=getpeserta&id='+id, function (catalog) {
            $("#table_4").bootstrapTable({data: catalog});
        });

        //isi feedback
        $.getJSON('app-monitoring.php?action=getfeedback&id='+id, function (catalog) {
            $("#table_feed").bootstrapTable({data: catalog});
        });

        //isi tabel materi
        $.getJSON('app-monitoring.php?action=getmateri&id='+id, function (catalog) {
            $("#table_materi").bootstrapTable({data: catalog});
        });
    });


    $('#btnRefreshHadir').click(function(){
        let id = $("#id_penyuluhan").val();
        $("#table_4").bootstrapTable('refreshOptions', {
            search : true,
            url: 'app-monitoring.php?action=getpeserta&id='+id
        });
    });
});
</script>