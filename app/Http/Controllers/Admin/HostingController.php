<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Hosting;
use Illuminate\Http\Request;

class HostingController extends Controller
{
    public function index()
    {
        $hostings = Hosting::all();

        return view('admin.hosting.index', compact('hostings'));
    }

    public function show($id)
    {
        $hosting = Hosting::where('id', $id)->first();
        
        return view('admin.hosting.show', compact('hosting'));
    }

    public function setujui($id)
    {
        Hosting::where('id', $id)->update([
            'status' => 'setujui'
        ]);

        return back();
    }
}
