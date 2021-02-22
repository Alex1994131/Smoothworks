function project_preview_bid() {
    var error = 0;

    if ($('#bid_proposal').val()=="") {
        error = 1;
        $('.bid_proposal_error').show();
    } else {
        $('.bid_proposal_error').hide();
    }

    if($('#bid_amount').val()=="")
    {
        error = 1;
        $('.bid_amount_error').show();
    }
    else
    {
        $('.bid_amount_error').hide();
    }
    if($('#delivery_day').val()=="")
    {
        error = 1;
        $('.delivery_day_error').show();
    }
    else
    {
        $('.delivery_day_error').hide();
    }

    if (error == 0) {
        $('#bid').submit();

    } else {
        return false;
    }
}

function checkinput(e) {
    var days = $(e).val();
    days = days.replace(/[^0-9]/g, '');
    $(e).val(days);
}
