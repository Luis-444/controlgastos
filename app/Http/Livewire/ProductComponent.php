<?php

namespace App\Http\Livewire;

use Livewire\{Component, WithPagination};
use App\Models\{Product, Category, Tax};
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\{Auth, DB};

class ProductComponent extends Component
{
    use WithPagination;

    public $newProductModal = false;
    public $editProductModal = false;
    public $confirmationModal = false;
    public $name = null;
    public $code = null;
    public $price = null;
    public $categories = [];
    public $taxes = [];
    public $category_id = null;
    public $tax_id = null;
    public $category = null;
    public $search = '';
    public $size_page = 5;

    protected $listeners = ['newProductModal' => 'newProductModal',];

    public function render()
    {
        return view('livewire.product-component', [
            'products'=> Product::where('name', 'like', '%'.$this->search.'%')->paginate($this->size_page)->onEachSide(0)
        ]);
    }

    public function mount(){
        $this->categories = Category::all();
        $this->taxes = Tax::all();
        $this->user = Auth::user();
    }

    public function newProductModal()
    {
        $this->newProductModal = true;
    }

    public function newProduct(){
        DB::beginTransaction();
        try {
            $this->validate([
                "name"=>'required|unique:products,name,NULL,id,deleted_at,NULL,user_id,'.$this->user->id,
                "code"=>'required|unique:products,code,NULL,id,deleted_at,NULL,user_id,'.$this->user->id,
                "price"=>"required",
                "category_id"=>"required",
                "tax_id"=>"required",
            ]);
            $product = new Product();
            $product->name = $this->name;
            $product->code = $this->code;
            $product->price = $this->price;
            $product->category_id = $this->category_id;
            $product->tax_id = $this->tax_id;
            $product->user_id = Auth::user()->id;

            $product->save();
            $this->erase();
            $this->emit('showNotification', "Producto registrado correctamente", "#008800");

            DB::commit();
        } catch (ValidationException $e) {
            DB::rollBack();
            return redirect()->back()->withErrors($e->validator)->withInput();
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Ocurrió un error al guardar la compra.');
        }
    }

    public function editProduct($id){
        $this->product = Product::find($id);
        $this->name = $this->product->name;
        $this->code = $this->product->code;
        $this->price = $this->product->price;
        $this->category_id = $this->product->category_id;
        $this->tax_id = $this->product->tax_id;
        $this->editProductModal = true;
    }

    public function updateProduct(){
        DB::beginTransaction();
        try {
            $this->validate([
                "name"=>["required",
                    Rule::unique('products', 'name')->where(function ($query) {
                        return $query->where('user_id', $this->user->id)->where('deleted_at', NULL);
                    })->ignore($this->product->id)],
                "code"=>["required",
                    Rule::unique('products', 'code')->where(function ($query) {
                        return $query->where('user_id', $this->user->id)->where('deleted_at', NULL);
                    })->ignore($this->product->id)],
                "price"=>"required",
                "category_id"=>"required",
                "tax_id"=>"required",
            ]);
            $this->product->name = $this->name;
            $this->product->code = $this->code;
            $this->product->price = $this->price;
            $this->product->category_id = $this->category_id;
            $this->product->tax_id = $this->tax_id;
            $this->product->save();
            $this->emit('showNotification', "producto actualizado correctamente", "#008800");
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

    public function productToDestroy($id){
        $this->product = Product::findOrFail($id);
        $this->confirmationModal = true;
    }

    public function destroy(){
        $this->product->delete();
        $this->emit('showNotification', "producto eliminado correctamente", "#008800");
        $this->erase();
    }

    public function erase(){
        $this->resetErrorBag();
        $this->resetValidation();
        $this->newProductModal = false;
        $this->editProductModal = false;
        $this->confirmationModal = false;
        $this->name = null;
        $this->code = null;
        $this->price = null;
        $this->category_id = null;
        $this->tax_id = null;
    }

    public function paginationView() {
        return ('components.pagination-component');
    }

}
