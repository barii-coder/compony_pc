@props(['answersGrouped', 'groupReadyForCheck', 'user'])

<style>
    .dash-box-pending {
        direction: ltr;
        background: #fff;
        border-radius: 1rem;
        box-shadow: 0 4px 24px rgba(0, 0, 0, 0.06), 0 0 0 1px rgba(0, 0, 0, 0.04);
        overflow: auto;
    }

    .dash-box-pending .dash-header {
        background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
        color: #fff;
        padding: 0.5rem 0.75rem;
        font-weight: 700;
        text-align: center;
        font-size: 0.85rem;
    }

    .dash-group-card {
        display: flex;
        gap: 0.5rem;
    }

    .dash-group-head {
        flex-shrink: 0;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.5rem;
    }

    .dash-group-actions {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }

    .dash-box-pending .dash-group-card {
        background: #fafbfc;
        border-radius: 0.875rem;
        padding: 0;
        margin: 0.5rem;
        box-shadow: 0 2px 10px rgba(0, 0, 0, .2);
        border: 1px solid #e5e7eb;
        overflow: hidden;
    }

    .dash-box-pending .dash-group-head {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 0.6rem;
        background: #f1f5f9;
        border-bottom: 1px solid #e5e7eb;
    }

    .dash-box-pending .dash-avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        object-fit: cover;
        flex-shrink: 0;
        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.08);
    }

    .dash-box-pending .dash-group-actions {
        display: flex;
        align-items: center;
        gap: 0.25rem;
        margin-right: auto;
    }

    .dash-box-pending .dash-btn-icon {
        width: 34px;
        height: 34px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        color: #64748b;
        transition: background 0.2s, color 0.2s, transform 0.1s;
    }

    .dash-box-pending .dash-btn-icon:hover {
        transform: scale(1.06);
    }

    .dash-box-pending .dash-btn-icon.green:hover {
        background: rgba(34, 197, 94, 0.15);
        color: #16a34a;
    }

    .dash-box-pending .dash-btn-icon.red:hover {
        background: rgba(239, 68, 68, 0.12);
        color: #dc2626;
    }

    .dash-box-pending .dash-answer-item {
        padding: 2px;
        border-bottom: 1px solid #f1f5f9;
        transition: background 0.15s;
        font-size: 12px;
    }

    .dash-box-pending .dash-answer-item:last-child {
        border-bottom: none;
    }

    .dash-box-pending .dash-answer-item:hover {
        background: #fafbfc;
    }

    .dash-box-pending .dash-answer-item .gallery-img {
        max-height: 100px;
        width: auto;
        border-radius: 6px;
        display: block;
        margin-bottom: 0.35rem;
        cursor: pointer;
    }

    .dash-box-pending .dash-code-tag {
        display: inline-block;
        padding: 3px;
        vertical-align: middle;
        border-radius: 0.375rem;
        background: #f1f5f9;
        font-weight: 600;
        color: #334155;
        font-size: 12px;
        cursor: pointer;
        transition: background 0.2s, color 0.2s;
    }

    .dash-box-pending .dash-code-tag:hover {
        background: #e0e7ff;
        color: #1e40af;
    }

    .dash-box-pending .dash-badge {
        display: inline-flex;
        padding: 0.3rem 0.6rem;
        vertical-align: middle;
        border-radius: 0.5rem;
        font-size: 11px;
        font-weight: 600;
    }

    .dash-box-pending .dash-badge-blue {
        background: linear-gradient(180deg, #3b82f6, #2563eb);
        color: #fff;
    }

    .dash-box-pending .dash-badge-green {
        background: linear-gradient(180deg, #22c55e, #16a34a);
        color: #fff;
    }

    .dash-box-pending .dash-badge-amber {
        background: #fef3c7;
        color: #92400e;
        padding: 0.25rem 0.5rem;
        border-radius: 0.375rem;
        font-size: 11px;
    }

    .dash-box-pending .dash-btn-action {
        padding: 5px 0.3rem;
        vertical-align: middle;
        border-radius: 0.5rem;
        font-size: 11px;
        font-weight: 600;
        transition: transform 0.1s, box-shadow 0.2s;
    }

    .dash-box-pending .dash-btn-action.blue {
        background: linear-gradient(180deg, #3b82f6, #2563eb);
        color: #fff;
    }

    .dash-box-pending .dash-btn-action.blue:hover {
        box-shadow: 0 3px 10px rgba(59, 130, 246, 0.35);
        transform: translateY(-1px);
    }

    .dash-box-pending .dash-btn-action.red {
        background: linear-gradient(180deg, #ef4444, #dc2626);
        color: #fff;
        font-size: 10px;
        padding: 0.25rem 0.5rem;
    }

    .dash-box-pending .dash-respondent {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        font-size: 11px;
        color: #64748b;
    }

    .dash-box-pending .dash-respondent img {
        width: 28px;
        height: 28px;
        border-radius: 0.5rem;
        object-fit: cover;
        box-shadow: 0 0 0 1px #fff;
    }

    .dash-box-pending .dash-group-head {
        display: grid;
        align-items: center;
        row-gap: 6px;
    }

    .dash-box-pending .dash-group-head > button:first-of-type {
        grid-column: 2;
        grid-row: 1;
        justify-self: center;
    }

    .dash-box-pending .dash-avatar {
        grid-column: 1;
        grid-row: 2;
        justify-self: start;
    }

    .dash-box-pending .dash-group-head > div:nth-of-type(1) {
        display: contents; /* اجازه بده دکمه‌ها جداگانه گرید بگیرن */
    }

    .dash-box-pending .dash-group-head > div:nth-of-type(1) button:nth-child(1) {
        grid-column: 2;
        grid-row: 2;
        justify-self: end;
    }

    .dash-box-pending .dash-group-head > div:nth-of-type(1) button:nth-child(2) {
        grid-column: 2;
        grid-row: 3;
        justify-self: end;
    }

    .dash-box-pending .dash-group-actions {
        grid-column: 1;
        grid-row: 3;
        justify-self: start;
    }

</style>

<div class="dash-box-pending float-left m-2 w-[28%] max-h overflow-auto">
    <div class="dash-header sticky top-0 z-10">منتظر بررسی</div>
    <ul class="p-2" style="list-style: none; margin: 0;">
        @foreach($answersGrouped as $groupId => $groupAnswers)
            @php $firstAnswer = $groupAnswers->first(); @endphp
            <li class="dash-group-card">
                <div class="dash-group-head">
                    @if($user->id == $firstAnswer->message->user_id && ($groupReadyForCheck[$groupId] ?? false))
                        <button onclick="hideMessage({{ $firstAnswer->message->id }})"
                                wire:click="checkAll('{{ $groupId }}')" class="dash-btn-icon" title="تایید کل">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                 fill="none" stroke="#16a34a" stroke-width="2.5" stroke-linecap="round"
                                 stroke-linejoin="round">
                                <path d="M20 6L9 17l-5-5"/>
                            </svg>
                        </button>
                    @endif
                    <img src="{{ $firstAnswer->message->user->profile_image_path }}" class="dash-avatar" alt="">
                        <div class="">
                            <button onclick="copyGroupCodes('{{ $groupId }}', this)"
                                    class="dash-btn-icon green copy-btn" title="کپی کلی">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                     viewBox="0 0 24 24">
                                    <path
                                        d="M16 1H4a2 2 0 0 0-2 2v12h2V3h12V1zm3 4H8a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h11a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2zm0 16H8V7h11v14z"/>
                                </svg>
                            </button>
                            <button onclick="copyOnlyCodes('{{ $groupId }}', this)" class="dash-btn-icon green copy-btn"
                                    title="کپی کد ها">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                     viewBox="0 0 24 24">
                                    <path
                                        d="M19 5H8a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h11a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2zm0 16H8V7h11v14z"></path>
                                </svg>
                            </button>
                        </div>
                    <div class="dash-group-actions">
                        <button wire:click="back('{{ $groupId }}')" class="dash-btn-icon red" title="برگشت">
                            <span wire:loading.remove wire:target="back('{{ $groupId }}')" class="send-arrow">
                                 <svg xmlns="http://www.w3.org/2000/svg" width="25" height="24" fill="none"
                                      stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                      stroke-linejoin="round"><path d="M20 12H4M10 6l-6 6 6 6"/></svg>
                            </span>

                            <span wire:loading wire:target="back('{{ $groupId }}')" style="font-size:12px;">...</span>
                        </button>

                    </div>
                </div>
                <div class="p-1 w-full">
                    @foreach($groupAnswers as $answer)
                        <div class="dash-answer-item" wire:key="answer-{{ $answer->id }}">
                            <img src="{{ $answer->message->image_url }}" alt="" class="gallery-img">
                            <p onclick="copyText(this)" class=" group-code mr-1 group-{{ $groupId }} dash-code-tag"
                               data-price="{{ $answer->price }}">{{ trim(explode(':', $answer->message->code)[0]) }}</p>
                            @if($answer->comment && $answer->price == null)
                                <span class="dash-badge-amber middle inline-block ml-2">{{ $answer->comment }}</span>
                                @if($answer->respondent_id == null)
                                    <button wire:click="i_had_it({{ $answer->message->id }})"
                                            class="dash-btn-action blue">
                                        <span wire:loading.remove wire:target="i_had_it({{ $answer->message->id }})"
                                              class="send-arrow">من برداشتم</span>

                                        <span wire:loading wire:target="i_had_it({{ $answer->message->id }})"
                                              style="font-size:12px;">...</span>
                                    </button>
                                @endif
                            @elseif($answer->comment && $answer->price != null)
                                <span class="dash-badge-amber middle inline-block ml-2">{{ $answer->comment }}</span>
                            @endif
                            @if($answer->price != 'x' && $answer->price != 'L')
                                @if($answer->respondent_by_code == 1)
                                    @if($answer->price != null)
                                        <span class="dash-badge ml-1 dash-badge-blue middle">{{ $answer->price }}</span>
                                    @endif
                                @elseif($answer->respondent_by_code == 0)
                                    @if($answer->price != null)
                                        <span class="dash-badge dash-badge-green">{{ $answer->price }}</span>
                                    @endif
                                @else
                                    <span class="dash-badge dash-badge-green">{{ $answer->price }}</span>
                                @endif
                            @endif
                            @if($answer->respondent_by_code && $answer->respondent_id)
                                <div class="dash-respondent mt-1 inline-block float-right">
                                    <img src="{{ $answer->respondent_profile_image_path }}" alt=""
                                         class="middle inline-block">
                                    <span
                                        class="middle">{{ $answer->updated_at->diffForHumans(['short' => true, 'syntax' => \Carbon\CarbonInterface::DIFF_ABSOLUTE, 'parts' => 1]) }}</span>
                                    @if($user->id == $answer->respondent_id)
                                        <button wire:click="save_for_ad_price({{ $answer->message->id }})"
                                                class="dash-btn-action blue">
                                            <span wire:loading.remove
                                                  wire:target="save_for_ad_price({{ $answer->message->id }})"
                                                  class="send-arrow">➜</span>

                                            <span wire:loading
                                                  wire:target="save_for_ad_price({{ $answer->message->id }})"
                                                  style="font-size:12px;">...</span>
                                        </button>
                                        <button wire:click="its_unavailable_on_column_2({{ $answer->message->id }})"
                                                class="dash-btn-action red">
                                            <span wire:loading.remove
                                                  wire:target="its_unavailable_on_column_2({{ $answer->message->id }})"
                                                  class="send-arrow">X</span>

                                            <span wire:loading
                                                  wire:target="its_unavailable_on_column_2({{ $answer->message->id }})"
                                                  style="font-size:12px;">...</span>
                                        </button>
                                    @endif
                                </div>
                            @elseif($answer->respondent_by_code && !$answer->respondent_id)
                                <div class="float-right">
                                    @if($answer->price == 'x')
                                        <span class="dash-btn-action red">محصول نا موجود</span>
                                    @elseif($answer->price === 'n')
                                        <span class="dash-btn-action red">خوب نیست</span>
                                    @elseif($answer->price === 'L')
                                        <span class="text-slate-500 text-xs">آخرین قیمت سیستم رو بدید</span>
                                    @else
                                        @if($answer->price != '👎' && $answer->price != '👍' && $answer->price != null)
                                            <button wire:click="i_had_it({{ $answer->message->id }})"
                                                    class="dash-btn-action blue">
                                                <span wire:loading.remove
                                                      wire:target="i_had_it({{ $answer->message->id }})"
                                                      class="send-arrow">من برداشتم</span>

                                                <span wire:loading wire:target="i_had_it({{ $answer->message->id }})"
                                                      style="font-size:12px;">...</span>
                                            </button>
                                        @endif
                                    @endif
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </li>
        @endforeach
    </ul>
</div>
