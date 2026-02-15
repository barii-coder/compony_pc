<div class="w-full p-1 mb-4">
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
         class="h-[94vh] w-[95%] inline-block overflow-y-auto rounded-2xl bg-white border rounded space-y-4">
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
                        <div class="rounded-lg p-2 mb-2 border w-full hidden bg-gray-100 chat-group"
                             data-group-id="{{ $groupId }}">

                            <button onclick="copyChatGroup('{{ $groupId }}', this)"
                                    class="copy-btn p-1 rounded-full float-right hover:bg-green-500/20 transition mb-5"
                                    title="کپی پیام‌های این گروه">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="#000"
                                     viewBox="0 0 24 24">
                                    <path
                                        d="M16 1H4a2 2 0 0 0-2 2v12h2V3h12V1zm3 4H8a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h11a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2zm0 16H8V7h11v14z"/>
                                </svg>
                            </button>

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
                                                    {{ $code[0] }} :
                                                </div>
                                                <div class="text-[11px] text-gray-500 inline-block ">
                                                    {{ $price !== null && $price !== '' ? $price : 'در حال بررسی' }}
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

                                        <div class="block">
                                            <p onclick="copyText(this)" class="cursor-pointer inline-block">
                                                {{ $code[0] }}
                                            </p>
                                            <span> : </span>
                                            <div class="text-[11px] text-gray-500 inline-block">
                                                {{ $price !== null && $price !== '' ? $price : 'در حال بررسی' }}
                                            </div>

                                            <button onclick="copySingleMessage('{{ $message->id }}', this)"
                                                    class="copy-btn p-1 rounded-full hover:bg-green-500/20 transition ml-2 float-right"
                                                    title="کپی این پیام">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                     fill="#000" viewBox="0 0 24 24">
                                                    <path
                                                        d="M16 1H4a2 2 0 0 0-2 2v12h2V3h12V1zm3 4H8a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h11a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2zm0 16H8V7h11v14z"/>
                                                </svg>
                                            </button>

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
                const priceEl = messageEl.querySelector('.text-xs');
                let price = priceEl?.innerText.trim() || '';

                // اگر هنوز در حال بررسی است، به عنوان "در حال بررسی" کپی شود
                if (!price || price.toLowerCase().includes('بررسی')) price = 'در حال بررسی';

                const textToCopy = `${code} : ${price}`;

                navigator.clipboard.writeText(textToCopy)
                    .then(() => {
                        const oldBg = btn.style.backgroundColor;
                        btn.style.backgroundColor = '#16a34a';
                        setTimeout(() => btn.style.backgroundColor = oldBg || '#22c55e', 1000);
                    })
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
                    const priceEl = el.querySelector('.text-sm > div:last-child');

                    const code = codeEl?.innerText.trim();
                    const price = priceEl?.innerText.trim() || 'در حال بررسی';

                    if (code) {
                        lines.push(`${code} : ${price}`);
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


        </script>
    </div>
</div>
