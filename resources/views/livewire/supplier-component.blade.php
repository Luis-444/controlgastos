<x-normal-layout>
    <x-slot name="actionSlot">
        <x-icons.add class="icon__pointer" tooltip="Registra un proveedor" tooltip_aling="bottom" wire:click="newSupplierModal()"/>
        <x-search-component  wire:model="search" />
    </x-slot>
    <div class="content__container">
        <table class="table">
            <thead>
                <tr>
                    <th class="w-1/12">Accion</th>
                    <th class="">Nombre</th>
                    <th class="w-1/12">Cambio</th>
                    <th class="w-1/12">Moneda</th>
                </tr>
            </thead>
            <tbody>
                @foreach($suppliers as $s)
                    <tr>
                        <td>
                            <div class="flex__container__center">
                                <x-icons.edit class="icon__pointer" wire:click="editSupplier({{$s->id}})" tooltip="Editar" />
                                <x-icons.trash class="icon__pointer" wire:click="supplierToDestroy({{$s->id}})" tooltip="Eliminar" tooltip_aling="top"/>
                            </div>
                        </td>
                        <td>{{$s->name}}</td>
                        <td>${{$s->exchange}}</td>
                        <td>{{$s->currency->name}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="footer__container">
        <x-select-component wire:model="size_page"/>
        {{$suppliers->links()}}
    </div>

    {{-- Modales --}}
    <x-dialog-modal wire:model="newSupplierModal">
        <x-slot name="title" >
            Nuevo proveedor
        </x-slot>
        <x-slot name="content">
            <x-full-input-component label="Nombre" for="name" wire:model="name"/>
            <x-full-input-component label="Tipo de cambio" for="exchange" wire:model="exchange"/>
            <x-full-select-component wire:model="currency_id" for="currency_id" :items="$currencies" label="Selecciona una moneda"/>

        </x-slot>
        <x-slot name="footer">
            <x-button class="button-primary" wire:click="newSupplier">
                Aceptar
            </x-button>
            <x-button class="button-danger" wire:click="erase">
                Cancelar
            </x-button>
        </x-slot>
    </x-dialog-modal>

    <x-dialog-modal wire:model="editSupplierModal">
        <x-slot name="title" >
            Editar proveedor
        </x-slot>
        <x-slot name="content">
            <x-full-input-component label="Nombre" for="name" wire:model="name"/>
            <x-full-input-component label="Exchange" for="name" wire:model="exchange"/>
            <x-full-select-component wire:model="currency_id" for="currency_id" :items="$currencies" label="Selecciona una moneda"/>
        </x-slot>
        <x-slot name="footer">
            <x-button class="button-primary" wire:click="updateSupplier">
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
