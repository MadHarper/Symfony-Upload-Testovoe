require ('fancybox')($);

$(document).ready(function(){

    $("a.photo").click(function(e){
        e.preventDefault();
        $.fancybox.open($("a.photo"));
    })

    $("a.delete-image").click(function(e){
            e.preventDefault();
            var url = $(this).data('url');
            var image_id = $(this).data('image-id');

            $.ajax({
                url: url,
                type: 'get',
                success: function(data) {
                    if(data.success == 1){
                        $("#image_box_" + image_id).remove();
                    }
                }
            });
        }
    )

});