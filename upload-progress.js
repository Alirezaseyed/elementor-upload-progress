jQuery(document).ready(function($) {
    $('form').on('change', 'input[type="file"]', function(e) {
        var fileInput = $(this);
        var files = fileInput[0].files;
        var formData = new FormData();

        $.each(files, function(i, file) {
            formData.append('file-' + i, file);
        });

        $.ajax({
            url: '/wp-admin/admin-ajax.php', // آدرس پیش‌فرض AJAX وردپرس
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            xhr: function() {
                var xhr = new window.XMLHttpRequest();

                xhr.upload.addEventListener('progress', function(e) {
                    if (e.lengthComputable) {
                        var percentComplete = e.loaded / e.total;
                        percentComplete = parseInt(percentComplete * 100);

                        $('#upload-progress-bar').width(percentComplete + '%');
                        $('#upload-progress-text').text(percentComplete + '%');

                        if (percentComplete === 100) {
                            $('#upload-progress-text').text('Upload complete');
                        }
                    }
                }, false);

                return xhr;
            },
            success: function(response) {
                console.log('File uploaded successfully');
            }
        });
    });
});
