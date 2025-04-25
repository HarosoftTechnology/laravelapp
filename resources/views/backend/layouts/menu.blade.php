<!-- Desktop sidebar -->
<aside class="z-20 hidden w-64 overflow-y-auto bg-white dark:bg-gray-800 md:block flex-shrink-0">
    <div class="py-4 text-gray-500 dark:text-gray-400">
        <a href="{{ route('admin-dashboard') }}" class="ml-6 text-lg font-bold text-gray-800 dark:text-gray-200">Dashboard</a>
        <ul class="mt-6">
            @foreach (get_menus("admin-menu") as $menu)
                <li class="relative px-6 py-3 {{ ($menu->isActive()) ? 'active-menu' : '' }} {{ ($menu->hasChildren() && $menu->isActive()) ? 'open' : '' }}">
                    <a href="{{ ($menu->hasChildren()) ? 'javascript:void(0);' : $menu->link }}"
                       class="inline-flex items-center w-full text-sm font-semibold text-gray-800 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 dark:text-gray-100"
                       {{ ($menu->hasChildren()) ? '@click="togglePagesMenu"' : '' }} aria-haspopup="true">
                        <span class="inline-flex items-center">
                            <i class="{{ $menu->icon }}"></i>
                            <span class="ml-4">{{ $menu->title }}</span>
                        </span>
                        @if($menu->hasChildren())
                            <i class="fa fa-angle-down ml-1"></i>
                        @endif
                    </a>
                    @if ($menu->hasChildren())
                        <template x-if="isPagesMenuOpen">
                            <ul x-transition:enter="transition-all ease-in-out duration-300"
                                x-transition:enter-start="opacity-25 max-h-0"
                                x-transition:enter-end="opacity-100 max-h-xl"
                                x-transition:leave="transition-all ease-in-out duration-300"
                                x-transition:leave-start="opacity-100 max-h-xl"
                                x-transition:leave-end="opacity-0 max-h-0"
                                class="p-2 mt-2 space-y-2 overflow-hidden text-sm font-medium text-gray-500 rounded-md shadow-inner bg-gray-50 dark:text-gray-400 dark:bg-gray-900"
                                aria-label="submenu">
                                @foreach ($menu->children as $subMenu)
                                    <li class="{{ ($subMenu->isActive()) ? 'active-menu' : '' }} px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200">
                                        <a href="{{ ($subMenu->hasChildren()) ? 'javascript:void(0);' : $subMenu->link }}"
                                           class="w-full" {{ ($subMenu->hasChildren()) ? '@click="togglePagesMenu"' : '' }}
                                           aria-haspopup="true">{{ $subMenu->title }}</a>
                                    </li>
                                    @if ($subMenu->hasChildren())
                                        <ul x-transition:enter="transition-all ease-in-out duration-300"
                                            x-transition:enter-start="opacity-25 max-h-0"
                                            x-transition:enter-end="opacity-100 max-h-xl"
                                            x-transition:leave="transition-all ease-in-out duration-300"
                                            x-transition:leave-start="opacity-100 max-h-xl"
                                            x-transition:leave-end="opacity-0 max-h-0"
                                            class="p-2 mt-2 space-y-2 overflow-hidden text-sm font-medium text-gray-500 rounded-md shadow-inner bg-gray-50 dark:text-gray-400 dark:bg-gray-900"
                                            aria-label="submenu">
                                            @foreach ($subMenu->children as $sMenu)
                                                <li class="{{ ($sMenu->isActive()) ? 'active-menu' : '' }} px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200">
                                                    <a href="{{ $sMenu->link }}" class="w-full">
                                                        {{ $sMenu->title }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                @endforeach
                            </ul>
                        </template>
                    @endif
                </li>
            @endforeach
        </ul>
                 
    </div>
</aside>

<!-- Mobile sidebar -->
<aside class="fixed inset-y-0 z-20 flex-shrink-0 w-48 pt-4 overflow-y-auto bg-white dark:bg-gray-800 md:hidden" x-show="isSideMenuOpen" x-transition:enter="transition ease-in-out duration-150" x-transition:enter-start="opacity-0 transform -translate-x-20" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in-out duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0 transform -translate-x-20" @click.away="closeSideMenu" @keydown.escape="closeSideMenu">
    <div class="py-4 text-gray-500 dark:text-gray-400">
        <a href="{{ url('admin-dashboard') }}" class="ml-6 text-lg font-bold text-gray-800 dark:text-gray-200">Dashboard</a>
        <ul class="mt-6">
            <li class="relative px-6 py-3">
                <a href="{{ url('admin-dashboard') }}" class="inline-flex items-center w-full text-sm font-semibold text-gray-800 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 dark:text-gray-100">
                <i class="fa fa-home"></i> <span class="ml-4">Home</span>
                </a>
            </li>
            <li class="relative px-6 py-3">
                <a href="{{ url('task/categories') }}" class="inline-flex items-center w-full text-red-500 text-sm font-semibold text-gray-800 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 dark:text-gray-100">
                <i class="fa fa-clone"></i> <span class="ml-4">Categories</span>
                </a>
            </li>
            <li class="relative px-6 py-3">
                <a href="{{ url('logout') }}" class="inline-flex items-center w-full text-red-500 text-sm font-semibold text-gray-800 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 dark:text-gray-100">
                <i class="fa fa-sign-out"></i> <span class="ml-4 text-red">Logout</span>
                </a>
            </li>
        </ul>
    </div>
</aside>