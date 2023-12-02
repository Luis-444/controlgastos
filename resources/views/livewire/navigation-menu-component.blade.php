<div
    x-data="{
        toggleSidebar(){
            $sidebar = document.getElementById('sidebar');
            $sidebar.classList.toggle('sidebar_closed');
            sidebar = !sidebar;
            localStorage.setItem('Sidebar', sidebar);
            console.log(sidebar)
        },
        closeSidebar(){
            $sidebar = document.getElementById('sidebar');
            $sidebar.classList.toggle('sidebar_closed');
        },
        color: '',
        user_menu: false
    }"
    x-init="
        $wire.on('notification', (dinamycColor)=>{
            color = dinamycColor;
        });
        $wire.on('errorsNotification', (dinamycColor)=>{
            color = dinamycColor;
        });
        if(!sidebar){
            closeSidebar();
        }
    "
    id="sidebar" x-show="sidebar" style="display: none"
    x-transition:enter="transition ease-in duration-700"
    x-transition:enter-start="opacity-0 w-0"
    x-transition:enter-end="opacity-100 w-[250px]"
    x-transition:leave="transition ease-in duration-300"
    x-transition:leave-start="opacity-100 w-[250px]"
    x-transition:leave-end="opacity-0 w-0"
    class="sidebar">

    <div class="flex__container__between p-2 text-secondary overflow-hidden">
        <x-icons.menu x-on:click="toggleSidebar" class="icon__pointer block md:hidden"/>
    </div>
    <div class="sidebar__content overflow-hidden">
        @foreach ($menus as $menu)
            <p class="sidebar__submenu__title">{{ $menu['text'] }}</p>
            <div class="sidebar__submenu__container">
                @foreach ($menu['subMenu'] as $submenu)
                    <a href="{{$submenu['route']}}" class="sidebar__submenu__link hidden md:flex {{ '/'.$currentRoute === $submenu['route'] ? 'bg-cyan-600' : '' }}">
                        @component($submenu['icon'])@endcomponent
                        <p>{{ $submenu['text'] }}</p>
                    </a>
                    <a x-on:click="localStorage.setItem('Sidebar', false);" href="{{$submenu['route']}}" class="sidebar__submenu__link flex md:hidden {{ '/'.$currentRoute === $submenu['route'] ? 'bg-cyan-600' : '' }}">
                        @component($submenu['icon'])@endcomponent
                        <p>{{ $submenu['text'] }}</p>
                    </a>
                @endforeach
            </div>
        @endforeach
    </div>

    <div class="sidebar__footer overflow-hidden">
        <div class="w-full relative hidden md:block">
            <div x-on:click="user_menu = !user_menu" class="flex__container__between p-2 space-x-2 text-secondary cursor-pointer">
                <div class="flex__container space-x-2">
                    <img class="h-8 aspect-square rounded-full" src="{{Auth::user() ? Auth::user()->profile_photo_url : ''}}" alt="" srcset="">
                    <span class="text-secondary text-md truncate">{{Auth::user() ? Auth::user()->name : ''}}</span>
                </div>
                <x-icons.right-arrow />
            </div>
        </div>
        <div class="flex space-x-2 md:hidden items-center text-secondary w-full p-2 justify-between">
            <a href="/mi-perfil" class="flex__container flex-1 space-x-2">
                <x-icons.user/>
                <span>Mi perfil</span>
            </a>
            <form action="/logout" method="post">
                @csrf
                <button type="submit" class="flex__container justify-end flex-1 space-x-2">
                    <x-icons.logout/>
                    <span>Cerrar sesion</span>
                </button>
            </form>
            <hr>
        </div>
    </div>
    <div  x-on:click.outside="user_menu = false" x-show="user_menu" x-transition class="profile__menu" style="display:none;">
        <a href="/mi-perfil" class="flex__container space-x-2 truncate">
            <x-icons.user/>
            <span>Mi perfil</span>
        </a>
        <hr>
        <form class="w-full flex__container__center" method="post" action="/logout">
            @csrf
            <x-button icon="logout" type="submit" class="button-danger p-2 rounded-md">Cerrar sesión</x-button>
        </form>
    </div>
</div>
