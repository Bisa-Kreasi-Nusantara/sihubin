@extends('layouts.app')

@section('title', 'internship-request')

@section('content')
    <!-- Breadcrumb Start -->
    <div x-data="{ pageName: `Internship Request` }">
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

        <div class="flex items-center justify-between px-6 py-4">

            <div class="flex items-center gap-2">
                <!-- Search Form -->
                <form action="{{ route('internship-request.index') }}" class="w-96">
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                        Search
                    </label>
                    <input type="text"
                        name="search"
                        placeholder="Type here..."
                        value="{{ request()->search }}"
                        class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
                </form>

                <!-- Filter Form -->
                <form action="{{ route('internship-request.index') }}" id="filterForm">

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
                                    {{-- <option value="avg_scores" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400" {{ request()->order_by == 'avg_scores' ? 'selected' : '' }}>Avg. Scores</option> --}}
                                    {{-- <option value="estimated_distance" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400" {{ request()->order_by == 'estimated_distance' ? 'selected' : '' }}>Estimated Distance</option> --}}
                                    <option value="weighing_scores" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400" {{ request()->order_by == 'weighing_scores' ? 'selected' : '' }}>Weighing Scores</option>
                                    <option value="requested_company" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400" {{ request()->order_by == 'requested_company' ? 'selected' : '' }}>Requested Company</option>
                                    <option value="requested_date" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400" {{ request()->order_by == 'requested_date' ? 'selected' : '' }}>Requested Date</option>
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
                <a href="{{ route('internship-request.index') }}"
                    class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-white transition rounded-lg bg-warning-500 shadow-theme-xs hover:bg-warning-600 mt-6">
                    <i data-feather="trash"></i>
                    Clear Filter
                </a>

            </div>

            <!-- Buttons Container -->
            <div class="flex items-center gap-2">
                <!-- Import Button -->

                {{-- @can('internship_request.import')
                <div x-data="{isModalOpen: false}">
                    <button @click="isModalOpen = !isModalOpen"
                        class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-white transition rounded-lg bg-success-500 shadow-theme-xs hover:bg-success-600">
                        <i data-feather="file"></i>
                        Import Data
                    </button>
                    <div x-show="isModalOpen" class="fixed inset-0 flex items-center justify-center p-5 overflow-y-auto modal z-99999">
                      <div class="modal-close-btn fixed inset-0 h-full w-full bg-gray-400/50 backdrop-blur-[32px]"></div>
                      <div class="flex flex-col px-4 py-4 overflow-y-auto no-scrollbar">
                        <div @click.outside="isModalOpen = false" class="relative w-full max-w-[507px] rounded-3xl bg-white p-6 dark:bg-gray-900 lg:p-10">

                            <form action="{{route('internship-request.upload')}}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <h4 class="mb-6 text-lg font-medium text-gray-800 dark:text-white/90"> Import Internship Data </h4>

                                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400"> Uploaded File </label>
                                <input
                                type="file"
                                name="file"
                                accept=".csv, .xlsx, .xls"
                                class="focus:border-ring-brand-300 shadow-theme-xs focus:file:ring-brand-300 h-11 w-full overflow-hidden rounded-lg border border-gray-300 bg-transparent text-sm text-gray-500 transition-colors file:mr-5 file:border-collapse file:cursor-pointer file:rounded-l-lg file:border-0 file:border-r file:border-solid file:border-gray-200 file:bg-gray-50 file:py-3 file:pr-3 file:pl-3.5 file:text-sm file:text-gray-700 placeholder:text-gray-400 hover:file:bg-gray-100 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-gray-400 dark:text-white/90 dark:file:border-gray-800 dark:file:bg-white/[0.03] dark:file:text-gray-400 dark:placeholder:text-gray-400"
                                />
                                <small>
                                    <a href="{{asset('assets/templates/internship-request-template.xlsx')}}" class="underline decoration-dashed decoration-2 text-brand-500">
                                    Download template
                                    </a>
                                </small>


                                <div class="flex items-center justify-center w-full gap-3 mt-8">
                                    <button @click="isModalOpen = false" type="button" class="flex justify-center rounded-lg border border-gray-300 bg-white px-4 py-3 text-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] dark:hover:text-gray-200"> Close </button>
                                    <button type="submit" class="flex justify-center px-4 py-3 text-sm font-medium text-white rounded-lg bg-brand-500 shadow-theme-xs hover:bg-brand-600"> Submit </button>
                                </div>


                            </form>
                        </div>
                      </div>
                    </div>
                  </div>
                @endcan --}}

                @can('internship_request.export')
                <a href="{{route('internship-request.export')}}"
                    class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-white transition rounded-lg bg-success-500 shadow-theme-xs hover:bg-success-600">
                    <i data-feather="file"></i>
                    Export .xlxs
                </a>
                <a href="{{route('internship-request.export-pdf')}}"
                    class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-white transition rounded-lg bg-error-500 shadow-theme-xs hover:bg-error-600">
                    <i data-feather="file"></i>
                    Export .pdf
                </a>
                @endcan


                <!-- Create Button -->
                @can('internship_request.create')
                <a href="{{ route('internship-request.create') }}"
                    class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-white transition rounded-lg bg-brand-500 shadow-theme-xs hover:bg-brand-600">
                    <i data-feather="plus"></i>
                    Create New
                </a>
                @endcan
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
                        {{-- <th class="px-5 py-3 sm:px-6">
                            <div class="flex items-center">
                                <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Avg Scores</p>
                            </div>
                        </th> --}}
                        {{-- <th class="px-5 py-3 sm:px-6">
                            <div class="flex items-center">
                                <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Estimated Distance</p>
                            </div>
                        </th> --}}
                        <th class="px-5 py-3 sm:px-6">
                            <div class="flex items-center">
                                <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Requested Company</p>
                            </div>
                        </th>
                        <th class="px-5 py-3 sm:px-6">
                            <div class="flex items-center">
                                <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Weighing Scores</p>
                            </div>
                        </th>
                        <th class="px-5 py-3 sm:px-6">
                            <div class="flex items-center">
                                <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Status</p>
                            </div>
                        </th>
                        <th class="px-5 py-3 sm:px-6">
                            <div class="flex items-center">
                                <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Requested Date</p>
                            </div>
                        </th>
                        <th class="px-5 py-3 sm:px-6">
                            <div class="flex items-center">
                                <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Created By</p>
                            </div>
                        </th>
                        <th class="px-5 py-3 sm:px-6">
                            <div class="flex items-center">
                                <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Action</p>
                            </div>
                        </th>
                        @can('internship_request.edit')
                            <th class="px-5 py-3 sm:px-6">
                                <div class="flex items-center">
                                    <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">#</p>
                                </div>
                            </th>
                        @endcan
                    </tr>
                </thead>

                <!-- Table body -->
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    @forelse ($internship_requests as $row)
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
                            {{-- <td class="px-5 py-4 sm:px-6">
                                <div class="flex items-center">
                                    <p class="text-gray-500 text-theme-sm dark:text-gray-400">{{ round($row->user->student->avg_scores, 3) }}</p>
                                </div>
                            </td> --}}
                            {{-- <td class="px-5 py-4 sm:px-6">
                                <div class="flex items-center">
                                    <p class="text-gray-500 text-theme-sm dark:text-gray-400">{{ $row->estimated_distance }} Km</p>
                                </div>
                            </td> --}}
                            <td class="px-5 py-4 sm:px-6">
                                <div class="flex items-center">
                                    <p class="text-gray-500 text-theme-sm dark:text-gray-400">{{ $row->company->name }}</p>
                                </div>
                            </td>
                            <td class="px-5 py-4 sm:px-6">
                                <div class="flex items-center">
                                    <p class="text-gray-500 text-theme-sm dark:text-gray-400">{{ round($row->weighing_scores, 3) }}</p>
                                </div>
                            </td>
                            <td class="px-5 py-4 sm:px-6">
                                <div class="flex items-center">
                                    @if ($row->status == 'pending')
                                    <p
                                        class="rounded-full bg-warning-50 px-2 py-0.5 text-theme-xs font-medium text-warning-700 dark:bg-warning-500/15 dark:text-warning-500">
                                        {{ $row->status }}
                                    </p>
                                    @elseif ($row->status == 'approved')
                                    <p
                                        class="rounded-full bg-success-50 px-2 py-0.5 text-theme-xs font-medium text-success-700 dark:bg-success-500/15 dark:text-success-500">
                                        {{ $row->status }}
                                    </p>
                                    @elseif ($row->status == 'rejected')
                                    <p
                                        class="rounded-full bg-error-50 px-2 py-0.5 text-theme-xs font-medium text-error-700 dark:bg-error-500/15 dark:text-error-500">
                                        {{ $row->status }}
                                    </p>
                                    @endif
                                </div>
                            </td>
                            <td class="px-5 py-4 sm:px-6">
                                <div class="flex items-center">
                                    <p class="text-gray-500 text-theme-sm dark:text-gray-400">
                                        {{ date('d M Y', strtotime($row->created_at)) }}
                                    </p>
                                </div>
                            </td>
                            <td class="px-5 py-4 sm:px-6">
                                <div class="flex items-center">
                                    <p class="text-gray-500 text-theme-sm dark:text-gray-400">
                                        {{ $row->createdBy->fullname }}
                                    </p>
                                </div>
                            </td>
                            <td class="px-5 py-4 sm:px-6">
                                <div class="flex items-center gap-2">

                                    <a href="{{ route('internship-request.show', $row->id) }}"
                                        class="inline-flex items-center gap-2 px-2.5 py-1.5 text-xs font-medium text-white transition rounded-md bg-brand-500 shadow hover:bg-brand-600">
                                        <i data-feather="eye" class="w-4 h-4"></i>
                                    </a>
                                    <a href="{{ route('internship-request.download', $row->id) }}"
                                        data-url="{{ route('internship-request.download', $row->id) }}"
                                        class="inline-flex items-center gap-2 px-2.5 py-1.5 text-xs font-medium text-white transition rounded-md bg-success-500 shadow hover:bg-success-600">
                                        <i data-feather="file-text" class="w-4 h-4"></i>
                                    </a>
                                </div>
                            </td>
                            @can('internship_request.edit')
                                <td class="px-5 py-4 sm:px-6">
                                    <div class="flex items-center gap-2">
                                        @if ($row->status == 'pending')
                                        <form action="{{route('internship-request.form', $row->id)}}" method="POST">
                                            @csrf
                                            <div x-data="{ isOptionSelected: false }" class="relative z-20 bg-transparent">
                                                <select
                                                class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 pr-11 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                                                required
                                                name="status"
                                                >
                                                    <option disabled class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">
                                                        -- Select --
                                                    </option>
                                                    <option value="approve" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">
                                                        Approve
                                                    </option>
                                                    <option value="reject" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">
                                                        Reject
                                                    </option>
                                                </select>
                                                <span class="pointer-events-none absolute top-1/2 right-4 z-30 -translate-y-1/2 text-gray-500 dark:text-gray-400">
                                                    <svg
                                                        class="stroke-current"
                                                        width="20"
                                                        height="20"
                                                        viewBox="0 0 20 20"
                                                        fill="none"
                                                        xmlns="http://www.w3.org/2000/svg"
                                                    >
                                                        <path
                                                        d="M4.79175 7.396L10.0001 12.6043L15.2084 7.396"
                                                        stroke=""
                                                        stroke-width="1.5"
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        />
                                                    </svg>
                                                </span>
                                            </div>

                                            <input
                                                type="text"
                                                placeholder="Reason"
                                                name="notes"
                                                required
                                                class="mt-3 dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                                            />

                                            <button
                                                type="submit"
                                                class="mt-3 inline-flex items-center gap-2 px-2.5 py-1.5 text-xs font-medium text-white transition rounded-md bg-brand-500 shadow hover:bg-brand-600">
                                                <i data-feather="check" class="w-4 h-4"></i> Submit
                                            </button>
                                        </form>
                                        @else
                                            <p class="text-gray-500 text-theme-sm dark:text-gray-400">{{ $row->notes ?? '-' }}</p>
                                        @endif
                                    </div>
                                </td>
                            @endcan
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

@endsection

@push('scripts')
<script>

    $('#filterButton').click(function() {
        filterForm = $('#filterForm')
        filterForm.submit()
    })

</script>
@endpush
