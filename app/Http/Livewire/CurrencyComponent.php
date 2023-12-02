<?php

namespace App\Http\Livewire;

use Livewire\{Component, WithPagination};
use App\Models\Currency;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\{Auth, DB};

class CurrencyComponent extends Component
{
    use WithPagination;

    public $newCurrencyModal = false;
    public $editCurrencyModal = false;
    public $confirmationModal = false;
    public $name = null;
    public $search = '';
    public $size_page = 5;
    protected $listeners = ['newCurrencyModal' => 'newCurrencyModal',];

    public function render()
    {
        return view('livewire.currency-component', [
            'currencies'=> Currency::where('name', 'like', '%'.$this->search.'%')->paginate($this->size_page)->onEachSide(0)
        ]);
    }

    public function newCurrencyModal()
    {
        $this->newCurrencyModal = true;
    }

    public function mount(){
        $this->user = Auth::user();
    }

    public function newCurrency(){
        DB::beginTransaction();
        try {
            $this->validate([
                "name"=>'required|unique:currencies,name,NULL,id,deleted_at,NULL,user_id,'.$this->user->id,
            ]);
            $currency = new Currency();
            $currency->name = $this->name;
            $currency->user_id = Auth::user()->id;

            $currency->save();
            $this->erase();
            $this->emit('showNotification', "Moneda añadida correctamente", "#008800");

            DB::commit();
        } catch (ValidationException $e) {
            DB::rollBack();
            return redirect()->back()->withErrors($e->validator)->withInput();
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Ocurrió un error al guardar la compra.');
        }
    }

    public function editCurrency($id){
        $this->currency = Currency::find($id);
        $this->name = $this->currency->name;
        $this->editCurrencyModal = true;
    }

    public function updateCurrency(){
        DB::beginTransaction();
        try {
            $this->validate([
                "name"=>["required",
                    Rule::unique('currencies', 'name')->where(function ($query) {
                        return $query->where('user_id', $this->user->id)->where('deleted_at', NULL);
                    })->ignore($this->currency->id)],
            ]);
            $this->currency->name = $this->name;
            $this->currency->save();
            $this->emit('showNotification', "Moneda actualizada correctamente", "#008800");
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

    public function currencyToDestroy($id){
        $this->currency = Currency::findOrFail($id);
        $this->confirmationModal = true;
    }

    public function destroy(){
        $this->currency->delete();
        $this->emit('showNotification', "Moneda eliminada correctamente", "#008800");
        $this->erase();
    }

    public function erase(){
        $this->resetErrorBag();
        $this->resetValidation();
        $this->newCurrencyModal = false;
        $this->editCurrencyModal = false;
        $this->confirmationModal = false;
        $this->name = null;
    }


    public function paginationView() {
        return ('components.pagination-component');
    }

}
