<x-normal-layout>
    <x-slot name="actionSlot">
        <x-icons.add class="icon__pointer" tooltip="Registra una Moneda" tooltip_aling="bottom" wire:click="newCurrencyModal()"/>
        <x-search-component  wire:model="search" />
    </x-slot>
    <div class="content__container">
        <table class="table">
            <thead>
                <tr>
                    <th class="w-1/12">Accion</th>
                    <th class="">Nombre</th>
                </tr>
            </thead>
            <tbody>
                @foreach($currencies as $c)
                    <tr>
                        <td>
                            <div class="flex__container__center">
                                <x-icons.edit class="icon__pointer" wire:click="editCurrency({{$c->id}})" tooltip="Editar" />
                                <x-icons.trash class="icon__pointer" wire:click="currencyToDestroy({{$c->id}})" tooltip="Eliminar" tooltip_aling="top"/>
                            </div>
                        </td>
                        <td>{{$c->name}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="footer__container">
        <x-select-component wire:model="size_page"/>
        {{$currencies->links()}}
    </div>



    {{-- Modales --}}
    <x-dialog-modal wire:model="newCurrencyModal">
        <x-slot name="title" >
            Nueva moneda
        </x-slot>
        <x-slot name="content">
            <x-full-input-component label="Nombre" for="name" wire:model="name"/>
        </x-slot>
        <x-slot name="footer">
            <x-button class="button-primary" wire:click="newCurrency">
                Aceptar
            </x-button>
            <x-button class="button-danger" wire:click="erase">
                Cancelar
            </x-button>
        </x-slot>
    </x-dialog-modal>

    <x-dialog-modal wire:model="editCurrencyModal">
        <x-slot name="title" >
            Editar concepto
        </x-slot>
        <x-slot name="content">
            <x-full-input-component label="Nombre" for="name" wire:model="name"/>
        </x-slot>
        <x-slot name="footer">
            <x-button class="button-primary" wire:click="updateCurrency">
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
