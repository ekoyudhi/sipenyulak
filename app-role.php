<?php
include "koneksi.php";

$action = $_GET['action'];
if ($action == 'get') {
    if (isset($_GET['user'])) {
        $user = $_POST['user'];
    } else {
        $sql = "SELECT * FROM vw_user_pegawai_role_lengkap";
        $res = $conn->query($sql);
        $item = array();
        $no=1;
        while($row = $res->fetch_object()) {
            $r = array( 'no' => $no,
                        'user' => $row->user,
                        'nama' => $row->nama,
                        'jabatan' => $row->nama_jabatan,
                        'role' => $row->role,
                        'ket' =>$row->ket,
                        'action' => '<ul class="d-flex justify-content-center">
                                        <li class="mr-3"><a href="#" class="text-secondary" data-toggle="modal" data-act="update" data-id="'.$row->user.'" data-role="'.$row->role.'" data-nip="'.$row->nip.'" data-target="#modalFormRole" data-toggle="tooltip" title="Ubah Role"><i class="fa fa-edit"></i></a></li>
                                    </ul>');
            array_push($item, $r);
            $no++;
        }
        header('Content-type:application/json');
        echo json_encode($item);
    }


} else if ($action == 'update') {
    $user = htmlspecialchars($_POST['user']);
    $role = htmlspecialchars($_POST['role']);
    $nip = htmlspecialchars($_POST['nip']);


    $sql = "UPDATE tb_role SET role='$role' WHERE nip='$nip'";
    $res = $conn->query($sql);
    if($res) {
        echo "sukses";
    } else {
        echo "Error tb_role";
    }
}
$conn->close();

?>