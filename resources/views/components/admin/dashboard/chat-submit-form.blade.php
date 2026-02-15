<style>
#chat-box.dash-chat-styled { direction: rtl; border-radius: 16px; box-shadow: 0 12px 40px rgba(0,0,0,0.18), 0 0 0 1px rgba(0,0,0,0.06); overflow: hidden; background: linear-gradient(180deg, #f0f4f8 0%, #e2e8f0 100%); }
#chat-box.dash-chat-styled #chat-header { background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%); color: #fff; padding: 12px 14px; font-weight: 700; font-size: 0.95rem; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 8px; }
#chat-box.dash-chat-styled #chat-header .chat-title { order: 1; }
#chat-box.dash-chat-styled #chat-header .chat-header-links { order: 2; display: flex; gap: 6px; }
#chat-box.dash-chat-styled #chat-header a { background: rgba(255,255,255,0.25); color: #fff; padding: 6px 12px; border-radius: 10px; font-weight: 600; font-size: 12px; text-decoration: none; transition: background 0.2s; }
#chat-box.dash-chat-styled #chat-header a:hover { background: rgba(255,255,255,0.4); }
#chat-box.dash-chat-styled #chat-body { padding: 14px; background: #fff; margin: 0 8px 8px; border-radius: 12px; box-shadow: inset 0 0 0 1px #e2e8f0; }
/* آیتم‌ها کنار هم، جمع‌وجور */
#chat-box.dash-chat-styled .chat-options { display: flex; flex-wrap: wrap; gap: 6px; margin-bottom: 10px; }
#chat-box.dash-chat-styled .chat-option { display: inline-flex; align-items: center; gap: 6px; padding: 5px 10px; border-radius: 9999px; font-size: 12px; font-weight: 500; color: #475569; background: #f1f5f9; cursor: pointer; transition: all 0.2s; user-select: none; border: 2px solid transparent; }
#chat-box.dash-chat-styled .chat-option:hover { background: #e2e8f0; color: #334155; }
#chat-box.dash-chat-styled .chat-option input { position: absolute; opacity: 0; width: 0; height: 0; pointer-events: none; }
#chat-box.dash-chat-styled .chat-option .chat-option-dot { width: 8px; height: 8px; border-radius: 50%; background: #cbd5e1; transition: all 0.2s; flex-shrink: 0; }
#chat-box.dash-chat-styled .chat-option input:checked ~ .chat-option-dot { background: #0ea5e9; box-shadow: 0 0 0 2px rgba(14, 165, 233, 0.3); }
#chat-box.dash-chat-styled .chat-option:has(input:checked) { background: linear-gradient(135deg, #e0f2fe 0%, #bae6fd 100%); color: #0369a1; border-color: #0ea5e9; }
#chat-box.dash-chat-styled .chat-option .chat-option-label { font-size: 12px; font-weight: 500; }
#chat-box.dash-chat-styled .chat-buyer-wrap { margin-top: 4px; }
#chat-box.dash-chat-styled .chat-buyer-wrap input { width: 100%; padding: 10px 14px; border-radius: 10px; font-size: 13px; background: #f8fafc; box-shadow: 0 0 0 1px #e2e8f0; transition: box-shadow 0.2s; }
#chat-box.dash-chat-styled .chat-buyer-wrap input::placeholder { color: #94a3b8; }
#chat-box.dash-chat-styled .chat-buyer-wrap input:focus { outline: none; box-shadow: 0 0 0 2px #0ea5e9; }
/* بخش ورودی: راست به چپ — textarea راست، دکمه ارسال چپ */
#chat-box.dash-chat-styled #chat-input{padding: 0 12px 8px 12px !important;}
#chat-box.dash-chat-styled #chat-input { direction: rtl; padding: 10px; background: #e2e8f0; border-radius: 0 0 16px 16px; display: flex; align-items: center; gap: 8px; flex-direction: row; }
#chat-box.dash-chat-styled #chat-input textarea { flex: 1; min-width: 0; border-radius: 12px; padding: 10px 14px; resize: none; font-size: 13px; min-height: 44px; box-shadow: 0 0 0 1px #cbd5e1; transition: box-shadow 0.2s; }
#chat-box.dash-chat-styled #chat-input textarea:focus { outline: none; box-shadow: 0 0 0 2px #0ea5e9; }
#chat-box.dash-chat-styled #chat-input button[type="submit"] { width: 44px; height: 44px; border-radius: 50%; background: linear-gradient(180deg, #0ea5e9, #0284c7); color: #fff; font-size: 18px; font-weight: bold; cursor: pointer; box-shadow: 0 4px 12px rgba(14, 165, 233, 0.4); transition: transform 0.1s, box-shadow 0.2s; flex-shrink: 0; display: flex; align-items: center; justify-content: center; }
#chat-box.dash-chat-styled #chat-input button[type="submit"]:hover { transform: scale(1.05); box-shadow: 0 6px 16px rgba(14, 165, 233, 0.5); }
#chat-box.dash-chat-styled #chat-input button[type="submit"] .send-arrow { display: inline-block; transform: rotate(180deg); }
#chat-box.dash-chat-styled .chat-bottom-row { display: flex; align-items: center; gap: 8px; }
#chat-box.dash-chat-styled .chat-bottom-row .chat-check-wrap { display: flex; align-items: center; gap: 6px; cursor: pointer; font-size: 12px; color: #64748b; font-weight: 500; }
#chat-box.dash-chat-styled .chat-bottom-row input[type="checkbox"] { width: 18px; height: 18px; accent-color: #0ea5e9; cursor: pointer; }
</style>

