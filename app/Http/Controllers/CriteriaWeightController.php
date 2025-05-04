<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\CriteriaWeight;

class CriteriaWeightController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $criterias = CriteriaWeight::all();
        return view('criteria-weight-management.index', compact('criterias'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('criteria-weight-management.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            CriteriaWeight::create($request->all());
            return redirect()->route('criteria-weight-management.index')->withSuccess("Success create new criteria weight");
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $criteria = CriteriaWeight::find($id);
        return view('criteria-weight-management.edit', compact('criteria'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $criteria = CriteriaWeight::find($id);
            $criteria->update($request->all());

            return redirect()->route('criteria-weight-management.edit', $id)->withSuccess("Success update criteria weight");
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
            CriteriaWeight::find($id)->delete();
            return redirect()->route('criteria-weight-management.index')->withSuccess("Success delete criteria weight");
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
