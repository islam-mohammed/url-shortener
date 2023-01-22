<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShortLinkRequest;
use App\Http\Resources\ShortLinksCollection;
use App\Models\ShortLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
class ShortLinkController extends Controller

{

    /**
     * Return the user list of short links.
     *
     **/
    public function index() {
        // $shortLinks = ShortLink::where('user_id', Auth::id())->paginate(20);
        return Inertia::render('ShortLinks', [
            'shortLinks' => new ShortLinksCollection(
                Auth::user()->shortLinks()
                            ->orderBy('destination')
                            ->paginate()
                            ->appends(request()->all()))
        ]);
    }
}
