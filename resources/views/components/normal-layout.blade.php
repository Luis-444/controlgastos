<div class="view__container"
    x-data="{
        toggleSidebar(){
            $sidebar = document.getElementById('sidebar');
            $sidebar.classList.toggle('sidebar_closed');
            sidebar = !sidebar;
            console.log(sidebar)
            localStorage.setItem('Sidebar', sidebar);
        }
    }">
    <div class="topbar">
        <div class="flex__container space-x-2">
            <x-icons.menu x-on:click="toggleSidebar" class="icon__pointer"/>
            <span wire:ignore> {{ Route::currentRouteName() }} </span>
        </div>
        <div class="topbar__action__slot">
            {{ $actionSlot }}
        </div>
    </div>
    <div class="p-2 space-y-2 overflow-hidden flex-1 flex flex-col">
        {{ $slot }}
    </div>
</div>
