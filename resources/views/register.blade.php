<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>ثبت‌نام</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=vazirmatn:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Vazirmatn', sans-serif; }
        .auth-page {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 40%, #0f172a 100%);
            min-height: 100vh;
            position: relative;
            overflow: hidden;
        }
        .auth-page::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -30%;
            width: 80%;
            height: 80%;
            background: radial-gradient(ellipse, rgba(16, 185, 129, 0.15) 0%, transparent 70%);
            pointer-events: none;
        }
        .auth-page::after {
            content: '';
            position: absolute;
            bottom: -30%;
            left: -20%;
            width: 60%;
            height: 60%;
            background: radial-gradient(ellipse, rgba(59, 130, 246, 0.12) 0%, transparent 70%);
            pointer-events: none;
        }
        .auth-card {
            position: relative;
            z-index: 1;
            animation: cardIn 0.5s ease-out;
        }
        @keyframes cardIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .auth-input {
            transition: box-shadow 0.2s, background-color 0.2s;
        }
        .auth-input:focus {
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.25);
        }
        .auth-btn {
            background: linear-gradient(135deg, #059669 0%, #10b981 100%);
            transition: transform 0.15s, box-shadow 0.2s;
        }
        .auth-btn:hover {
            box-shadow: 0 10px 30px -10px rgba(16, 185, 129, 0.5);
            transform: translateY(-1px);
        }
        .auth-btn:active {
            transform: translateY(0);
        }
        .auth-link {
            transition: color 0.2s;
        }
        .auth-link:hover {
            color: #059669 !important;
        }
        .auth-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 56px;
            height: 56px;
            background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
            color: #059669;
            border-radius: 16px;
            font-size: 1.5rem;
        }
    </style>
</head>
<body class="auth-page flex items-center justify-center p-4 py-10">
    <div class="w-full max-w-[420px] auth-card">
        <div class="bg-white rounded-3xl shadow-2xl shadow-black/25 p-8 sm:p-10">
            <div class="text-center mb-8">
                <div class="auth-badge mx-auto mb-4">✨</div>
                <h1 class="text-2xl font-bold text-slate-800">ثبت‌نام</h1>
                <p class="text-slate-500 mt-2 text-sm">اطلاعات خود را برای ساخت حساب وارد کنید</p>
            </div>

            @if($errors->any())
                <div class="mb-6 p-4 rounded-xl bg-red-50 text-red-700 text-sm flex items-center gap-2" style="box-shadow: 0 0 0 2px rgba(239, 68, 68, 0.2);">
                    <span>⚠</span>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf
                <div>
                    <label for="name" class="block text-sm font-medium text-slate-700 mb-2">نام</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}"
                           placeholder="نام شما" required
                           class="auth-input w-full px-4 py-3.5 rounded-xl bg-slate-50 text-slate-800 placeholder-slate-400 outline-none"
                           style="box-shadow: 0 0 0 2px #e2e8f0;">
                </div>
                <div>
                    <label for="email" class="block text-sm font-medium text-slate-700 mb-2">ایمیل</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}"
                           placeholder="example@email.com" required
                           class="auth-input w-full px-4 py-3.5 rounded-xl bg-slate-50 text-slate-800 placeholder-slate-400 outline-none"
                           style="box-shadow: 0 0 0 2px #e2e8f0;">
                </div>
                <div>
                    <label for="password" class="block text-sm font-medium text-slate-700 mb-2">رمز عبور</label>
                    <input type="password" name="password" id="password" placeholder="••••••••" required
                           class="auth-input w-full px-4 py-3.5 rounded-xl bg-slate-50 text-slate-800 placeholder-slate-400 outline-none"
                           style="box-shadow: 0 0 0 2px #e2e8f0;">
                </div>
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-slate-700 mb-2">تکرار رمز عبور</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" placeholder="••••••••" required
                           class="auth-input w-full px-4 py-3.5 rounded-xl bg-slate-50 text-slate-800 placeholder-slate-400 outline-none"
                           style="box-shadow: 0 0 0 2px #e2e8f0;">
                </div>
                <button type="submit"
                        class="auth-btn w-full py-4 rounded-xl font-semibold text-white mt-1">
                    ثبت‌نام
                </button>
            </form>

            <p class="mt-7 text-center text-slate-500 text-sm">
                قبلاً ثبت‌نام کرده‌اید؟
                <a href="{{ route('login') }}" class="auth-link font-medium text-slate-700">ورود</a>
            </p>
        </div>
    </div>
</body>
</html>
