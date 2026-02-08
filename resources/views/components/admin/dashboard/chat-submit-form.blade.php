<form wire:submit.prevent="submit" id="chat-box">
    <div class="ripple-container">
        <div class="ripple ripple-on ripple-out" style="left: 25px; top: -14.9167px; background-color: rgb(153, 153, 153); transform: scale(2.65152);"></div>
    </div>
    <div id="chat-header">
        <a href="/view-user-chats" class="text-s px-2 py-1 rounded-md bg-gray-100 text-gray-700 hover:bg-gray-200 transition">پیام های کابران</a>
        <a href="/login" class="text-s px-2 py-1 rounded-md bg-gray-100 text-gray-700 hover:bg-gray-200 transition">ورود</a>
        <span class="float-right">ارسال پیام</span>
    </div>
    <div id="chat-body">
        <div class="msg bot">
            <input wire:model="buser" type="checkbox"><span>مصرف کننده</span><br>
            <input wire:model="dalal" type="checkbox"><span>دلال</span><br>
            <input wire:model="hamkar" type="checkbox"><span>همکار</span><br>
            <input wire:model="tamirkar" type="checkbox"><span>تعمیر کار</span><br>
            <input wire:model="moshtaryg" type="checkbox"><span>مشتری جدید</span><br>
            <input class="p-1 text-right" wire:model="buyer_name" style="border: 1px solid #aaa!important;" type="text" placeholder="نام فروشنده/توضیحات">
        </div>
    </div>
    <div id="chat-input">
        <textarea type="text" wire:model="test" id="messageInput" wire:keydown.enter.prevent="submit" placeholder="پیام..."></textarea>
        <div id="previewContainer"></div>
        <button type="submit">➤</button>
        <input wire:model="checkbox" type="checkbox">
    </div>
</form>
