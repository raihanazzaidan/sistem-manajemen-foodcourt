<?php

namespace App\Http\Controllers\Penjual;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $menus = Menu::with('stan')
            ->when($request->id_stan, fn ($q, $idStan) => $q->where('id_stan', $idStan))
            ->when($request->kategori, fn ($q, $kategori) => $q->where('kategori', $kategori))
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Daftar menu berhasil diambil.',
            'data'    => $menus,
        ]);
    }

    public function store(Request $request)
    {
        // 
    }

    public function show(Menu $menu)
    {
        // 
    }

    public function update(Request $request, Menu $menu)
    {
        // 
    }

    public function destroy(Menu $menu)
    {
    //  
    }
}