<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Jenssegers\Agent\Agent;

class HomeController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }

    public function hubungi($telp)
    {
        if (is_null($telp)) {
            alert()->error('Error', 'Gagal menemukan Nomor Telepon!');
            return back();
        }

        $agent = new Agent;
        $desktop = $agent->isDesktop();

        if ($desktop) {
            return Redirect::away('https://web.whatsapp.com/send?phone=' . $telp);
        } else {
            return Redirect::away('https://wa.me/' . $telp);
        }
    }
}
