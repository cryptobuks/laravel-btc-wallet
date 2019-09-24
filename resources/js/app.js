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

$("#btc").on("change", function(){
    $.get("/system/getprice/tbtc", function(result){
        let entry = parseFloat($("#btc").val());
        let price = result.price;
        $("#usd").val((entry * price).toFixed(2));
    });
});

$(".btn-create-transaction").on("click", function(){
    let btc = parseFloat($("#btc").val());
    let destination = $("#destination").val();
    let numblocks = $("#numblocks").val();
    let walletId = $("#senderWalletId").val();

    $.ajax({
        url: '/wallet/send',
        type: 'POST',
        data: { 
            'amount': btc,
            'destination' : destination,
            'numblocks': numblocks,
            'identifier' : walletId
        },
        datatype: 'application/json',
        success: function (data) { 
            $("#success").html(data.result);
            setTimeout(function(){
                window.location.href='/wallet/transactions/' + walletId;
            }, 2000);
         },
        error: function (jqXHR, textStatus, errorThrown) { 
            let result = JSON.parse(jqXHR.responseText);
            let text = result.errors.join();
            $("#errors").html(text);
        }
    });


});