@extends('layouts.app')

@section('title', 'Edit criteria-weight-management')

@section('content')
    <!-- Breadcrumb Start -->
    <div x-data="{ pageName: `Criteria Weight Management` }">
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
        <form action="{{ route('criteria-weight-management.update', $criteria->id) }}" method="POST" enctype="multipart/form-data" class="w-full">
            @csrf
            @method('PUT')
    
            <div class="border-t border-gray-100 p-4 dark:border-gray-800 sm:p-6">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Full Name -->
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            Name
                        </label>
                        <input type="text"
                            class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                            autocomplete="name"
                            name="name"
                            value="{{$criteria->name}}"
                            />
                    </div>

                    {{-- Max Capacity --}}
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            Weight Value
                        </label>
                        <input type="number"
                            min="0" 
                            max="5"
                            step="0.01" 
                            inputmode="decimal"
                            pattern="\d+(\.\d{1,2})?"
                            placeholder="e.g. 4.5"
                            title="Please use dot (.) as decimal separator"
                            class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                            autocomplete="weight_value"
                            name="weight_value" 
                            value="{{$criteria->weight_value}}" 
                            />
                    </div>

                    <!-- Select Input -->
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            Select Type
                        </label>
                        <div x-data="{ isOptionSelected: false }" class="relative z-20 bg-transparent">
                            <select
                                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 pr-11 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                                :class="isOptionSelected && 'text-gray-800 dark:text-white/90'"
                                @change="isOptionSelected = true" 
                                name="type">
                                <option class="text-gray-700 dark:bg-gray-900 dark:text-gray-400" selected disabled>Select Option</option>
                                <option value="benefit" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400" {{$criteria->type == 'benefit' ? 'selected' : ''}}>Benefit</option>
                                <option value="Cost" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400" {{$criteria->type == 'cost' ? 'selected' : ''}}>Cost</option>
                            </select>
                            <span
                                class="pointer-events-none absolute top-1/2 right-4 z-30 -translate-y-1/2 text-gray-500 dark:text-gray-400">
                                <svg class="stroke-current" width="20" height="20" viewBox="0 0 20 20" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M4.79175 7.396L10.0001 12.6043L15.2084 7.396" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </span>
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
