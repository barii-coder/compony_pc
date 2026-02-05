<?php

namespace App\Livewire;

use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class TestForm extends \Livewire\Component
{
    public $uploadedImages = [];
    public $uploadedDescription = '';

    protected $listeners = ['setUploadedData'];

    public function setUploadedData($urls = [], $description = '')
    {
        // تبدیل URL کامل به مسیر نسبی
        $paths = collect($urls)->map(function ($url) {
            return parse_url($url, PHP_URL_PATH); // /test-paste/img_xxx.png
        })->map(function ($path) {
            return ltrim($path, '/'); // test-paste/img_xxx.png
        })->toArray();

        $this->uploadedImages = $paths;
        $this->uploadedDescription = $description;

        $code = time() . '-' . rand(100000, 999999);
        $user = Auth::user();

        Message::create([
            'user_id' => $user->id,
            'code' => $description,
            'active_group' => 1,
            'question' => '1',
            'type' => 'image',
            'image_url' => $paths[0] ?? null,
            'group_id' => $code,
            'chat_in_progress' => '2',
        ]);
    }




    public function render()
    {
        return view('livewire.test-form');
    }
}

