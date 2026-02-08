@props(['productsGrouped'])

{{-- صورت ها (فقط گروه‌های با بیش از یک پیام) --}}
<div class="status_bar">
    <div class="status_text sticky top-0">صورت ها</div>
    <div class="m-2">
        @foreach($productsGrouped as $groupId => $messages)
            @if(count($messages) > 1)
                <div class="border rounded p-4 mb-4 m-1 bg-gray-50 inline-block float-left" style="font-size: 9pt; font-weight: bold">
                    <div class="font-bold mb-2">گروه: {{ $groupId }}</div>
                    <form wire:submit.prevent="editPriceOnSoraats(Object.fromEntries(new FormData($event.target)),'{{ $groupId }}')">
                        @foreach($messages as $message)
                            <div class="{{ Str::endsWith(trim($message->code), ': -') ? 'text-gray-400 italic' : '' }}">
                                @php
                                    $msg = explode(":", $message->code);
                                    $msg1 = $msg[0] . ':';
                                @endphp
                                {{ $msg1 }}
                                @if($message->answers->last()?->respondent_by_code == 1 && $message->final_price == null)
                                    <span class="text-green-600">
                                        <input style="border: 1px solid #aaa!important" value="درحال برسی" name="price.{{ $message->id }}">
                                    </span>
                                @endif
                                @if(Str::endsWith(trim($message->code), ['1','2','3','4','5','6','7','8','9','0','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z']))
                                    @php
                                        $a = explode(":", $message->code);
                                    @endphp
                                    @if(isset($a[1]))
                                        <input style="border: 1px solid #aaa!important" value="{{ $a[1] }}" name="price.{{ $message->id }}">
                                    @else
                                        <input style="border: 1px solid #aaa!important" name="price.{{ $message->id }}">
                                    @endif
                                @endif
                                @if($message->answers->last()?->price != null && $message->answers->last()?->respondent_by_code != 1)
                                    <span class="text-green-600" style="{{ Str::endsWith(trim($message->code), ': -') ? 'display: inline' : 'display: none' }}">
                                        <input type="text" style="border: 1px solid #aaa!important" value="{{ $message->answers->last()?->price }}" name="price.{{ $message->id }}">
                                    </span>
                                @endif
                            </div>
                        @endforeach
                        <button type="submit" class="px-3 py-2 bg-blue-600 text-white rounded-xl float-right">ثبت همه</button>
                    </form>
                </div>
            @endif
        @endforeach
    </div>
</div>

{{-- صورت ها (همه گروه‌ها) --}}
<div class="status_bar shadow overflow-y-auto">
    <div class="status_text sticky top-0">صورت ها</div>
    <div class="m-2">
        @foreach($productsGrouped as $groupId => $messages)
            <div class="border rounded p-4 mb-4 m-1 bg-gray-50 inline-block float-left" style="font-size: 9pt; font-weight: bold">
                <form wire:submit.prevent="editPriceOnSoraats(Object.fromEntries(new FormData($event.target)), '{{ $groupId }}')">
                    @foreach($messages as $message)
                        <div class="soraat-item-{{ $groupId }} {{ Str::endsWith(trim($message->code), ': -') ? 'text-gray-400 italic' : '' }}">
                            @php
                                $parts = explode(':', $message->code);
                                $label = $parts[0];
                                $codeValue = trim($parts[1] ?? '');
                            @endphp
                            <p onclick="copyText(this)" class="inline-block cursor-pointer soraat-code">{{ $label }}</p>
                            <p class="inline-block">:</p>
                            @if($message->answers->last()?->price !== null && $message->answers->last()?->respondent_by_code != 1)
                                <input type="text" style="border: 1px solid #aaa!important" value="{{ $message->answers->last()->price }}" name="price.{{ $message->id }}">
                            @elseif($message->answers->last()?->respondent_by_code == 1 && $message->final_price == null)
                                @if($message->answers->last()?->price == 'x')
                                    <input style="border: 1px solid #aaa!important; color: red;" placeholder="قیمت نا موجود" name="price.{{ $message->id }}">
                                @else
                                    <input style="border: 1px solid #aaa!important; color: green;" placeholder="درحال بررسی" name="price.{{ $message->id }}">
                                @endif
                            @elseif(Str::endsWith(trim($message->code), ['1','2','3','4','5','6','7','8','9','0','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z']))
                                <input style="border: 1px solid #aaa!important;" value="{{ $codeValue }}" name="price.{{ $message->id }}">
                            @else
                                <input style="border: 1px solid #aaa!important" name="price.{{ $message->id }}">
                            @endif
                        </div>
                    @endforeach
                    <button type="submit" class="px-3 py-2 bg-blue-600 text-white rounded-xl float-right mt-2">ثبت همه</button>
                    <div class="mb-2 flex">
                        <button type="button" onclick="copySoraatGroup('{{ $groupId }}', this, 'all')" class="p-2 rounded-full hover:bg-green-500/20 transition" title="کپی همه">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="#000" viewBox="0 0 24 24">
                                <path d="M16 1H4a2 2 0 0 0-2 2v12h2V3h12V1zm3 4H8a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h11a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2zm0 16H8V7h11v14z"/>
                            </svg>
                        </button>
                        <button type="button" onclick="copySoraatGroup('{{ $groupId }}', this, 'codes')" class="p-2 rounded-full hover:bg-blue-500/20 transition" title="کپی کدها">
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
