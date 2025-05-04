<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use App\Models\Major;

class MajorController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:majors_management');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $majors = Major::query();

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $majors->where(function($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            });
        }

        $majors = $majors->get();

        return view('majors-management.index', compact('majors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('majors-management.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            Major::create($request->all());

            return redirect()->route('majors-management.index')->withSuccess("Success create new major");
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $major = Major::find($id);
        return view('majors-management.edit', compact('major'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $major = Major::find($id);
        $major->update($request->all());

        return redirect()->route('majors-management.index')->withSuccess("Success update major");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            Major::find($id)->delete();
            return redirect()->route('majors-management.index')->withSuccess("Success delete major");
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
