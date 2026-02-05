<div class="w-full p-1 mb-4">
    <a class="block w-0.5" href="/">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M19 12H5" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
            <path d="M12 19L5 12L12 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
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

    <div id="chat-container"
         class="h-[94vh] w-[95%] inline-block overflow-y-auto bg-white border rounded p-3 space-y-4">

        @foreach($messages->groupBy('group_id') as $groupId => $group)
            @if($group->count() > 1)
                {{-- باکس برای پیام‌های گروهی --}}
                <div class="rounded-lg p-2 border hidden bg-gray-100 chat-group" data-group-id="{{ $groupId }}">
                    <button onclick="copyChatGroup('{{ $groupId }}', this)"
                            class="copy-btn p-1 rounded-full hover:bg-green-500/20 transition mb-2"
                            title="کپی پیام‌های این گروه">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="#000" viewBox="0 0 24 24">
                            <path d="M16 1H4a2 2 0 0 0-2 2v12h2V3h12V1zm3 4H8a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h11a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2zm0 16H8V7h11v14z"/>
                        </svg>
                    </button>

                    @foreach($group as $message)
                        @if($message->chat_in_progress == "0")
                            <div class="message-item hidden mb-2" data-user-id="{{ $message->user_id }}" data-message-id="{{ $message->id }}">
                                <div class="w-[100%] {{ $message->user_id === auth()->id() ? 'ml-auto bg-blue-100' : 'bg-gray-100' }} p-2 rounded-lg">
                                    @php
                                        $lastAnswer = $message->answers->last();
                                        $price = $lastAnswer?->price;
                                        $code = $message->code;
                                    $code= explode(':', $code);
                                    @endphp

                                    <div class="text-sm w-[100%]">
                                        <div class=" inline-block">
                                            {{ $code[0] }} :
                                        </div>
                                        <div class="text-[11px] text-gray-500 inline-block float-right">
                                            {{ $price !== null && $price !== '' ? $price : 'در حال بررسی' }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>

            @else
                {{-- پیام تکی بدون باکس --}}
                @foreach($group as $message)
                    @if($message->chat_in_progress == "0")
                        <div class="message-item hidden mb-2" data-user-id="{{ $message->user_id }}" data-message-id="{{ $message->id }}">
                            <div class="w-[95%] {{ $message->user_id === auth()->id() ? 'ml-auto bg-blue-100' : 'bg-gray-100' }} p-2 rounded-lg">

                                @php
                                    $lastAnswer = $message->answers->last();
                                    $price = $lastAnswer?->price;
                                @endphp

                                <div class="text-sm ">

                                    <div class="flex justify-between items-center">
                                        <p onclick="copyText(this)" class="cursor-pointer">
                                            {{ $message->code }}
                                        </p>

                                        {{-- دکمه کپی برای پیام تکی --}}
                                        <button onclick="copySingleMessage('{{ $message->id }}', this)"
                                                class="copy-btn p-1 rounded-full hover:bg-green-500/20 transition ml-2"
                                                title="کپی این پیام">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="#000" viewBox="0 0 24 24">
                                                <path d="M16 1H4a2 2 0 0 0-2 2v12h2V3h12V1zm3 4H8a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h11a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2zm0 16H8V7h11v14z"/>
                                            </svg>
                                        </button>
                                    </div>

                                    <div class="text-xs text-gray-600">
                                        <div class="text-[11px] text-gray-500">
                                            {{ $price !== null && $price !== '' ? $price : 'در حال بررسی' }}
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach


            @endif
        @endforeach

    </div>

    <script>
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

            // اول همه پیام‌ها رو مخفی کن
            messages.forEach(el => {
                el.classList.add('hidden');
            });

            // فقط پیام‌های این یوزر رو نمایش بده
            messages.forEach(el => {
                if (el.dataset.userId == userId) {
                    el.classList.remove('hidden');
                }
            });

            // حالا بررسی کن هر گروه پیام قابل نمایش داره یا نه
            groups.forEach(group => {
                const visibleMessages = group.querySelectorAll('.message-item:not(.hidden)');
                if (visibleMessages.length > 0) {
                    group.classList.remove('hidden'); // گروه نمایش داده شود
                } else {
                    group.classList.add('hidden'); // کل باکس + دکمه کپی مخفی شود
                }
            });

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
