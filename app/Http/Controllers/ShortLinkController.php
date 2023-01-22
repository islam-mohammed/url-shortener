<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShortLinkRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ShortLinkController extends Controller
{
    /**
     * create new short link.
     */
    public function store(ShortLinkRequest $request)
    {
        $request->user()->shor

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit');
    }
}
