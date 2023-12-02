<?php

namespace App\Http\Livewire;

use Livewire\{Component, WithPagination, WithFileUploads};
use App\Models\{Purchase, PurchaseDetail, PurchaseDetailTax, Product, Supplier, Currency, Media, Tax};
use Illuminate\Support\Facades\{Auth, DB};
use Carbon\Carbon;

class ShowPurchaseComponent extends Component
{
    public $purchase;
    public $date;
    public $media = [];
    public $img_extensions =  ['jpg', 'jpeg', 'png', 'gif', 'webp'];

    public function mount($id){
        $this->showPurchaseDetails($id);
        $this->date = Carbon::now()->format('Y-m-d\TH:i');
    }

    public function showPurchaseDetails($id){
        $this->purchase = Purchase::with('purchase_details')->find($id);
        $this->media = $this->purchase->media;
        $this->date = $this->purchase->date;
    }

    public function export($path, $name)
    {
        return response()->download(storage_path($path), $name);
    }

    public function render()
    {
        return view('livewire.show-purchase-component');
    }
}
