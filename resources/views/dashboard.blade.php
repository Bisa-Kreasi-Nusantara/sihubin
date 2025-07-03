@extends('layouts.app')

@section('title', 'dashboard')

@section('content')

    <div class="grid grid-cols-12 gap-4 md:gap-6">
        <div class="col-span-12 space-y-6 xl:col-span-7">
            <!-- Metric Group One -->
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:gap-6">
                <!-- Metric Item Start -->
                <div
                    class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] md:p-6">
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-gray-100 dark:bg-gray-800">
                        <svg class="fill-gray-800 dark:fill-white/90" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M8.80443 5.60156C7.59109 5.60156 6.60749 6.58517 6.60749 7.79851C6.60749 9.01185 7.59109 9.99545 8.80443 9.99545C10.0178 9.99545 11.0014 9.01185 11.0014 7.79851C11.0014 6.58517 10.0178 5.60156 8.80443 5.60156ZM5.10749 7.79851C5.10749 5.75674 6.76267 4.10156 8.80443 4.10156C10.8462 4.10156 12.5014 5.75674 12.5014 7.79851C12.5014 9.84027 10.8462 11.4955 8.80443 11.4955C6.76267 11.4955 5.10749 9.84027 5.10749 7.79851ZM4.86252 15.3208C4.08769 16.0881 3.70377 17.0608 3.51705 17.8611C3.48384 18.0034 3.5211 18.1175 3.60712 18.2112C3.70161 18.3141 3.86659 18.3987 4.07591 18.3987H13.4249C13.6343 18.3987 13.7992 18.3141 13.8937 18.2112C13.9797 18.1175 14.017 18.0034 13.9838 17.8611C13.7971 17.0608 13.4132 16.0881 12.6383 15.3208C11.8821 14.572 10.6899 13.955 8.75042 13.955C6.81096 13.955 5.61877 14.572 4.86252 15.3208ZM3.8071 14.2549C4.87163 13.2009 6.45602 12.455 8.75042 12.455C11.0448 12.455 12.6292 13.2009 13.6937 14.2549C14.7397 15.2906 15.2207 16.5607 15.4446 17.5202C15.7658 18.8971 14.6071 19.8987 13.4249 19.8987H4.07591C2.89369 19.8987 1.73504 18.8971 2.05628 17.5202C2.28015 16.5607 2.76117 15.2906 3.8071 14.2549ZM15.3042 11.4955C14.4702 11.4955 13.7006 11.2193 13.0821 10.7533C13.3742 10.3314 13.6054 9.86419 13.7632 9.36432C14.1597 9.75463 14.7039 9.99545 15.3042 9.99545C16.5176 9.99545 17.5012 9.01185 17.5012 7.79851C17.5012 6.58517 16.5176 5.60156 15.3042 5.60156C14.7039 5.60156 14.1597 5.84239 13.7632 6.23271C13.6054 5.73284 13.3741 5.26561 13.082 4.84371C13.7006 4.37777 14.4702 4.10156 15.3042 4.10156C17.346 4.10156 19.0012 5.75674 19.0012 7.79851C19.0012 9.84027 17.346 11.4955 15.3042 11.4955ZM19.9248 19.8987H16.3901C16.7014 19.4736 16.9159 18.969 16.9827 18.3987H19.9248C20.1341 18.3987 20.2991 18.3141 20.3936 18.2112C20.4796 18.1175 20.5169 18.0034 20.4837 17.861C20.2969 17.0607 19.913 16.088 19.1382 15.3208C18.4047 14.5945 17.261 13.9921 15.4231 13.9566C15.2232 13.6945 14.9995 13.437 14.7491 13.1891C14.5144 12.9566 14.262 12.7384 13.9916 12.5362C14.3853 12.4831 14.8044 12.4549 15.2503 12.4549C17.5447 12.4549 19.1291 13.2008 20.1936 14.2549C21.2395 15.2906 21.7206 16.5607 21.9444 17.5202C22.2657 18.8971 21.107 19.8987 19.9248 19.8987Z"
                                fill="" />
                        </svg>
                    </div>

                    <div class="mt-5 flex items-end justify-between">
                        <div>
                            <span class="text-sm text-gray-500 dark:text-gray-400">Total Students</span>
                            <h4 class="mt-2 text-title-sm font-bold text-gray-800 dark:text-white/90">
                                {{$data['student_count']}}
                            </h4>
                        </div>
                    </div>
                </div>
                <!-- Metric Item End -->
                <!-- Metric Item Start -->
                <div
                    class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] md:p-6">
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-gray-100 dark:bg-gray-800">
                        <i data-feather="grid"></i>
                    </div>

                    <div class="mt-5 flex items-end justify-between">
                        <div>
                            <span class="text-sm text-gray-500 dark:text-gray-400">Total Companies</span>
                            <h4 class="mt-2 text-title-sm font-bold text-gray-800 dark:text-white/90">
                                {{$data['company_count']}}
                            </h4>
                        </div>
                    </div>
                </div>
                <!-- Metric Item End -->

                <!-- Metric Item Start -->
                <div
                    class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] md:p-6">
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-gray-100 dark:bg-gray-800">
                        <i data-feather="clock"></i>
                    </div>

                    <div class="mt-5 flex items-end justify-between">
                        <div>
                            <span class="text-sm text-gray-500 dark:text-gray-400">Pending Request</span>
                            <h4 class="mt-2 text-title-sm font-bold text-gray-800 dark:text-white/90">
                                {{$data['pending_request']}}
                            </h4>
                        </div>
                    </div>
                </div>
                <!-- Metric Item End -->
                <!-- Metric Item Start -->
                <div
                    class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] md:p-6">
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-gray-100 dark:bg-gray-800">
                        <i data-feather="check-square"></i>
                    </div>

                    <div class="mt-5 flex items-end justify-between">
                        <div>
                            <span class="text-sm text-gray-500 dark:text-gray-400">Internshipped Students</span>
                            <h4 class="mt-2 text-title-sm font-bold text-gray-800 dark:text-white/90">
                                {{$data['internship_user_count']}}
                            </h4>
                        </div>
                    </div>
                </div>
                <!-- Metric Item End -->
                <!-- Metric Item Start -->
                <div
                    class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] md:p-6">
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-gray-100 dark:bg-gray-800">
                        <i data-feather="alert-triangle"></i>
                    </div>

                    <div class="mt-5 flex items-end justify-between">
                        <div>
                            <span class="text-sm text-gray-500 dark:text-gray-400">Not Yet Internship</span>
                            <h4 class="mt-2 text-title-sm font-bold text-gray-800 dark:text-white/90">
                                {{$data['not_internship_user_count']}}
                            </h4>
                        </div>
                    </div>
                </div>
                <!-- Metric Item End -->
            </div>
            <!-- Metric Group One -->
        </div>

        <div class="col-span-12 xl:col-span-5">
            <!-- ====== Table One Start -->
            <div
                class="overflow-hidden rounded-2xl border border-gray-200 bg-white px-4 pb-3 pt-4 dark:border-gray-800 dark:bg-white/[0.03] sm:px-6">
                <div class="flex flex-col gap-2 mb-4 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                            Recent Requested
                        </h3>
                    </div>

                    <div class="flex items-center gap-3">
                        <a
                        href="{{route('internship-request.index')}}"
                            class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-theme-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] dark:hover:text-gray-200">
                            See all
                        </a>
                    </div>
                </div>

                <div class="w-full overflow-x-auto">
                    <table class="min-w-full">
                        <!-- table header start -->
                        <thead>
                            <tr class="border-gray-100 border-y dark:border-gray-800">
                                <th class="py-3">
                                    <div class="flex items-center">
                                        <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                                            Fullname
                                        </p>
                                    </div>
                                </th>
                                <th class="py-3">
                                    <div class="flex items-center">
                                        <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                                            Requested Company
                                        </p>
                                    </div>
                                </th class="py-3">
                                <th class="py-3">
                                    <div class="flex items-center">
                                        <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                                            Requested Date
                                        </p>
                                    </div>
                                </th>
                                <th class="py-3">
                                    <div class="flex items-center col-span-2">
                                        <p class="font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                                            Status
                                        </p>
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <!-- table header end -->

                        <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                            @forelse ($data['internship_requests'] as $item)
                            <tr>
                                <td class="py-3">
                                    <div class="flex items-center">
                                        <p class="text-gray-500 text-theme-sm dark:text-gray-400">
                                            {{$item->user->fullname}}
                                        </p>
                                    </div>
                                </td>
                                <td class="py-3">
                                    <div class="flex items-center">
                                        <p class="text-gray-500 text-theme-sm dark:text-gray-400">
                                            {{substr($item->company->name, 0, 10)}}...
                                        </p>
                                    </div>
                                </td>
                                <td class="py-3">
                                    <div class="flex items-center">
                                        <p class="text-gray-500 text-theme-sm dark:text-gray-400">
                                            {{ date('d M Y', strtotime($item->created_at)) }}
                                        </p>
                                    </div>
                                </td>
                                <td class="py-3">
                                    <div class="flex items-center">
                                        @if ($item->status == 'pending')
                                        <p
                                            class="rounded-full bg-warning-50 px-2 py-0.5 text-theme-xs font-medium text-warning-700 dark:bg-warning-500/15 dark:text-warning-500">
                                            {{ $item->status }}
                                        </p>
                                        @elseif ($item->status == 'approved')
                                        <p
                                            class="rounded-full bg-success-50 px-2 py-0.5 text-theme-xs font-medium text-success-700 dark:bg-success-500/15 dark:text-success-500">
                                            {{ $item->status }}
                                        </p>
                                        @elseif ($item->status == 'rejected')
                                        <p
                                            class="rounded-full bg-error-50 px-2 py-0.5 text-theme-xs font-medium text-error-700 dark:bg-error-500/15 dark:text-error-500">
                                            {{ $item->status }}
                                        </p>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4">No Data Available.</td>
                            </tr>
                            @endforelse
                            <!-- table body end -->
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- ====== Table One End -->
        </div>
    </div>
@endsection
