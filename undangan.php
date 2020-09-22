<div class="row">
<div class="col">
<input type="hidden" id="id_penyuluhan">
<button type="button" class="btn btn-outline-primary btn-lg" id="btnUndRefresh">Refresh</button>
<table  id="table_und" 
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
</div>
<script type="text/javascript">
$(function() {
    $.getJSON('app-undangan.php?action=get', function(catalog) {
        $('#table_und').bootstrapTable({data: catalog});
    });

    $('#btnUndRefresh').click(function() {
        $('#table_und').bootstrapTable('refreshOptions', {
            search:true,
            url:'app-undangan.php?action=get'
        });
    });
});
</script>