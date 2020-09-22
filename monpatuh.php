<div class="row">
<div class="col">
<div id="main-patuh">
<input type="hidden" id="id_penyuluhan">
<input type="hidden" id="id_peserta">
<input type="hidden" id="npwp">
<table  id="table_monpeserta" 
            data-search="true"
            data-pagination="true">
    <thead class="text-uppercase" style="background-color:#afafaf;">
        <tr>
            <th scope="col" data-field="no">No</th>
            <th scope="col" data-field="npwp">NPWP</th>
            <th scope="col" data-field="nama">Nama</th>
            <th scope="col" data-field="jml">Jumlah Penyuluhan</th>
            <th scope="col" data-width="110" data-field="action">Action</th>
        </tr>
    </thead>
</table>
</div>
<div class="collapse" id="collapsePatuh">
<button type="button" class="btn btn-outline-primary btn-lg" id="btnX">Kembali</button>
<!-- nav tab start -->
<div class="d-flex flex-column" id="identitasWP">
    <div class="d-flex flex-row">
        <div class="p-2" style=" width:75px;">NPWP</div>
        <div class="p-2" style=" width:15px;">:</div>
        <div class="p-2" style=" width:200px;" id="tb-npwp"></div>
    </div>
    <div class="d-flex flex-row">
        <div class="p-2" style=" width:75px;">Nama</div>
        <div class="p-2" style=" width:15px;">:</div>
        <div class="p-2" style=" width:200px;" id="tb-nama"></div>
    </div>
    <div class="d-flex flex-row">
        <div class="p-2" style=" width:75px;">Alamat</div>
        <div class="p-2" style=" width:15px;">:</div>
        <div class="p-2" style=" width:200px;" id="tb-alamat"></div>
    </div>
</div>
<div class="mt-5">
    <div class="card">
        <div class="card-body">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link" id="pembayaran-tab" data-toggle="tab" href="#pembayaran" role="tab" aria-controls="pembayaran" aria-selected="false">Pembayaran</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="kepatuhan-tab" data-toggle="tab" href="#kepatuhan" role="tab" aria-controls="kepatuhan" aria-selected="false">Kepatuhan</a>
                </li>
            </ul>
            <div class="tab-content mt-3" id="myTabContent">
                <div class="tab-pane fade" id="pembayaran" role="tabpanel" aria-labelledby="pembayaran-tab">
                    <table  id="table_bayar" 
                            data-search="true">
                        <thead class="text-uppercase" style="background-color:#afafaf;">
                            <tr>
                                <th scope="col" data-field="no">No</th>
                                <th scope="col" data-field="kdmap">Kode MAP</th>
                                <th scope="col" data-field="kjs">Kode Setor</th>
                                <th scope="col" data-field="ptmspj">Masa Pajak</th>
                                <th scope="col" data-field="jumlah">Jumlah Bayar</th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <div class="tab-pane fade" id="kepatuhan" role="tabpanel" aria-labelledby="kepatuhan-tab">
                <table  id="table_spt" 
                            data-search="true">
                        <thead class="text-uppercase" style="background-color:#afafaf;">
                            <tr>
                                <th scope="col" data-field="no">No</th>
                                <th scope="col" data-field="masa">Masa Pajak SPT</th>
                                <th scope="col" data-field="status">Status SPT</th>
                                <th scope="col" data-field="jenis">Jenis SPT</th>
                                <th scope="col" data-field="pajak">Jenis Pajak</th>
                                <th scope="col" data-field="nilai">Nilai</th>
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
<script type="text/javascript">
$(function () {
    $.getJSON('app-monitoring.php?action=pesertaall', function(catalog) {
        $("#table_monpeserta").bootstrapTable({data : catalog});
    });

    $("#btnX").click(function(event) {
        event.preventDefault();
        document.getElementById("sidebar-monpatuh").click();
    })
    $("#collapsePatuh").on('show.bs.collapse', function(e) {
        $("#main-patuh").hide();
    });

    $("#collapsePatuh").on('shown.bs.collapse', function(e) {
        var a = $(e.target).data('bs.collapse');
        var npwp = a._config.npwp;
        $("#npwp").val(npwp);
        var collapse = $(this);
        $.post('app-monitoring.php?action=getwp',
        {
            'npwp':npwp
        },
        function(data, status) {
            collapse.find('#tb-npwp').text(data.data.npwp);
            collapse.find('#tb-nama').text(data.data.nama);
            collapse.find('#tb-alamat').text(data.data.alamat);
        },'json');

        $.post('app-monitoring.php?action=getbayar',
        {
            'npwp':npwp
        },
        function(data, status) {
            $("#table_bayar").bootstrapTable({data : data});
        },'json');

        $.post('app-monitoring.php?action=getspt',
        {
            'npwp':npwp
        },
        function(data, status) {
            $("#table_spt").bootstrapTable({data : data});
        },'json');
        
    });
})
</script>