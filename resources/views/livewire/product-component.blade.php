<x-normal-layout>
    <x-slot name="actionSlot">
        <x-icons.add class="icon__pointer" tooltip="Registra un producto" tooltip_aling="bottom" wire:click="newProductModal()"/>
        <x-search-component  wire:model="search" />
    </x-slot>
    <div class="content__container">
        <table class="table">
            <thead>
                <tr>
                    <th class="w-1/12">Accion</th>
                    <th class="w-1/12">Codigo</th>
                    <th class="">Nombre</th>
                    <th class="w-1/12">Precio</th>
                    <th class="w-1/12">Categoria</th>
                    <th class="w-1/12">Impuestos</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $p)
                    <tr>
                        <td>
                            <div class="flex__container__center">
                                <x-icons.edit class="icon__pointer" wire:click="editProduct({{$p->id}})" tooltip="Editar" />
                                <x-icons.trash class="icon__pointer" wire:click="productToDestroy({{$p->id}})" tooltip="Eliminar" tooltip_aling="top"/>
                            </div>
                        </td>
                        <td>{{$p->code}}</td>
                        <td>{{$p->name}}</td>
                        <td>${{$p->price}}</td>
                        <td>{{$p->category->name}}</td>
                        <td>{{$p->tax?->name ?? 'No hay'}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="footer__container">
        <x-select-component wire:model="size_page"/>
        {{$products->links()}}
    </div>

    {{-- Modales --}}
    <x-dialog-modal wire:model="newProductModal">
        <x-slot name="title" >
            Nuevo producto
        </x-slot>
        <x-slot name="content">
            <x-full-input-component label="Codigo" for="code" wire:model="code"/>
            <x-full-input-component label="Nombre" for="name" wire:model="name"/>
            <x-full-input-component label="Precio" for="price" wire:model="price"/>
            <x-full-select-component wire:model="category_id" for="category_id" :items="$categories" label="Selecciona una categoria"/>
            <x-full-select-component wire:model="tax_id" for="tax_id" :items="$taxes" label="Selecciona un Impuesto"/>
        </x-slot>
        <x-slot name="footer">
            <x-button class="button-primary" wire:click="newProduct">
                Aceptar
            </x-button>
            <x-button class="button-danger" wire:click="erase">
                Cancelar
            </x-button>
        </x-slot>
    </x-dialog-modal>

    <x-dialog-modal wire:model="editProductModal">
        <x-slot name="title" >
            Editar producto
        </x-slot>
        <x-slot name="content">
            <x-full-input-component label="Codigo" for="code" wire:model="code"/>
            <x-full-input-component label="Nombre" for="name" wire:model="name"/>
            <x-full-input-component label="Precio" for="price" wire:model="price"/>
            <x-full-select-component wire:model="category_id" for="category_id" :items="$categories" label="Selecciona una categoria"/>
            <x-full-select-component wire:model="tax_id" for="tax_id" :items="$taxes" label="Selecciona un Impuesto"/>
        </x-slot>
        <x-slot name="footer">
            <x-button class="button-primary" wire:click="updateProduct">
                Aceptar
            </x-button>
            <x-button class="button-danger" wire:click="erase">
                Cancelar
            </x-button>
        </x-slot>
    </x-dialog-modal>

    <x-dialog-modal wire:model="confirmationModal">
        <x-slot name="title">
            Confirmar
        </x-slot>
        <x-slot name="content">
            <div class="flex__container space-x-2">
                <x-icons.warning class="text-warning w-10"/>
                <span>¿Estas seguro de eliminar este registro? Esta accion no podra deshacerce.</span>
            </div>
        </x-slot>
        <x-slot name="footer">
            <x-button class="button-primary" wire:click="destroy">
                Aceptar
            </x-button>
            <x-button class="button-danger" wire:click="erase">
                Cancelar
            </x-button>
        </x-slot>
    </x-dialog-modal>
</x-normal-layout>
