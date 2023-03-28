<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tupoksi;
use Illuminate\Http\Request;

class TupoksiController extends Controller
{
    public function index()
    {
        $tupoksis = Tupoksi::get();

        return view('admin.tupoksi.index', compact('tupoksis'));
    }

    public function create()
    {
        return view('admin.tupoksi.create');
    }

    public function store(Request $request)
    {
        
    }

    public function show($id)
    {
        
    }

    public function edit($id)
    {
        $tupoksi = Tupoksi::where('id', $id)->first();

        return view('admin.tupoksi.edit', compact('tupoksi'));
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
