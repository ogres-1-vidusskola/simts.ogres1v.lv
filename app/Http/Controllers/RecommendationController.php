<?php

namespace App\Http\Controllers;

use App\Recommendation;
use Illuminate\Http\Request;
use App\Rules\Recaptcha;
use Illuminate\Support\Facades\Mail;
use App\Mail\RecommendationCreated;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;

class RecommendationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['create', 'store']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $recommendations = Recommendation::all();

        return view('pages.recommend.index', compact('recommendations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.recommend.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Recaptcha $recaptcha
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Recaptcha $recaptcha)
    {
        $request->validate(
            [
                'title' => 'required|max:255',
                'body' => 'required',
                'email' => 'nullable|required_without:telephone|email',
                'telephone' => 'nullable|required_without:email|max:12',
                'attachment' => 'nullable|file|max:2000',
                'g-recaptcha-response' => ['required', $recaptcha]
            ]
        );

        if ($request->hasFile('attachment'))
        {
            $request->attachment = $request->attachment->store('recommend', 'public');
        }

        $recommendation = Recommendation::create([
            'title' => $request->title,
            'body' => $request->body,
            'email' => $request->email,
            'telephone' => $request->telephone,
            'attachment' => $request->attachment
        ]);

        if ($recommendation->email != null)
            Mail::to($recommendation->email)->queue(new RecommendationCreated($recommendation));

        return redirect('/recommend/create')->with('success', 'Paldies par jūsu ieteikumu, noteikti ņemsim vērā!');
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $recommendation = Recommendation::find($id);

        $attachmentURL = null;
        $attachmentMIMEType = null;

        if ($recommendation->attachment != null)
        {
            $attachmentURL = Storage::url($recommendation->attachment);

            $attachmentMIME = Storage::disk('public')->getMimeType($recommendation->attachment);

            $attachmentMIMEType = explode('/', $attachmentMIME)[0];
        }

        return view('pages.recommend.show', compact('recommendation', 'attachmentURL', 'attachmentMIMEType'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return void
     */
    public function edit()
    {
        abort(404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @return void
     */
    public function update()
    {
        abort(404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return void
     * @throws \Exception
     */
    public function destroy($id)
    {
        // Again it's returned in a collection for some magical reason
        $recommendation = Recommendation::find($id);

        Storage::disk('public')->delete($recommendation->attachment);

        $recommendation->delete();

        Session::flash('success', 'Ieteikums izdzēsts.');
    }
}
