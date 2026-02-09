@props(['productsGrouped'])

<style>
/* باکس صورت ها */
.dash-soraat-bar {box-shadow: 0 4px 24px rgba(0,0,0,0.06), 0 0 0 1px rgba(0,0,0,0.04); border-radius: 1rem; background: #fff; overflow: scroll; }
.dash-soraat-bar .status_text.dash-soraat-title { display: block; float: none; background: linear-gradient(135deg, #334155 0%, #475569 100%); color: #fff; padding: 0.4rem 0.6rem; font-weight: 600; font-size: 0.8rem; text-align: center; line-height: 1.3; }
/* ردیف کارت‌ها با اسکرول افقی + اسکرول‌بار باریک */
.dash-soraat-bar .dash-soraat-scroll {display: flex;flex-direction: row;flex-wrap: wrap;overflow-x: hidden;overflow-y: auto;padding: 0.6rem;
    align-items: stretch;
    gap: 0.75rem;             /* فاصله بین کارت‌ها */
}
.dash-soraat-bar .dash-soraat-scroll::-webkit-scrollbar { height: 5px; }
.dash-soraat-bar .dash-soraat-scroll::-webkit-scrollbar-track { background: #f1f5f9; border-radius: 10px; }
.dash-soraat-bar .dash-soraat-scroll::-webkit-scrollbar-thumb { background: #94a3b8; border-radius: 10px; }
.dash-soraat-bar .dash-soraat-scroll::-webkit-scrollbar-thumb:hover { background: #64748b; }
.dash-soraat-bar .dash-soraat-card {height: 100%; flex: 0 0 auto; min-width: 250px; max-width: 320px; background: #fff; border-radius: 0.875rem; padding: 0; margin: 0; box-shadow: 0 2px 12px rgba(0,0,0,0.06); border: 1px solid #e5e7eb; font-size: 12px; overflow: hidden; }
.dash-soraat-card .dash-soraat-group-title { font-size: 13px; font-weight: 700; color: #1e293b; padding: 0.75rem 1rem; margin: 0; background: linear-gradient(180deg, #f8fafc 0%, #f1f5f9 100%); border-bottom: 1px solid #e2e8f0; }
/* هر سطر آیتم */
.dash-soraat-card .dash-soraat-row { display: flex; align-items: center; gap: 0.5rem; min-height: 36px; line-height: 1.5; flex-wrap: wrap; border-bottom: 1px solid #f1f5f9; transition: background 0.15s;padding: 3px 5px }
.dash-soraat-card .dash-soraat-row:last-of-type { border-bottom: none; }
.dash-soraat-card .dash-soraat-row:hover { background: #fafbfc; }
.dash-soraat-card .dash-soraat-row.italic { color: #94a3b8; font-style: italic; }
.dash-soraat-card .dash-soraat-row.italic:hover { background: #f8fafc; }
/* برچسب کد */
.dash-soraat-card .dash-soraat-row .soraat-code { margin: 0; cursor: pointer; font-weight: 600; color: #334155; padding: 0.2rem 0.5rem; border-radius: 0.375rem; background: #f1f5f9; font-size: 12px; transition: background 0.2s, color 0.2s; }
.dash-soraat-card .dash-soraat-row .soraat-code:hover { color: #1e40af; background: #e0e7ff; }
.dash-soraat-card .dash-soraat-row .soraat-colon { color: #94a3b8; font-weight: 600; margin: 0 0.1rem; }
/* اینپوت‌ها */
.dash-soraat-card .dash-soraat-row input[type="text"] { height: 22px; padding: 3px; border-radius: 0.5rem; font-size: 12px; min-width: 80px; flex: 1; max-width: 160px; background: #f8fafc; box-shadow: 0 0 0 1px #e2e8f0; transition: box-shadow 0.2s, background 0.2s; box-sizing: border-box; }
.dash-soraat-card .dash-soraat-row input[type="text"]:focus { outline: none; box-shadow: 0 0 0 2px #3b82f6; background: #fff; }
.dash-soraat-card .dash-soraat-row input[type="text"]::placeholder { color: #94a3b8; }
.dash-soraat-card .dash-soraat-row input.soraat-input-red { color: #dc2626 !important; }
.dash-soraat-card .dash-soraat-row input.soraat-input-green { color: #16a34a !important; }
/* ناحیه دکمه‌ها */
.dash-soraat-card .dash-soraat-footer { padding: 0.75rem 1rem; background: #f8fafc; border-top: 1px solid #e2e8f0; display: flex; flex-wrap: wrap; align-items: center; gap: 0.5rem; }
.dash-soraat-card .dash-btn-submit { padding: 0.5rem 1rem; border-radius: 0.5rem; font-weight: 600; font-size: 12px; background: linear-gradient(180deg, #2563eb, #1d4ed8); color: #fff; box-shadow: 0 2px 8px rgba(37, 99, 235, 0.25); transition: transform 0.1s, box-shadow 0.2s; }
.dash-soraat-card .dash-btn-submit:hover { box-shadow: 0 4px 12px rgba(37, 99, 235, 0.4); transform: translateY(-1px); }
.dash-soraat-card .dash-copy-btns { display: flex; gap: 0.35rem; margin-right: auto; }
.dash-soraat-card .dash-copy-btns button { width: 36px; height: 36px; display: inline-flex; align-items: center; justify-content: center; border-radius: 50%; color: #64748b; background: #fff; box-shadow: 0 0 0 1px #e2e8f0; transition: background 0.2s, color 0.2s, transform 0.1s; }
.dash-soraat-card .dash-copy-btns button:hover { background: rgba(34, 197, 94, 0.12); color: #16a34a; transform: scale(1.05); }
.dash-soraat-card .dash-copy-btns button.blue:hover { background: rgba(59, 130, 246, 0.12); color: #2563eb; }
</style>

{{-- صورت ها (فقط گروه‌های با بیش از یک پیام) --}}
<div class="status_bar dash-soraat-bar">
    <div class="status_text dash-soraat-title sticky top-0">صورت ها</div>
    <div class="dash-soraat-scroll">
        @foreach($productsGrouped as $groupId => $messages)
            @if(count($messages) > 1)
                <div class="dash-soraat-card">
                    <div class="dash-soraat-group-title">گروه: {{ $groupId }}</div>
                    <form wire:submit.prevent="editPriceOnSoraats(Object.fromEntries(new FormData($event.target)),'{{ $groupId }}')"
                          wire:keydown.enter.prevent="editPriceOnSoraats(Object.fromEntries(new FormData($event.target.closest('form'))),'{{ $groupId }}')">
                        @foreach($messages as $message)
                            <div class="dash-soraat-row {{ Str::endsWith(trim($message->code), ': -') ? 'italic' : '' }}">
                                @php $msg = explode(":", $message->code); $msg1 = $msg[0]; @endphp
                                <span onclick="copyText(this)" class="soraat-code">{{ $msg1 }}</span>
                                <span class="soraat-colon">:</span>
                                @if($message->answers->last()?->respondent_by_code == 1 && $message->final_price == null)
                                    <input type="text" value="درحال برسی" name="price.{{ $message->id }}">
                                @endif
                                @if(Str::endsWith(trim($message->code), ['1','2','3','4','5','6','7','8','9','0','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z']))
                                    @php $a = explode(":", $message->code); @endphp
                                    @if(isset($a[1]))<input type="text" value="{{ $a[1] }}" name="price.{{ $message->id }}">@else<input type="text" name="price.{{ $message->id }}">@endif
                                @endif
                                @if($message->answers->last()?->price != null && $message->answers->last()?->respondent_by_code != 1)
                                    <span style="{{ Str::endsWith(trim($message->code), ': -') ? 'display: inline' : 'display: none' }}"><input type="text" value="{{ $message->answers->last()?->price }}" name="price.{{ $message->id }}"></span>
                                @endif
                            </div>
                        @endforeach
                        <div class="dash-soraat-footer">
                            <button type="submit" class="dash-btn-submit">ثبت همه</button>
                        </div>
                    </form>
                </div>
            @endif
        @endforeach
    </div>
</div>

{{-- صورت ها (همه گروه‌ها) --}}
<div class="status_bar dash-soraat-bar shadow overflow-y-auto">
    <div class="status_text dash-soraat-title sticky top-0">صورت ها</div>
    <div class="dash-soraat-scroll">
        @foreach($productsGrouped as $groupId => $messages)
            <div class="dash-soraat-card">
                <form wire:submit.prevent="editPriceOnSoraats(Object.fromEntries(new FormData($event.target)), '{{ $groupId }}')"
                      wire:keydown.enter.prevent="editPriceOnSoraats(Object.fromEntries(new FormData($event.target.closest('form'))), '{{ $groupId }}')">
                    @foreach($messages as $message)
                        <div class="soraat-item-{{ $groupId }} dash-soraat-row {{ Str::endsWith(trim($message->code), ': -') ? 'italic' : '' }}">
                            @php $parts = explode(':', $message->code); $label = $parts[0]; $codeValue = trim($parts[1] ?? ''); @endphp
                            <p onclick="copyText(this)" class="soraat-code">{{ $label }}</p>
                            <span class="soraat-colon">:</span>
                            @if($message->answers->last()?->price !== null && $message->answers->last()?->respondent_by_code != 1)
                                <input type="text" value="{{ $message->answers->last()->price }}" name="price.{{ $message->id }}">
                            @elseif($message->answers->last()?->respondent_by_code == 1 && $message->final_price == null)
                                @if($message->answers->last()?->price == 'x')
                                    <input type="text" class="soraat-input-red" placeholder="قیمت نا موجود" name="price.{{ $message->id }}">
                                @else
                                    <input type="text" class="soraat-input-green" placeholder="درحال بررسی" name="price.{{ $message->id }}">
                                @endif
                            @elseif(Str::endsWith(trim($message->code), ['1','2','3','4','5','6','7','8','9','0','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z']))
                                <input type="text" value="{{$codeValue}}" name="price.{{ $message->id }}">
                            @else
                                <input type="text" name="price.{{ $message->id }}" value="-">
                            @endif
                        </div>
                    @endforeach
                    <div class="dash-soraat-footer" style="direction: rtl">
                        <button type="submit" class="dash-btn-submit">ثبت همه</button>
                        <div class="dash-copy-btns">
                            <button type="button" onclick="copySoraatGroup('{{ $groupId }}', this, 'all')" title="کپی همه">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M16 1H4a2 2 0 0 0-2 2v12h2V3h12V1zm3 4H8a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h11a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2zm0 16H8V7h11v14z"/></svg>
                            </button>
                            <button type="button" class="blue" onclick="copySoraatGroup('{{ $groupId }}', this, 'codes')" title="کپی کدها">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M19 5H8a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h11a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2zm0 16H8V7h11v14z"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        @endforeach
    </div>
</div>
