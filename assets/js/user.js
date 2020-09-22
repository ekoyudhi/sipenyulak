$(document).ready(function(){
    $("#sidebar-perencanaan").click(function(){
        $("#title-page").text("Perencanaan Penyuluhan");
        $("#main-content").load("perencanaan.php");
    });
    $("#sidebar-setuju").click(function(){
        $("#title-page").text("Persetujuan Penyuluhan");
        $("#main-content").load("persetujuan.php");
    });
    $("#sidebar-pelaksanaan").click(function(){
        $("#title-page").text("Pelaksanaan Penyuluhan");
        $("#main-content").load("pelaksanaan.php");
    });
    $("#sidebar-laporan").click(function(){
        $("#title-page").text("Laporan Penyuluhan");
        $("#main-content").load("laporan.php");
    });
    $("#sidebar-setujulap").click(function(){
        $("#title-page").text("Persetujuan Laporan Penyuluhan");
        $("#main-content").load("setujulap.php");
    });
    $("#sidebar-monpenyul").click(function(){
        $("#title-page").text("Monitoring Penyuluhan");
        $("#main-content").load("monpenyul.php");
    });
    $("#sidebar-monpatuh").click(function(){
        $("#title-page").text("Monitoring Kepatuhan dan Pembayaran");
        $("#main-content").load("monpatuh.php");
    });
    $("#sidebar-undangan").click(function(){
        $("#title-page").text("Undangan Peserta Penyuluhan");
        $("#main-content").load("undangan.php");
    });

    $("#sidebar-role").click(function(){
        $("#title-page").text("Pengaturan Role");
        $("#main-content").load("role.php");
    });

    $.getJSON('app-dashboard.php?action=gettimeline', function(response) {
        var data = response.data;
        var txt = "";
        data.forEach(function(item) {
            txt +=item;
        })
        $("#timeline").html(txt);
    });

    $.getJSON('app-dashboard.php?action=getstatus', function(response) {
        var data = response.data;
        $("#pending_setuju").text(data.pending_setuju);
        $("#setuju").text(data.setuju);
        $("#pending_laporan").text(data.pending_laporan);
        $("#selesai").text(data.selesai);
    });



});
