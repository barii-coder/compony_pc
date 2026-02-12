<div class="w-full" style="margin: 0 10px" wire:poll.2000ms>
    <div style="width: 1px;height: 1px;background: #f00"></div>

    <div class="lightbox" wire:ignore>
        <span class="close">&times;</span>
        <img class="lightbox-content" id="lightbox-img"/>
    </div>

    @error('prices')
    <div class="w-full max-w-md mx-auto mt-3">
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 text-center rounded relative">
            <strong class="font-bold">خطا! </strong>
            <span>{{ $message }}</span>
        </div>
    </div>
    @enderror
    @error('access')
    <div class="w-full max-w-md mx-auto mt-3">
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 text-center rounded relative">
            <strong class="font-bold">خطا! </strong>
            <span>{{ $message }}</span>
        </div>
    </div>
    @enderror

    {{-- باکس چت‌های در جریان --}}
    <x-admin.dashboard.chats-in-progress-box
        wire:ignore
        :groups="$groups"
        :messageCounts="$messageCounts"
        :messageTimesByCode="$messageTimesByCode"
        :selectedCodes="$selectedCodes"
        :user="$user"
    />

    {{-- باکس منتظر بررسی --}}
    <x-admin.dashboard.pending-review-box
        :answersGrouped="$answersGrouped"
        :groupReadyForCheck="$groupReadyForCheck"
        :user="$user"
    />

    {{-- باکس منتظر قیمت --}}
    <x-admin.dashboard.waiting-for-price-box
        :wait_for_price="$wait_for_price"
        :prices="$prices"
    />

    {{-- باکس تکمیل شده --}}
    <x-admin.dashboard.completed-chats-box :ended_chats="$ended_chats"/>

    {{-- صورت ها --}}
    @if($user->id == 5 or $user->id == 1)
        <x-admin.dashboard.soraat-forms-box :productsGrouped="$productsGrouped"/>
    @endif

    {{-- فرم ارسال پیام --}}
    <x-admin.dashboard.chat-submit-form/>

    <livewire:test-form wire:ignore/>

    <script>

        function showToast(message) {
            alert(message) // اینجا Toast حرفه‌ای بذار
        }

        function copySoraatGroup(groupId, btn, type = 'all') {
            let lines = [];
            document.querySelectorAll('.soraat-item-' + groupId).forEach(row => {
                const codeEl = row.querySelector('.soraat-code');
                const inputEl = row.querySelector('input');
                if (!codeEl) return;
                const code = codeEl.innerText.trim();
                const value = inputEl ? inputEl.value.trim() : '';
                if (type === 'all') {
                    if (value !== '') lines.push(code + ' : ' + value);
                } else if (type === 'codes') {
                    lines.push(code);
                }
            });
            if (lines.length === 0) return;
            navigator.clipboard.writeText(lines.join('\n'));
            animateCopyIcon(btn);
        }

        function animateCopyIcon(btn) {
            const svg = btn.querySelector('svg');
            if (!svg) return;
            const oldColor = svg.style.fill || svg.style.stroke;
            svg.style.fill = '#16a34a';
            svg.style.stroke = '#16a34a';
            btn.classList.add('scale-110');
            setTimeout(() => {
                svg.style.fill = oldColor || '#000';
                svg.style.stroke = oldColor || '#000';
                btn.classList.remove('scale-110');
            }, 1000);
        }

        function copyGroupData(groupId, btn, type = 'all') {
            let lines = [];
            document.querySelectorAll('.group-item-' + groupId).forEach(el => {
                const code = el.querySelector('span')?.innerText.trim();
                const input = el.querySelector('input');
                const price = input ? input.value.trim() : '';
                if (!code) return;
                if (type === 'all' && price && !['x', 'n', 'L'].includes(price)) {
                    lines.push(code + ' : ' + price);
                } else if (type === 'codes') {
                    lines.push(code);
                }
            });
            if (lines.length === 0) return;
            navigator.clipboard.writeText(lines.join('\n'));
            showCopySuccess(btn);
        }

        function showCopySuccess(btn) {
            const svg = btn.querySelector('svg');
            if (!svg) return;
            const elements = svg.querySelectorAll('path, rect, circle, line, polyline, polygon');
            let oldStrokes = [], oldFills = [];
            elements.forEach((el, i) => {
                oldStrokes[i] = el.getAttribute('stroke');
                oldFills[i] = el.getAttribute('fill');
                el.setAttribute('stroke', '#16a34a');
                if (oldFills[i] && oldFills[i] !== 'none') el.setAttribute('fill', '#16a34a');
            });
            btn.classList.add('scale-110');
            setTimeout(() => {
                elements.forEach((el, i) => {
                    if (oldStrokes[i] !== null) el.setAttribute('stroke', oldStrokes[i]);
                    if (oldFills[i] !== null) el.setAttribute('fill', oldFills[i]);
                });
                btn.classList.remove('scale-110');
            }, 1000);
        }

        function copyChatGroupCodes(groupId, btn) {
            let result = [];
            document.querySelectorAll('.chat-group-' + groupId).forEach(el => {
                const code = el.innerText.trim();
                if (code) result.push(code);
            });
            if (result.length === 0) return;
            navigator.clipboard.writeText(result.join('\n'));
            showCopySuccess(btn);
        }

        function copyOnlyCodes(groupId, btn) {
            let result = [];
            document.querySelectorAll('.group-' + groupId).forEach(el => {
                const code = el.innerText.trim();
                if (code) result.push(code);
            });
            if (result.length === 0) return;
            navigator.clipboard.writeText(result.join('\n'));
            showCopySuccess(btn);
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

        function copyCompletedGroup(groupId, btn) {
            let lines = [];
            document.querySelectorAll('.completed-' + groupId).forEach(row => {
                const code = row.querySelector('p')?.innerText.trim();
                const price = row.querySelector('.font-bold')?.innerText.trim();
                if (code && price) lines.push(code + ' : ' + price);
            });
            if (lines.length === 0) return;
            navigator.clipboard.writeText(lines.join('\n'));
            showCopySuccess(btn);
        }

        function copyCompletedCodesOnly(groupId, btn) {
            let result = [];
            document.querySelectorAll('.completed-group-' + groupId).forEach(el => {
                const code = el.innerText.trim();
                if (code) result.push(code);
            });
            if (result.length === 0) return;
            navigator.clipboard.writeText(result.join('\n'));
            showCopySuccess(btn);
        }

        function copyGroupCodes(groupId, btn) {
            let result = [];
            document.querySelectorAll('.group-' + groupId).forEach(el => {
                const code = el.innerText.trim();
                const price = el.dataset.price;
                if (!price || price === 'x' || price === 'L' || price === 'n') return;
                result.push(code + ' : ' + price);
            });
            if (result.length === 0) return;
            navigator.clipboard.writeText(result.join('\n'));
            const svg = btn.querySelector('svg');
            if (!svg) return;
            const oldColor = svg.style.fill;
            svg.style.fill = '#16a34a';
            btn.classList.add('scale-110');
            setTimeout(() => {
                svg.style.fill = oldColor || '#000';
                btn.classList.remove('scale-110');
            }, 2000);
        }

        function handleCodeClick(event, code, messageId) {
            if (event.ctrlKey) {
                event.preventDefault();
                Livewire.dispatch('toggleCode', {code: code, messageId: messageId});
            } else {
                Livewire.dispatch('codeAnswerDirect', {chat_code: code, id: messageId});
            }
        }

        function hideMessage(id) {
            const el = document.getElementById('message-' + id);
            if (!el) return;
            el.classList.add('animate__fadeOut');
            setTimeout(() => {
                el.style.display = 'none';
            }, 500);
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
                .catch(err => console.error("خطا در کپی:", err));
        }
    </script>
</div>
