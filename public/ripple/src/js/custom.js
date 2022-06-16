$(document).ready(function () {
    var Index = 0;
    if ($(".editor").length) {
        $('.editor').summernote({
            fontNames: ['Helvetica','Arial', 'Arial Black', 'Comic Sans MS', 'Courier New'],
            fontNamesIgnoreCheck: ['Helvetica']
        });
    }

    $('.delete-image').on('click',function () {
        let url = $(this).attr('data-val');
        if (confirm('Are you sure want to delete?')){
            window.location.href = url;
        }
        return false;
    });

    $(".saveImagePosition").click(function (e) {
        var positionArray = [];
        $(".image-position").each(function (k,i) {
            var position = parseInt($(i).val());

            if (positionArray.indexOf(position) == -1)
            {
                positionArray.push(position);
            }
            else{
                alert("Resimlerinizde " + position + " numaralı pozisyon zaten mevcut, aynı pozisyonda iki resim bulunamaz.");
                e.preventDefault();
            }
        });

        if (positionArray.indexOf(1) == -1)
        {
            alert("Resimlerinizin içerisinde pozisyonu 1 olan resim bulunması zorunludur, lütfen pozisyonlarınızı düzeltiniz.");
            e.preventDefault();
        }
    });

    $('.save-attraction-image-position').on('click',function (e) {
        e.preventDefault();
        let form =$(this).parents('form').serialize();
        let element = $(this);
        element.addClass('disabled').html('<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>');
        $.ajax({
            url : '/admin/attraction/image/set-image-position',
            type: 'POST',
            data : form,
            success : function(response){
                $.toast({
                    text: response.status,
                    icon: 'success',
                    allowToastClose: false,
                    heading: 'Success!',
                    position: 'top-right',
                    loader: true,
                    loaderBg: '#ed673c'
                })
            },
            error : function(response){
                $.toast({
                    text: response.status,
                    icon: 'warning',
                    allowToastClose: false,
                    heading: 'Error!',
                    position: 'top-right',
                    loader: true,
                    loaderBg: '#ed673c'
                })
            }
        }).done(function () {
            element.removeClass('disabled').html('Save Position');
        });
    });

    $(document).on("click", ".attraction-status-switch" ,function () {
        let input = $(this).parent('.custom-switch').find('input');
        let target = $(this).attr('data-target') == undefined ? 'status' :$(this).attr('data-target');
        let status = !input.is(':checked');
        let targetAttraction = input.attr('data-attraction');

        input.attr('disabled','disabled');
        $.ajax({
            url : '/admin/attraction/change'+target+'/'+targetAttraction,
            type: 'POST',
            data : {'status':status},
            beforeSend: function( xhr ) {
                xhr.overrideMimeType( "text/plain; charset=x-user-defined" );
            },
            success : function(response){
                $.toast({
                    text: response.status,
                    icon: 'success',
                    allowToastClose: false,
                    heading: 'Success!',
                    position: 'top-right',
                    loader: true,
                    loaderBg: '#ed673c'
                })
            },
            error : function(response){
                $.toast({
                    text: response.status,
                    icon: 'warning',
                    allowToastClose: false,
                    heading: 'Error!',
                    position: 'top-right',
                    loader: true,
                    loaderBg: '#ed673c'
                })
            }
        }).done(function () {
            input.removeAttr('disabled');
            input.attr('checked',status);
        });
    });

    $('.question-delete-category').on('click', function () {
        var dataTarget = $(this).attr('data-ajax-href');
        var data = $(this).attr('data-ajax-data');
        var element = $(this);
        var oldHtml = $(this).html();
        element.addClass('disabled').html('Loading');
        $.ajax({
            url : dataTarget,
            type: 'POST',
            data : data,
            success : function(response){
                $.toast({
                    text: response.message,
                    icon: 'success',
                    allowToastClose: false,
                    heading: 'Success!',
                    position: 'top-right',
                    loader: true,
                    loaderBg: '#ed673c'
                });
                element.parents('.question-group').remove();
            },
            error : function(response){
                $.toast({
                    text: response.message,
                    icon: 'warning',
                    allowToastClose: false,
                    heading: 'Error!',
                    position: 'top-right',
                    loader: true,
                    loaderBg: '#ed673c'
                })
            },
            complete: function () {
                element.removeClass('disabled').html(oldHtml);
            }
        })
    });

    $('.question-delete').on('click', function () {
        var dataTarget = $(this).attr('data-ajax-href');
        var data = $(this).attr('data-ajax-data');
        var element = $(this);
        var oldHtml = $(this).html();
        element.addClass('disabled').html('Loading');
        $.ajax({
            url : dataTarget,
            type: 'POST',
            data : data,
            success : function(response){
                $.toast({
                    text: response.message,
                    icon: 'success',
                    allowToastClose: false,
                    heading: 'Success!',
                    position: 'top-right',
                    loader: true,
                    loaderBg: '#ed673c'
                });
                element.parents('.question').remove();
            },
            error : function(response){
                $.toast({
                    text: response.message,
                    icon: 'warning',
                    allowToastClose: false,
                    heading: 'Error!',
                    position: 'top-right',
                    loader: true,
                    loaderBg: '#ed673c'
                })
            },
            complete: function () {
                element.removeClass('disabled').html(oldHtml);
            }
        })
    });
});