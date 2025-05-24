<!-- ===== Sidebar Start ===== -->
<aside :class="sidebarToggle ? 'translate-x-0 lg:w-[90px]' : '-translate-x-full'"
    class="sidebar fixed left-0 top-0 z-9999 flex h-screen w-[290px] flex-col overflow-y-hidden border-r border-gray-200 bg-white px-5 dark:border-gray-800 dark:bg-black lg:static lg:translate-x-0">
    <!-- SIDEBAR HEADER -->
    <div :class="sidebarToggle ? 'justify-center' : 'justify-between'"
        class="flex items-center gap-2 pt-8 sidebar-header pb-7">
        <a href="index.html">
            <span class="logo" :class="sidebarToggle ? 'hidden' : ''">
                {{-- light mode --}}
                <div class="dark:hidden">
                    {{-- <img src="{{asset('assets/images/logo/logo-icon.svg')}}" alt="Logo" class="h-8 w-8" /> --}}
                    <span class="font-bold text-2xl text-gray-900">SIHUBIN</span>
                </div>

                <div class="hidden dark:block ">
                    {{-- <img src="{{asset('assets/images/logo/logo-icon.svg')}}" alt="Logo" /> --}}
                    <span class="font-bold text-2xl text-gray-300">SIHUBIN</span>
                </div>

                {{-- dark mode --}}
                {{-- <img class="hidden dark:block" src="{{asset('assets/images/logo/logo-dark.svg')}}" alt="Logo"/> --}}
            </span>

            <img class="logo-icon" :class="sidebarToggle ? 'lg:block' : 'hidden'"
                src="{{ asset('assets/images/logo/logo-icon.svg') }}" alt="Logo" />
        </a>
    </div>
    <!-- SIDEBAR HEADER -->

    <div class="flex flex-col overflow-y-auto duration-300 ease-linear no-scrollbar">
        <!-- Sidebar Menu -->
        <nav x-data="{ selected: $persist('Dashboard') }">
            <!-- Menu Group -->
            <div>
                <h3 class="mb-4 text-xs uppercase leading-[20px] text-gray-400">
                    <span class="menu-group-title" :class="sidebarToggle ? 'lg:hidden' : ''">
                        MENU
                    </span>

                    <svg :class="sidebarToggle ? 'lg:block hidden' : 'hidden'"
                        class="mx-auto fill-current menu-group-icon" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M5.99915 10.2451C6.96564 10.2451 7.74915 11.0286 7.74915 11.9951V12.0051C7.74915 12.9716 6.96564 13.7551 5.99915 13.7551C5.03265 13.7551 4.24915 12.9716 4.24915 12.0051V11.9951C4.24915 11.0286 5.03265 10.2451 5.99915 10.2451ZM17.9991 10.2451C18.9656 10.2451 19.7491 11.0286 19.7491 11.9951V12.0051C19.7491 12.9716 18.9656 13.7551 17.9991 13.7551C17.0326 13.7551 16.2491 12.9716 16.2491 12.0051V11.9951C16.2491 11.0286 17.0326 10.2451 17.9991 10.2451ZM13.7491 11.9951C13.7491 11.0286 12.9656 10.2451 11.9991 10.2451C11.0326 10.2451 10.2491 11.0286 10.2491 11.9951V12.0051C10.2491 12.9716 11.0326 13.7551 11.9991 13.7551C12.9656 13.7551 13.7491 12.9716 13.7491 12.0051V11.9951Z"
                            fill="" />
                    </svg>
                </h3>

                <ul class="flex flex-col gap-4 mb-6">
                    @can('dashboard.view')
                    <li>
                        <a href="{{route('dashboard')}}" class="menu-item group {{Request::is('/') ? 'menu-item-active' : 'menu-item-inactive'}}">
                            <i data-feather="home"></i>
                            <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : ''">
                                Dashboard
                            </span>
                        </a>
                    </li>
                    @endcan
                    @can('internship_request.view')    
                    <li>
                        <a href="{{route('internship-request.index')}}" class="menu-item group {{Request::is('internship-request') ? 'menu-item-active' : 'menu-item-inactive'}}">
                            <i data-feather="clipboard"></i>
                            <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : ''">
                                Internship Request
                            </span>
                        </a>
                    </li>
                    @endcan
                    @can('weighing_result.view')
                    <li>
                        <a href="{{route('weighing-result.index')}}" class="menu-item group  {{Request::is('weighing-result') ? 'menu-item-active' : 'menu-item-inactive'}}">
                            <i data-feather="sliders"></i>
                            <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : ''">
                                Weighing Result
                            </span>
                        </a>
                    </li>
                    @endcan
                    @can('internship_schedules.view')
                    <li>
                        <a href="{{route('internship-schedule.index')}}" class="menu-item group {{Request::is('internship-schedule') ? 'menu-item-active' : 'menu-item-inactive'}}">
                            <i data-feather="calendar"></i>
                            <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : ''">
                                Internship Schedules
                            </span>
                        </a>
                    </li>
                    @endcan
                </ul>
            </div>

            <!-- Others Group -->
            <div>
                <h3 class="mb-4 text-xs uppercase leading-[20px] text-gray-400">
                    <span class="menu-group-title" :class="sidebarToggle ? 'lg:hidden' : ''">
                        Master Data
                    </span>

                    <svg :class="sidebarToggle ? 'lg:block hidden' : 'hidden'"
                        class="mx-auto fill-current menu-group-icon" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M5.99915 10.2451C6.96564 10.2451 7.74915 11.0286 7.74915 11.9951V12.0051C7.74915 12.9716 6.96564 13.7551 5.99915 13.7551C5.03265 13.7551 4.24915 12.9716 4.24915 12.0051V11.9951C4.24915 11.0286 5.03265 10.2451 5.99915 10.2451ZM17.9991 10.2451C18.9656 10.2451 19.7491 11.0286 19.7491 11.9951V12.0051C19.7491 12.9716 18.9656 13.7551 17.9991 13.7551C17.0326 13.7551 16.2491 12.9716 16.2491 12.0051V11.9951C16.2491 11.0286 17.0326 10.2451 17.9991 10.2451ZM13.7491 11.9951C13.7491 11.0286 12.9656 10.2451 11.9991 10.2451C11.0326 10.2451 10.2491 11.0286 10.2491 11.9951V12.0051C10.2491 12.9716 11.0326 13.7551 11.9991 13.7551C12.9656 13.7551 13.7491 12.9716 13.7491 12.0051V11.9951Z"
                            fill="" />
                    </svg>
                </h3>

                <ul class="flex flex-col gap-4 mb-6">
                    @can('users_management.view')
                    <li>
                        <a href="{{ route('users-management.index') }}" class="menu-item group {{Request::is('users-management') ? 'menu-item-active' : 'menu-item-inactive'}}">
                            <i data-feather="users"></i>
                            <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : ''">
                                Users Management
                            </span>
                        </a>
                    </li>
                    @endcan
                    @can('student_management.view')
                    <li>
                        <a href="{{ route('students-management.index') }}" class="menu-item group {{Request::is('students-management') ? 'menu-item-active' : 'menu-item-inactive'}}">
                            <i data-feather="user"></i>
                            <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : ''">
                                Students Management
                            </span>
                        </a>
                    </li>
                    @endcan
                    @can('majors_management.view')
                    <li>
                        <a href="{{ route('majors-management.index') }}" class="menu-item group {{Request::is('majors-management') ? 'menu-item-active' : 'menu-item-inactive'}}">
                            <i data-feather="box"></i>
                            <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : ''">
                                Majors Management
                            </span>
                        </a>
                    </li>
                    @endcan
                    @can('companies_management.view')   
                    <li>
                        <a href="{{route('companies-management.index')}}" class="menu-item group {{Request::is('companies-management') ? 'menu-item-active' : 'menu-item-inactive'}}">
                            <i data-feather="grid"></i>
                            <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : ''">
                                Companies Management
                            </span>
                        </a>
                    </li>
                    @endcan
                    @can('criteria_weight_management.view')
                    <li>
                        <a href="{{route('criteria-weight-management.index')}}" class="menu-item group {{Request::is('criteria-weight-management') ? 'menu-item-active' : 'menu-item-inactive'}}">
                            <i data-feather="sliders"></i>
                            <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : ''">
                                Criteria Weight Management
                            </span>
                        </a>
                    </li>
                    @endcan
                </ul>
            </div>
        </nav>
        <!-- Sidebar Menu -->
    </div>
</aside>

<!-- ===== Sidebar End ===== -->
