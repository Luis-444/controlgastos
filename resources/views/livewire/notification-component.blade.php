<div
    x-data="{
        color: '',
    }"
    x-init="
        $wire.on('notification', (dinamycColor)=>{
            color = dinamycColor;
        });
    ">
    {{-- <x-action-message x-bind:style="'background-color: ' + color" class="notification" on="notification">
        {{ $message }}
    </x-action-message> --}}
    <x-action-message class="absolute right-1 bottom-1 p-3 z-[100000]" on="notification">
        <div class="flex h-full shadow-md border border-gray-200 bg-primary text-white w-full">
            <div  x-bind:style="'background-color: ' + color" class="flex items-center justify-center h-[48px] aspect-square">
                <svg p-3 xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-secondary">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0M3.124 7.5A8.969 8.969 0 015.292 3m13.416 0a8.969 8.969 0 012.168 4.5" />
                </svg>
            </div>
            <label class="label-message-dialog2 p-3" for="">{{ $message }}</label>
        </div>
    </x-action-message>
</div>
