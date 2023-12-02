
<x-normal-layout>
    <x-slot name="actionSlot">
    </x-slot>

    <div class="content__container flex max-w-full flex-col lg:flex-row space-x-0 lg:justify-between space-y-10 lg:space-y-0 py-10 lg:p-10">
        <div class="w-full lg:w-[30%]">
            <x-chart-doughnut-component class="h-96 w-full bg-white" :datasets="$datasetsDoughnut" :labels="$labelsDoughnut"/>
        {{--<ul class="bg-white">
                <li class="flex__container space-x-2 p-2 bg-blue-700 rounded-md text-white">
                    <x-icons.products/>
                    <span>Categoria 1</span>
                </li>
            </ul> --}}
        </div>
        <x-chart-component class="h-96 w-full lg:w-[60%] bg-white" :datasets="$datasets" :labels="$labels" />
    </div>

    <div class="footer__container">
    </div>
</x-normal-layout>
