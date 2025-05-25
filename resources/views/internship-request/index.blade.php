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
            <!-- Search Form -->
            <form action="{{ route('internship-request.index') }}" class="w-96">
                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                    Search
                </label>
                <input type="text"
                    name="search"
                    placeholder="Search user..."
                    value="{{ request()->search }}"
                    class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
            </form>

            <!-- Buttons Container -->
            <div class="flex items-center gap-2">
                <!-- Import Button -->

                @can('internship_request.import')
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
                        <th class="px-5 py-3 sm:px-6">
                            <div class="flex items-center">
                                <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Avg Scores</p>
                            </div>
                        </th>
                        <th class="px-5 py-3 sm:px-6">
                            <div class="flex items-center">
                                <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Estimated Distance</p>
                            </div>
                        </th>
                        <th class="px-5 py-3 sm:px-6">
                            <div class="flex items-center">
                                <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">Requested Company</p>
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
                            <td class="px-5 py-4 sm:px-6">
                                <div class="flex items-center">
                                    <p class="text-gray-500 text-theme-sm dark:text-gray-400">{{ round($row->user->student->avg_scores, 3) }}</p>
                                </div>
                            </td>
                            <td class="px-5 py-4 sm:px-6">
                                <div class="flex items-center">
                                    <p class="text-gray-500 text-theme-sm dark:text-gray-400">{{ $row->estimated_distance }} Km</p>
                                </div>
                            </td>
                            <td class="px-5 py-4 sm:px-6">
                                <div class="flex items-center">
                                    <p class="text-gray-500 text-theme-sm dark:text-gray-400">{{ $row->company->name }}</p>
                                </div>
                            </td>
                            <td class="px-5 py-4 sm:px-6">
                                <div class="flex items-center">
                                    @if ($row->status == 'pending')
                                    <p
                                        class="rounded-full bg-warning-50 px-2 py-0.5 text-theme-xs font-medium text-warning-700 dark:bg-warning-500/15 dark:text-warning-500">
                                        {{ $row->status }}
                                    </p>
                                    @elseif ($row->status == 'weighed')
                                    <p
                                        class="rounded-full bg-success-50 px-2 py-0.5 text-theme-xs font-medium text-success-700 dark:bg-success-500/15 dark:text-success-500">
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

                                    @if ($row->status == 'pending')
                                        <a href="{{ route('internship-request.edit', $row->id) }}"
                                            class="inline-flex items-center gap-2 px-2.5 py-1.5 text-xs font-medium text-white transition rounded-md bg-warning-500 shadow hover:bg-warning-600">
                                            <i data-feather="edit" class="w-4 h-4"></i>
                                        </a>
                                        <a href="{{route('internship-request.delete', $row->id)}}" 
                                            class="delete-button inline-flex items-center gap-2 px-2.5 py-1.5 text-xs font-medium text-white transition rounded-md bg-error-500 shadow hover:bg-error-600"
                                            data-id="{{ $row->id }}"
                                            data-url="{{ route('internship-request.delete', $row->id) }}">
                                            <i data-feather="trash" class="w-4 h-4"></i>
                                        </a>
                                    @elseif ($row->status == 'weighed')
                                        <a href="{{ route('internship-request.download', $row->id) }}"
                                            class="action-button inline-flex items-center gap-2 px-2.5 py-1.5 text-xs font-medium text-white transition rounded-md bg-success-500 shadow hover:bg-success-600">
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
    {{-- <div id="importModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white dark:bg-gray-800 rounded-lg w-full max-w-md mx-auto p-6 shadow-lg">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold text-gray-800 dark:text-white">Import Internship Data</h2>
                <button id="closeImportModal" class="text-gray-500 hover:text-gray-800 dark:hover:text-white">
                    ✕
                </button>
            </div>

            <!-- Import Form -->
            <form action="{{ route('internship-request.create') }}" method="POST" enctype="multipart/form-data">
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
    </div> --}}


@endsection

@push('scripts')
{{-- <script>
    $(document).ready(function () {
        $('#openImportModal').on('click', function () {
            $('#importModal').removeClass('hidden').addClass('flex');
        });

        $('#closeImportModal, #cancelImport').on('click', function () {
            $('#importModal').removeClass('flex').addClass('hidden');
        });
    });
</script> --}}
@endpush