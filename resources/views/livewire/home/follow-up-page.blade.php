<div class="dash-box-done float-left ml-1 mt-2 w-[20%] h-[97vh] overflow-auto" wire:poll.2s>
    <style>
        .dash-box-done {
            background: #fff;
            border-radius: 1rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08),
            0 0 0 1px rgba(0, 0, 0, 0.04);
            overflow: auto;
        }

        body{
            display: block!important;
            padding: 5px;
        }

        /* هدر مخصوص پیگیری */
        .dash-box-done .dash-header {
            background: linear-gradient(135deg, #33f 0%, #00f 100%);
            color: #fff;
            padding: 0.5rem 0.75rem;
            font-weight: 700;
            text-align: center;
            font-size: 0.9rem;
            border-radius: 1rem 1rem 0 0;
        }

        .dash-box-done .dash-card {
            border-radius: 0.75rem;
            padding: 0.5rem 0.6rem;
            margin-bottom: 0.5rem;
            border: 1px solid #fed7aa;
            background: #eee;
            box-shadow: 0 2px 10px rgba(249, 115, 22, 0.15);
            transition: all 0.2s;
        }

        .dash-box-done .dash-card:hover {
            box-shadow: 0 6px 6px rgba(0,0,100,.5);
            transform: translateY(-2px);
        }

        .dash-box-done .dash-row {
            border-top: 1px solid #fde68a;
            padding-top: 0.35rem;
            margin-top: 0.35rem;
            font-size: 12px;
            display: flex;
            align-items: center;
        }

        .dash-avatar {
            width: 2rem;
            height: 2rem;
            border-radius: 100%;
            object-fit: cover;
            border: 2px solid #fb923c;
        }

        .dash-time {
            font-size: 10px;
            color: #9a3412;
            font-weight: 600;
        }

        .dash-btn-follow {
            padding: 0.2rem .8rem;
            border-radius: 0.5rem;
            font-size: 10px;
            font-weight: 600;
            background: #55f;
            color: #fff;
            box-shadow: 0 2px 8px rgba(239, 68, 68, 0.3);
            transition: all 0.15s;
        }

        .dash-btn-follow:hover {
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.4);
            transform: translateY(-1px);
        }
        .dash-btn-code {
            padding: 1px 0 !important;
            border-radius: 0.5rem;
            font-size: 11px;
            font-weight: 600;
            transition: all 0.15s;
            background: #e0e7ff;
            color: #3730a3;
            min-width: 28px;
            text-align: center;
        }
        .dash-btn-code2 {
            padding: 1px 0 !important;
            border-radius: 0.5rem;
            font-size: 11px;
            font-weight: 600;
            transition: all 0.15s;
            min-width: 28px;
            text-align: center;
        }

        .dash-btn-code2 {
            background: #a7f3d0;
            color: #3730a3;
        }
    </style>
    <div class="dash-header sticky top-0 z-10">پیگیری</div>

    <ul class="text-xs space-y-2 p-2 " style="list-style: none;">

        @foreach($FollowMessages->groupBy('group_id') as $groupId => $groupChats)

            @php
                $firstChat = $groupChats->first();
            @endphp

            <li class="dash-card follow">

                <div class="flex items-left justify-between mb-1">
                    <div class="flex items-center gap-2">

                        <img src="{{ $firstChat->user->profile_image_path }}"
                             class="dash-avatar scale-90" alt="">

                        <button
                            wire:click="toggleFollowUp('{{ $groupId }}')"
                            class="dash-btn-follow">
                            حذف پیگیری
                        </button>
                        <button onclick="copyFollowGroup('{{ $groupId }}', this)"
                                class="dash-btn-icon"
                                title="کپی کدها و قیمت‌ها">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                 viewBox="0 0 24 24">
                                <path
                                    d="M16 1H4a2 2 0 0 0-2 2v12h2V3h12V1zm3 4H8a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h11a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2zm0 16H8V7h11v14z"/>
                            </svg>
                        </button>

                        <button onclick="copyFollowCodesOnly('{{ $groupId }}', this)"
                                class="dash-btn-icon"
                                title="کپی فقط کدها">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                 viewBox="0 0 24 24">
                                <path
                                    d="M19 5H8a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h11a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2zm0 16H8V7h11v14z"></path>
                            </svg>
                        </button>

                    </div>

                    <span class="dash-time">
                        {{ $firstChat->updated_at->format('H:i') }}
                    </span>
                </div>

                @foreach($groupChats as $chat)
                    <div class="dash-row  follow-group-{{ $groupId }}">

                        <span class="text-slate-600 follow-code follow-code-group-{{ $groupId }}">
                            {{ trim(explode(':', $chat->code)[0]) }} :
                        </span>

                        <span class="font-bold text-left text-slate-800 follow-price">
                            {{ $chat->final_price }}
                        </span>
                        <button wire:click="dbtn({{$chat->id}})"
                                class="d-btn ml-1 {{$chat->is_circle == '1' ? 'dash-btn-code2' : 'dash-btn-code'}}">
                            <span wire:loading.remove wire:target="dbtn({{$chat->id}})" class="send-arrow ">D</span>

                            <span wire:loading wire:target="dbtn({{$chat->id}})"
                                  style="font-size:12px;">...</span>
                        </button>
                    </div>
                @endforeach

            </li>

        @endforeach

    </ul>
    <script>
        // کپی همه کدها + قیمت‌ها
        function copyFollowGroup(groupId, btn) {

            let rows = document.querySelectorAll('.follow-group-' + groupId);
            let text = '';

            rows.forEach(row => {
                let code = row.querySelector('.follow-code')?.innerText.trim();
                let price = row.querySelector('.follow-price')?.innerText.trim();

                if (code && price) {
                    text += code + price + '\n';
                }
            });

            if (!text) return;

            navigator.clipboard.writeText(text).then(() => {
                showCopySuccess(btn);
            });
        }


        // کپی فقط کدها
        function copyFollowCodesOnly(groupId, btn) {

            let codes = document.querySelectorAll('.follow-code-group-' + groupId);
            let text = '';

            codes.forEach(code => {

                let raw = code.innerText.trim();

                // اگر ":" داشت فقط قبلش رو بگیر
                if (raw.includes(':')) {
                    raw = raw.split(':')[0].trim();
                }

                text += raw + '\n';
            });

            if (!text) return;

            navigator.clipboard.writeText(text).then(() => {
                showCopySuccess(btn);
            });
        }


        function showCopySuccess(btn) {

            let svg = btn.querySelector('svg');
            if (!svg) return;

            // ذخیره رنگ قبلی
            let originalColor = svg.style.color;

            // سبز شدن
            svg.style.color = "#22c55e";

            // اگر fill مستقیم داشت اینم امن‌تره
            svg.style.fill = "#22c55e";

            setTimeout(() => {
                svg.style.color = originalColor;
                svg.style.fill = "";
            }, 800);
        }
    </script>
</div>
