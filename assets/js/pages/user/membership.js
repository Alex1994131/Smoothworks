$(document).ready(function() {
    $("[id^='price_kind_']").on('change', function() {
        var id = $(this).attr('id');
        var membership_id = id.split('_')[2];

        var type = $(this).val();

        if(type == 1) {
            var price = $("#monthly_price_"+membership_id).val();
        }
        else if(type == 2) {
            var price = $("#quarterly_price_"+membership_id).val();
        }
        else if(type == 3) {
            var price = $("#yearly_price_"+membership_id).val();
        }
        else {
            return;
        }

        price = parseFloat(price);
        var main_price = Math.floor(price);
        var decimal_price = price - main_price;
        decimal_price = decimal_price.toFixed(2);
        decimal_price = decimal_price.split('.')[1];
        decimal_price = '.' + decimal_price;
        $("#main_price_" + membership_id).text(main_price);
        $("#decimal_price_" +membership_id).text(decimal_price);
        $("#price_value_" + membership_id).val(price);
    })
})

function membership_up_downgrade(membership_id, membership_title, membership_level, account_type) {

    var price = $("#price_value_" + membership_id).val();
    var membership_type = $("#price_kind_" +membership_id).val();
    var my_balance = $("#my_balance").val();
    var margin_price = $("#margin_price").val();

    my_balance = parseFloat(my_balance);
    price = parseFloat(price);
    margin_price = parseFloat(margin_price);

    price = price - margin_price;

    if(my_balance >= price) {
        
        swal({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ok!',
            confirmButtonClass: 'btn btn-primary',
            cancelButtonClass: 'btn btn-danger ml-1',
            buttonsStyling: false,
        }).then(function (result) {
            if (result.value) {
                $.ajax({
                    url: base_url + 'user/membership/up_downgrade_membership',
                    type: 'post',
                    data: {
                        membership_id: membership_id,
                        membership_type: membership_type,
                        membership_level: membership_level,
                        price: price,
                        account_type: account_type
                    },
                    success: function(message) {
                        if(message == 'success') {
                            document.location.href = base_url+ 'membership';
                        }
                    }
                })
            }
        })
    }
    else {
        $("#membership_id").val(membership_id);
        $("#membership_title").text(membership_title);
        $("#membership_level").val(membership_level);
        $("#membership_price_text").text(price + '$');
        $("#membership_price").val(price);
        $("#membership_type").val(membership_type);

        if(membership_type == 1) {
            $("#membership_type_text").text('Monthly Membership');
        }
        else if(membership_type == 2){
            $("#membership_type_text").text('Quarterly Membership');
        }
        else {
            $("#membership_type_text").text('Annually Membership');
        }

        $("#account_type").val(account_type);
        $("#checkout-popup").modal();
    }
}

function check_payment_type(e) {
    $('#payment_btn').show();
}