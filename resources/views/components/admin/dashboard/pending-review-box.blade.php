@props(['answersGrouped', 'groupReadyForCheck', 'user'])

<div class="bg-gray-300 rounded-2xl float-left m-2 w-[26%] max-h-[600px] overflow-auto shadow-lg border border-slate-200">
    <div class="bg-gradient-to-r bg-blue-600 text-white p-2 font-bold text-center sticky top-0 z-10">منتظر بررسی</div>
    <ul class="text-sm p-1">
        @foreach($answersGrouped as $groupId => $groupAnswers)
            @php $firstAnswer = $groupAnswers->first(); @endphp
            <li class="rounded-2xl shadow-sm m-1 border border-slate-700">
                <div class="bg-gray-100 rounded-2xl p-1 w-[100%] shadow-sm border border-slate-700 float-right mb-1">
                    <ul>
                        <div class="inline-block">
                            @if($user->id == $firstAnswer->message->user_id && ($groupReadyForCheck[$groupId] ?? false))
                                <button onclick="hideMessage({{ $firstAnswer->message->id }})" wire:click="checkAll('{{ $groupId }}')"
                                        class="p-2 rounded-full hover:bg-green-600/30 transition" title="تایید کل">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="black" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M20 6L9 17l-5-5"/>
                                    </svg>
                                </button>
                            @endif
                            <img src="{{ $firstAnswer->message->user->profile_image_path }}" class="w-8 h-8 rounded-xl ring-2 m-1 ring-white shadow block" alt="">
                            <button wire:click="back('{{ $groupId }}')" class="p-2 ms-1 rounded-full hover:bg-red-500/20 transition" title="برگشت">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none">
                                    <path d="M20 12H4M10 6l-6 6 6 6" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </button>
                            <button onclick="copyGroupCodes('{{ $groupId }}', this)" class="copy-btn p-2 m-1 rounded-full block hover:bg-green-500/20 transition" title="کپی کلی">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="#000" viewBox="0 0 24 24">
                                    <path d="M16 1H4a2 2 0 0 0-2 2v12h2V3h12V1zm3 4H8a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h11a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2zm0 16H8V7h11v14z"/>
                                </svg>
                            </button>
                            <button onclick="copyOnlyCodes('{{ $groupId }}', this)" class="copy-btn m-1 p-1 rounded-full block hover:bg-green-500/20 transition" title="کپی کد ها">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect>
                                    <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>
                                </svg>
                            </button>
                        </div>
                        <div class="float-right w-[90%]">
                            @foreach($groupAnswers as $answer)
                                <li class="rounded-xl hover:bg-slate-100 transition-all duration-200 p-1" wire:key="answer-{{ $answer->id }}">
                                    <div class="inline-block mt-1">
                                        <span class="inline-block text-slate-500 rounded-2xl cursor-pointer">
                                            <img src="{{ $answer->message->image_url }}" alt="" class="gallery-img" style="width: 100%;border-radius: 0">
                                            <p onclick="copyText(this)" class="group-code group-{{ $groupId }} inline-block text-xs float-left font-semibold text-slate-600 cursor-pointer leading-none" data-price="{{ $answer->price }}">
                                                {{ trim(explode(':', $answer->message->code)[0]) }}
                                            </p>
                                        </span>
                                        @if($answer->comment && $answer->price == null)
                                            <span class="inline-block ml-2 px-3 py-1 bg-amber-100 text-amber-800 rounded-xl text-xs shadow-sm">{{ $answer->comment }}</span>
                                            @if($answer->respondent_id == null)
                                                <div class="float-right">
                                                    <button wire:click="i_had_it({{ $answer->message->id }})" class="px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl float-right shadow transition">من برداشتم</button>
                                                </div>
                                            @endif
                                        @elseif($answer->comment && $answer->price != null)
                                            <span class="inline-block ml-2 px-3 py-1 bg-amber-100 text-amber-800 rounded-xl text-xs shadow-sm">{{ $answer->comment }}</span>
                                        @endif
                                    </div>
                                    @if($answer->price != 'x' && $answer->price != 'L')
                                        @if($answer->respondent_by_code == 1)
                                            @if($answer->price != null)
                                                <span class="inline-flex px-4 py-1.5 bg-blue-500 text-white rounded-full text-xs shadow">{{ $answer->price }}</span>
                                            @endif
                                        @elseif($answer->respondent_by_code == 0)
                                            @if($answer->price != null)
                                                <span class="inline-flex px-4 py-1.5 bg-green-500 text-white rounded-full text-xs shadow float-right">{{ $answer->price }}</span>
                                            @endif
                                        @else
                                            <span class="inline-flex px-4 py-1.5 bg-green-500 text-white rounded-full text-xs shadow">{{ $answer->price }}</span>
                                        @endif
                                    @endif
                                    @if($answer->respondent_by_code)
                                        @if($answer->respondent_id)
                                            <div class="float-right" style="margin: -3px">
                                                @if($user->id == $answer->respondent_id)
                                                    <button wire:click="save_for_ad_price({{ $answer->message->id }})" class="px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl float-right shadow transition">➜</button>
                                                    <button wire:click="its_unavailable_on_column_2({{ $answer->message->id }})" class="px-3 py-1.5 mx-1 bg-red-600 hover:bg-red-700 text-white rounded-xl float-right shadow transition">X</button>
                                                @endif
                                                <span class="m-1 float-right">
                                                    <img width="30px" class="rounded-xl inline-block ring-2 ring-white shadow" src="{{ $answer->respondent_profile_image_path }}">
                                                    <p class="inline-block">{{ $answer->updated_at->diffForHumans(['short' => true, 'syntax' => \Carbon\CarbonInterface::DIFF_ABSOLUTE, 'parts' => 1]) }}</p>
                                                </span>
                                            </div>
                                        @else
                                            @if($answer->price == 'x')
                                                <div class="text-left inline-block middle">
                                                    <span class="px-3 py-1.5 bg-red-500 text-white rounded-xl float-left text-xs shadow">محصول نا موجود</span>
                                                </div>
                                            @elseif($answer->price === 'n')
                                                <div class="float-right">
                                                    <span class="px-3 py-1.5 bg-red-500 text-white rounded-xl float-right text-xs shadow">خوب نیست</span>
                                                </div>
                                            @elseif($answer->price === 'L')
                                                <div class="float-right">
                                                    <span class="px-3 py-1.5 text-white rounded-xl float-right text-xs shadow">آخرین قیمت سیستم رو بدید</span>
                                                </div>
                                            @else
                                                @if($answer->price != '👎' && $answer->price != '👍' && $answer->price != null)
                                                    <div class="float-right">
                                                        <button wire:click="i_had_it({{ $answer->message->id }})" class="px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl float-right shadow transition">من برداشتم</button>
                                                    </div>
                                                @endif
                                            @endif
                                        @endif
                                    @endif
                                </li>
                            @endforeach
                        </div>
                    </ul>
                </div>
            </li>
        @endforeach
    </ul>
</div>
