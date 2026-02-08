@props(['wait_for_price', 'prices' => []])

<div class="bg-gray-200 rounded-2xl float-left m-2 w-[26%] max-h-[600px] overflow-auto">
    <div class="bg-blue-600 text-white p-2 rounded-t-2xl font-bold text-center sticky top-0 z-10">منتظر قیمت</div>
    <ul class="space-y-2 text-sm p-2">
        @foreach($wait_for_price->groupBy('group_id') as $groupId => $groupMessages)
            @php $firstMessage = $groupMessages->first(); @endphp
            <li class="bg-white rounded-2xl shadow-sm border border-slate-700 p-2 group group-{{ $groupId }}">
                <div class="flex items-center justify-between mb-2">
                    <div class="flex items-center gap-2">
                        <img width="30px" class="rounded-2xl" src="{{ $firstMessage->user->profile_image_path }}" alt="">
                    </div>
                    <div class="flex gap-1">
                        <button onclick="copyGroupData('{{ $groupId }}', this, 'codes')"
                                class="px-2 py-1 rounded-xl bg-green-500 text-white hover:bg-green-600 transition" title="کپی فقط کدها">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect>
                                <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>
                            </svg>
                        </button>
                    </div>
                </div>
                @foreach($groupMessages as $message)
                    <div class="mt-2 p-2 rounded-xl shadow-sm border border-slate-300 group-item group-item-{{ $groupId }}"
                         data-price="{{ $prices[$message->id] ?? '' }}" wire:key="wait-{{ $message->id }}">
                        <div class="flex items-center justify-between mb-1">
                            <span onclick="copyText(this)" class="cursor-pointer text-xs font-semibold text-slate-600">{{ trim(explode(':', $message->code)[0]) }}</span>
                            <div class="flex gap-1">
                                <button class="px-2 py-1 rounded-xl bg-red-600 text-white hover:bg-red-700 transition" wire:click="price_is_unavailable({{ $message->id }})">X</button>
                                <button class="px-2 py-1 rounded-xl bg-green-500 text-white hover:bg-green-600 transition" wire:click="code_answer_update('g', {{ $message->id }})">G</button>
                                <button class="px-2 py-1 rounded-xl bg-blue-600 text-white hover:bg-blue-700 transition" wire:click="code_answer_update('n', {{ $message->id }})">🥲</button>
                            </div>
                            <span class="text-red-600 cursor-pointer">{{ $message->text }}</span>
                        </div>
                        <div class="mt-2 block relative bg-gray-100 rounded-lg h-10 overflow-hidden">
                            <input type="text" class="h-full w-full pl-2 bg-transparent" placeholder="قیمت"
                                   wire:model.defer="prices.{{ $message->id }}"
                                   wire:keydown.enter="submit_answer_on3({{ $message->id }})">
                            <button wire:click="submit_answer_on3({{ $message->id }})"
                                    class="absolute top-0 right-0 h-full px-4 bg-blue-600 text-white hover:bg-blue-700 transition">➤</button>
                        </div>
                    </div>
                @endforeach
            </li>
        @endforeach
    </ul>
</div>
