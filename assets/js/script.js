$(document).ready(function() {
    $('#shortenForm').submit(function(e) {
        e.preventDefault();
        const originalUrl = $('#originalUrl').val();
        
        $.post('api.php', { url: originalUrl }, function(response) {
            if(response.success) {
                $('#shortLink').attr('href', response.short_url).text(response.short_url);
                $('#qrcode').attr('src', 'https://api.pwmqr.com/qrcode/create/?url=' + encodeURIComponent(response.short_url));
                $('#result').removeClass('d-none');
            } else {
                alert('生成失败：' + response.error);
            }
        });
    });
});
