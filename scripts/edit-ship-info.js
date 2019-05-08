function readURL(input) {

    if (input.files) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#img-preview').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}

$("#ship-image").change(function () {
    readURL(this);
});