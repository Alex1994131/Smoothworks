$(document).ready(function() {

    $('#memberships').select2({
        dropdownAutoWidth: true,
        width: '100%'
    });

    $("#multi_deletes_form").submit(function (event) {
        var multi_Delete = $('#multi_Delete').val();
        if (multi_Delete == '') {
            alert('Please choose anyone category');
            return false;
        } else {
            $("#multi_deletes_form").submit();
        }
    });

    $("#ckbCheckAll").click(function () {
        $(".checkBoxClass").prop('checked', $(this).prop('checked'));
        var checkboxValues = [];
        $('.checkBoxClass:checked').each(function (index, elem) {
            checkboxValues.push($(elem).val());
        });
        $('#multi_Delete').val(checkboxValues.join(','));
    });

    $(".checkBoxClass").change(function () {
        if (!$(this).prop("checked")) {
            $("#ckbCheckAll").prop("checked", false);
        }

        var checkboxValues = [];
        $('.checkBoxClass:checked').each(function (index, elem) {
            checkboxValues.push($(elem).val());
        });
        $('#multi_Delete').val(checkboxValues.join(','));
    });
});