<?php

namespace App\Livewire\Home;

use App\Models\Message;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class FollowUpPage extends Component
{

    public function checkAccess($userId)
    {
        $user = User::find($userId);

        if (!$user || $user->role !== 'admin') {
            throw ValidationException::withMessages([
                'access' => 'شما دسترسی لازم برای مشاهده این بخش را ندارید.'
            ]);
        }
    }

    public function dbtn($message_id)
    {
        $message = Message::find($message_id);

        $message->timestamps = false; // غیرفعال کردن موقت timestamps

        $message->update([
            'is_circle' => !$message->is_circle,
            'update_time' => Carbon::now()->format('Y/m/d H:i:s'),
        ]);
    }

    public
    function toggleFollowUp($groupId)
    {
        $user = Auth::user();
        $this->checkAccess($user->id);

        $messages = Message::where('group_id', $groupId)->get();


        foreach ($messages as $message) {
            if (!$message) {
                return;
            }
            if ($message->needs_follow_up) {
                // 🔴 خاموش کردن پیگیری → برگردوندن زمان قبلی
                Message::withoutTimestamps(function () use ($message) {
                    $message->update([
                        'needs_follow_up' => false,
                        'updated_at' => $message->previous_updated_at, // برگرد به جای قبلی
                        'previous_updated_at' => null,
                    ]);
                });

            } else {
                // 🟢 روشن کردن پیگیری → ذخیره زمان قبلی + بیاد بالا
                $message->previous_updated_at = $message->updated_at;
                $message->needs_follow_up = true;
                $message->save(); // اینجا عمداً updated_at جدید می‌گیره
            }
        }
    }

    public function render()
    {
        $FollowMessages = Message::query()->where('needs_follow_up', 1)->orderBy('updated_at','desc')->get();
        return view('livewire.home.follow-up-page',compact('FollowMessages'));
    }
}
