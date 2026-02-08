@props(['groups', 'messageCounts', 'messageTimesByCode', 'selectedCodes', 'user'])

<style>
/* باکس چت‌های در جریان */
.dash-box-chats { direction: ltr; background: #fff; border-radius: 1rem; box-shadow: 0 4px 24px rgba(0,0,0,0.06), 0 0 0 1px rgba(0,0,0,0.04); overflow: auto; }
.dash-box-chats .dash-header { background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%); color: #fff; padding: 0.75rem 1rem; font-weight: 700; text-align: center; font-size: 0.95rem; letter-spacing: 0.02em; }
/* کارت هر گروه */
.dash-box-chats .dash-card { background: #fafbfc; border-radius: 0.875rem; padding: 0; margin: 0 0.5rem 0.6rem; box-shadow: 0 1px 6px rgba(0,0,0,0.1); border: 1px solid #e5e7eb; overflow: hidden; }
.dash-box-chats .dash-card:last-child { margin-bottom: 0.5rem; }
/* هدر کارت: آواتار + دکمه‌ها */
.dash-box-chats .dash-card-head { display: flex; align-items: center; gap: 0.5rem; padding: 0.5rem 0.6rem; background: #f1f5f9; border-bottom: 1px solid #e5e7eb; }
.dash-box-chats .dash-avatar { width: 32px; height: 32px; border-radius: 50%; object-fit: cover; flex-shrink: 0; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
.dash-box-chats .dash-card-actions { display: flex; align-items: center; gap: 0.2rem; margin-right: auto; }
.dash-box-chats .dash-btn-icon { width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center; border-radius: 50%; color: #64748b; transition: background 0.2s, color 0.2s, transform 0.15s; }
.dash-box-chats .dash-btn-icon:hover { background: rgba(239, 68, 68, 0.12); color: #dc2626; transform: scale(1.08); }
.dash-box-chats .dash-btn-icon.copy:hover { background: rgba(34, 197, 94, 0.15); color: #16a34a; }
/* هر پیام */
.dash-box-chats .dash-msg-item { padding: 0.6rem 0.75rem; border-bottom: 1px solid #f1f5f9; font-size: 12px; background: #fff; transition: background 0.15s; }
.dash-box-chats .dash-msg-item:last-child { border-bottom: none; }
.dash-box-chats .dash-msg-item:hover { background: #fafbfc; }
.dash-box-chats .dash-msg-item .gallery-img { max-height: 120px; width: auto; display: block; margin-bottom: 0.35rem; border-radius: 6px; cursor: pointer; }
.dash-box-chats .dash-code-line { font-weight: 600; color: #334155; cursor: pointer; padding: 0.2rem 0; }
.dash-box-chats .dash-code-line:hover { color: #1e40af; }
.dash-box-chats .dash-time-badge { font-size: 10px; color: #94a3b8; margin-right: 0.35rem; }
/* ردیف دکمه‌های کد */
.dash-box-chats .dash-code-btns { display: flex; flex-wrap: wrap; gap: 0.35rem; margin-top: 0.5rem; align-items: center; }
.dash-box-chats .dash-btn-code { padding: 0.3rem 0.6rem; border-radius: 0.5rem; font-size: 11px; font-weight: 600; transition: all 0.15s; min-width: 28px; text-align: center; }
.dash-box-chats .dash-btn-code { background: #e0e7ff; color: #3730a3; }
.dash-box-chats .dash-btn-code:hover { background: #c7d2fe; transform: translateY(-1px); }
.dash-box-chats .dash-btn-code.selected { background: linear-gradient(135deg, #059669, #047857); color: #fff; }
.dash-box-chats .dash-buyer-tag { font-size: 11px; color: #64748b; margin-right: 0.5rem; }
/* ردیف کامنت + قیمت — یک ارتفاع، جمع‌وجور */
.dash-box-chats .dash-comment-price-row { display: flex; align-items: stretch; gap: 0.4rem; margin-top: 0.4rem; }
.dash-box-chats .dash-comment-input { width: 100%; max-width: 140px; height: 32px; padding: 0 0.5rem; font-size: 11px; border-radius: 0.4rem; background: #f8fafc; box-shadow: 0 0 0 1px #e2e8f0; box-sizing: border-box; }
.dash-box-chats .dash-comment-input:focus { outline: none; box-shadow: 0 0 0 2px #3b82f6; }
.dash-box-chats .dash-input-wrap { display: flex; flex: 1; min-width: 0; height: 32px; background: #f1f5f9; border-radius: 0.4rem; overflow: hidden; box-shadow: 0 0 0 1px #e2e8f0; }
.dash-box-chats .dash-input-wrap input { padding: 0 0.5rem; font-size: 11px; flex: 1; min-width: 0; background: transparent; height: 100%; }
.dash-box-chats .dash-input-wrap input::placeholder { color: #94a3b8; }
.dash-box-chats .dash-btn-submit { padding: 0 0.5rem; font-size: 11px; font-weight: 700; background: linear-gradient(180deg, #2563eb, #1d4ed8); color: #fff; transition: opacity 0.2s, box-shadow 0.2s; display: inline-flex; align-items: center; justify-content: center; }
.dash-box-chats .dash-btn-submit:hover { opacity: 0.95; box-shadow: inset 0 1px 0 rgba(255,255,255,0.2); }
.dash-box-chats .dash-btn-submit .dash-submit-arrow { display: inline-block; transform: rotate(180deg); }
/* دکمه ثبت انتخاب‌ها */
.dash-box-chats .dash-btn-register { margin-top: 0.5rem; width: 100%; padding: 0.45rem; border-radius: 0.5rem; font-weight: 600; font-size: 12px; background: linear-gradient(180deg, #059669, #047857); color: #fff; transition: transform 0.1s, box-shadow 0.2s; }
.dash-box-chats .dash-btn-register:hover { box-shadow: 0 4px 12px rgba(5, 150, 105, 0.35); transform: translateY(-1px); }
.dash-box-chats .dash-msg-body { margin-right: 0; }
</style>

<div class="dash-box-chats float-left m-2 w-[26%] max-h-[600px] overflow-auto">
    <div class="dash-header sticky top-0 z-10">چت‌های در جریان</div>
    <ul class="p-2" style="list-style: none; margin: 0;">
        @foreach($groups as $groupId => $messages)
            @php $firstMessage = $messages->first(); @endphp
            <div class="dash-card">
                <div id="lightbox" class="lightbox"><span class="close">&times;</span><img class="lightbox-content"/></div>
                <div class="dash-card-head">
                    <img src="{{ $firstMessage->user->profile_image_path }}" class="dash-avatar" alt="">
                    <div class="dash-card-actions">
                        <button wire:click="deleteGroup('{{ $groupId }}')" class="dash-btn-icon" title="حذف گروه">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
                        </button>
                        <button onclick="copyChatGroupCodes('{{ $groupId }}', this)" class="dash-btn-icon copy" title="کپی کدهای این گروه">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M19 5H8a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h11a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2zm0 16H8V7h11v14z"></path>
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="dash-msg-body">
                    @foreach($messages as $message)
                        @php $isEmpty = preg_match('/:\s*-\s*$/', trim($message->code)); $hasNoColon = strpos($message->code, ':') === false; $count = $messageCounts[$message->code] ?? 0; @endphp
                        <li id="message-{{ $message->id }}" class="dash-msg-item">
                            <img src="{{ $message->image_url }}" alt="" class="gallery-img" style="border-radius: 6px;">
                            <p onclick="copyText(this)" class="chat-code chat-group-{{ $groupId }} dash-code-line">{{ trim(explode(':', $message->code)[0]) }}</p>
                            @if($count > 1)<span class="dash-time-badge">( {{ implode(' ، ', $messageTimesByCode[$message->code] ?? []) }} )</span>@endif
                            @if($isEmpty == 1 || $hasNoColon == true)
                                <div class="dash-code-btns">
                                    @foreach(['a','k','h','g','x','L', $message->question == '1' ? '👍' : null, $message->question == '1' ? '👎' : null] as $c)
                                        @if($c)
                                            @php $key = $message->id . ':' . $c; @endphp
                                            <button onclick="handleCodeClick(event,'{{ $c }}',{{ $message->id }})" class="dash-btn-code {{ in_array($key, $selectedCodes) ? 'selected' : '' }}">{{ $c }}</button>
                                        @endif
                                    @endforeach
                                    @if(!empty($message->buyer_name))<span class="dash-buyer-tag">{{ $message->buyer_name }}</span>@endif
                                </div>
                                <div class="dash-comment-price-row">
                                    @if($user->id == '1' || $user->id == '5')
                                        <input type="text" wire:model="comments.{{ $message->id }}" dir="rtl" wire:keydown.enter="submit_comment({{ $message->id }})" wire:ignore placeholder="کامنت" class="dash-comment-input">
                                    @endif
                                    <div class="dash-input-wrap">
                                        <input type="text" wire:model="prices.{{ $message->id }}" placeholder="قیمت" wire:ignore wire:keydown.enter="submit_answer({{ $message->id }})">
                                        <button type="button" wire:click="submit_answer({{ $message->id }})" class="dash-btn-submit"><span class="dash-submit-arrow">➤</span></button>
                                    </div>
                                </div>
                                @if(collect($selectedCodes)->contains(fn($v) => str_starts_with($v, $message->id . ':')))
                                    <button wire:click="submitSelectedCodes({{ $message->id }})" class="dash-btn-register">ثبت انتخاب‌ها</button>
                                @endif
                            @endif
                        </li>
                    @endforeach
                </div>
            </div>
        @endforeach
    </ul>
</div>
