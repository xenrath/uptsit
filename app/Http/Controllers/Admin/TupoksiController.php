<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tupoksi;
use Illuminate\Http\Request;

class TupoksiController extends Controller
{
    public function index()
    {
        $tupoksis = Tupoksi::select('id', 'nama', 'file')->get();

        return view('admin.tupoksi.index', compact('tupoksis'));
    }

    public function create()
    {
        return view('error.500');
        // return view('admin.tupoksi.create');
    }

    public function store(Request $request)
    {
    }

    public function show($id)
    {
    }

    public function edit($id)
    {
        return view('error.500');

        // $tupoksi = Tupoksi::where('id', $id)->first();
        // return view('admin.tupoksi.edit', compact('tupoksi'));
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        return view('error.500');
    }
}
