jQuery(document).ready(function ($) {
    $('#file-upload').on('change', function () {
        var files = this.files;
        var formData = new FormData();

        $.each(files, function (key, file) {
            formData.append('file[]', file); // آپلود چندین فایل
        });

        $.ajax({
            url: ajaxurl + '?action=handle_upload',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            xhr: function () {
                var xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener('progress', function (e) {
                    if (e.lengthComputable) {
                        var percent = Math.round((e.loaded / e.total) * 100);
                        $('#upload-progress-bar').css('width', percent + '%');
                        $('#upload-progress-percent').text(percent + '%'); // نمایش درصد
                    }
                });
                return xhr;
            },
            success: function (response) {
                if (response.success) {
                    alert(response.data); // پیام موفقیت آمیز
                } else {
                    alert(response.data); // پیام خطا
                }
            },
            error: function () {
                alert('خطا در آپلود.');
            }
        });
    });
});
