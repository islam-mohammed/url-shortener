<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShortLinkRequest;
use App\Http\Resources\ShortLinksCollection;
use App\Models\ShortLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
                            ->latest()
                            ->paginate(10)
                            ->appends(request()->all()))
        ]);
    }

    /**
     * Redirect the user to the original link.
     *
     * @param  App\Models\ShortLink;  $request
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function view(ShortLink $shortlink)
    {
        if($shortlink != null) {
            // increment the views by 1
            $shortlink->views += 1;
            // save the short link
            $shortlink->save();
            // redirect the user to the original link
            return Inertia::location($shortlink->destination);
        }

        report(new NotFoundHttpException('This link in not valid'));
        return false;

    }
}
