@props(['ended_chats'])

<style>
.dash-box-done { background: linear-gradient(180deg, #f8fafc 0%, #e2e8f0 100%); border-radius: 1rem; box-shadow: 0 4px 20px rgba(0,0,0,0.08), 0 0 0 1px rgba(0,0,0,0.04); overflow: hidden; }
.dash-box-done .dash-header { background: linear-gradient(135deg, #047857 0%, #059669 100%); color: #fff; padding: 0.65rem 0.75rem; font-weight: 700; text-align: center; font-size: 0.9rem; border-radius: 1rem 1rem 0 0; }
.dash-box-done .dash-card { border-radius: 0.75rem; padding: 0.5rem 0.6rem; margin-bottom: 0.5rem; border: 1px solid #e2e8f0; transition: box-shadow 0.2s; }
.dash-box-done .dash-card.normal { background: #fff; box-shadow: 0 1px 6px rgba(0,0,0,0.05); }
.dash-box-done .dash-card.follow { background: linear-gradient(135deg, #fef9c3 0%, #fef08a 100%); border-color: #facc15; box-shadow: 0 2px 10px rgba(234, 179, 8, 0.2); }
.dash-box-done .dash-card:hover { box-shadow: 0 4px 12px rgba(0,0,0,0.08); }
.dash-box-done .dash-row { border-top: 1px solid #f1f5f9; padding-top: 0.35rem; margin-top: 0.35rem; font-size: 12px; display: flex; align-items: center; gap: 0.25rem; flex-wrap: wrap; }
.dash-box-done .dash-btn-icon { padding: 0.25rem; border-radius: 50%; transition: background 0.2s, transform 0.1s; }
.dash-box-done .dash-btn-icon:hover { background: rgba(34, 197, 94, 0.2); transform: scale(1.05); }
.dash-box-done .dash-btn-icon.blue:hover { background: rgba(59, 130, 246, 0.2); }
.dash-box-done .dash-btn-follow { padding: 0.4rem 1rem; border-radius: 0.5rem; font-size: 12px; font-weight: 600; background: linear-gradient(180deg, #3b82f6, #2563eb); color: #fff; box-shadow: 0 2px 8px rgba(59, 130, 246, 0.3); transition: transform 0.1s, box-shadow 0.2s; }
.dash-box-done .dash-btn-follow:hover { box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4); transform: translateY(-1px); }
.dash-box-done .dash-avatar { width: 1.5rem; height: 1.5rem; border-radius: 0.5rem; object-fit: cover; }
.dash-box-done .dash-time { font-size: 10px; color: #64748b; }
</style>

<div class="dash-box-done float-left m-2 w-[18%] max-h-[600px] overflow-auto">
    <div class="dash-header sticky top-0 z-10">تکمیل شده</div>
    <ul class="text-xs space-y-2 p-2" style="list-style: none;">
        @foreach($ended_chats->groupBy('group_id') as $groupId => $groupChats)
            @php $firstChat = $groupChats->first(); $isFollowUp = $groupChats->first()->needs_follow_up ?? false; @endphp
            <li class="dash-card {{ $isFollowUp ? 'follow' : 'normal' }}">
                <div class="flex items-center justify-between mb-1">
                    <div class="flex items-center gap-2">
                        <img src="{{ $firstChat->user->profile_image_path }}" class="dash-avatar" alt="">
                        <button onclick="copyCompletedGroup('{{ $groupId }}', this)" class="dash-btn-icon p-1 rounded-full" title="کپی کدها و قیمت‌ها">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#475569" viewBox="0 0 24 24"><path d="M16 1H4a2 2 0 0 0-2 2v12h2V3h12V1zm3 4H8a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h11a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2zm0 16H8V7h11v14z"/></svg>
                        </button>
                        <button onclick="copyCompletedCodesOnly('{{ $groupId }}', this)" class="dash-btn-icon blue p-1 rounded-full" title="کپی فقط کدها">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#475569" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg>
                        </button>
                        <button wire:click="toggleFollowUp('{{ $groupId }}')" class="dash-btn-follow">پیگیری</button>
                    </div>
                    <span class="dash-time">{{ $firstChat->updated_at->format('H:i') }}</span>
                </div>
                @foreach($groupChats as $chat)
                    <div class="dash-row completed-{{ $groupId }}">
                        <span class="text-slate-600">
                            <p onclick="copyText(this)" class="completed-code completed-group-{{ $groupId }} inline-block text-xs font-semibold text-slate-600 cursor-pointer leading-none">{{ trim(explode(':', $chat->code)[0]) }}</p>
                            :
                        </span>
                        <span class="font-bold text-slate-800">{{ $chat->final_price }}</span>
                        <img src="{{ $chat->image_url }}" alt="" class="gallery-img" style="width: 15%; border-radius: 0">
                    </div>
                @endforeach
            </li>
        @endforeach
    </ul>
</div>
