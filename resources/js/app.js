require('./bootstrap');

require('bootstrap');


$(".btn-send").on("click", function(){
    let id = $(this).data("id");
    $("#senderWalletId").val(id);
    $("#modalSend").modal("show");
}); 

$(".btn-generate").on("click", function(){
    let id = $(this).data("id");
    $("#wallet_id").val(id);
    $("#modalGenerate").modal("show");
}); 