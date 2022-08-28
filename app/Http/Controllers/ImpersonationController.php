<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImpersonationController extends Controller
{

    public function leave()
    {

        if (! session()->get('origin_user_id')) {
            abort(403);
        }

        auth()->loginUsingId(session()->pull('origin_user_id'));
        return redirect()->route('team.index');
    }
}
