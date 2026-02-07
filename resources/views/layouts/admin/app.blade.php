<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8"/>
    <title>چت سازمانی یدک شاپ</title>
    <link rel="icon" type="image/png" href="/favicon.png" />
@if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
                @vite(['resources/css/app.css', 'resources/js/app.js'])
            @endif
{{--        <script src="https://cdn.tailwindcss.com"></script>--}}
    {{--    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>--}}
    <title>{{ $title ?? 'Page Title' }}</title>
    <livewire:styles />
</head>

<body class="bg-gray-100 flex items-center justify-center">
<livewire:scripts />
{{$slot}}
</body>
</html>
