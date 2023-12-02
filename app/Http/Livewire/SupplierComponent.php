<?php

namespace App\Http\Livewire;

use Livewire\{Component, WithPagination};
use App\Models\{Supplier, Currency};
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\{Auth, DB};

class SupplierComponent extends Component
{
    use WithPagination;

    public $newSupplierModal = false;
    public $editSupplierModal = false;
    public $confirmationModal = false;
    public $name = null;
    public $exchange = null;
    public $currency_id = null;
    public $search = '';
    public $size_page = 5;
    public $currencies = [];
    protected $listeners = ['newSupplierModal' => 'newSupplierModal',];

    public function render()
    {
        return view('livewire.supplier-component', [
            'suppliers'=> Supplier::where('name', 'like', '%'.$this->search.'%')->paginate($this->size_page)->onEachSide(0)
        ]);
    }

    public function mount(){
        $this->currencies = Currency::all();
        $this->user = Auth::user();
    }

    public function newSupplierModal()
    {
        $this->newSupplierModal = true;
    }

    public function newSupplier(){
        DB::beginTransaction();
        try {
            $this->validate([
                "name"=>'required|unique:suppliers,name,NULL,id,deleted_at,NULL,user_id,'.$this->user->id,
                "exchange"=>"required",
                "currency_id"=>"required",
            ]);
            $supplier = new Supplier();
            $supplier->name = $this->name;
            $supplier->exchange = $this->exchange;
            $supplier->currency_id = $this->currency_id;
            $supplier->user_id = Auth::user()->id;

            $supplier->save();
            $this->erase();
            $this->emit('showNotification', "Proveedor añadido correctamente", "#008800");

            DB::commit();
        } catch (ValidationException $e) {
            DB::rollBack();
            return redirect()->back()->withErrors($e->validator)->withInput();
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Ocurrió un error al guardar la compra.');
        }
    }

    public function editSupplier($id){
        $this->supplier = Supplier::find($id);
        $this->name = $this->supplier->name;
        $this->exchange = $this->supplier->exchange;
        $this->currency_id = $this->supplier->currency_id;
        $this->editSupplierModal = true;
    }

    public function updateSupplier(){
        DB::beginTransaction();
        try {
            $this->validate([
                "name"=>["required",
                    Rule::unique('suppliers', 'name')->where(function ($query) {
                        return $query->where('user_id', $this->user->id)->where('deleted_at', NULL);
                    })->ignore($this->supplier->id)],
                "exchange"=>"required",
                "currency_id"=>"required",
            ]);
            $this->supplier->name = $this->name;
            $this->supplier->exchange = $this->exchange;
            $this->supplier->currency_id = $this->currency_id;
            $this->supplier->save();
            $this->emit('showNotification', "Proveedor actualizado correctamente", "#008800");
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

    public function supplierToDestroy($id){
        $this->supplier = Supplier::findOrFail($id);
        $this->confirmationModal = true;
    }

    public function destroy(){
        $this->supplier->delete();
        $this->emit('showNotification', "Proveedor eliminado correctamente", "#008800");
        $this->erase();
    }

    public function erase(){
        $this->resetErrorBag();
        $this->resetValidation();
        $this->newSupplierModal = false;
        $this->editSupplierModal = false;
        $this->confirmationModal = false;
        $this->name = null;
        $this->exchange = null;
        $this->currency_id = null;
    }

    public function paginationView() {
        return ('components.pagination-component');
    }
}
