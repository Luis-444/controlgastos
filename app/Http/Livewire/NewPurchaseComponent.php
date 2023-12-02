<?php

namespace App\Http\Livewire;

use Livewire\{Component, WithPagination, WithFileUploads};
use App\Models\{Purchase, PurchaseDetail, PurchaseDetailTax, Product, Supplier, Currency, Media, Tax};
use Illuminate\Support\Facades\{Auth, DB};
use Carbon\Carbon;

class NewPurchaseComponent extends Component
{
    use WithFileUploads;

    public $newPurchaseModal = false;
    public $viewPurchaseModal = false;
    public $confirmationSaveModal = false;
    public $folio = null;
    public $notes = null;
    public $product = null;
    public $product_id = null;
    public $supplier_id = null;
    public $media = [];
    public $tax_id = null;
    public $purchase_id = null;
    public $price = null;
    public $date = null;
    public $search = '';
    public $productSearch = '';
    public $productCodeSearch = '';
    public $productNameSearch = '';
    public $size_page = 5;
    public $suppliers = [];
    public $taxes = [];
    public $products = [];
    public $productsCodes = [];
    public $productsNames = [];
    public $productsfind = [];
    public $img_extensions =  ['jpg', 'jpeg', 'png', 'gif', 'webp'];

    public function render()
    {
        return view('livewire.new-purchase-component');
    }

    public function mount(){
        $this->suppliers = Supplier::all();
        $this->taxes = Tax::all();
        $this->date = Carbon::now()->format('Y-m-d\TH:i');
    }

    public function searchProduct(){
        if($this->productSearch){
            $this->productsfind = Product::where("name", "like", "%".$this->productSearch."%")->orWhere("name", "like", "%".$this->productSearch."%")->get();
        }else{
            $this->products = [];
        }
    }

    public function addProductForIndex($index){
        if(count($this->productsfind)){
            $this->addProduct($this->productsfind[$index]->id);
        }
    }

    public function addProduct($id){
        $product = Product::with('tax')->find($id);
        if(in_array($product->code, $this->productsCodes)){
            /* $this->emit('showNotification', 'Parte agregada anteriormente'); */
        }
        else{
            array_push($this->productsCodes, $product->code);
            $this->searchNameModal = false;
            $this->emit("addProduct", $product);
        }
        $this->productSearch = null;
        $this->productsfind = [];
    }

    public function productDetailRemove($id){
        $productRemove = Product::find($id);
        if($productRemove){
            $productRemove->delete();
        }
    }

    public function validatePurchase(){
        $this->validate([
            "folio"=>"required|unique:purchases,folio,",
            "date"=>"required",
            "notes"=>"required",
            "supplier_id"=>"required",
        ]);
        $this->confirmationSaveModal = true;
    }

    public function savePurchase($details, $taxAmount){
        DB::beginTransaction();
        try {
            $purchase = new Purchase();
            $purchase->folio = $this->folio;
            $purchase->date = $this->date;
            $purchase->notes = $this->notes;
            $purchase->supplier_id = $this->supplier_id;
            $purchase->user_id = Auth::user()->id;
            $purchase->save();
            foreach($details as $key => $detail){
                $product = Product::find($detail['product']['id']);

                $purchaseDetail = new PurchaseDetail();
                $purchaseDetail->purchase_id = $purchase->id;
                $purchaseDetail->product_id = $detail['product']['id'];
                $purchaseDetail->code = $detail['product']['code'];
                $purchaseDetail->name = $detail['product']['name'];
                $purchaseDetail->tax_id = $detail['tax_id'];
                $purchaseDetail->quantity = $detail['quantity'];
                $purchaseDetail->price = $detail['product']['price'];
                $purchaseDetail->amount = $detail['amount'];
                $purchaseDetail->save();

                $purchaseDetailTax = new PurchaseDetailTax();
                $purchaseDetailTax->purchase_detail_id = $purchaseDetail->id;
                $purchaseDetailTax->tax_id = $detail['tax_id'];
                $purchaseDetailTax->amount = $taxAmount;
                $purchaseDetailTax->save();

                $product->price = $detail['product']['price'];
                $product->tax_id = $detail['tax_id'];
                $product->save();
            }
            foreach($this->media as $key => $file){
                $medias = new Media();
                $medias->purchase_id = $purchase->id;
                $medias->user_id = Auth::user()->id;
                $medias->name = $file->getClientOriginalName();
                $namefile = 'Purchase-' . $purchase->id . '-' . time() . '-' . $key .'.'.$file->getClientOriginalExtension();
                $storagePath = 'public/PurchaseMedia';
                $file->storeAs($storagePath, $namefile);
                $medias->path = 'app/' . $storagePath . '/' . $namefile;
                $medias->save();
            }

            $this->erase();

            DB::commit();
        } catch (ValidationException $e) {
            DB::rollBack();
            return redirect()->back()->withErrors($e->validator)->withInput();
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Ocurrió un error al guardar la compra.');
        }
    }

    public function erase(){
        $this->searchNameModal = false;
        $this->confirmationModal = false;
        $this->confirmationGuardarModal = false;
        $this->confirmationSaveModal = false;
        $this->productsCodes = [];
        $this->productsNames = [];
        $this->folio = null;
        $this->supplier_id = null;
        $this->notes = null;
        $this->media = [];
        $this->productCodeSearch = "";
        $this->productNameSearch = "";
        $this->emit('erase');
    }

    public function getTaxes(){
        $this->emit('setTaxes', $this->taxes);
    }
}
