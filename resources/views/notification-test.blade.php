<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8"/>
    <title>چت سازمانی یدک شاپ</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 flex items-center justify-center">

<h1>تست نوتیفیکیشن</h1>

<button id="sendBtn">ارسال نوتیف</button>

<script>
    document.addEventListener('DOMContentLoaded', function () {

        // درخواست اجازه نوتیفیکیشن
        if (Notification.permission !== 'granted') {
            Notification.requestPermission().then(permission => {
                console.log('Notification permission:', permission);
            });
        }
        Echo.channel('notifications')
            .listen('.new.notification', (e) => {
                console.log(e.message);
            });
        window.Echo.channel('notifications')
            .listen('.new.notification', (e) => {

                console.log('نوتیف جدید:', e.message);

                // نمایش نوتیفیکیشن کروم
                if (Notification.permission === 'granted') {
                    new Notification('📩 پیام جدید', {
                        body: e.message,
                        icon: '/icon.png' // اختیاری
                    });
                }

            });

    });
</script>

</body>
</html>
