<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
            return redirect()->away('https://web.whatsapp.com/send?phone=' . $telp);
        } else {
            return redirect()->away('https://wa.me/' . $telp);
        }
    }
}
