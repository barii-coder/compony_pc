<div wire:poll.3s>
    <style>
        .dash-header {
            background: linear-gradient(135deg, #00f 0%, #000 100%);
            color: #fff;
            padding: 0.65rem 0.75rem;
            font-weight: 700;
            text-align: center;
            font-size: 0.9rem;
            margin-bottom: 10px;
            border-radius: 1rem 1rem 0 0;
        }
    </style>
    <a class="block absolute" href="/">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M19 12H5" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
            <path d="M12 19L5 12L12 5" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                  stroke-linejoin="round"/>
        </svg>
    </a>
    <div class="h-screen p-4 bg-gray-100 flex w-[1920px]">
        <div class="w-full h-full max-w-[400px] overflow-y-auto bg-white rounded-2xl relative">
            <div class="dash-header sticky top-0 z-10">دایره ها</div>

            <!-- Lightbox -->
{{--            <div id="lightbox" class="fixed inset-0 bg-black bg-opacity-70 hidden items-center justify-center z-50">--}}
{{--                <span id="lightbox-close"--}}
{{--                      class="absolute top-4 right-6 text-white text-3xl cursor-pointer">&times;</span>--}}
{{--                <img id="lightbox-img" class="max-h-[80%] max-w-[80%] rounded" src="" alt=""/>--}}
{{--            </div>--}}

            <!-- پیام‌ها -->
            <div class="space-y-4 p-4">
                <!-- جداکننده تاریخ -->
                {{--                <div class="flex justify-center">--}}
                {{--                    <div class="bg-gray-200 text-gray-600 text-xs px-4 py-1 rounded-full shadow-sm">--}}
                {{--                        شنبه 25 بهمن--}}
                {{--                    </div>--}}
                {{--                </div>--}}

                <!-- پیام گروهی -->

                @foreach($circleMesages as $circleMesage)
                    @php
                        $code = $circleMesage->code;
                        $code = explode(':', $code)
                    @endphp
                    <div class="bg-gray-100 rounded-lg p-3 space-y-2">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="inline-block text-s">
                                    {{$code[0]}}
                                </p>
{{--                                <span class="text-sm text-gray-500 ml-1">: 2000</span>--}}
                            </div>
{{--                            <div class="flex gap-2">--}}
{{--                                <button onclick="copyText(this)" class="p-1 rounded hover:bg-green-200">کپی</button>--}}
{{--                            </div>--}}
                        </div>
                    </div>
                @endforeach

                <!-- پیام تکی -->
                {{--                <div class="bg-blue-100 rounded-lg p-3 flex justify-between items-center">--}}
                {{--                    <div>--}}
                {{--                        <p class="inline-block font-semibold">کد9999</p>--}}
                {{--                        <span class="text-sm text-gray-500 ml-1">: 5000</span>--}}
                {{--                    </div>--}}
                {{--                    <div class="flex gap-2">--}}
                {{--                        <button onclick="copyText(this)" class="p-1 rounded hover:bg-green-200">کپی</button>--}}
                {{--                        <img src="https://via.placeholder.com/40" class="w-10 h-10 rounded cursor-pointer" onclick="showLightbox(this)" alt="">--}}
                {{--                    </div>--}}
                {{--                </div>--}}

                <!-- پیام با تصویر فقط -->
                {{--                <div class="bg-gray-100 rounded-lg p-3 flex justify-start items-center gap-2">--}}
                {{--                    <img src="https://via.placeholder.com/80" class="w-20 h-20 rounded cursor-pointer" onclick="showLightbox(this)" alt="">--}}
                {{--                    <div>--}}
                {{--                        <p class="font-semibold">کد2023</p>--}}
                {{--                        <span class="text-sm text-gray-500 ml-1">: 3000</span>--}}
                {{--                    </div>--}}
                {{--                    <button onclick="copyText(this)" class="p-1 rounded hover:bg-green-200">کپی</button>--}}
                {{--                </div>--}}

            </div>
        </div>
    </div>

    <script>
        // نمایش Lightbox
        function showLightbox(img) {
            const lb = document.getElementById('lightbox');
            const lbImg = document.getElementById('lightbox-img');
            lbImg.src = img.src;
            lb.classList.remove('hidden');
            lb.classList.add('flex');
        }

        document.getElementById('lightbox-close').addEventListener('click', () => {
            document.getElementById('lightbox').classList.add('hidden');
            document.getElementById('lightbox').classList.remove('flex');
        });

        document.getElementById('lightbox').addEventListener('click', (e) => {
            if (e.target.id === 'lightbox') {
                document.getElementById('lightbox').classList.add('hidden');
                document.getElementById('lightbox').classList.remove('flex');
            }
        });

        // کپی متن
        function copyText(btn) {
            const parent = btn.closest('div');
            const textEl = parent.querySelector('p');
            const priceEl = parent.querySelector('span');
            const text = textEl.innerText + ' : ' + (priceEl ? priceEl.innerText : '');
            navigator.clipboard.writeText(text).then(() => {
                btn.innerText = '✔️';
                setTimeout(() => btn.innerText = 'کپی', 1000);
            });
        }
    </script>
</div>
