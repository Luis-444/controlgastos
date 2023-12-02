<x-normal-layout>
    <div class="view__container">
        <x-slot name="actionSlot">
            <x-button class="button-primary" tooltip="Registrar nueva compra" tooltip_aling="bottom" onclick="window.location.href = '/nueva_compra';">
                Nueva Compra
            </x-button>
            <x-search-component  wire:model="search"/>
        </x-slot>
        <div class="content__container">
            <table class="table">
                <thead>
                    <tr>
                        <th class="w-1/12">Accion</th>
                        <th class="w-1/12">Folio</th>
                        <th class="w-2/12">Fecha</th>
                        <th class="w-3/12">Proveedor</th>
                        <th class="">Notas</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($purchases as $p)
                        <tr>
                            <td>
                                <div class="flex__container__center">
                                    <a href="mostrar_compra/{{$p->id}}">
                                        <x-icons.eye class="icon__pointer" wire:click="" tooltip="" tooltip_aling="top"/>
                                    </a>
                                </div>
                            </td>
                            <td>{{$p->folio}}</td>
                            <td>{{$p->date}}</td>
                            <td>{{$p->supplier->name}}</td>
                            <td>{{$p->notes}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="footer__container">
            <x-select-component wire:model="size_page"/>
            {{$purchases->links()}}
        </div>
    </div>
</x-normal-layout>
