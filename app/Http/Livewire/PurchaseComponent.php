<?php

namespace App\Http\Livewire;

use Livewire\{Component, WithPagination, WithFileUploads};
use App\Models\{Purchase, PurchaseDetail, PurchaseDetailTax, Product, Supplier, Currency, Media, Tax};
use Illuminate\Support\Facades\{Auth, DB};
use Carbon\Carbon;


class PurchaseComponent extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $search = '';
    public $productSearch = '';
    public $size_page = 5;

    protected $listeners = ['newPurchaseModal' => 'newPurchaseModal',];

    public function render()
    {
        return view('livewire.purchase-component', [
            'purchases'=> Purchase::where('folio', 'like', '%'.$this->search.'%')->paginate($this->size_page)->onEachSide(0)
        ]);
    }

    public function paginationView() {
        return ('components.pagination-component');
    }
}
