@extends('layouts.app')

@section('title', 'company-refrences')

@section('content')
    <!-- Breadcrumb Start -->
    <div x-data="{ pageName: `Company References` }">
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

    @if(session('import_errors'))
        <div class="bg-error-100 border border-error-400 text-error-700 px-4 py-3 rounded mb-4">
            <h4 class="font-bold mb-2">Terjadi kesalahan saat import:</h4>
            <ul class="list-disc list-inside">
                @foreach(session('import_errors') as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <!-- ====== Table Start -->
    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">

        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4 px-6 py-4">

            <!-- Search Form -->
            <form action="{{ route('company-refrences.show-refrences') }}" method="POST" class="w-full md:w-auto" id="filterForm">
                <label for="searchInput" class="block mb-1.5 text-sm font-medium text-gray-700 dark:text-gray-400">
                    Search Student
                </label>
                @csrf
                <input
                    id="searchInput"
                    type="text"
                    required
                    name="student_name"
                    placeholder="Type here..."
                    value="{{ Auth::user()->role->name == 'student' ? Auth::user()->fullname : '' }}"
                    {{ Auth::user()->role->name == 'student' ? 'readonly' : '' }}
                    class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 shadow-theme-xs focus:border-brand-300 focus:ring-3 focus:ring-brand-500/10 focus:outline-none dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800 dark:bg-dark-900"
                />
                <!-- Show References Button -->
                <button
                    type="submit"
                    class="inline-flex items-center gap-2 px-4 py-2 mt-2 md:mt-6 text-sm font-medium text-white transition bg-brand-500 rounded-lg shadow-theme-xs hover:bg-brand-600"
                >
                    <i data-feather="search"></i>
                    Show References
                </button>
            </form>


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
                                <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Company Name</p>
                            </div>
                        </th>
                        <th class="px-5 py-3 sm:px-6">
                            <div class="flex items-center">
                                <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Reputation</p>
                            </div>
                        </th>
                        <th class="px-5 py-3 sm:px-6">
                            <div class="flex items-center">
                                <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Address</p>
                            </div>
                        </th>
                        <th class="px-5 py-3 sm:px-6">
                            <div class="flex items-center">
                                <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Max Capacity</p>
                            </div>
                        </th>
                        <th class="px-5 py-3 sm:px-6">
                            <div class="flex items-center">
                                <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Weighing Scores</p>
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
                    @forelse ($refrences as $row)
                        <tr>
                            <td class="px-5 py-4 sm:px-6">
                                <div class="flex items-center">
                                    <p class="text-gray-500 text-theme-sm dark:text-gray-400">{{ $loop->iteration }}</p>
                                </div>
                            </td>
                            <td class="px-5 py-4 sm:px-6">
                                <div class="flex items-center">
                                    <p class="text-gray-500 text-theme-sm dark:text-gray-400">{{ $row['company_name'] }}</p>
                                </div>
                            </td>
                            <td class="px-5 py-4 sm:px-6">
                                <div class="flex items-center">
                                    <p class="text-gray-500 text-theme-sm dark:text-gray-400">{!! str_repeat('★', min($row['company_reputations'], 5)) . str_repeat('☆', 5 - min($row['company_reputations'], 5)) !!} ({{$row['company_reputations']}})</p>
                                </div>
                            </td>
                            <td class="px-5 py-4 sm:px-6">
                                <div class="flex items-center">
                                    <p class="text-gray-500 text-theme-sm dark:text-gray-400">{{ $row['company_address'] }}</p>
                                </div>
                            </td>
                            <td class="px-5 py-4 sm:px-6">
                                <div class="flex items-center">
                                    <p class="text-gray-500 text-theme-sm dark:text-gray-400">{{ $row['current_students'] }} / {{ $row['company_capacity'] }}</p>
                                </div>
                            </td>
                            <td class="px-5 py-4 sm:px-6">
                                <div class="flex items-center">
                                    <p class="text-gray-500 text-theme-sm dark:text-gray-400">{{ $row['weighing_scores'] }}</p>
                                </div>
                            </td>
                            <td class="px-5 py-4 sm:px-6">
                                <div class="flex items-center gap-2">
                                    <a href="javascript:void(0);"
                                        data-url="{{ route('company-refrences.request-internship', ['data' => base64_encode(serialize($row))]) }}"
                                        class="action-button inline-flex items-center gap-2 px-2.5 py-1.5 text-xs font-medium text-white transition rounded-md bg-success-500 shadow hover:bg-success-600">
                                        Request
                                    </a>
                                </div>
                            </td>
                        </tr>
                      @empty
                        <tr>
                            <td class="px-5 py-4 sm:px-6" colspan="7">
                                <div class="text-center">
                                    <p class="text-gray-500 font-semibold text-theme-sm dark:text-gray-400">Please Search Student First.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                    {{-- @if (count($refrences) >= 1)
                        <tr>
                            <td class="px-5 py-4 sm:px-6" colspan="6">
                                <p class="text-xs">Note: By pressing the "Apply for Internship" button, it means that you agree to the company recommended by the system.</p>
                                <div class="text-center">
                                    <form action="#" method="POST">
                                        @csrf
                                        <input type="hidden" name="data_refrences" value="{{$refrences}}">
                                        <button
                                        href="#"
                                        class="inline-flex items-center gap-2 px-4 py-2 mt-2 md:mt-6 text-sm font-medium text-white transition bg-brand-500 rounded-lg shadow-theme-xs hover:bg-brand-600">
                                        Apply for Internship
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endif --}}
                </tbody>
            </table>
        </div>
    </div>
    <!-- ====== Table End -->

@endsection

@push('scripts')
<script>

    $('#filterButton').click(function() {
        filterForm = $('#filterForm')
        filterForm.submit()
    })

</script>
@endpush
