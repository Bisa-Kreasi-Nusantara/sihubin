@extends('layouts.app')

@section('title', 'Edit role-permission')

@section('content')
    <!-- Breadcrumb Start -->
    <div x-data="{ pageName: `Role Permission Management` }">
        <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90" x-text="pageName"></h2>

            <nav>
                <ol class="flex items-center gap-1.5">
                    <li>
                        <a class="inline-flex items-center gap-1.5 text-sm text-gray-500 dark:text-gray-400"
                            href="index.html">
                            Home
                            <svg class="stroke-current" width="17" height="16" viewBox="0 0 17 16" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M6.0765 12.667L10.2432 8.50033L6.0765 4.33366" stroke="" stroke-width="1.2"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </a>
                    </li>
                    <li class="text-sm text-gray-500 dark:text-white/90" x-text="pageName"></li>
                    <li class="flex items-center gap-1.5 text-sm text-gray-800 dark:text-white/90">
                        <svg class="stroke-current" width="17" height="16" viewBox="0 0 17 16" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M6.0765 12.667L10.2432 8.50033L6.0765 4.33366" stroke="" stroke-width="1.2"
                                stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <span> Edit </span>
                    </li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
        <form action="{{ route('role-permission.update', $role->id) }}" method="POST" enctype="multipart/form-data" class="w-full">
            @csrf
            @method('PUT')
    
            <div class="border-t border-gray-100 p-4 dark:border-gray-800 sm:p-6">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Full Name -->
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            Role Name
                        </label>
                        <input type="text"
                            class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                            autocomplete="name" 
                            name="name"
                            value="{{$role->name}}" />
                    </div>

                    <!-- Permissions -->
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-400 mb-2">
                        Permissions
                    </label>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                        <div class="flex items-center mb-2">
                            <input type="checkbox" id="select-all" class="mr-2">
                            <label for="select-all" class="text-sm text-gray-700 dark:text-gray-400">Select All Permissions</label>
                        </div>
                        <div id="permissions-list">
                            @foreach($permissions as $permission)
                                <div class="flex items-center mb-1">
                                    <input
                                        type="checkbox"
                                        name="permissions[]"
                                        value="{{ $permission->id }}"
                                        {{ $role->permissions->contains($permission->id) ? 'checked' : '' }}
                                        class="permission-checkbox mr-2">
                                    <label class="text-sm text-gray-700 dark:text-gray-400">
                                        {{ $permission->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
    
                <!-- Submit Button -->
                <div class="w-full flex justify-end mt-6">
                    <button type="submit"
                        class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-white transition rounded-lg bg-brand-500 shadow-theme-xs hover:bg-brand-600">
                        Submit
                    </button>
                </div>
            </div>
        </form>
    </div>
    
    
@endsection

@push('scripts')
<script>
    document.getElementById('select-all').addEventListener('change', function () {
        const checked = this.checked;
        document.querySelectorAll('.permission-checkbox').forEach(cb => {
            cb.checked = checked;
        });
    });
</script>
@endpush