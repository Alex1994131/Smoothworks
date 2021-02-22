function upload_product() {
    $('#product_upload').click();
}

$(document).on('change', '#product_upload', function (e) {

    var max_size = parseInt(Math.ceil(this.files[0].size / 1024 / 1024));

    if (max_size <= 5) {

        var error = 0
        var filename = $('#product_upload').val();

        var allowedExtensions = /(\.zip)$/i;

        if (!allowedExtensions.exec(filename)) {
            alert('Please upload file having extensions .zip only.');
            $('#product_upload').val('')
            return false;
        } else {

            if (error == 0) {
                $('#product_upload_form').submit();
            } else {
                return false;
            }
        }
    } else {

        alert('Maximum upload files size less than or equal to 5 MB');
        $('#product_upload').val('')
        return false;
    }
});

function remove_details(e) {

    bootbox.confirm({
        title: "Remove",
        message: "Are you sure you want to remove this ?",
        buttons: {
            cancel: {
                label: '<i class="fa fa-times"></i> Cancel'
            },
            confirm: {
                label: '<i class="fa fa-check"></i> Confirm'
            }
        },
        callback: function (result) {
            if (result == true) {
                window.location.href = $(e).data('url');
            }
        }
    });
}   

var Transactions = function() {
    return {
        init: function() {
            var all_transaction_table;

            var params = {
                from_date: '',
                to_date: '',
                status: '',
                currency: ''
            };
    
            $('#from_date').datepicker({
                format: "dd-mm-yyyy",
                endDate: "d",
                clearBtn: true,
                autoclose: true,
                todayHighlight: true
            });

            $('#to_date').datepicker({
                format: "dd-mm-yyyy",
                endDate: "d",
                clearBtn: true,
                autoclose: true,
                todayHighlight: true
            });

            $("#search_btn").on('click', function() {
                params.from_date = $("#from_date").val();
                params.to_date = $("#to_date").val();
                params.status = $("#transaction_status").val();
                params.currency = $("#currency_type").val();

                console.log(params);

                all_transaction_table.ajax.reload();
            });

            $("#reset_btn").on('click', function() {

                $("#from_date").val('');
                $("#to_date").val('');
                $("transaction_status").val('');
                $("#currency_type").val('');

                params.from_date = '';
                params.to_date = '';
                params.status = '';
                params.currency = '';

                all_transaction_table.ajax.reload();
            })

            all_transaction_table = $("#all_transactions").DataTable({
                order: [[ 1, "desc" ]],
                //responsive: true,
                processing: true,
                fnRowCallback: function( nRow, aData, iDisplayIndex ) {
                    var index = iDisplayIndex +1;
                    $('td:eq(0)',nRow).html(index);
                },
                columnDefs: [{
                    "orderable": false,
                    "render": function(data, type, row, rowIndex) {
                        if(row.remark == 'membership') {
                            return "<span>"+ row.fullname +" 's membership purchace</span>";
                        }
                        // else if(row.remark == 'gigs') {
                        //     return "<span>"+ row.fullname +" 's gigs purchace</span>"
                        // }
                        else if(row.remark == 'created_milestone') {
                            return "<span>"+ row.fullname +" 's create milestone( project: "+ title +")</span>";
                        }
                        else if(row.remark == 'release_milestone') {
                            return "<span>"+ row.fullname +" 's release milestone( project: "+ title +")</span>";
                        }
                        else if(row.remark == 'withdraw') {
                            return "<span>"+ row.fullname +" 's balance withdraw</span>";
                        }
                        else if(row.remark == 'deposit') {
                            return "<span>"+ row.fullname +" 's balance deposit</span>";
                        }
                    },
                    'className': 'justify-content-center',
                    "targets": 2
                }, {
                    "orderable": false,
                    "render": function(data, type, row, rowIndex) {
                        if(row.status == 0) {
                            return "<span>Order Failure</span>";
                        }
                        else if(row.status == 1) {
                            return "<span>Pending</span>";
                        }
                        else if(row.status == 3) {
                            return "<span>Completed</span>";
                        }
                        else if(row.status == -1) {
                            return "<span>Cancel</span>";
                        }
                        else if(row.status == -2) {
                            return "<span>Decline</span>";
                        }
                    },
                    'className': 'justify-content-center',
                    "targets": -1
                }],
                ajax: {
                    url: base_url + "user/transactions/all_transaction_data",
                    type: 'POST',
                    data: function(d) {
                        d.from_date = params.from_date,
                        d.to_date = params.to_date,
                        d.status = params.status,
                        d.currency = params.currency
                    }
                },
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'created_date', name: 'created_date'},
                    {data: 'user_id', name: 'user_id'},
                    {data: 'currency', name: 'currency'},
                    {data: 'price', name: 'price'},
                    {data: 'pay_method', name: 'pay_method'},
                    {data: 'status', name: 'status'}
                ]
            });
        }
    }
}();

$(document).ready(function () {
    Transactions.init();
});