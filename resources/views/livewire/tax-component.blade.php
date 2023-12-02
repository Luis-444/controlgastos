<x-normal-layout>
    <x-slot name="actionSlot">
        <x-icons.add class="icon__pointer" tooltip="Registra un impuesto" tooltip_aling="bottom" wire:click="newTaxModal()"/>
        <x-search-component  wire:model="search" />
    </x-slot>
    <div class="content__container">
        <table class="table">
            <thead>
                <tr>
                    <th class="w-1/12">Accion</th>
                    <th class="w-1/12">Codigo</th>
                    <th class="">Nombre</th>
                    <th class="w-1/12">Porcentage</th>
                </tr>
            </thead>
            <tbody>
                @foreach($taxes as $t)
                    <tr>
                        <td>
                            <div class="flex__container__center">
                                <x-icons.edit class="icon__pointer" wire:click="editTax({{$t->id}})" tooltip="Editar" />
                                <x-icons.trash class="icon__pointer" wire:click="taxToDestroy({{$t->id}})" tooltip="Eliminar" tooltip_aling="top"/>
                            </div>
                        </td>
                        <td>{{$t->code}}</td>
                        <td>{{$t->name}}</td>
                        <td>{{$t->percentage}}%</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="footer__container">
        <x-select-component wire:model="size_page"/>
        {{$taxes->links()}}
    </div>

    {{-- Modales --}}
    <x-dialog-modal wire:model="newTaxModal">
        <x-slot name="title" >
            Nuevo Impuesto
        </x-slot>
        <x-slot name="content">
            <x-full-input-component label="Codigo" for="code" wire:model="code"/>
            <x-full-input-component label="Nombre" for="name" wire:model="name"/>
            <x-full-input-component label="Porcentaje" for="percentage" wire:model="percentage"/>
        </x-slot>
        <x-slot name="footer">
            <x-button class="button-primary" wire:click="newTax">
                Aceptar
            </x-button>
            <x-button class="button-danger" wire:click="erase">
                Cancelar
            </x-button>
        </x-slot>
    </x-dialog-modal>

    <x-dialog-modal wire:model="editTaxModal">
        <x-slot name="title" >
            Editar proveedor
        </x-slot>
        <x-slot name="content">
            <x-full-input-component label="Codigo" for="code" wire:model="code"/>
            <x-full-input-component label="Nombre" for="name" wire:model="name"/>
            <x-full-input-component label="Porcentaje" for="precentage" wire:model="percentage"/>
        </x-slot>
        <x-slot name="footer">
            <x-button class="button-primary" wire:click="updateTax">
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
