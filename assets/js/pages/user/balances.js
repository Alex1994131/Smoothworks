function check_withdraw_type(e) {
    $('#withdraw_submit_btn').show();
}

function check_deposit_type(e) {
    $('#deposit_submit_btn').show();
}

$(document).ready(function () {
    // $("#deposit_btn").on('click', function(e) {
    //     $("#deposit-popup").modal();
    // })
    
    $("#withdraw_btn").on('click', function() {
        var balances = $("#my_balances").val();
        $("#real_balances").val(balances);
        $("#balances_title").text(balances + 'USD');

        $("#withdraw-popup").modal();
    })

    var balances_dataTable = $("#my_balances_table").DataTable({
        order: [[ 1, "desc" ]],
        responsive: true,
        processing: true,
        fnRowCallback: function( nRow, aData, iDisplayIndex ) {
            var index = iDisplayIndex +1;
            $('td:eq(0)',nRow).html(index);
        },
        ajax: {
            url: base_url + "user/balances/my_balances_data",
            type: 'POST',
            dataType: 'json',
            data: {
                flag: 'ok'
            }
        },
        columns: [
            {data: 'id', name: 'id'},
            {data: 'currency_type', name: 'currency_type'},
            {data: 'amount', name: 'amount'}
        ]
    });
});