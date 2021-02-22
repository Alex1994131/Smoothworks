function delete_gigs(gigs_id) {
    swal({
        text: "Are you sure you want to award this Proposal?",
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
                url: base_url + 'user/gigs/delete_gigs',
                type: 'post',
                data: {
                    gigs_id: gigs_id
                },
                success: function(response) {
                    if(response == 'success') {
                        location.reload();
                    }
                    else {
                        document.location.href = base_url + '/';
                    }
                }
            })
        }
    })
}

$(document).ready(function() {
    
})