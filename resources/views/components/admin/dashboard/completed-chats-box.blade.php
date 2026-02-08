@props(['ended_chats'])

<div class="bg-gray-200 rounded-2xl float-left m-2 w-[18%] max-h-[600px] overflow-auto">
    <div class="bg-blue-600 text-white p-2 font-bold text-center sticky top-0 z-10 rounded-t-2xl">تکمیل شده</div>
    <ul class="text-xs space-y-2">
        @foreach($ended_chats->groupBy('group_id') as $groupId => $groupChats)
            @php
                $firstChat = $groupChats->first();
                $isFollowUp = $groupChats->first()->needs_follow_up ?? false;
            @endphp
            <li class="rounded-lg border p-2 {{ $isFollowUp ? 'bg-yellow-100 border-yellow-400' : 'bg-white border-gray-300' }}">
                <div class="flex items-center justify-between mb-1">
                    <div class="flex items-center gap-2">
                        <img src="{{ $firstChat->user->profile_image_path }}" class="w-6 h-6 rounded-lg" alt="">
                        <span class="font-bold text-gray-700 text-xs"></span>
                        <button onclick="copyCompletedGroup('{{ $groupId }}', this)" class="copy-btn p-1 rounded-full hover:bg-green-500/20 transition" title="کپی کدها و قیمت‌ها">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="#000" viewBox="0 0 24 24">
                                <path d="M16 1H4a2 2 0 0 0-2 2v12h2V3h12V1zm3 4H8a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h11a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2zm0 16H8V7h11v14z"/>
                            </svg>
                        </button>
                        <button onclick="copyCompletedCodesOnly('{{ $groupId }}', this)" class="copy-btn p-1 rounded-full hover:bg-blue-500/20 transition" title="کپی فقط کدها">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect>
                                <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>
                            </svg>
                        </button>
                        <button wire:click="toggleFollowUp('{{ $groupId }}')"
                                class="px-5 py-2 bg-blue-400 text-white rounded-lg shadow-md hover:shadow-lg transition">پیگیری</button>
                    </div>
                    <span class="text-gray-500 text-[10px]">{{ $firstChat->updated_at->format('H:i') }}</span>
                </div>
                @foreach($groupChats as $chat)
                    <div class="border-t border-gray-200 pt-1 mt-1 leading-tight flex completed-{{ $groupId }}">
                        <span class="text-gray-700">
                            <p onclick="copyText(this)" class="completed-code completed-group-{{ $groupId }} inline-block text-xs font-semibold text-slate-600 cursor-pointer leading-none">
                                {{ trim(explode(':', $chat->code)[0]) }}
                            </p>
                            :
                        </span>
                        <span class="font-bold text-gray-800">{{ $chat->final_price }}</span>
                        <img src="{{ $chat->image_url }}" alt="" class="gallery-img" style="width: 15%;border-radius: 0">
                    </div>
                @endforeach
            </li>
        @endforeach
    </ul>
</div>
