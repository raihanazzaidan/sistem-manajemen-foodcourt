<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Stan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StanController extends Controller
{
    public function index()
    {
        $stans = Stan::withCount('menus')->latest()->get();

        return response()->json([
            'success' => true,
            'message' => 'Daftar stan berhasil diambil.',
            'data'    => $stans,
        ]);
    }

    public function create()
    {
        // 
    }

    public function store(Request $request)
    {
        // 
    }

    public function edit(Stan $stan)
    {
        //
    }

    public function update(Request $request, Stan $stan)
    {
        //
    }

    public function destroy(Stan $stan)
    {
        // 
    }
}