<div class="w-full p-1 mb-4">
    <div class=" w-[80%] bg-gray-200 border rounded-l" style="margin: 3px auto; box-shadow: 1px 1px 4px #aaa">
        <input type="text" id="code-search" placeholder="جستجوی کد..."
               class="w-full p-2 border rounded-lg" onkeyup="searchByCode()" />
    </div>
    <div class="lightbox" wire:ignore>
        <span class="close">&times;</span>
        <img class="lightbox-content" id="lightbox-img"/>
    </div>
    <a class="block w-0.5" href="/">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M19 12H5" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
            <path d="M12 19L5 12L12 5" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                  stroke-linejoin="round"/>
        </svg>
    </a>
    <div class="gap-2 inline-block m-1 h-[93vh] overflow-y-auto">
        @foreach($messages->unique('user_id') as $message)
            <button onclick="showUserMessages({{ $message->user_id }})"
                    class="focus:outline-none block w-full">
                <img class="w-[40px] h-[40px] m-1 rounded-full border"
                     src="{{ $message->user->profile_image_path }}"
                     alt="">
            </button>
        @endforeach
    </div>
    <style>
        .dash-header {
            background: linear-gradient(135deg, #047857 0%, #059669 100%);
            color: #fff;
            padding: 0.65rem 0.75rem;
            font-weight: 700;
            text-align: center;
            font-size: 0.9rem;
            border-radius: 1rem 1rem 0 0;
        }
    </style>

    @php
        use Morilog\Jalali\Jalalian;

        $messagesByDate = $messages->sortBy('created_at')->groupBy(function ($msg) {
            return Jalalian::fromDateTime($msg->created_at)->format('Y-m-d');
        });
    @endphp

    <div id="chat-container"
         class="h-[94vh] w-[95%] inline-block overflow-y-auto rounded-2xl bg-white border space-y-4">
        <div class="dash-header sticky top-0 z-10">تکمیل شده</div>
        <div class="p-5">
            @foreach($messagesByDate as $date => $dayMessages)

                @php
                    // تنظیم به زمان تهران
                    $createdAt = $dayMessages->first()->created_at->copy()->setTimezone('Asia/Tehran');
                    $jalaliDate = Jalalian::fromDateTime($createdAt)->format('%A %d %B');

                    $groups = $dayMessages->groupBy('group_id');
                @endphp

                <div class="flex justify-center my-3 date-separator hidden" data-date="{{ $date }}">
                    <div class="bg-gray-200 text-gray-600 text-xs px-4 py-1 rounded-full shadow-sm">
                        {{ $jalaliDate }}
                    </div>
                </div>

                @foreach($groups as $groupId => $group)

                    @if($group->count() > 1)
                        {{-- پیام‌های گروهی --}}
                        <div class="rounded-lg p-2 mb-2 border w-full hidden bg-gray-100 chat-group relative"
                             data-group-id="{{ $groupId }}">

                            <div class="absolute right-[20px] top-[10px]">
                                <button onclick="copyChatGroup('{{ $groupId }}', this)"
                                        class="copy-btn p-1 rounded-full float-right hover:bg-green-500/20 transition mb-5"
                                        title="کپی پیام‌های این گروه">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="#000"
                                         viewBox="0 0 24 24">
                                        <path
                                            d="M16 1H4a2 2 0 0 0-2 2v12h2V3h12V1zm3 4H8a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h11a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2zm0 16H8V7h11v14z"/>
                                    </svg>
                                </button>

                                <button onclick="copyCodesOnly(this)"
                                        class="copy-btn p-1 rounded-full float-right hover:bg-green-500/20 transition mb-5"
                                        title="کپی فقط کد ها">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                         viewBox="0 0 24 24">
                                        <path
                                            d="M19 5H8a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h11a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2zm0 16H8V7h11v14z"></path>
                                    </svg>
                                </button>
                            </div>

                            @foreach($group as $message)
                                @if($message->chat_in_progress == "0")
                                    <div class="message-item hidden mb-2"
                                         data-user-id="{{ $message->user_id }}"
                                         data-message-id="{{ $message->id }}"
                                         data-date="{{ $date }}">


                                        <div
                                            class="w-full {{ $message->user_id === auth()->id() ? 'ml-auto bg-blue-100' : 'bg-gray-100' }} p-2 rounded-lg">
                                            @php
                                                $lastAnswer = $message->answers->last();
                                                $price = $lastAnswer?->price;
                                                $code = explode(':', $message->code);
                                            @endphp

                                            <div class="text-sm w-full">
                                                <div class="inline-block">
                                                    <p data-code onclick="copyText(this)"
                                                       class="cursor-pointer inline-block">
                                                        {{ $code[0] }}
                                                    </p>
                                                </div>
                                                <div class="text-[11px] price text-gray-500 inline-block " data-price>
                                                    <span class="m-1">:</span>
                                                    {{ $price !== null && $price !== '' ? $price : 'در حال بررسی' }}
                                                </div>
                                                <div class="text-[15px] inline-block float-right mr-[70px]">
                                                    <span
                                                        class="dash-time">{{ $message->updated_at->format('H:i') }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>

                    @else
                        {{-- پیام تکی --}}
                        @foreach($group as $message)
                            @if($message->chat_in_progress == "0")
                                <div class="message-item hidden mb-2 w-full"
                                     data-user-id="{{ $message->user_id }}"
                                     data-message-id="{{ $message->id }}"
                                     data-date="{{ $date }}">

                                    <div
                                        class="{{ $message->user_id === auth()->id() ? 'ml-auto bg-blue-100' : 'bg-gray-100' }} min-h-[70px] p-2 rounded-lg">

                                        @php
                                            $lastAnswer = $message->answers->last();
                                            $price = $lastAnswer?->price;
                                            $code = explode(':', $message->code);
                                        @endphp

                                        <div class="block relative">
                                            <p data-code onclick="copyText(this)" class="cursor-pointer inline-block">
                                                {{ $code[0] }}
                                            </p>
                                            <span> : </span>
                                            <div class="text-[11px] text-gray-500 inline-block" data-price>
                                                {{ $price !== null && $price !== '' ? $price : 'در حال بررسی' }}
                                            </div>
                                            <div class="text-[15px] inline-block float-right mr-[80px]">
                                                    <span
                                                        class="dash-time">{{ $message->updated_at->format('H:i') }}</span>
                                            </div>
                                            <div class="absolute right-[10px] top-[3px]">
                                                <button onclick="copySingleMessage('{{ $message->id }}', this)"
                                                        class="copy-btn p-1 rounded-full hover:bg-green-500/20 transition ml-2 float-right"
                                                        title="کپی این پیام">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                         fill="#000" viewBox="0 0 24 24">
                                                        <path
                                                            d="M16 1H4a2 2 0 0 0-2 2v12h2V3h12V1zm3 4H8a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h11a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2zm0 16H8V7h11v14z"/>
                                                    </svg>
                                                </button>
                                                <button onclick="copyCodesOnly(this)"
                                                        class="copy-btn p-1 rounded-full hover:bg-green-500/20 transition ml-2 float-right"
                                                        title="کپی فقط کد ها">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                         fill="currentColor"
                                                         viewBox="0 0 24 24">
                                                        <path
                                                            d="M19 5H8a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h11a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2zm0 16H8V7h11v14z"></path>
                                                    </svg>
                                                </button>
                                            </div>


                                            <img src="{{$message->image_url}}" class="gallery-img"
                                                 style="width: 40px;border-radius: 0">
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    @endif

                @endforeach
            @endforeach

        </div>

        <script>

            function copyCodesOnly(btn) {
                let codes = [];

                // 1️⃣ بررسی می‌کنیم آیا دکمه داخل یک گروه است
                const group = btn.closest('.chat-group');

                if (group) {
                    // اگر داخل گروه بود، فقط کدهای پیام‌های داخل گروه را بگیریم
                    group.querySelectorAll('[data-code]').forEach(el => {
                        const code = el.innerText.trim();
                        if (code) codes.push(code);
                    });
                } else {
                    // اگر داخل پیام تکی بود، فقط کد همان پیام را بگیریم
                    const message = btn.closest('.message-item');
                    if (message) {
                        const codeEl = message.querySelector('[data-code]');
                        if (codeEl) codes.push(codeEl.innerText.trim());
                    }
                }

                if (codes.length === 0) return;

                navigator.clipboard.writeText(codes.join('\n'))
                    .then(() => showCopySuccess(btn))
                    .catch(err => console.error("خطا در کپی فقط کدها:", err));
            }


            const lightbox = document.querySelector(".lightbox");
            const lightboxImg = document.getElementById("lightbox-img");
            const closeBtn = document.querySelector(".close");

            document.addEventListener("click", function (e) {
                if (e.target.classList.contains("gallery-img")) {
                    lightbox.style.display = "block";
                    lightboxImg.src = e.target.src;
                }
            });

            closeBtn.addEventListener("click", () => {
                lightbox.style.display = "none";
            });

            lightbox.addEventListener("click", (e) => {
                if (e.target === lightbox) lightbox.style.display = "none";
            });

            function copySingleMessage(messageId, btn) {
                const messageEl = document.querySelector(`.message-item[data-message-id="${messageId}"]`);
                if (!messageEl) return;

                const code = messageEl.querySelector('p')?.innerText.trim() || '';
                const priceEl = messageEl.querySelector('[data-price]');
                let price = priceEl?.innerText.trim() || '';

                // اگر هنوز در حال بررسی است، به عنوان "در حال بررسی" کپی شود
                if (!price || price.toLowerCase().includes('بررسی')) price = 'در حال بررسی';

                const textToCopy = `${code} : ${price}`;

                navigator.clipboard.writeText(textToCopy)
                    .then(() => showCopySuccess(btn))
                    .catch(err => console.error("خطا در کپی:", err));
            }

            function copyText(element) {
                const text = element.innerText;
                navigator.clipboard.writeText(text)
                    .then(() => {
                        element.style.color = '#0f0';
                        setTimeout(() => {
                            element.style.color = '';
                        }, 1000);
                    })
                    .catch(err => {
                        console.error("خطا در کپی:", err);
                    });
            }

            function showUserMessages(userId) {
                const messages = document.querySelectorAll('.message-item');
                const groups = document.querySelectorAll('.chat-group');
                const container = document.getElementById('chat-container');
                const dateSeparators = document.querySelectorAll('.date-separator');

                // 1️⃣ مخفی کردن همه پیام‌ها
                messages.forEach(el => el.classList.add('hidden'));

                // 2️⃣ نمایش پیام‌های یوزر انتخاب شده
                messages.forEach(el => {
                    if (el.dataset.userId == userId) {
                        el.classList.remove('hidden');
                    }
                });

                // 3️⃣ بررسی هر گروه: اگر پیام visible داشت، خودش هم visible شود
                groups.forEach(group => {
                    const visibleMessages = group.querySelectorAll('.message-item:not(.hidden)');
                    if (visibleMessages.length > 0) {
                        group.classList.remove('hidden');
                    } else {
                        group.classList.add('hidden');
                    }
                });

                // 4️⃣ بررسی جداکننده تاریخ‌ها
                dateSeparators.forEach(separator => {
                    const date = separator.dataset.date;
                    const visibleMessagesForDate = document.querySelectorAll(`.message-item[data-date="${date}"]:not(.hidden)`);

                    if (visibleMessagesForDate.length > 0) {
                        separator.classList.remove('hidden');
                    } else {
                        separator.classList.add('hidden');
                    }

                });

                // 5️⃣ اسکرول به پایین
                setTimeout(() => {
                    container.scrollTop = container.scrollHeight;
                }, 50);
            }


            function copyChatGroup(groupId, btn) {
                let lines = [];

                document.querySelectorAll(`.chat-group[data-group-id="${groupId}"] .message-item`).forEach(el => {
                    const codeEl = el.querySelector('.text-sm > div:first-child');
                    const priceEl = el.querySelector('.text-sm > .price');

                    const code = codeEl?.innerText.trim();
                    const price = priceEl?.innerText.trim() || 'در حال بررسی';

                    if (code) {
                        lines.push(`${code} ${price}`);
                    }
                });

                if (lines.length === 0) return;

                navigator.clipboard.writeText(lines.join('\n'))
                    .then(() => showCopySuccess(btn))
                    .catch(err => console.error("خطا در کپی گروهی:", err));
            }


            function showCopySuccess(btn) {
                const svg = btn.querySelector('svg');
                if (!svg) return;

                const oldFill = svg.style.fill;
                svg.style.fill = '#16a34a';

                btn.classList.add('scale-110');

                setTimeout(() => {
                    svg.style.fill = oldFill || '#000';
                    btn.classList.remove('scale-110');
                }, 2000);
            }

            function searchByCode() {
                const query = document.getElementById('code-search').value.trim().toLowerCase();
                const messages = document.querySelectorAll('.message-item');
                const groups = document.querySelectorAll('.chat-group');
                const dateSeparators = document.querySelectorAll('.date-separator');

                // اگر سرچ خالی بود → برگرد به حالت پیش‌فرض (همه مخفی بمانند تا یوزر انتخاب شود)
                if (!query) {
                    messages.forEach(m => m.classList.add('hidden'));
                    groups.forEach(g => g.classList.add('hidden'));
                    dateSeparators.forEach(d => d.classList.add('hidden'));
                    return;
                }

                // اول همه چیز رو مخفی کن
                messages.forEach(m => m.classList.add('hidden'));
                groups.forEach(g => g.classList.add('hidden'));
                dateSeparators.forEach(d => d.classList.add('hidden'));

                // بررسی پیام‌ها
                messages.forEach(m => {
                    const codeEl = m.querySelector('[data-code]');
                    if (codeEl && codeEl.innerText.toLowerCase().includes(query)) {

                        const parentGroup = m.closest('.chat-group');

                        if (parentGroup) {
                            // اگر داخل گروه بود → کل گروه نمایش داده شود
                            parentGroup.classList.remove('hidden');

                            // همه پیام‌های داخل گروه هم visible شوند
                            parentGroup.querySelectorAll('.message-item').forEach(msg => {
                                msg.classList.remove('hidden');
                            });

                        } else {
                            // اگر پیام تکی بود → خودش نمایش داده شود
                            m.classList.remove('hidden');
                        }

                        // نمایش separator مربوط به تاریخ
                        const date = m.dataset.date;
                        const separator = document.querySelector(`.date-separator[data-date="${date}"]`);
                        if (separator) separator.classList.remove('hidden');
                    }
                });
            }
        </script>
    </div>
</div>
