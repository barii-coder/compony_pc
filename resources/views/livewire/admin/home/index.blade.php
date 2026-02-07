<div class="w-full" style="margin: 0 10px" wire:poll.100ms>
    <div style="width: 1px;height: 1px;background: #f00"></div>
    <div class="lightbox" wire:ignore>
        <span class="close">&times;</span>
        <img class="lightbox-content" id="lightbox-img"/>
    </div>

    @error('prices')
    <div class="w-full max-w-md mx-auto">
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 text-center rounded relative">
            <strong class="font-bold">خطا! </strong>
            <span>{{ $message }}</span>
        </div>
    </div>
    @enderror
    @error('access')
    <div class="w-full max-w-md mx-auto">
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 text-center rounded relative">
            <strong class="font-bold">خطا! </strong>
            <span>{{ $message }}</span>
        </div>
    </div>
    @enderror

    <div class="bg-gray-300 rounded-2xl float-left m-2 w-[26%] max-h-[600px] overflow-auto">

        {{-- هدر --}}
        <div class="bg-blue-600 text-white p-2 font-bold text-center sticky top-0 z-10 rounded-t-2xl">
            چت‌های در جریان
        </div>

        <ul class="text-[13px] space-y-2 p-1">

            @foreach($groups as $groupId => $messages)

                @php
                    $firstMessage = $messages->first();
                @endphp

                {{-- گروه --}}
                <div class="bg-white rounded-lg p-2 border border-gray-300">

                    <div id="lightbox" class="lightbox">
                        <span class="close">&times;</span>
                        <img class="lightbox-content"/>
                    </div>
                    {{-- هدر گروه --}}
                    <div class="inline-block float-left">
                        <img src="{{ $firstMessage->user->profile_image_path }}"
                             class="w-6 h-6 rounded-full ">
                        <button
                            {{--                            onclick="hideMessage({{ $firstAnswer->message->id }})"--}}
                            wire:click="deleteGroup('{{ $groupId }}')"
                            class="p-1 rounded-full hover:bg-red-500/20 transition"
                            title="حذف گروه">
                            <svg xmlns="http://www.w3.org/2000/svg" shape-rendering="geometricPrecision" width="18"
                                 text-rendering="geometricPrecision" image-rendering="optimizeQuality"
                                 fill-rule="evenodd" clip-rule="evenodd" viewBox="0 0 456 511.82">
                                <path fill="#FD3B3B"
                                      d="M48.42 140.13h361.99c17.36 0 29.82 9.78 28.08 28.17l-30.73 317.1c-1.23 13.36-8.99 26.42-25.3 26.42H76.34c-13.63-.73-23.74-9.75-25.09-24.14L20.79 168.99c-1.74-18.38 9.75-28.86 27.63-28.86zM24.49 38.15h136.47V28.1c0-15.94 10.2-28.1 27.02-28.1h81.28c17.3 0 27.65 11.77 27.65 28.01v10.14h138.66c.57 0 1.11.07 1.68.13 10.23.93 18.15 9.02 18.69 19.22.03.79.06 1.39.06 2.17v42.76c0 5.99-4.73 10.89-10.62 11.19-.54 0-1.09.03-1.63.03H11.22c-5.92 0-10.77-4.6-11.19-10.38 0-.72-.03-1.47-.03-2.23v-39.5c0-10.93 4.21-20.71 16.82-23.02 2.53-.45 5.09-.37 7.67-.37zm83.78 208.38c-.51-10.17 8.21-18.83 19.53-19.31 11.31-.49 20.94 7.4 21.45 17.57l8.7 160.62c.51 10.18-8.22 18.84-19.53 19.32-11.32.48-20.94-7.4-21.46-17.57l-8.69-160.63zm201.7-1.74c.51-10.17 10.14-18.06 21.45-17.57 11.32.48 20.04 9.14 19.53 19.31l-8.66 160.63c-.52 10.17-10.14 18.05-21.46 17.57-11.31-.48-20.04-9.14-19.53-19.32l8.67-160.62zm-102.94.87c0-10.23 9.23-18.53 20.58-18.53 11.34 0 20.58 8.3 20.58 18.53v160.63c0 10.23-9.24 18.53-20.58 18.53-11.35 0-20.58-8.3-20.58-18.53V245.66z"/>
                            </svg>
                        </button>
                        <button onclick="copyChatGroupCodes('{{ $groupId }}', this)"
                                class="p-1 block rounded-full hover:bg-green-500/20 transition"
                                title="کپی کدهای این گروه">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 width="18"
                                 height="18"
                                 viewBox="0 0 24 24"
                                 fill="none"
                                 stroke="#000"
                                 stroke-width="2"
                                 stroke-linecap="round"
                                 stroke-linejoin="round">
                                <rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect>
                                <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>
                            </svg>
                        </button>

                    </div>

                    {{-- پیام‌ها --}}
                    <div class="w-[96%] min-h-[80px]">

                        @foreach($messages as $message)

                            @php
                                $isEmpty = preg_match('/:\s*-\s*$/', trim($message->code));
                                $hasNoColon = strpos($message->code, ':') === false;
                            @endphp

                            <li id="message-{{ $message->id }}"
                                class="px-10 border-b last:border-b-0  m-1 " style="border-bottom: 1px solid #eee!important;">

                                @php
                                    $count = $messageCounts[$message->code] ?? 0;
                                @endphp
                                <img src="{{$message->image_url}}" alt="" class="gallery-img"
                                     style="width: 100%;border-radius: 0">
                                <p onclick="copyText(this)"
                                   class="chat-code chat-group-{{ $groupId }} inline-block text-xs font-semibold text-slate-600 cursor-pointer leading-none">
                                    {{ trim(explode(':', $message->code)[0]) }}
                                </p>
                                @if($count > 1)
                                    {{--                                        <span class="text-red-500">*</span>--}}

                                    <span class="text-gray-400 text-[10px] ml-1">
            (
            {{ implode(' , ', $messageTimesByCode[$message->code] ?? []) }}
            )
        </span>
                                @endif

                                @if($isEmpty == 1 or $hasNoColon == true)

                                    {{-- دکمه‌های کد --}}
                                    <div class="inline-block gap-1 mt-1 flex-wrap">
                                        @foreach(['a','k','h','g','x','L', $message->question == '1' ? '👍' : null,$message->question == '1' ? '👎' : null,] as $c)
                                            @php $key = $message->id . ':' . $c; @endphp
                                            <button
                                                onclick="handleCodeClick(event,'{{ $c }}',{{ $message->id }})"
                                                style="{{$c == 'x' ? 'margin-left:5px' : ''}}"
                                                class="px-2 rounded text-[12px]
                                            {{ in_array($key,$selectedCodes)
                                                ? 'bg-green-600 text-white'
                                                : 'bg-blue-600 text-white hover:bg-blue-700' }}">
                                                {{ $c }}
                                            </button>
                                        @endforeach
                                        {{@$message->buyer_name}}
                                    </div>

                                    {{-- کامنت --}}
                                    @if($user->id == '1' or $user->id == '5')
                                        <input type="text"
                                               wire:model="comments.{{ $message->id }}"
                                               dir="rtl"
                                               wire:keydown.enter="submit_comment({{ $message->id }})"
                                               wire:ignore
                                               placeholder="کامنت"
                                               class="mt-1 w-[45%] float-right bg-gray-100 rounded px-1 py-0.5">
                                    @endif
                                    {{-- قیمت --}}
                                    <div class="flex mt-2 bg-gray-100 rounded overflow-hidden">
                                        <input type="text"
                                               wire:model="prices.{{ $message->id }}"
                                               placeholder="قیمت"
                                               wire:ignore
                                               wire:keydown.enter="submit_answer({{ $message->id }})"
                                               class="flex-1 bg-transparent px-1 py-0.5">
                                        <button
                                            wire:click="submit_answer({{ $message->id }})"
                                            class="px-2 bg-blue-600 text-white text-[9px]">
                                            ➤
                                        </button>
                                    </div>
                                    {{-- ثبت انتخاب --}}
                                    @if(collect($selectedCodes)->contains(fn($v)=>str_starts_with($v,$message->id.':')))
                                        <button
                                            wire:click="submitSelectedCodes({{ $message->id }})"
                                            class="mt-1 w-full bg-green-600 text-white py-0.5 rounded">
                                            ثبت
                                        </button>
                                    @endif

                                @endif
                            </li>
                        @endforeach

                    </div>

                </div>
            @endforeach

        </ul>
    </div>

    <div
        class="bg-gray-300 rounded-2xl float-left m-2 w-[26%] max-h-[600px] overflow-auto shadow-lg border border-slate-200">
        <div class="bg-gradient-to-r  bg-blue-600 text-white p-2 font-bold text-center sticky top-0 z-10">
            منتظر بررسی
        </div>

        <ul class="text-sm p-1">

            @foreach($answersGrouped as $groupId => $groupAnswers)
                <li class=" rounded-2xl shadow-sm m-1 border border-slate-700">

                    @php
                        $firstAnswer = $groupAnswers->first();
                    @endphp

                    <div class="bg-gray-100 rounded-2xl p-1 w-[100%] shadow-sm border border-slate-700 float-right mb-1">

                        <ul class="">

                            <div class="inline-block">
                                @if(
    $user->id == $firstAnswer->message->user_id &&
    ($groupReadyForCheck[$groupId] ?? false)
    )
                                    <button
                                        onclick="hideMessage({{ $firstAnswer->message->id }})"
                                        wire:click="checkAll('{{ $groupId }}')"
                                        class="p-2 rounded-full hover:bg-green-600/30 transition"
                                        title="تایید کل">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                             viewBox="0 0 24 24"
                                             fill="none" stroke="black" stroke-width="3"
                                             stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M20 6L9 17l-5-5"/>
                                        </svg>
                                    </button>
                                @endif
                                <img
                                    src="{{ $firstAnswer->message->user->profile_image_path }}"
                                    class="w-8 h-8 rounded-xl ring-2 m-1 ring-white shadow block"
                                    alt=""
                                >
                                <button
                                    {{--onclick="hideMessage({{ $firstAnswer->message->id }})"--}}
                                    wire:click="back('{{ $groupId }}')"
                                    class="p-2 ms-1 rounded-full hover:bg-red-500/20 transition"
                                    title="برگشت">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none">
                                        <path d="M20 12H4M10 6l-6 6 6 6"
                                              stroke="black" stroke-width="2"
                                              stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </button>
                                <button onclick="copyGroupCodes('{{ $groupId }}', this)"
                                        class="copy-btn p-2 m-1 rounded-full block hover:bg-green-500/20 transition"
                                        title="کپی کلی">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="#000"
                                         viewBox="0 0 24 24">
                                        <path
                                            d="M16 1H4a2 2 0 0 0-2 2v12h2V3h12V1zm3 4H8a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h11a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2zm0 16H8V7h11v14z"/>
                                    </svg>
                                </button>
                                <button onclick="copyOnlyCodes('{{ $groupId }}', this)"
                                        class="copy-btn m-1 p-1 rounded-full block hover:bg-green-500/20 transition"
                                        title="کپی کد ها">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                         width="24"
                                         height="24"
                                         viewBox="0 0 24 24"
                                         fill="none"
                                         stroke="currentColor"
                                         stroke-width="2"
                                         stroke-linecap="round"
                                         stroke-linejoin="round">
                                        <rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect>
                                        <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>
                                    </svg>
                                </button>
                            </div>
                            <div class="float-right w-[90%]">
                                @foreach($groupAnswers as $answer)
                                    <li
                                        class="rounded-xl hover:bg-slate-100 transition-all duration-200 p-1 "
                                        wire:key="answer-{{ $answer->id }}">
                                        <div class="inline-block mt-1">
                                <span
                                    class="inline-block  text-slate-500 rounded-2xl cursor-pointer ">
                                    {{--<p onclick="copyText(this)"--}}
                                    {{--                                       class="group-code group-{{ $groupId }} inline-block text-xs font-semibold text-slate-600 cursor-pointer leading-none">--}}
                                    {{--                                            {{ trim(explode(':', $answer->message->code)[0]) }}--}}
                                    {{--                                    </p>--}}
                                     <img src="{{$answer->message->image_url}}" alt="" class="gallery-img"
                                          style="width: 100%;border-radius: 0">
