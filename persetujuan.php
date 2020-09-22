<?php
session_start();
$nip = $_SESSION['nip'];
$role = $_SESSION['role']; //1 eksten 2 umum 3 kakap
?>
<div class="row">
<div class="col">
<input type="hidden" id="id_penyuluhan">
<input type="hidden" id="txt-role" value="<?php echo $role; ?>"></input>
<input type="hidden" id="txt-nip" value="<?php echo $nip; ?>"></input>
<button type="button" class="btn btn-outline-primary btn-lg" id="btnRefresh">Refresh</button>
<div id="notif-persetujuan"></div>
<table  id="table_2" 
            data-search="true">
    <thead class="text-uppercase" style="background-color:#afafaf;">
        <tr>
            <th scope="col" data-field="no">No</th>
            <th scope="col" data-field="nama">Nama</th>
            <th scope="col" data-field="lokasi">Lokasi</th>
            <th scope="col" data-field="waktu">Tanggal/Waktu</th>
            <th scope="col" data-field="tema">Tanggal/Waktu</th>
            <th scope="col" data-field="target">Target</th>
            <th scope="col" data-field="peserta">Peserta</th>
            <th scope="col" data-width="120" data-field="status">Status</th>
            <th scope="col" data-width="120" data-field="action">Action</th>
        </tr>
    </thead>
</table>
<div id="modalFormPersetujuan" class="modal fade bd-example-modal-lg" data-backdrop="static">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Lihat / Ubah</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                <div class="form-group">
                    <label for="txt-nama" class="col-form-label">Nama Penyuluhan</label>
                    <input class="form-control" type="text" name="txt-nama" id="txt-nama" disabled required>
                </div>
                <div class="form-group">
                    <label for="date-waktu" class="col-form-label">Waktu Penyuluhan</label>
                    <input class="form-control" type="datetime-local" name="date-waktu" id="date-waktu" disabled required>
                </div>
                <div class="form-group">
                    <label for="txt-lokasi" class="col-form-label">Lokasi Penyuluhan</label>
                    <input class="form-control" type="text" name="txt-lokasi" id="txt-lokasi" disabled required>
                </div>
                <div class="form-group">
                    <label for="txt-tema" class="col-form-label">Tema Penyuluhan</label>
                    <input class="form-control" type="text" name="txt-tema" id="txt-tema" <?php if ($role != 1) {echo 'disabled';} else {'';}?> required>
                </div>
                <div class="form-group">
                    <label for="num-target" class="col-form-label">Target Penyuluhan</label>
                    <input class="form-control" type="number" name="num-target" id="num-target" <?php if ($role != 1) {echo 'disabled';} else {'';}?> required>
                </div>
                <div class="form-group">
                    <label for="num-anggaran" class="col-form-label">Anggaran Penyuluhan</label>
                    <input class="form-control" type="number" name="num-anggaran" id="num-anggaran" <?php if ($role != 2) {echo 'disabled';} else {'';}?> required>
                </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" id='btnFormTutup'>Tutup</button>
                    <button type="button" class="btn btn-primary" id="btnFormSimpan">Simpan</button>
                </div>
                
            </div>
        </div>
</div>
  <div id="modalSetujuTolak" class="modal fade bd-example-modal-lg" data-backdrop="static">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Setuju/Tolak</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                <p></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" id="btnDecTutup">Tutup</button>
                    <button type="button" class="btn btn-primary" id="btnDec">Setuju/Tolak</button>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<style>
#notif-persetujuan  {
    margin: 8px;
}
#notif-persetujuan .alert {
    font-size: 14px;
}
</style>
<script type="text/javascript">
$(function() {
    var role = $('#txt-role').val();
    $.getJSON('app-persetujuan.php?action=get&role='+role, function (catalog) {
        $("#table_2").bootstrapTable({data: catalog});
    });

    $('[data-toggle="tooltip"]').tooltip()   
});

