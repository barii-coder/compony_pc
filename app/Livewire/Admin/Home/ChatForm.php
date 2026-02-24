<?php

namespace App\Livewire\Admin\Home;
use App\Models\Message;
use App\Models\Answer;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;

class ChatForm extends Component
{
    use WithFileUploads;

    public $messageText = '';
    public $uploadedImages = [];
    public $userType = null;
    public $checkbox = false;
    public $isSubmitting = false;

    protected $rules = [
        'uploadedImages.*' => 'image|max:10240',
    ];

    public function submit()
    {
        if ($this->isSubmitting) return;
        $this->isSubmitting = true;

        $user = Auth::user();
        $groupId = time() . '-' . rand(100000, 999999);

        // 🔹 ثبت عکس‌ها اگر آپلود شده
        $imagePaths = [];
        if (!empty($this->uploadedImages)) {
            foreach ($this->uploadedImages as $file) {
                $filename = 'chat_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('public/chat-images', $filename);
                $imagePaths[] = "chat-images/$filename";
            }
        }

        // 🔹 ثبت پیام متن اگر وجود داشت یا فقط عکس باشه
        if (trim($this->messageText) !== '' || !empty($imagePaths)) {
            foreach ($imagePaths as $img) {
                Message::create([
                    'user_id' => $user->id,
                    'code' => $this->messageText ?: '📷 تصویر ارسال شد',
                    'type' => 'image',
                    'image_path' => $img,
                    'buyer_name' => $this->userType,
                    'active_group' => 1,
                    'group_id' => $groupId,
                    'chat_in_progress' => '2',
                    'past_chat_progress' => '2',
                ]);
            }

            if (trim($this->messageText) !== '') {
                Message::create([
                    'user_id' => $user->id,
                    'code' => $this->messageText,
                    'type' => 'text',
                    'buyer_name' => $this->userType,
                    'active_group' => 1,
                    'group_id' => $groupId,
                    'chat_in_progress' => $this->checkbox ? '1' : '2',
                    'past_chat_progress' => '2',
                ]);
            }
        }

        $this->reset(['messageText', 'uploadedImages', 'checkbox']);
        $this->isSubmitting = false;
        $this->dispatchBrowserEvent('message-sent'); // برای ریست کردن فرم در JS
    }

    public function render()
    {
        return view('livewire.admin.home.chat-form');
    }
}