<p onclick="copyText(this)"
   class="group-code group-{{ $groupId }} inline-block text-xs float-left font-semibold text-slate-600 cursor-pointer leading-none"
   data-price="{{ $answer->price }}">
    {{ trim(explode(':', $answer->message->code)[0]) }}
</p>
                                </span>
                                            @if($answer->comment and $answer->price == null)
                                                <span
                                                    class="inline-block ml-2 px-3 py-1 bg-amber-100 text-amber-800 rounded-xl text-xs shadow-sm">
                                        {{ $answer->comment }}
                                            </span>

                                                @if($answer->respondent_id == null)
                                                    <div class="float-right">
                                                        <button
                                                            wire:click="i_had_it({{ $answer->message->id }})"
                                                            class="px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl float-right shadow transition">
                                                            من برداشتم
                                                        </button>
                                                    </div>
                                                @endif
                                            @elseif($answer->comment and $answer->price != null)
                                                <span
                                                    class="inline-block ml-2 px-3 py-1 bg-amber-100 text-amber-800 rounded-xl text-xs shadow-sm">
                                        {{ $answer->comment }}
                                            </span>
                                            @endif
                                        </div>

                                        {{-- قیمت --}}
                                        @if($answer->price == 'x' or $answer->price == 'L')

                                        @else
                                            @if($answer->respondent_by_code == 1)
                                                @if($answer->price != null)
                                                    <span
                                                        class="inline-flex px-4 py-1.5 bg-blue-500 text-white rounded-full text-xs shadow">
                                        {{ $answer->price }}
                                    </span>
                                                @endif
                                            @elseif($answer->respondent_by_code == 0)
                                                @if($answer->price != null)
                                                    <span
                                                        class="inline-flex px-4 py-1.5 bg-green-500 text-white rounded-full text-xs shadow float-right">
                                        {{ $answer->price }}
                                    </span>
                                                @endif
                                            @else
                                                <span
                                                    class="inline-flex px-4 py-1.5 bg-green-500 text-white rounded-full text-xs shadow">
                                        {{ $answer->price }}
                                    </span>
                                            @endif
                                        @endif

                                        {{-- دکمه‌ها (کاملاً دست‌نخورده) --}}
                                        @if($answer->respondent_by_code)
                                            @if($answer->respondent_id)
                                                <div class="float-right" style="margin: -3px">
                                                    @if($user->id == $answer->respondent_id)
                                                        <button
                                                            wire:click="save_for_ad_price({{ $answer->message->id }})"
                                                            class="px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl float-right shadow transition">
                                                            ➜
                                                        </button>

                                                        <button
                                                            wire:click="its_unavailable_on_column_2({{ $answer->message->id }})"
                                                            class="px-3 py-1.5 mx-1 bg-red-600 hover:bg-red-700 text-white rounded-xl float-right shadow transition">
                                                            X
                                                        </button>
                                                    @endif
                                                    <span class="m-1 float-right">
                                        <img width="30px"
                                             class="rounded-xl inline-block ring-2 ring-white shadow"
                                             src="{{$answer->respondent_profile_image_path}}">
                                                    <p class="inline-block">
{{ $answer->updated_at->diffForHumans(['short' => true, 'syntax' => \Carbon\CarbonInterface::DIFF_ABSOLUTE, 'parts' => 1]) }}
                                                    </p>
                                    </span>
                                                </div>
                                            @else
                                                @if($answer->price == 'x')
                                                    <div class="text-left inline-block middle">
                                            <span
                                                class="px-3 py-1.5 bg-red-500 text-white rounded-xl float-left text-xs shadow">
                                            محصول نا موجود
                                            </span></div>
                                                @elseif($answer->price === 'n')
                                                    <div class="float-right">
                                                <span
                                                    class="px-3 py-1.5 bg-red-500 text-white rounded-xl float-right text-xs shadow">
                                            خوب نیست
                                        </span>
                                                    </div>
                                                @elseif($answer->price === 'L')
                                                    <div class="float-right">
                                            <span
                                                class="px-3 py-1.5  text-white rounded-xl float-right text-xs shadow">
                                            آخرین قیمت سیستم رو بدید
                                        </span>
                                                    </div>
                                                @else

                                                    @if($answer->price == '👎' or $answer->price == '👍')

                                                    @else
                                                        @if($answer->price != null)
                                                            <div class="float-right">
                                                                <button
                                                                    wire:click="i_had_it({{ $answer->message->id }})"
                                                                    class="px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl float-right shadow transition">
                                                                    من برداشتم
                                                                </button>
                                                            </div>
                                                        @endif
                                                    @endif

                                                @endif
                                            @endif
                                        @else
                                        @endif

                                    </li>
                                @endforeach
                            </div>
                        </ul>

                    </div>

            @endforeach

        </ul>
    </div>

    <div class="bg-gray-200 rounded-2xl float-left m-2 w-[26%] max-h-[600px] overflow-auto">
        <!-- هدر ستون -->
        <div class="bg-blue-600 text-white p-2 rounded-t-2xl font-bold text-center sticky top-0 z-10">
            منتظر قیمت
        </div>

        <ul class="space-y-2 text-sm p-2">
            {{-- گروه‌بندی بر اساس group_id --}}
            @foreach($wait_for_price->groupBy('group_id') as $groupId => $groupMessages)
                <li class="bg-white rounded-2xl shadow-sm border border-slate-700 p-2 group group-{{ $groupId }}">

                    {{-- هدر گروه --}}
                    @php $firstMessage = $groupMessages->first(); @endphp
                    <div class="flex items-center justify-between mb-2">
                        <div class="flex items-center gap-2">
                            <img width="30px" class="rounded-2xl" src="{{ $firstMessage->user->profile_image_path }}"
                                 alt="">
                        </div>

                        <div class="flex gap-1">
                            {{--                            <button onclick="copyGroupData('{{ $groupId }}', this, 'all')"--}}
                            {{--                                    class="px-2 py-1 rounded-xl bg-blue-600 text-white hover:bg-blue-700 transition"--}}
                            {{--                                    title="کپی کد + قیمت">--}}
                            {{--                                کپی همه--}}
                            {{--                            </button>--}}
                            <button onclick="copyGroupData('{{ $groupId }}', this, 'codes')"
                                    class="px-2 py-1 rounded-xl bg-green-500 text-white hover:bg-green-600 transition"
                                    title="کپی فقط کدها">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                     width="24"
                                     height="24"
                                     viewBox="0 0 24 24"
                                     fill="none"
                                     stroke="currentColor"
                                     stroke-width="2"
                                     stroke-linecap="round"
                                     stroke-linejoin="round">
                                    <rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect>
                                    <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    {{-- پیام‌ها --}}
                    @foreach($groupMessages as $message)
                        <div
                            class="mt-2 p-2 rounded-xl shadow-sm border border-slate-300 group-item group-item-{{ $groupId }}"
                            data-price="{{ $prices[$message->id] ?? '' }}" wire:key="wait-{{ $message->id }}">

                            <div class="flex items-center justify-between mb-1">
                            <span onclick="copyText(this)" class="cursor-pointer text-xs font-semibold text-slate-600">
                                {{ trim(explode(':', $message->code)[0]) }}
                            </span>

                                <div class="flex gap-1">
                                    <button
                                        class="px-2 py-1 rounded-xl bg-red-600 text-white hover:bg-red-700 transition"
                                        wire:click="price_is_unavailable({{ $message->id }})">X
                                    </button>
                                    <button
                                        class="px-2 py-1 rounded-xl bg-green-500 text-white hover:bg-green-600 transition"
                                        wire:click="code_answer_update('g', {{ $message->id }})">G
                                    </button>
                                    <button
                                        class="px-2 py-1 rounded-xl bg-blue-600 text-white hover:bg-blue-700 transition"
                                        wire:click="code_answer_update('n', {{ $message->id }})">🥲
                                    </button>
                                </div>

                                <span class="text-red-600 cursor-pointer">{{ $message->text }}</span>
                            </div>

                            <div class="mt-2 block relative bg-gray-100 rounded-lg h-10 overflow-hidden">
                                <input type="text"
                                       class="h-full w-full pl-2 bg-transparent"
                                       placeholder="قیمت"
                                       wire:model.defer="prices.{{ $message->id }}"
                                       wire:keydown.enter="submit_answer_on3({{ $message->id }})">
                                <button wire:click="submit_answer_on3({{ $message->id }})"
                                        class="absolute top-0 right-0 h-full px-4 bg-blue-600 text-white hover:bg-blue-700 transition">
                                    ➤
                                </button>
                            </div>
                        </div>
                    @endforeach

                </li>
            @endforeach
        </ul>
    </div>


    <div class="bg-gray-200 rounded-2xl float-left m-2 w-[18%] max-h-[600px] overflow-auto">

        <div
            class="bg-blue-600 text-white p-2 font-bold text-center sticky top-0 z-10 rounded-t-2xl">
            تکمیل شده
        </div>

        <ul class="text-xs space-y-2">

            @foreach($ended_chats->groupBy('group_id') as $groupId => $groupChats)

                @php
                    $firstChat = $groupChats->first();
                    $isFollowUp = $groupChats->first()->needs_follow_up ?? false;
                @endphp

                <li class="rounded-lg border p-2 {{ $isFollowUp ? 'bg-yellow-100 border-yellow-400' : 'bg-white border-gray-300' }}">


                    {{-- هدر گروه --}}
                    <div class="flex items-center justify-between mb-1">

                        <div class="flex items-center gap-2">
                            <img
                                src="{{ $firstChat->user->profile_image_path }}"
                                class="w-6 h-6 rounded-lg"
                                alt="">
                            <span class="font-bold text-gray-700 text-xs">
                        </span>
                            <button onclick="copyCompletedGroup('{{ $groupId }}', this)"
                                    class="copy-btn p-1 rounded-full hover:bg-green-500/20 transition"
                                    title="کپی کدها و قیمت‌ها">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="#000"
                                     viewBox="0 0 24 24">
                                    <path
                                        d="M16 1H4a2 2 0 0 0-2 2v12h2V3h12V1zm3 4H8a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h11a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2zm0 16H8V7h11v14z"/>
                                </svg>
                            </button>
                            <button onclick="copyCompletedCodesOnly('{{ $groupId }}', this)"
                                    class="copy-btn p-1 rounded-full hover:bg-blue-500/20 transition"
                                    title="کپی فقط کدها">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                     width="18"
                                     height="18"
                                     viewBox="0 0 24 24"
                                     fill="none"
                                     stroke="#000"
                                     stroke-width="2"
                                     stroke-linecap="round"
                                     stroke-linejoin="round">
                                    <rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect>
                                    <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>
                                </svg>
                            </button>
                            <button
                                wire:click="toggleFollowUp('{{ $groupId }}')"
                                class="px-5 py-2 bg-blue-400 text-white rounded-lg shadow-md
               hover:shadow-lg transition">
                                پیگیری
                            </button>

                        </div>

                        <span class="text-gray-500 text-[10px]">
{{ $firstChat->updated_at->format('H:i') }}
                    </span>
                    </div>

                    {{-- آیتم‌ها --}}
                    @foreach($groupChats as $chat)
                        <div
                            class="border-t border-gray-200 pt-1 mt-1 leading-tight flex completed-{{ $groupId }}">


                        <span class="text-gray-700">
                                <p onclick="copyText(this)"
                                   class="completed-code completed-group-{{ $groupId }} inline-block text-xs font-semibold text-slate-600 cursor-pointer leading-none">
                                    {{ trim(explode(':', $chat->code)[0]) }}
                                </p>
                            :
                        </span>

                            <span class="font-bold text-gray-800">
                            {{ $chat->final_price }}
                        </span>

                            <img src="{{$chat->image_url}}" alt="" class="gallery-img"
                                 style="width: 15%;border-radius: 0">
                        </div>

                    @endforeach

                </li>

            @endforeach
        </ul>
    </div>


    <div class="status_bar">
        <div class="status_text sticky top-0">
            صورت ها
        </div>
        <div class="m-2">
            @foreach($productsGrouped as $groupId => $messages)
                @if(count($messages)>1)
                    <div class="border rounded p-4 mb-4 m-1 bg-gray-50 inline-block float-left"
                         style="font-size: 9pt; font-weight: bold">

                        <div class="font-bold mb-2">گروه: {{ $groupId }}</div>
                        <form
                            wire:submit.prevent="editPriceOnSoraats(Object.fromEntries(new FormData($event.target)),'{{$groupId}}')">
                            @foreach($messages as $message)
                                <div
                                    class="{{ Str::endsWith(trim($message->code), ': -') ? 'text-gray-400 italic' : '' }}">
                                        <?php
                                        $msg = explode(":", $message->code);
                                        $msg1 = $msg[0] . ':';
                                        ?>
                                    {{ $msg1 }}
                                    @if($message->answers->last()?->respondent_by_code == 1 and $message->final_price == null)
                                        <span class="text-green-600">
                                        <input style='border: 1px solid #aaa!important' value='درحال برسی'
                                               name='price.{{$message->id}}'>
                                    </span>
                                    @endif
                                    @if(Str::endsWith(trim($message->code), ['1','2','3','4','5','6','7','8','9','0','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z']) )
                                            <?php
                                            $a = explode(":", $message->code);
                                            if (isset($a[1])) {
                                                $b = "
                                        <input style='border: 1px solid #aaa!important' value='$a[1]' name='price.$message->id'>
                                        ";
                                                $c = str_replace($a[1], $b, $a);
                                                echo $c[1];
                                            } else {
                                                $d = "
                                        <input style='border: 1px solid #aaa!important' name='price.$message->id'>
                                                ";
                                                echo $d;
                                            }
                                            ?>
                                    @endif
                                    @if($message->answers->last()?->price != null and $message->answers->last()?->respondent_by_code != 1)
                                        <span class="text-green-600"
                                              style="{{ Str::endsWith(trim($message->code), ': -') ? 'display: inline' : 'display: none' }}">
                                            <input type="text" style="border: 1px solid #aaa!important"
                                                   value="{{ $message->answers->last()?->price }}"
                                                   name='price.{{$message->id}}'
                                            >
                                        </span>
                                    @endif
                                </div>
                            @endforeach
                            <button type="submit"
                                    class="px-3 py-2 bg-blue-600 text-white rounded-xl float-right">
                                ثبت همه
                            </button>
                        </form>
                    </div>
                @endif
            @endforeach

        </div>
    </div>

    <div class="status_bar shadow overflow-y-auto">
        <div class="status_text sticky top-0">
            صورت ها
        </div>

        <div class="m-2">
            @foreach($productsGrouped as $groupId => $messages)

                <div class="border rounded p-4 mb-4 m-1 bg-gray-50 inline-block float-left"
                     style="font-size: 9pt; font-weight: bold">

                    <form
                        wire:submit.prevent="editPriceOnSoraats(
                            Object.fromEntries(new FormData($event.target)),
                            '{{ $groupId }}'
                        )"
                    >

                        @foreach($messages as $message)

                            <div class="soraat-item-{{ $groupId }} {{ Str::endsWith(trim($message->code), ': -') ? 'text-gray-400 italic' : '' }}">


                                @php
                                    $parts = explode(':', $message->code);
                                    $label = $parts[0];
                                    $codeValue = trim($parts[1] ?? '');
                                @endphp

                                <p onclick="copyText(this)" class="inline-block cursor-pointer soraat-code">
                                    {{ $label }}
                                </p>


                                <p class="inline-block">
                                    :
                                </p>

                                @if(
                                    $message->answers->last()?->price !== null &&
                                    $message->answers->last()?->respondent_by_code != 1
                                )
                                    <input
                                        type="text"
                                        style="border: 1px solid #aaa!important"
                                        value="{{ $message->answers->last()->price }}"
                                        name="price.{{ $message->id }}"
                                    >

                                @elseif(
                                    $message->answers->last()?->respondent_by_code == 1 &&
                                    $message->final_price == null
                                )
                                    @if($message->answers->last()?->price == 'x')
                                        <input
                                            style="border: 1px solid #aaa!important; color: red;"
                                            placeholder="قیمت نا موجود"
                                            name="price.{{ $message->id }}"
                                        >
                                    @else
                                        <input
                                            style="border: 1px solid #aaa!important; color: green;"
                                            placeholder="درحال بررسی"
                                            name="price.{{ $message->id }}"
                                        >
                                    @endif

                                @elseif(
                                    Str::endsWith(trim($message->code), [
                                        '1','2','3','4','5','6','7','8','9','0',
                                        'A','B','C','D','E','F','G','H','I','J',
                                        'K','L','M','N','O','P','Q','R','S','T',
                                        'U','V','W','X','Y','Z'
                                    ])
                                )
                                    <input
                                        style="border: 1px solid #aaa!important;"
                                        value="{{ $codeValue }}"
                                        name="price.{{ $message->id }}"
                                    >

                                @else
                                    <input
                                        style="border: 1px solid #aaa!important"
                                        name="price.{{ $message->id }}"
                                    >
                                @endif

                            </div>

                        @endforeach

                        <button
                            type="submit"
                            class="px-3 py-2 bg-blue-600 text-white rounded-xl float-right mt-2"
                        >
                            ثبت همه
                        </button>

                        <div class="mb-2 flex">
                            <button type="button"
                                    onclick="copySoraatGroup('{{ $groupId }}', this, 'all')"
                                    class="p-2 rounded-full hover:bg-green-500/20 transition"
                                    title="کپی همه">
                                <!-- آیکن کپی -->
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="#000" viewBox="0 0 24 24">
                                    <path d="M16 1H4a2 2 0 0 0-2 2v12h2V3h12V1zm3 4H8a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h11a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2zm0 16H8V7h11v14z"/>
                                </svg>
                            </button>

                            <button type="button"
                                    onclick="copySoraatGroup('{{ $groupId }}', this, 'codes')"
                                    class="p-2 rounded-full hover:bg-blue-500/20 transition"
                                    title="کپی کدها">
                                <!-- آیکن کد -->
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="#000" stroke-width="2">
                                    <rect x="9" y="9" width="13" height="13" rx="2"></rect>
                                    <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>
                                </svg>
                            </button>
                        </div>


                    </form>
                </div>

            @endforeach
        </div>
    </div>

    <form wire:submit.prevent="submit" id="chat-box">
        <div class="ripple-container">
            <div
                class="ripple ripple-on ripple-out"
                style="left: 25px; top: -14.9167px; background-color: rgb(153, 153, 153); transform: scale(2.65152);"></div>
        </div>
        <div id="chat-header">
            <a href="/view-user-chats" class="text-s px-2 py-1 rounded-md bg-gray-100 text-gray-700 hover:bg-gray-200 transition">پیام های کابران</a>
            <a href="/login" class="text-s px-2 py-1 rounded-md bg-gray-100 text-gray-700 hover:bg-gray-200 transition">ورود</a>
            <span class="float-right">
            ارسال پیام
            </span>
        </div>
        <div id="chat-body">
            <div class="msg bot">
                <input wire:model="buser" type="checkbox"><span>مصرف کننده</span>
                <br>
                <input wire:model="dalal" type="checkbox"><span>دلال</span>
                <br>
                <input wire:model="hamkar" type="checkbox"><span>همکار</span>
                <br>
                <input wire:model="tamirkar" type="checkbox"><span>تعمیر کار</span>
                <br>
                <input wire:model="moshtaryg" type="checkbox"><span>مشتری جدید</span>
                <br>
                <input class="p-1 text-right"  wire:model="buyer_name" style="border: 1px solid #aaa!important;" type="text" placeholder="نام فروشنده/توضیحات">
            </div>
        </div>

        <div id="chat-input">
