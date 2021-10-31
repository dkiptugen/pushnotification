$(document).ready(function(){
    $(document).on('click','.chact',function(s){
        s.preventDefault();
        var link    =   $(this).attr('href');
        var data    =   $(this).data('data');
        $.ajax({
            url: link,
            type: 'DELETE',
            data:data ,
            success: function(Mess) {
                if (Mess.status == true) {

                    toastr.success(Mess.msg, Mess.header, {
                        timeOut: 1000,
                        closeButton: true,
                        progressBar: true,
                        newestOnTop: true,
                        onHidden: function () {
                            window.location = Mess.url;
                        }
                    });


                } else {
                    toastr.error(Mess.msg, Mess.header, {
                        timeOut: 1000,
                        closeButton: true,
                        progressBar: true,
                        newestOnTop: true,
                        onHidden: function () {

                            window.location = Mess.url;
                        }
                    });
                }
            },
            error: function(request,msg,error) {

                toastr.error(error, 'error', {
                    timeOut: 1000,
                    closeButton: true,
                    progressBar: true,
                    newestOnTop: true,
                    onHidden: function () {
                        window.location.reload();
                    }
                });
            }
        });

    });
    if($('.editor').length)
        {
            $('.editor').summernote({
                height:150,
                tabsize: 2,
                lineHeight:1.5,
                dialogsInBody: true,
                dialogsFade: false,
                toolbar: [
                    // [groupName, [list of button]]
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough', 'superscript', 'subscript','fontname']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph','style']],
                    ['height', ['height']],
                    ['insert',['picture','link','video','table','hr']],
                    ['misc',['codeview','undo','redo']]
                ],
                callbacks : {
                    onImageUpload: function(image) {

                        uploadImage(image[0],$(this));

                    }
                }

            }).on('summernote.change', function (we, contents, $editable) {
                $(this).val(contents);
            });
        }
    function uploadImage(image,$summernote)
        {
            var dat = new FormData();
            dat.append("image",image);
            var IMAGE_PATH = 'https://alert.boxraft.net/uploads';
            $.ajax ({
                data: dat,
                type: "POST",
                url:  'https://alert.boxraft.net/image_upload',
                headers: {"X-CSRF-TOKEN":$('meta[name="csrf-token"]').attr('content')},
                cache: false,
                contentType: false,
                processData: false,
                success: function(url) {
                    var image = IMAGE_PATH+$.trim(url);
                    $summernote.summernote("insertImage", image,function ($image) {
                        $image.attr('class', 'image-fluid');
                    });
                },
                error: function(e) {
                    toastr.error(e, 'upload', {
                        timeOut: 1000,
                        closeButton: true,
                        progressBar: true,
                        newestOnTop: true

                    });
                }
            });
        }
    $(document).on('submit','.create-form',function(e){
        e.preventDefault();
        var frm         = $(this);
        var formData    = new FormData(frm[0]);
        $.ajax({
            type:'POST',
            url:frm.attr('action'),
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data:formData,
            processData: false,
            contentType: false,
            success:function(Mess){
                if(Mess.status === true)
                    {

                        toastr.success( Mess.msg,Mess.header, {timeOut: 1000, closeButton:true, progressBar:true, newestOnTop:true, onHidden: function () {

                                window.location= Mess.url;
                            }});


                    }
                else
                    {
                        toastr.error( Mess.msg,Mess.header, {timeOut: 1000, closeButton:true, progressBar:true, newestOnTop:true, onHidden: function () {

                                window.location= Mess.url;
                            }});
                    }
            },
            error:function (xhr, status, errorThrown) {

                toastr.error(errorThrown, xhr.responseText, {timeOut: 1000, closeButton:true, progressBar:true, newestOnTop:true,onHidden: function () {
                        window.location.reload();
                    }});



            }
        });

    });
    $('.message').keydown(function(e){
        //e.preventDefault();
        var len =   $(this).val().length;
        //console.log(len);

        if (e.which == 8)
            {
                text = $(this).val().substring(0, len-1);
                $(this).val(text);
                $(this).removeAttr('readonly');
            }
        if(len < 160)
            {
                $('.msg-error').html((160-len)+" Charaters remaining");
            }
        else
            {
                $(this).attr('readonly','true');
            }

    });


});
document.addEventListener("DOMContentLoaded", function(event) {
    // Select2
    $('.select2').each(function() {
        $(this)
            .wrap('<div class="position-relative"></div>')
            .select2({
                placeholder: 'Select value',
                dropdownParent: $(this).parent()
            });
    })
    // Daterangepicker
    $('input[name="daterange"]').daterangepicker({
        opens: 'left',
        startDate: moment().startOf('hour'),
        endDate: moment().startOf('hour').add(32, 'hour')
    });
    $('.datetime').daterangepicker({
        timePicker: true,
        opens: 'left',
        singleDatePicker: true,
        showDropdowns: true,
        startDate: moment(),
        locale: {
            format: 'YYYY-MM-DD hh:mm A'
        }
    });
    $('.date').daterangepicker({
        opens: 'left',
        singleDatePicker: true,
        showDropdowns: true,
        startDate: moment().startOf('hour')
    });
    $('.dt').datetimepicker({
        autoSize: true,
        changeYear: true,
        changeMonth: true,
        buttonImageOnly: true,

    });
    $('.time').datetimepicker({
        format:'LT'
    });
    var start = moment().subtract(29, 'days');
    var end = moment();

    function cb(start, end) {
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
    }
    $('#reportrange').daterangepicker({
        startDate: start,
        endDate: end,
        ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    }, cb);
    cb(start, end);
});
