@props(['groups', 'messageCounts', 'messageTimesByCode', 'selectedCodes', 'user'])

<style>
    /* باکس چت‌های در جریان */
    .dash-box-chats {
        direction: ltr;
        background: #fff;
        border-radius: 1rem;
        box-shadow: 0 4px 24px rgba(0, 0, 0, 0.06), 0 0 0 1px rgba(0, 0, 0, 0.04);
        overflow: auto;
    }

    .dash-box-chats .dash-header {
        background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
        color: #fff;
        padding: 0.75rem 1rem;
        font-weight: 700;
        text-align: center;
        font-size: 0.95rem;
        letter-spacing: 0.02em;
    }

    /* کارت هر گروه */
    .dash-box-chats .dash-card {
        background: #fafbfc;
        border-radius: 0.875rem;
        padding: 0;
        margin: 0 0.5rem 0.6rem;
        box-shadow: 0 1px 6px rgba(0, 0, 0, .2);
        border: 1px solid #e5e7eb;
        overflow: hidden;
    }

    .here-column-1 {
        .dash-box-chats .dash-card:last-child {
            margin-bottom: 0.5rem;
        }

        /* هدر کارت: آواتار + دکمه‌ها */

        .dash-card {
            display: flex;
            gap: 0.5rem; /* فاصله بین هدر و پیام‌ها */
        }

        .dash-card-head {
            background: #f1f5f9;
            padding: 5px;
        }

        .dash-card-actions {
            display: flex;
            flex-direction: column; /* دکمه‌ها زیر هم */
            gap: 0.25rem;
        }

        .dash-msg-body {
            flex: 1;
        }

    }

    .dash-box-chats .dash-avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        object-fit: cover;
        flex-shrink: 0;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .dash-box-chats .dash-card-actions {
        display: flex;
        align-items: center;
        gap: 0.2rem;
        margin-right: auto;
    }

    .dash-box-chats .dash-btn-icon {
        width: 32px;
        height: 32px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        color: #64748b;
        transition: background 0.2s, color 0.2s, transform 0.15s;
    }

    .dash-box-chats .dash-btn-icon:hover {
        background: rgba(239, 68, 68, 0.12);
        color: #dc2626;
        transform: scale(1.08);
    }

    .dash-box-chats .dash-btn-icon.copy:hover {
        background: rgba(34, 197, 94, 0.15);
        color: #16a34a;
    }

    /* هر پیام */
    .dash-box-chats .dash-msg-item {
        padding: 3px 5px;
        border-bottom: 1px solid #f1f5f9;
        font-size: 12px;
        background: #fff;
        transition: background 0.15s;
    }

    .dash-box-chats .dash-msg-item:last-child {
        border-bottom: none;
    }

    .dash-box-chats .dash-msg-item:hover {
        background: #fafbfc;
    }

    .dash-box-chats .dash-msg-item .gallery-img {
        max-height: 120px;
        width: auto;
        display: block;
        margin-bottom: 0.35rem;
        border-radius: 6px;
        cursor: pointer;
    }

    .dash-box-chats .dash-code-line {
        font-weight: 600;
        color: #334155;
        cursor: pointer;
        padding: 0;
    }

    .dash-box-chats .dash-code-line:hover {
        color: #1e40af;
    }

    .dash-box-chats .dash-time-badge {
        font-size: 10px;
        color: #94a3b8;
        margin-right: 0.35rem;
    }

    .edit-price-btn {
        background: none;
        border: none;
        font-size: 11px;
        cursor: pointer;
        margin-right: 4px;
        opacity: .6;
    }

    .edit-price-btn:hover {
        opacity: 1;
        transform: scale(1.1);
    }

    /* ردیف دکمه‌های کد */
    .dash-box-chats .dash-code-btns {
        display: flex;
        flex-wrap: wrap;
        gap: 0.35rem;
        margin-top: 0.1rem;
        align-items: center;
    }

    .dash-box-chats .dash-btn-code {
        padding: 3px 0 !important;
        border-radius: 0.5rem;
        font-size: 11px;
        font-weight: 600;
        transition: all 0.15s;
        min-width: 28px;
        text-align: center;
    }

    .dash-box-chats .dash-btn-code {
        background: #e0e7ff;
        color: #3730a3;
    }

    .dash-box-chats .dash-btn-code:hover {
        background: #c7d2fe;
        transform: translateY(-1px);
    }

    .dash-box-chats .dash-btn-code.selected {
        background: linear-gradient(135deg, #059669, #047857);
        color: #fff;
    }

    .dash-box-chats .dash-buyer-tag {
        font-size: 11px;
        color: #64748b;
        margin-right: 0.5rem;
    }

    /* ردیف کامنت + قیمت — یک ارتفاع، جمع‌وجور */
    .dash-box-chats .dash-comment-price-row {
        display: flex;
        align-items: stretch;
        gap: 0.4rem;
        margin-top: 0.4rem;
    }

    .dash-box-chats .dash-comment-input {
        width: 100%;
        max-width: 140px;
        height: 20px;
        padding: 0 0.5rem;
        font-size: 11px;
        border-radius: 0.4rem;
        background: #f8fafc;
        box-shadow: 0 0 0 1px #e2e8f0;
        box-sizing: border-box;
    }

    .dash-box-chats .dash-comment-input:focus {
        outline: none;
        box-shadow: 0 0 0 2px #3b82f6;
    }

    .dash-box-chats .dash-input-wrap {
        display: flex;
        flex: 1;
        min-width: 0;
        height: 20px;
        background: #f1f5f9;
        border-radius: 0.4rem;
        overflow: hidden;
        box-shadow: 0 0 0 1px #e2e8f0;
    }

    .dash-box-chats .dash-input-wrap input {
        font-size: 11px;
        flex: 1;
        min-width: 0;
        background: transparent;
        height: 100%;
    }

    .dash-box-chats .dash-input-wrap input::placeholder {
        color: #94a3b8;
    }

    .dash-box-chats .dash-btn-submit {
        padding: 0 0.5rem;
        font-size: 11px;
        font-weight: 700;
        background: linear-gradient(180deg, #2563eb, #1d4ed8);
        color: #fff;
        transition: opacity 0.2s, box-shadow 0.2s;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .dash-box-chats .dash-btn-submit:hover {
        opacity: 0.95;
        box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2);
    }

    .dash-box-chats .dash-btn-submit .dash-submit-arrow {
        display: inline-block;
        margin-top: 2px
    }

    /* دکمه ثبت انتخاب‌ها */
    .dash-box-chats .dash-btn-register {
        margin-top: 0.5rem;
        width: 100%;
        padding: 0.45rem;
        border-radius: 0.5rem;
        font-weight: 600;
        font-size: 12px;
        background: linear-gradient(180deg, #059669, #047857);
        color: #fff;
        transition: transform 0.1s, box-shadow 0.2s;
    }

    .dash-box-chats .dash-btn-register:hover {
        box-shadow: 0 4px 12px rgba(5, 150, 105, 0.35);
        transform: translateY(-1px);
    }

    .dash-box-chats .dash-msg-body {
        margin-right: 0;
    }
</style>

<div class="dash-box-chats float-left m-2 w-[28%] max-h overflow-auto here-column-1">
    <div class="dash-header sticky top-0 z-10">چت‌های در جریان</div>
    <ul class="p-2" style="list-style: none; margin: 0;">
        @foreach($groups as $groupId => $messages)
            @php $firstMessage = $messages->first(); @endphp
            <div class="dash-card">
                <div id="lightbox" class="lightbox"><span class="close">&times;</span><img class="lightbox-content"/>
                </div>
                <div class="dash-card-head">
                    <img src="{{ $firstMessage->user->profile_image_path }}" class="dash-avatar" alt="">
                    <div class="dash-card-actions">
                        <button wire:click="deleteGroup('{{ $groupId }}')" class="dash-btn-icon" title="حذف گروه">
                            <span wire:loading.remove wire:target="deleteGroup('{{ $groupId }}')" class="send-arrow">
                                 <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                      fill="none" stroke="currentColor" stroke-width="2"><path
                                         d="M3 6h18M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line
                                         x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
                            </span>

                            <span wire:loading wire:target="deleteGroup('{{ $groupId }}')"
                                  style="font-size:12px;">...</span>
                        </button>
                        <button onclick="copyChatGroupCodes('{{ $groupId }}', this)" class="dash-btn-icon copy"
                                title="کپی کدهای این گروه">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                 viewBox="0 0 24 24">
                                <path
                                    d="M19 5H8a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h11a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2zm0 16H8V7h11v14z"></path>
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="dash-msg-body">
                    @php $shownBuyerGroups = []; @endphp
                    @foreach($messages as $message)
                        @if(!empty($message->buyer_name) && !in_array($groupId, $shownBuyerGroups))
                            <span class="dash-buyer-tag float-right m-2">{{ $message->buyer_name }}</span>
                            @php $shownBuyerGroups[] = $groupId; @endphp

                        @endif
                        @php
                            $isEmpty = preg_match('/:\s*-\s*$/', trim($message->code));
                            $hasNoColon = strpos($message->code, ':') === false;
//                            $count = $messageCounts[$message->code] ?? 0;
                            $hasPrice = !$hasNoColon && !$isEmpty;
                            $parts = explode(':', $message->code);
                            $mainCode = trim($parts[0]);
                                $count = $messageCounts[$mainCode] ?? 0;
                             $times = $messageTimesByCode[$mainCode] ?? [];
                            @endphp
                        <li id="message-{{ $message->id }}" class="dash-msg-item" wire:key="message-{{ $message->id }}">
                            <img src="{{ $message->image_url }}" alt="" class="gallery-img" style="border-radius: 6px;">
                            <p onclick="copyText(this)"
                               class="chat-code chat-group-{{ $groupId }} dash-code-line inline-block">{{ trim($parts[0]) }}</p>
                            @if(isset($parts[1]) && trim($parts[1]) !== '')
                                : <p onclick="copyText(this)"
                                     class="chat-code  chat-group-{{ $groupId }} dash-code-line inline-block"
                                     style="color: #aaa">
                                    {{ trim($parts[1]) }}
                                </p>
                            @endif
                            @if($hasPrice)
                                <button
                                    onclick="toggleEditBox({{ $message->id }})"
                                    class="edit-price-btn"
                                    title="ویرایش قیمت">
                                    ✏️
                                </button>
                            @endif

                            <div id="edit-box-{{ $message->id }}" class="edit-price-box" style="display:none;"
                                 wire:ignore>
                                <div class="dash-code-btns">
                                    @foreach(['a','k','h','g','x','L', $message->question == '1' ? '👍' : null, $message->question == '1' ? '👎' : null] as $c)
                                        @if($c)
                                            @php $key = $message->id . ':' . $c; @endphp
                                            <button onclick="handleCodeClick(event,'{{ $c }}',{{ $message->id }})"
                                                    style="{{$c=='x'? 'margin-left: 10px' : ''}}"
                                                    class="dash-btn-code {{ in_array($key, $selectedCodes) ? 'selected' : '' }}">{{ $c }}</button>
                                        @endif
                                    @endforeach
                                </div>
                                <div class="dash-comment-price-row">
                                    <input type="text" wire:model.debounce.500ms="comments.{{ $message->id }}" dir="rtl"
                                           wire:keydown.enter="submit_comment({{ $message->id }})"
                                           placeholder="کامنت" class="dash-comment-input">
                                    <div class="dash-input-wrap">
{{--                                        @if(isset($parts[1]) && trim($parts[1]) !== '')--}}
{{--                                            @php--}}
{{--                                            $inputPricevalue = trim($parts[1]);--}}
{{--                                            @endphp--}}
{{--                                        @endif--}}
                                        <input type="text" wire:model.debounce.500ms="prices.{{ $message->id }}"
                                               wire:keydown.enter="submit_answer({{ $message->id }})">
                                        <button type="button" wire:click="submit_answer({{ $message->id }})"
                                                class="dash-btn-submit"><span class="dash-submit-arrow">
                                                            <span wire:loading.remove
                                                                  wire:target="submit_answer({{ $message->id }})"
                                                                  class="send-arrow">➤</span>

                                                <span wire:loading wire:target="submit_answer({{ $message->id }})"
                                                      style="font-size:12px;">...</span>
                                                </span></button>
                                    </div>
                                </div>
                                @if(collect($selectedCodes)->contains(fn($v) => str_starts_with($v, $message->id . ':')))
                                    <button wire:click="submitSelectedCodes({{ $message->id }})"
                                            class="dash-btn-register">ثبت انتخاب‌ها
                                    </button>
                                @endif
                            </div>

                            @if($count > 1)
                                {{$times[0] = ''}}
                                <span class="dash-time-badge">( {{ implode(' ، ', $times) }} )</span>
                            @endif

                        @if($isEmpty == 1 || $hasNoColon == true)
                                <div class="dash-code-btns">
                                    @foreach(['a','k','h','g','x','L', $message->question == '1' ? '👍' : null, $message->question == '1' ? '👎' : null] as $c)
                                        @if($c)
                                            @php $key = $message->id . ':' . $c; @endphp
                                            <button onclick="handleCodeClick(event,'{{ $c }}',{{ $message->id }})"
                                                    style="{{$c=='x'? 'margin-left: 10px' : ''}}"
                                                    class="dash-btn-code {{ in_array($key, $selectedCodes) ? 'selected' : '' }}">{{ $c }}</button>
                                        @endif
                                    @endforeach
                                </div>
                                <div class="dash-comment-price-row">
                                    <input type="text" wire:model.debounce.500ms="comments.{{ $message->id }}" dir="rtl"
                                           wire:keydown.enter="submit_comment({{ $message->id }})"
                                           placeholder="کامنت" class="dash-comment-input">
                                    <div class="dash-input-wrap">
                                        <input type="text" wire:model.debounce.500ms="prices.{{ $message->id }}"
                                               placeholder="قیمت"
                                               wire:keydown.enter="submit_answer({{ $message->id }})">
                                        <button type="button" wire:click="submit_answer({{ $message->id }})"
                                                class="dash-btn-submit"><span class="dash-submit-arrow">
                                                            <span wire:loading.remove
                                                                  wire:target="submit_answer({{ $message->id }})"
                                                                  class="send-arrow">➤</span>

                                                <span wire:loading wire:target="submit_answer({{ $message->id }})"
                                                      style="font-size:12px;">...</span>
                                                </span></button>
                                    </div>
                                </div>
                                @if(collect($selectedCodes)->contains(fn($v) => str_starts_with($v, $message->id . ':')))
                                    <button wire:click="submitSelectedCodes({{ $message->id }})"
                                            class="dash-btn-register">ثبت انتخاب‌ها
                                    </button>
                                @endif
                            @endif
                        </li>
                    @endforeach
                </div>
            </div>
        @endforeach
    </ul>

    <script>
        function toggleEditBox(id){
            let box = document.getElementById('edit-box-' + id);
            if(!box) return;

            if(box.style.display === 'none' || box.style.display === ''){
                box.style.display = 'block';
            } else {
                box.style.display = 'none';
            }
        }
    </script>


</div>
