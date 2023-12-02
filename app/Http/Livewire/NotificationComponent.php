<?php

namespace App\Http\Livewire;

use Livewire\Component;

class NotificationComponent extends Component
{
    public $message;
    protected $listeners = ['showNotification'=>'showNotification'];
    public function render()
    {
        return view('livewire.notification-component');
    }

    public function showNotification($message, $color = "#008800"){
        $this->message = $message;
        $this->emit('notification', $color);
    }
}