$('#btnRefresh').click(function() {
    var role = $('#txt-role').val();
    $("#table_2").bootstrapTable('refreshOptions', {
        search: true,
        url: 'app-persetujuan.php?action=get&role='+role
      })
});
$('#modalFormPersetujuan').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var recipient = button.data('act') // Extract info from data-* attributes
  var modal = $(this)
  let id = button.data('id')
  if (recipient == 'update') {
    var role = $('#txt-role').val();
    $.getJSON('app-persetujuan.php?action=get&role='+role+'&id='+id, function (catalog) {
            //$("#table_1").bootstrapTable({data: catalog});
            modal.find('#txt-nama').val(catalog.nama)
            modal.find('#date-waktu').val(catalog.waktu)
            modal.find('#txt-lokasi').val(catalog.lokasi)
            modal.find('#txt-tema').val(catalog.tema)
            modal.find('#num-target').val(catalog.target)
            modal.find('#num-anggaran').val(catalog.anggaran)
            if (role == 3) {
                modal.find('#btnFormSimpan').hide();
            } else {
                modal.find('#btnFormSimpan').show();
            }
    })
    $('#btnFormSimpan').click(function(event) {
        event.preventDefault();
        let id = button.data('id')
        let tema = $('#txt-tema').val()
        let target = $('#num-target').val()
        let anggaran = $('#num-anggaran').val()

        $.post('app-persetujuan.php?action=update',
        {
            'id': id,
            'tema': tema,
            'target': target,
            'anggaran': anggaran
        },
        function(data, status) {
            if (data == 'sukses') {
                $("#notif-persetujuan").fadeIn(function(){
                    $(this).html('<div class="alert alert-success" role="alert">Rencana penyuluhan berhasil diubah</div>')
                    .fadeOut(5000, function() { $(this).html(''); }); // Removed the .hide()
                });
            } else {
                $("#notif-persetujuan").fadeIn(function(){
                    $(this).html('<div class="alert alert-danger" role="alert">Rencana penyuluhan gagal diubah <b>'+data+'</b></div>')
                    .fadeOut(5000, function() { $(this).html(''); }); // Removed the .hide()
                });
            }
            modal.modal('toggle');
            $('#btnRefresh').click();
        });
    });
  }
});

$('#modalSetujuTolak').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var recipient = button.data('act') // Extract info from data-* attributes
  var modal = $(this)
  $('#id_penyuluhan').val(button.data('id'));
  if (recipient == 'setuju') {
    modal.find('.modal-title').text('Persetujuan');
    modal.find('#btnDec').text('Setuju');
    let id = $('#id_penyuluhan').val();
    $.getJSON('app-perencanaan.php?action=getpenyuluhan&id='+id, function(response) {
        modal.find('.modal-body p').text('Apakah akan menyetujui rencana penyuluhan '+response.data.nama+' ?');
    })

    $('#btnDec').click(function(e) {
        e.preventDefault();
      var role = $('#txt-role').val();
      var nip = $('#txt-nip').val();
      var id = $('#id_penyuluhan').val();
      $.post('app-persetujuan.php?action=setuju',
          {
              'id': id,
              'nip': nip,
              'role': role
          },
          function(data, status) {
            if (data == 'sukses') {
                $("#notif-persetujuan").fadeIn(function(){
                    $(this).html('<div class="alert alert-success" role="alert">Rencana penyuluhan berhasil disetujui</div>')
                    .fadeOut(5000, function() { $(this).html(''); }); // Removed the .hide()
                });
            } else {
                $("#notif-persetujuan").fadeIn(function(){
                    $(this).html('<div class="alert alert-danger" role="alert">Rencana penyuluhan gagal disetujui <b>'+data+'</b></div>')
                    .fadeOut(5000, function() { $(this).html(''); }); // Removed the .hide()
                });
            }
              modal.modal('toggle');
              $('#btnRefresh').click();
      });
    });

  } else if (recipient == 'tolak') {
    modal.find('.modal-title').text('Penolakan');
    modal.find('#btnDec').text('Tolak');
    let id = $('#id_penyuluhan').val();
    $.getJSON('app-perencanaan.php?action=getpenyuluhan&id='+id, function(response) {
        modal.find('.modal-body p').text('Apakah akan menolak rencana penyuluhan '+response.data.nama+' ?');
    })

    $('#btnDec').click(function(e) {
        e.preventDefault();
      var role = $('#txt-role').val();
      var nip = $('#txt-nip').val();
      let id = $('#id_penyuluhan').val();
      $.post('app-persetujuan.php?action=tolak',
          {
              'id': id,
              'nip': nip,
              'role': role
          },
          function(data, status) {
            if (data == 'sukses') {
                $("#notif-persetujuan").fadeIn(function(){
                    $(this).html('<div class="alert alert-success" role="alert">Rencana penyuluhan berhasil ditolak</div>')
                    .fadeOut(5000, function() { $(this).html(''); }); // Removed the .hide()
                });
            } else {
                $("#notif-persetujuan").fadeIn(function(){
                    $(this).html('<div class="alert alert-danger" role="alert">Rencana penyuluhan gagal ditolak <b>'+data+'</b></div>')
                    .fadeOut(5000, function() { $(this).html(''); }); // Removed the .hide()
                });
            }
              modal.modal('toggle');
              $('#btnRefresh').click();
      });
    });
  }
});
</script>