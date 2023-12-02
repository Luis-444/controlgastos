<?php

namespace App\Http\Livewire;

use Livewire\{Component, WithPagination};
use App\Models\Category;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\{Auth, DB};

class CategoryComponent extends Component
{
    use WithPagination;

    public $newCategoryModal = false;
    public $editCategoryModal = false;
    public $confirmationModal = false;
    public $name = null;
    public $search = '';
    public $size_page = 5;
    protected $listeners = ['newCategoryModal' => 'newCategoryModal',];

    public function render()
    {
        return view('livewire.category-component', [
            'categories'=> Category::where('name', 'like', '%'.$this->search.'%')->paginate($this->size_page)->onEachSide(0)
        ]);
    }

    public function newCategoryModal()
    {
        $this->newCategoryModal = true;
    }

    public function mount(){
        $this->user = Auth::user();
    }

    public function newCategory(){
        DB::beginTransaction();
        try {
            $this->validate([
                "name" => 'required|unique:categories,name,NULL,id,deleted_at,NULL,user_id,'.$this->user->id,
            ]);
            $category = new Category();
            $category->name = $this->name;
            $category->user_id = Auth::user()->id;
            $category->save();
            $this->emit('showNotification', "Categoria registrada correctamente", "#008800");
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

    public function editCategory($id){
        $this->category = Category::find($id);
        $this->name = $this->category->name;
        $this->editCategoryModal = true;
    }

    public function updateCategory(){
        DB::beginTransaction();
        try {
            $this->validate([
                "name"=>["required",
                Rule::unique('categories', 'name')->where(function ($query) {
                    return $query->where('user_id', $this->user->id)->where('deleted_at', NULL);
                })->ignore($this->category->id)],
            ]);
            $this->category->name = $this->name;
            $this->category->save();
            $this->emit('showNotification', "Categoria actualizada correctamente", "#008800");
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

    public function categoryToDestroy($id){
        $this->category = Category::findOrFail($id);
        $this->confirmationModal = true;
    }

    public function destroy(){
        $this->category->delete();
        $this->emit('showNotification', "Categoria eliminada correctamente", "#008800");
        $this->erase();
    }

    public function erase(){
        $this->resetErrorBag();
        $this->resetValidation();
        $this->newCategoryModal = false;
        $this->editCategoryModal = false;
        $this->confirmationModal = false;
        $this->name = null;
    }

    public function paginationView() {
        return ('components.pagination-component');
    }

}
