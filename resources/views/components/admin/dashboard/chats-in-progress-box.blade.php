@props(['groups', 'messageCounts', 'messageTimesByCode', 'selectedCodes', 'user'])

<div class="bg-gray-300 rounded-2xl float-left m-2 w-[26%] max-h-[600px] overflow-auto">
    <div class="bg-blue-600 text-white p-2 font-bold text-center sticky top-0 z-10 rounded-t-2xl">
        چت‌های در جریان
    </div>
    <ul class="text-[13px] space-y-2 p-1">
        @foreach($groups as $groupId => $messages)
            @php $firstMessage = $messages->first(); @endphp
            <div class="bg-white rounded-lg p-2 border border-gray-300">
                <div id="lightbox" class="lightbox">
                    <span class="close">&times;</span>
                    <img class="lightbox-content"/>
                </div>
                <div class="inline-block float-left">
                    <img src="{{ $firstMessage->user->profile_image_path }}" class="w-6 h-6 rounded-full ">
                    <button wire:click="deleteGroup('{{ $groupId }}')"
                            class="p-1 rounded-full hover:bg-red-500/20 transition" title="حذف گروه">
                        <svg xmlns="http://www.w3.org/2000/svg" shape-rendering="geometricPrecision" width="18"
                             text-rendering="geometricPrecision" image-rendering="optimizeQuality"
                             fill-rule="evenodd" clip-rule="evenodd" viewBox="0 0 456 511.82">
                            <path fill="#FD3B3B" d="M48.42 140.13h361.99c17.36 0 29.82 9.78 28.08 28.17l-30.73 317.1c-1.23 13.36-8.99 26.42-25.3 26.42H76.34c-13.63-.73-23.74-9.75-25.09-24.14L20.79 168.99c-1.74-18.38 9.75-28.86 27.63-28.86zM24.49 38.15h136.47V28.1c0-15.94 10.2-28.1 27.02-28.1h81.28c17.3 0 27.65 11.77 27.65 28.01v10.14h138.66c.57 0 1.11.07 1.68.13 10.23.93 18.15 9.02 18.69 19.22.03.79.06 1.39.06 2.17v42.76c0 5.99-4.73 10.89-10.62 11.19-.54 0-1.09.03-1.63.03H11.22c-5.92 0-10.77-4.6-11.19-10.38 0-.72-.03-1.47-.03-2.23v-39.5c0-10.93 4.21-20.71 16.82-23.02 2.53-.45 5.09-.37 7.67-.37zm83.78 208.38c-.51-10.17 8.21-18.83 19.53-19.31 11.31-.49 20.94 7.4 21.45 17.57l8.7 160.62c.51 10.18-8.22 18.84-19.53 19.32-11.32.48-20.94-7.4-21.46-17.57l-8.69-160.63zm201.7-1.74c.51-10.17 10.14-18.06 21.45-17.57 11.32.48 20.04 9.14 19.53 19.31l-8.66 160.63c-.52 10.17-10.14 18.05-21.46 17.57-11.31-.48-20.04-9.14-19.53-19.32l8.67-160.62zm-102.94.87c0-10.23 9.23-18.53 20.58-18.53 11.34 0 20.58 8.3 20.58 18.53v160.63c0 10.23-9.24 18.53-20.58 18.53-11.35 0-20.58-8.3-20.58-18.53V245.66z"/>
                        </svg>
                    </button>
                    <button onclick="copyChatGroupCodes('{{ $groupId }}', this)" class="p-1 block rounded-full hover:bg-green-500/20 transition" title="کپی کدهای این گروه">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect>
                            <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>
                        </svg>
                    </button>
                </div>
                <div class="w-[96%] min-h-[80px]">
                    @foreach($messages as $message)
                        @php
                            $isEmpty = preg_match('/:\s*-\s*$/', trim($message->code));
                            $hasNoColon = strpos($message->code, ':') === false;
                            $count = $messageCounts[$message->code] ?? 0;
                        @endphp
                        <li id="message-{{ $message->id }}" class="px-10 border-b last:border-b-0 m-1" style="border-bottom: 1px solid #eee!important;">
                            <img src="{{ $message->image_url }}" alt="" class="gallery-img" style="width: 100%;border-radius: 0">
                            <p onclick="copyText(this)" class="chat-code chat-group-{{ $groupId }} inline-block text-xs font-semibold text-slate-600 cursor-pointer leading-none">
                                {{ trim(explode(':', $message->code)[0]) }}
                            </p>
                            @if($count > 1)
                                <span class="text-gray-400 text-[10px] ml-1">( {{ implode(' , ', $messageTimesByCode[$message->code] ?? []) }} )</span>
                            @endif
                            @if($isEmpty == 1 || $hasNoColon == true)
                                <div class="inline-block gap-1 mt-1 flex-wrap">
                                    @foreach(['a','k','h','g','x','L', $message->question == '1' ? '👍' : null, $message->question == '1' ? '👎' : null] as $c)
                                        @if($c)
                                            @php $key = $message->id . ':' . $c; @endphp
                                            <button onclick="handleCodeClick(event,'{{ $c }}',{{ $message->id }})"
                                                    style="{{ $c == 'x' ? 'margin-left:5px' : '' }}"
                                                    class="px-2 rounded text-[12px] {{ in_array($key, $selectedCodes) ? 'bg-green-600 text-white' : 'bg-blue-600 text-white hover:bg-blue-700' }}">
                                                {{ $c }}
                                            </button>
                                        @endif
                                    @endforeach
                                    {{ $message->buyer_name ?? '' }}
                                </div>
                                @if($user->id == '1' || $user->id == '5')
                                    <input type="text" wire:model="comments.{{ $message->id }}" dir="rtl"
                                           wire:keydown.enter="submit_comment({{ $message->id }})" wire:ignore
                                           placeholder="کامنت" class="mt-1 w-[45%] float-right bg-gray-100 rounded px-1 py-0.5">
                                @endif
                                <div class="flex mt-2 bg-gray-100 rounded overflow-hidden">
                                    <input type="text" wire:model="prices.{{ $message->id }}" placeholder="قیمت"
                                           wire:ignore wire:keydown.enter="submit_answer({{ $message->id }})"
                                           class="flex-1 bg-transparent px-1 py-0.5">
                                    <button wire:click="submit_answer({{ $message->id }})" class="px-2 bg-blue-600 text-white text-[9px]">➤</button>
                                </div>
                                @if(collect($selectedCodes)->contains(fn($v) => str_starts_with($v, $message->id . ':')))
                                    <button wire:click="submitSelectedCodes({{ $message->id }})" class="mt-1 w-full bg-green-600 text-white py-0.5 rounded">ثبت</button>
                                @endif
                            @endif
                        </li>
                    @endforeach
                </div>
            </div>
        @endforeach
    </ul>
</div>
