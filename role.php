<div class="row">
<div class="col">
<div id="main-patuh">
<input type="hidden" id="user">
<input type="hidden" id="nip">
<input type="hidden" id="role">
<div id="notif-role"></div>
<table  id="table_role" 
            data-search="true"
            data-pagination="true">
    <thead class="text-uppercase" style="background-color:#afafaf;">
        <tr>
            <th scope="col" data-field="no">No</th>
            <th scope="col" data-field="user">Username</th>
            <th scope="col" data-field="nama">Nama</th>
            <th scope="col" data-field="jabatan">Jabatan</th>
            <th scope="col" data-field="ket">Role</th>
            <th scope="col" data-width="110" data-field="action">Action</th>
        </tr>
    </thead>
</table>
<div id="modalFormRole" class="modal fade bd-example-modal-lg" data-backdrop="static">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ubah Role</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
            <div class="form-group">
                    <label for="txt-user" class="col-form-label">Username</label>
                    <input class="form-control" type="text" name="txt-user" id="txt-user" disabled required>
                </div>
                <div class="form-group">
                    <label for="txt-role">Role</label>
                    <select class="form-control" id="txt-role" name="txt-role" style="height:40px;">
                        <option value="9">Admin Penyuluhan</option>
                        <option value="1">Kepala Seksi EP</option>
                        <option value="2">Kepala Subbagian Umum</option>
                        <option value="3">Kepala Kantor</option>
                        <option value="4">Petugas Penyuluhan</option>
                        <option value="5">Tanpa Role</option>
                        <option value="8">Super Administrator</option>
                    </select>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" >Tutup</button>
                <button type="button" class="btn btn-primary" id="btnRoleSimpan">Simpan</button>
            </div>
        </div>
    </div>
</div>
</div>
</div>
<script type="text/javascript">
$(function() {
    $.getJSON('app-role.php?action=get', function(catalog){
        $("#table_role").bootstrapTable({data:catalog});
    });

    function reloadTable() {
        $("#table_role").bootstrapTable('refreshOptions', {
            search: true,
            url: 'app-role.php?action=get'
        })
    }

    $("#modalFormRole").on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var recipient = button.data('act') // Extract info from data-* attributes
        var modal = $(this)
        $("#user").val(button.data('id'));
        $("#role").val(button.data('role'));
        $("#nip").val(button.data('nip'));
        if (recipient == 'update') {
            $("#txt-user").val($("#user").val());
            $("#txt-role").val($("#role").val());
            $("#btnRoleSimpan").click(function(event) {
                event.preventDefault();
                let user = $("#user").val();
                let nip = $("#nip").val();
                let role = $('#role').val(); //$("#txt-role option:selected").val()
                modal.find('#txt-user').val(user)
                event.preventDefault();
                
                $.post('app-role.php?action=update',
                {
                    'user' : user,
                    'nip' : nip,
                    'role' : role
                },
                function(data, status) {
                    if (data == 'sukses') {
                        $("#notif-role").fadeIn(function(){
                            $(this).html('<div class="alert alert-success" role="alert">Role berhasil diubah</div>')
                            .fadeOut(2000, function() { $(this).html(''); }); // Removed the .hide()
                        });
                    } else {
                        $("#notif-role").fadeIn(function(){
                            $(this).html('<div class="alert alert-danger" role="alert">Role gagal diubah <b>'+data+'</b></div>')
                            .fadeOut(2000, function() { $(this).html(''); }); // Removed the .hide()
                        });
                    }
                    modal.modal('toggle');
                    reloadTable();
                })

            })
        }
    });

    $("#txt-role").change(function(){
        var role = $("#txt-role option:selected").val()
        $('#role').val(role);
    });
});
</script>