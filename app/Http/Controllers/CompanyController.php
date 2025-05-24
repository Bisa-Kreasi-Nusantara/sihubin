<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use App\Models\Company;
use App\Models\Major;

use Auth;

class CompanyController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:companies_management.view');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $companies = Company::query()->with('major');

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $companies->where(function($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            });
        }

        $companies = $companies->get();

        return view('companies-management.index', compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $majors = Major::all();
        return view('companies-management.create', compact('majors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            Company::create($request->all());
            return redirect()->route('companies-management.index')->withSuccess("Success create new company");
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $company = Company::find($id);
        $majors = Major::all();
        return view('companies-management.edit', compact('company', 'majors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $company = Company::find($id);

            $company->update($request->all());

            return redirect()->route('companies-management.edit', $id)->withSuccess("Success update company");
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            Company::find($id)->delete();
            return redirect()->route('companies-management.index')->withSuccess("Success delete company");
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
