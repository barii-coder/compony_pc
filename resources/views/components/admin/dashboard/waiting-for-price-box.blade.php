@props(['wait_for_price', 'prices' => []])

<style>
.dash-box-wait { background: linear-gradient(180deg, #f8fafc 0%, #e2e8f0 100%); border-radius: 1rem; box-shadow: 0 4px 20px rgba(0,0,0,0.08), 0 0 0 1px rgba(0,0,0,0.04); overflow: scroll; }
.dash-box-wait .dash-header { background: linear-gradient(135deg, #0f766e 0%, #14b8a6 100%); color: #fff; padding: 0.65rem 0.75rem; font-weight: 700; text-align: center; font-size: 0.9rem; border-radius: 1rem 1rem 0 0; }
.dash-box-wait .dash-group-card { background: #fff; border-radius: 1rem; padding: 0.75rem; margin-bottom: 0.5rem; box-shadow: 0 2px 10px rgba(0,0,0,0.06); border: 1px solid #e2e8f0; }
.dash-box-wait .dash-item { margin-top: 0.5rem; padding: 0.5rem; border-radius: 0.75rem; background: #f8fafc; border: 1px solid #e2e8f0; }
.dash-box-wait .dash-item:hover { background: #f1f5f9; }
.dash-box-wait .dash-price-wrap { margin-top: 0.5rem; position: relative; height: 2.5rem; background: #f1f5f9; border-radius: 0.5rem; overflow: hidden; box-shadow: 0 0 0 1px #e2e8f0; }
.dash-box-wait .dash-price-wrap input { height: 100%; width: 100%; padding-left: 0.5rem; padding-right: 3rem; background: transparent; font-size: 13px; }
.dash-box-wait .dash-price-btn { position: absolute; top: 0; right: 0; height: 100%; padding: 0 1rem; background: linear-gradient(180deg, #14b8a6, #0d9488); color: #fff; font-weight: 600; transition: opacity 0.2s; }
.dash-box-wait .dash-price-btn:hover { opacity: 0.95; }
.dash-box-wait .dash-btn-sm { padding: 0.25rem 0.5rem; border-radius: 0.5rem; font-size: 12px; font-weight: 600; transition: transform 0.1s, opacity 0.2s; }
.dash-box-wait .dash-btn-sm.red { background: linear-gradient(180deg, #ef4444, #dc2626); color: #fff; }
.dash-box-wait .dash-btn-sm.green { background: linear-gradient(180deg, #22c55e, #16a34a); color: #fff; }
.dash-box-wait .dash-btn-sm.blue { background: linear-gradient(180deg, #3b82f6, #2563eb); color: #fff; }
.dash-box-wait .dash-btn-sm:hover { transform: translateY(-1px); }
.dash-box-wait .dash-avatar { width: 30px; height: 30px; border-radius: 0.75rem; object-fit: cover; box-shadow: 0 1px 4px rgba(0,0,0,0.1); }
</style>

<div class="dash-box-wait float-left m-2 w-[26%] max-h-[600px] overflow-auto">
    <div class="dash-header sticky top-0 z-10">منتظر قیمت</div>
    <ul class="space-y-2 text-sm p-2" style="list-style: none;">
        @foreach($wait_for_price->groupBy('group_id') as $groupId => $groupMessages)
            @php $firstMessage = $groupMessages->first(); @endphp
            <li class="dash-group-card group group-{{ $groupId }}">
                <div class="flex items-center justify-between mb-2">
                    <div class="flex items-center gap-2">
                        <img width="30" height="30" class="dash-avatar" src="{{ $firstMessage->user->profile_image_path }}" alt="">
                    </div>
                    <div class="flex gap-1">
                        <button onclick="copyGroupData('{{ $groupId }}', this, 'codes')" class="dash-btn-sm green" title="کپی فقط کدها">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2"/></svg>
                        </button>
                    </div>
                </div>
                @foreach($groupMessages as $message)
                    <div class="dash-item group-item group-item-{{ $groupId }}" data-price="{{ $prices[$message->id] ?? '' }}" wire:key="wait-{{ $message->id }}">
                        <div class="flex items-center justify-between mb-1 gap-2 flex-wrap">
                            <span onclick="copyText(this)" class="cursor-pointer text-xs font-semibold text-slate-600">{{ trim(explode(':', $message->code)[0]) }}</span>
                            <div class="flex gap-1">
                                <button class="dash-btn-sm red" wire:click="price_is_unavailable({{ $message->id }})">X</button>
                                <button class="dash-btn-sm green" wire:click="code_answer_update('g', {{ $message->id }})">G</button>
                                <button class="dash-btn-sm blue" wire:click="code_answer_update('n', {{ $message->id }})">🥲</button>
                            </div>
                            <span class="text-red-600 cursor-pointer text-xs">{{ $message->text }}</span>
                        </div>
                        <div class="dash-price-wrap">
                            <input type="text" placeholder="قیمت" wire:model.defer="prices.{{ $message->id }}" wire:keydown.enter="submit_answer_on3({{ $message->id }})">
                            <button type="button" wire:click="submit_answer_on3({{ $message->id }})" class="dash-price-btn">➤</button>
                        </div>
                    </div>
                @endforeach
            </li>
        @endforeach
    </ul>
</div>