<textarea
    type="text"
    wire:model="test"
    id="messageInput"
    wire:keydown.enter.prevent="submit"
    placeholder="پیام...">
</textarea>
            <div id="previewContainer"></div>
            <button type="submit">➤</button>
            <input wire:model="checkbox" type="checkbox">
        </div>
    </form>
    <livewire:test-form wire:ignore/>
    <script>

        function copySoraatGroup(groupId, btn, type = 'all') {
            let lines = [];

            document.querySelectorAll('.soraat-item-' + groupId).forEach(row => {
                const codeEl = row.querySelector('.soraat-code');
                const inputEl = row.querySelector('input');

                if (!codeEl) return;

                const code = codeEl.innerText.trim();
                const value = inputEl ? inputEl.value.trim() : '';

                if (type === 'all') {
                    if (value !== '') {
                        lines.push(code + ' : ' + value);
                    }
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

            // همه path / rect / circle داخل svg
            const elements = svg.querySelectorAll('path, rect, circle, line, polyline, polygon');

            let oldStrokes = [];
            let oldFills = [];

            elements.forEach((el, i) => {
                oldStrokes[i] = el.getAttribute('stroke');
                oldFills[i] = el.getAttribute('fill');

                el.setAttribute('stroke', '#16a34a');
                if (oldFills[i] && oldFills[i] !== 'none') {
                    el.setAttribute('fill', '#16a34a');
                }
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

            showCopySuccess(btn); // همون افکت سبز
        }


        // گرفتن اجازه نوتیف فقط یکبار
        if (Notification.permission !== "granted" && Notification.permission !== "denied") {
            Notification.requestPermission();
        }

        window.addEventListener('answer-submitted', event => {
            if (Notification.permission === 'granted') {
                new Notification("ثبت پاسخ", {
                    body: event.detail.message,
                });
            }
        });


        const lightbox = document.querySelector(".lightbox");
        const lightboxImg = document.getElementById("lightbox-img");
        const closeBtn = document.querySelector(".close");

        // وقتی روی هر عکس کلیک شد
        document.addEventListener("click", function (e) {
            if (e.target.classList.contains("gallery-img")) {
                lightbox.style.display = "block";
                lightboxImg.src = e.target.src;
            }
        });

        // بستن با دکمه ضربدر
        closeBtn.addEventListener("click", () => {
            lightbox.style.display = "none";
        });

        // بستن با کلیک روی بک‌گراند
        lightbox.addEventListener("click", (e) => {
            if (e.target === lightbox) {
                lightbox.style.display = "none";
            }
        });


        // setInterval(() => {
        //     Livewire.dispatch('checkNewMessages')
        // }, 30);

        function copyCompletedGroup(groupId, btn) {
            let lines = [];

            document.querySelectorAll('.completed-' + groupId).forEach(row => {
                const code = row.querySelector('p')?.innerText.trim();
                const price = row.querySelector('.font-bold')?.innerText.trim();

                if (code && price) {
                    lines.push(code + ' ' + ':' + ' ' + price);
                }
            });

            if (lines.length === 0) return;

            navigator.clipboard.writeText(lines.join('\n'));
            showCopySuccess(btn); // همون افکت سبز شدن
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

                result.push(code + ' ' + ':' + ' ' + price);
            });

            if (result.length === 0) return;

            navigator.clipboard.writeText(result.join('\n'));

            // 🎨 افکت سبز شدن آیکون
            const svg = btn.querySelector('svg');
            if (!svg) return;

            const oldColor = svg.style.fill;
            svg.style.fill = '#16a34a'; // سبز

            btn.classList.add('scale-110');

            setTimeout(() => {
                svg.style.fill = oldColor || '#000';
                btn.classList.remove('scale-110');
            }, 2000);
        }


        function handleCodeClick(event, code, messageId) {
            if (event.ctrlKey) {
                event.preventDefault();
                Livewire.dispatch('toggleCode', {
                    code: code,
                    messageId: messageId
                });
            } else {
                Livewire.dispatch('codeAnswerDirect', {
                    chat_code: code,
                    id: messageId
                });
            }
        }


        const chatBox = document.getElementById("chat-box");
        const chatBody = document.getElementById("chat-body");
        const input = document.getElementById("messageInput");
        const productCodeElement = document.getElementById("productCode");

        function hideMessage(id) {
            const el = document.getElementById('message-' + id);
            if (!el) return;

            el.classList.add('animate__fadeOut');

            setTimeout(() => {
                el.style.display = 'none';
            }, 500);
        }


        function sendMessage() {
            if (input.value.trim() === "") return;

            const userMsg = document.createElement("div");
            userMsg.className = "msg user";
            userMsg.innerText = input.value;
            chatBody.appendChild(userMsg);

            setTimeout(() => {
                const botMsg = document.createElement("div");
                botMsg.className = "msg bot";
                botMsg.innerText = "کد محصول ثبت شد☑️";
                chatBody.appendChild(botMsg);
                chatBody.scrollTop = chatBody.scrollHeight;
            }, 600);

            input.value = "";
            chatBody.scrollTop = chatBody.scrollHeight;
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

    </script>

</div>
