<?php

namespace App\Http\Livewire;

use Livewire\{Component, WithPagination};
use App\Models\Tax;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\{Auth, DB};

class TaxComponent extends Component
{
    use WithPagination;

    public $newTaxModal = false;
    public $editTaxModal = false;
    public $confirmationModal = false;
    public $name = null;
    public $code = null;
    public $percentage = null;
    public $search = '';
    public $size_page = 5;
    protected $listeners = ['newTaxModal' => 'newTaxModal',];

    public function render()
    {
        return view('livewire.tax-component', [
            'taxes'=> Tax::where('name', 'like', '%'.$this->search.'%')->paginate($this->size_page)->onEachSide(0)
        ]);
    }

    public function newTaxModal()
    {
        $this->newTaxModal = true;
    }

    public function mount(){
        $this->user = Auth::user();
    }

    public function newTax(){
        DB::beginTransaction();
        try {
            $this->validate([
                "name"=>'required|unique:taxes,name,NULL,id,deleted_at,NULL,user_id,'.$this->user->id,
                "code"=>'required|unique:taxes,code,NULL,id,deleted_at,NULL,user_id,'.$this->user->id,
                "percentage"=>"required",
            ]);
            $tax = new Tax();
            $tax->code = $this->code;
            $tax->name = $this->name;
            $tax->percentage = $this->percentage;
            $tax->user_id = Auth::user()->id;
            $tax->save();
            $this->emit('showNotification', "Impuesto creado correctamente", "#008800");
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

    public function editTax($id){
        $this->tax = Tax::find($id);
        $this->name = $this->tax->name;
        $this->code = $this->tax->code;
        $this->percentage = $this->tax->percentage;
        $this->editTaxModal = true;
    }

    public function updateTax(){
        DB::beginTransaction();
        try {
            $this->validate([
                "name"=>["required",
                Rule::unique('taxes', 'name')->where(function ($query) {
                    return $query->where('user_id', $this->user->id)->where('deleted_at', NULL);
                })->ignore($this->tax->id)],
                "code"=>["required",
                Rule::unique('taxes', 'code')->where(function ($query) {
                    return $query->where('user_id', $this->user->id)->where('deleted_at', NULL);
                })->ignore($this->tax->id)],
                "percentage"=>"required"
            ]);
            $this->tax->name = $this->name;
            $this->tax->code = $this->code;
            $this->tax->percentage = $this->percentage;
            $this->tax->save();
            $this->emit('showNotification', "Impuesto actualizado correctamente", "#008800");
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

    public function taxToDestroy($id){
        $this->tax = Tax::findOrFail($id);
        $this->confirmationModal = true;
    }

    public function destroy(){
        $this->tax->delete();
        $this->emit('showNotification', "Impuesto eliminado correctamente", "#008800");
        $this->erase();
    }

    public function erase(){
        $this->resetErrorBag();
        $this->resetValidation();
        $this->newTaxModal = false;
        $this->editTaxModal = false;
        $this->confirmationModal = false;
        $this->name = null;
        $this->code = null;
        $this->percentage = null;
    }

    public function paginationView() {
        return ('components.pagination-component');
    }
}
