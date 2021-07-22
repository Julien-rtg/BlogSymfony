// DOUBLE CONFIRMATION WHEN DELETING A PRODUCT
$('.deleteButton').on('click', function() {

    event.preventDefault();

    const form = $(this).parents('form');

    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.isConfirmed) {

            setTimeout( function () { 
                form.submit();
            }, 1200);

            Swal.fire(
            'Deleted!',
            '',
            'success'
            )

        }

    })
    
});

// LOAD IMAGE BEFORE SUBMIT FORM
function readURL(input) {

    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('.imgLoad').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}

$(".custom-file-input").change(function(){
    readURL(this);
});