<form wire:submit.prevent="submit" id="chat-box" class="dash-chat-styled">
    <div class="ripple-container"><div class="ripple ripple-on ripple-out" style="left: 25px; top: -14.9167px; background-color: rgb(153, 153, 153); transform: scale(2.65152);"></div></div>
    <div id="chat-header">
        <span class="chat-title">ارسال پیام</span>
        <div class="chat-header-links">
            <a href="/view-user-chats">پیام های کاربران</a>
            <a href="/login">ورود</a>
        </div>
    </div>
    <div id="chat-body">
        <div class="msg bot">
            <div class="chat-options">
                <label class="chat-option"><input wire:model.live="userType" type="radio" value="مصرف کننده"><span class="chat-option-label">مصرف کننده</span><span class="chat-option-dot"></span></label>
                <label class="chat-option"><input wire:model.live="userType" type="radio" value="دلال"><span class="chat-option-label">دلال</span><span class="chat-option-dot"></span></label>
                <label class="chat-option"><input wire:model.live="userType" type="radio" value="همکار"><span class="chat-option-label">همکار</span><span class="chat-option-dot"></span></label>
                <label class="chat-option"><input wire:model.live="userType" type="radio" value="تعمیرکار"><span class="chat-option-label">تعمیرکار</span><span class="chat-option-dot"></span></label>
                <label class="chat-option"><input wire:model.live="userType" type="radio" value="مشتری جدید"><span class="chat-option-label">مشتری جدید</span><span class="chat-option-dot"></span></label>
            </div>
            <div class="chat-buyer-wrap">
                <input wire:model="userType" type="text" placeholder="نام فروشنده / توضیحات (اختیاری)" dir="rtl">
            </div>
        </div>
    </div>
    <div id="chat-input">
        <textarea type="text" wire:model="test" id="messageInput" wire:keydown.enter.prevent="submit" placeholder="پیام..." dir="ltr"></textarea>
        <div id="previewContainer"></div>
        <button type="submit"
                wire:loading.attr="disabled"
                wire:target="submit"
                class="relative">

            <span wire:loading.remove wire:target="submit" class="send-arrow">➤</span>

            <span wire:loading wire:target="submit"
                  style="font-size:12px;">...</span>
        </button>
        <label class="chat-bottom-row chat-check-wrap">
            <input wire:model="checkbox" type="checkbox">
            <span>کد جدا</span>
        </label>
    </div>
</form>
