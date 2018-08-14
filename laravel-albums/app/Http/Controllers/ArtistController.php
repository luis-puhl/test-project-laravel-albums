<?php

namespace App\Http\Controllers;

use View;
use Illuminate\Http\Request;
use App\Services\ArtistService;

class ArtistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ArtistService $service)
    {
        $artists = $service->index();
        return View::make('artists.index')->with('artists', $artists);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return View::make('artists.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $artist = $service->create($request->all());
        return View::make('artists.view')->with('artist', $artist);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Artist  $artist
     * @return \Illuminate\Http\Response
     */
    public function show(Artist $artist, $id)
    {
        $artist = $artist ?? $service->find($id);
        return View::make('artists.view')->with('artist', $artist);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Artist  $artist
     * @return \Illuminate\Http\Response
     */
    public function edit(Artist $artist, $id)
    {
        $artist = $artist ?? $service->find($id);
        return View::make('artists.form')->with('artist', $artist);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Artist  $artist
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Artist $artist, $id)
    {
        $artist = $service->update($request->all(), $id);
        return View::make('artists.view')->with('artist', $artist);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Artist  $artist
     * @return \Illuminate\Http\Response
     */
    public function destroy(Artist $artist, $id)
    {
        $service->destroy($id);
        return $this->index();
    }
}
