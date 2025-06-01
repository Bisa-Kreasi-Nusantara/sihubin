@extends('layouts.app')

@section('title', 'internship-schedule')

@section('content')
    <!-- Breadcrumb Start -->
    <div x-data="{ pageName: `Internship Schedules` }">
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
                    <li class="text-sm text-gray-800 dark:text-white/90" x-text="pageName"></li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- ====== Table Start -->
    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">

        <div class="flex items-center justify-between px-6 py-4">

            <div class="flex items-center gap-2">
                <!-- Search Form -->
                <form action="{{ route('internship-schedule.index') }}" class="w-96">
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                        Search
                    </label>
                    <input type="text"
                        name="search"
                        placeholder="Type Here..."
                        value="{{request()->search}}"
                        class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
                </form>

                <!-- Filter Form -->
                <form action="{{ route('internship-schedule.index') }}" id="filterForm">

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-2">
                        
                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                Order By
                            </label>
                            <div x-data="{ isOptionSelected: false }" class="relative z-20 bg-transparent">
                                <select
                                    class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 pr-11 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                                    :class="isOptionSelected && 'text-gray-800 dark:text-white/90'"
                                    @change="isOptionSelected = true" name="order_by">
                                    <option class="text-gray-700 dark:bg-gray-900 dark:text-gray-400" selected disabled>Select Option</option>
                                    <option value="fullname" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400" {{ request()->order_by == 'fullname' ? 'selected' : '' }}>Fullname</option>
                                    <option value="company" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400" {{ request()->order_by == 'company' ? 'selected' : '' }}>Company</option>
                                    <option value="avg_scores" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400" {{ request()->order_by == 'avg_scores' ? 'selected' : '' }}>Avg. Scores</option>
                                    <option value="weighing_scores" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400" {{ request()->order_by == 'weighing_scores' ? 'selected' : '' }}>Weighing Scores Result</option>
                                    <option value="is_finished" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400" {{ request()->order_by == 'is_finished' ? 'selected' : '' }}>Is Finished</option>
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
                        
                        <div class="mt-6">
                            <div x-data="{ isOptionSelected: false }" class="relative z-20 bg-transparent">
                                <select
                                    class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 pr-11 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                                    :class="isOptionSelected && 'text-gray-800 dark:text-white/90'"
                                    @change="isOptionSelected = true" name="order_by_type">
                                    <option value="asc" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400" {{ request()->order_by_type == 'asc' ? 'selected' : '' }}>ASC</option>
                                    <option value="desc" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400" {{ request()->order_by_type == 'desc' ? 'selected' : '' }}>DESC</option>
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

                </form>
                
                <button type="button"
                    class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-white transition rounded-lg bg-brand-500 shadow-theme-xs hover:bg-brand-600 mt-6"
                    id="filterButton">
                    <i data-feather="search"></i>
                    Search
                </button>
                <a href="{{ route('internship-schedule.index') }}"
                    class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-white transition rounded-lg bg-warning-500 shadow-theme-xs hover:bg-warning-600 mt-6">
                    <i data-feather="trash"></i>
                    Clear Filter
                </a>

            </div>

            <!-- Buttons Container -->
            <div class="flex items-center gap-2">
                <!-- Create Button -->
                <a href="{{ route('internship-schedule.export') }}"
                    class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-white transition rounded-lg bg-success-500 shadow-theme-xs hover:bg-success-600">
                    <i data-feather="printer"></i>
                    Export Data
                </a>
            </div>
        </div>
    

        <div class="max-w-full overflow-x-auto">
            <table class="min-w-full">
                <!-- Table header -->
                <thead>
                    <tr class="border-b border-gray-100 dark:border-gray-800">
                        <th class="px-5 py-3 sm:px-6">
                            <div class="flex items-center">
                                <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">#</p>
                            </div>
                        </th>
                        <th class="px-5 py-3 sm:px-6">
                            <div class="flex items-center">
                                <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Fullname</p>
                            </div>
                        </th>
                        <th class="px-5 py-3 sm:px-6">
                            <div class="flex items-center">
                                <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Company</p>
                            </div>
                        </th>
                        <th class="px-5 py-3 sm:px-6">
                            <div class="flex items-center">
                                <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Avg Scores</p>
                            </div>
                        </th>
                        <th class="px-5 py-3 sm:px-6">
                            <div class="flex items-center">
                                <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Weighing Scores</p>
                            </div>
                        </th>
                        <th class="px-5 py-3 sm:px-6">
                            <div class="flex items-center">
                                <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Internship Date</p>
                            </div>
                        </th>
                        <th class="px-5 py-3 sm:px-6">
                            <div class="flex items-center">
                                <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Is Finished</p>
                            </div>
                        </th>
                        <th class="px-5 py-3 sm:px-6">
                            <div class="flex items-center">
                                <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Action</p>
                            </div>
                        </th>
                    </tr>
                </thead>

                <!-- Table body -->
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    @forelse ($internship_schedules as $row)
                        <tr>
                            <td class="px-5 py-4 sm:px-6">
                                <div class="flex items-center">
                                    <p class="text-gray-500 text-theme-sm dark:text-gray-400">{{ $loop->iteration }}</p>
                                </div>
                            </td>
                            <td class="px-5 py-4 sm:px-6">
                                <div class="flex items-center">
                                    <p class="text-gray-500 text-theme-sm dark:text-gray-400">{{ $row->user->fullname }}</p>
                                </div>
                            </td>
                            <td class="px-5 py-4 sm:px-6">
                                <div class="flex items-center">
                                    <p class="text-gray-500 text-theme-sm dark:text-gray-400">{{ $row->company->name }}</p>
                                </div>
                            </td>
                            <td class="px-5 py-4 sm:px-6">
                                <div class="flex items-center">
                                    <p class="text-gray-500 text-theme-sm dark:text-gray-400">{{ round($row->user->student->avg_scores, 2) }}</p>
                                </div>
                            </td>
                            <td class="px-5 py-4 sm:px-6">
                                <div class="flex items-center">
                                    <p class="text-gray-500 text-theme-sm dark:text-gray-400">{{ $row->acceptedWeighingResult->scores }}</p>
                                </div>
                            </td>
                            <td class="px-5 py-4 sm:px-6">
                                <div class="flex items-center">
                                    <p class="text-gray-500 text-theme-sm dark:text-gray-400">{{ date('d M Y', strtotime($row->start_date)) }} - {{ date('d M Y', strtotime($row->end_date)) }}</p>
                                </div>
                            </td>
                            <td class="px-5 py-4 sm:px-6">
                                <div class="flex items-center">
                                    @if (!$row->is_finished)
                                    <p
                                        class="rounded-full bg-warning-50 px-2 py-0.5 text-theme-xs font-medium text-warning-700 dark:bg-warning-500/15 dark:text-warning-500">
                                        Not Finish
                                    </p>
                                    @else
                                    <p
                                        class="rounded-full bg-success-50 px-2 py-0.5 text-theme-xs font-medium text-success-700 dark:bg-success-500/15 dark:text-success-500">
                                        Finished
                                    </p>
                                    @endif
                                </div>
                            </td>
                            <td class="px-5 py-4 sm:px-6">
                                <div class="flex items-center gap-2">

                                    @if (!$row->is_finished)
                                        @can('internship_schedules.edit')
                                        <a href="{{ route('internship-schedule.edit', $row->id) }}"
                                            class="inline-flex items-center gap-2 px-2.5 py-1.5 text-xs font-medium text-white transition rounded-md bg-warning-500 shadow hover:bg-warning-600">
                                            <i data-feather="edit" class="w-4 h-4"></i>
                                        </a>
                                        @endcan
                                        <a href="{{ route('internship-schedule.download', $row->id) }}"
                                            class="inline-flex items-center gap-2 px-2.5 py-1.5 text-xs font-medium text-white transition rounded-md bg-success-500 shadow hover:bg-success-600">
                                            <i data-feather="file-text" class="w-4 h-4"></i>
                                        </a>
                                    @else
                                        <a href="{{ route('internship-schedule.download', $row->id) }}"
                                            class="inline-flex items-center gap-2 px-2.5 py-1.5 text-xs font-medium text-white transition rounded-md bg-success-500 shadow hover:bg-success-600">
                                            <i data-feather="file-text" class="w-4 h-4"></i>
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                      @empty
                        <tr>
                            <td class="px-5 py-4 sm:px-6" colspan="7">
                                <div class="text-center">
                                    <p class="text-gray-500 font-semibold text-theme-sm dark:text-gray-400">No Data Available.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <!-- ====== Table End -->

    <!-- Import Modal -->
    <div id="importModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white dark:bg-gray-800 rounded-lg w-full max-w-md mx-auto p-6 shadow-lg">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold text-gray-800 dark:text-white">Import Internship Data</h2>
                <button id="closeImportModal" class="text-gray-500 hover:text-gray-800 dark:hover:text-white">
                    ✕
                </button>
            </div>

            <!-- Import Form -->
            <form action="{{ route('internship-schedule.create') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label for="file" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Upload File (CSV/Excel)</label>
                    <input type="file" name="file" id="file" accept=".csv, .xlsx, .xls"
                        class="block w-full border border-gray-300 rounded-md shadow-sm p-2 text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                </div>

                <div class="flex justify-end space-x-2">
                    <button type="button" id="cancelImport"
                        class="px-4 py-2 text-sm text-gray-600 hover:text-gray-800 dark:text-gray-300 dark:hover:text-white">
                        Cancel
                    </button>
                    <button type="submit"
                        class="px-4 py-2 text-sm text-white bg-brand-500 rounded hover:bg-brand-600">
                        Import
                    </button>
                </div>
            </form>
        </div>
    </div>


@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        $('#openImportModal').on('click', function () {
            $('#importModal').removeClass('hidden').addClass('flex');
        });

        $('#closeImportModal, #cancelImport').on('click', function () {
            $('#importModal').removeClass('flex').addClass('hidden');
        });
    });
</script>
@endpush

@push('scripts')
<script>

    $('#filterButton').click(function() {
        filterForm = $('#filterForm')
        filterForm.submit()
    })
    
</script>
@endpush