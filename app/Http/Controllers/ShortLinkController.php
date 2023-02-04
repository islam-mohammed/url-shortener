<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShortLinkRequest;
use App\Http\Resources\ShortLinkResource;
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

        /**
     * Store a new user short link.
     *
     * @param  App\Http\Requests\ShortLinkRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ShortLinkRequest $request)
    {
        ShortLink::create($request->all());
        return to_route('shortlink.index');

    }
    public function update(ShortLinkRequest $request, $id)
    {

    }
    public function destroy(ShortLink $shortlink)
    {
        $shortlink->delete();
    }

    public function findByDestination(Request $request) {
        $headers = ['Content-Type' => 'application/json'];
        // Check if there is a destination input is exist in the request and if this destination has a URL
        if ($request->has('destination') && $request->destination != null) {
            $link = ShortLink::where('destination', $request->destination)->first();
            if($link) {
                // if the destination is exist then return the respose
                return new ShortLinkResource($link);
            } else {
                // if the destination doesn't exist then return an error message with the status code not found(404)
                 return response(json_encode(["message" => "The destination dose not exist!"]), 404, $headers);
            }
        }
         // if the destination input does not exist in the request or the input is null then return the status code bad request(400)
         return response(json_encode(["message" => "The request body dosen't have the destination!"]), 400, $headers);

    }
}
