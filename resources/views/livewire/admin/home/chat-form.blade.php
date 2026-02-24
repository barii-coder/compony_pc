<div>
    <form wire:submit.prevent="submit" id="chat-box" class="dash-chat-styled">
        <div id="chat-body">
            <div class="chat-buyer-wrap">
                <input type="text" wire:model="userType" placeholder="نوع کاربر">
            </div>

            <!-- آپلود تصویر -->
            <input type="file" wire:model="uploadedImages" multiple accept="image/*">
            <div>
                @if($uploadedImages)
                    @foreach($uploadedImages as $img)
                        <span>{{ $img->getClientOriginalName() }}</span>
                    @endforeach
                @endif
            </div>

            <!-- پیام متنی -->
            <textarea wire:model="messageText" placeholder="پیام..."></textarea>

            <label>
                <input type="checkbox" wire:model="checkbox"> کد جدا
            </label>

            <button type="submit" wire:loading.attr="disabled">ارسال</button>
        </div>
    </form></div>
