<!-- Desktop sidebar -->
<aside class="z-20 hidden w-64 overflow-y-auto bg-white dark:bg-gray-800 md:block flex-shrink-0">
    <div class="py-4 text-gray-500 dark:text-gray-400">
        <a href="{{ route('dashboard') }}" class="ml-6 text-lg font-bold text-gray-800 dark:text-gray-200">Dashboard</a>
        <ul class="mt-6">
        <li class="relative px-6 py-3">
            <a href="{{ route('dashboard') }}" class="inline-flex items-center w-full text-sm font-semibold text-gray-800 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 dark:text-gray-100">            
            <i class="fa fa-home"></i><span class="ml-4">Home</span>
            </a>
        </li>
        <li class="relative px-6 py-3">
            <a href="{{ route('create-task') }}" class="inline-flex items-center w-full text-sm font-semibold text-gray-800 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 dark:text-gray-100">            
            <i class="fa fa-add"></i> <span class="ml-4">Add Task</span>
            </a>
        </li>
        <li class="relative px-6 py-3">
            <a href="{{ route('task-categories') }}" class="inline-flex items-center w-full text-sm font-semibold text-gray-800 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 dark:text-gray-100">            
            <i class="fa fa-clone"></i> <span class="ml-4">Categories</span>
            </a>
        </li>
        <li class="relative px-6 py-3">
            <a href="{{ route('logout') }}" class="inline-flex items-center text-red-500 w-full text-sm font-semibold text-gray-800 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 dark:text-gray-100">            
            <i class="fa fa-sign-out"></i> <span class="ml-4">Logout</span>
            </a>
        </li>
        </ul>          
    </div>
</aside>

<!-- Mobile sidebar -->
<aside class="fixed inset-y-0 z-20 flex-shrink-0 w-48 pt-4 overflow-y-auto bg-white dark:bg-gray-800 md:hidden" x-show="isSideMenuOpen" x-transition:enter="transition ease-in-out duration-150" x-transition:enter-start="opacity-0 transform -translate-x-20" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in-out duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0 transform -translate-x-20" @click.away="closeSideMenu" @keydown.escape="closeSideMenu">
    <div class="py-4 text-gray-500 dark:text-gray-400">
        <a href="{{ url('dashboard') }}" class="ml-6 text-lg font-bold text-gray-800 dark:text-gray-200">Dashboard</a>
        <ul class="mt-6">
            <li class="relative px-6 py-3">
                <a href="{{ url('dashboard') }}" class="inline-flex items-center w-full text-sm font-semibold text-gray-800 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 dark:text-gray-100">
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