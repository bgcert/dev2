<?php

namespace App\Http\Controllers\Publishers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\ResizableImage;
use Image;

class VenueController extends Controller
{
	use ResizableImage;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return \Auth::user()->company->venues;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    	return $request->all();
    	$venue = \Auth::user()->company->venues()->create($request->except('images'));

    	if ($request->cover) {
    		$venue->cover = $request->cover;
    		$venue->save();
    	}

    	// return $request->images;
    	if ($request->images) {
    		$images_array = explode(",", $request->images);
	    	$images = [];
	    	foreach ($request->images as $filename) {
	    		array_push($images, ['filename' => $filename]);
	    	}
	    	$venue->venue_images()->createMany($images);
    	}

    	return $venue;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    	$cities = \App\City::all();
    	$venue = \App\Venue::find($id);
        return [$venue, $venue->venue_images, $cities];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

    	$venue = \App\Venue::find($id);

    	if ($request->cover) {
    		// $filename = $this->saveVenueCover($request->cover, $venue->id);
    		$venue->cover = $request->cover;
    		$venue->save();
    	}

    	if ($request->images) {
	    	$images_array = explode(",", $request->images);
	    	$images = [];
	    	foreach ($images_array as $filename) {
	    		array_push($images, ['filename' => $filename]);
	    	}

	    	$venue->venue_images()->createMany($images);
    	}

    	if ($request->detached) {
        	foreach ($request->detached as $detached) {
        		$venue->venue_images()->where('id', $detached)->delete();
        	}
        }

    	return $venue;




    	// 
        

        $venue->update($request->all());

        $images = [];

        if ($request->images) {
        	foreach ($request->images as $image) {
    			array_push($images, ['filename' => $image]);
	    	}
	    	$venue->venue_images()->createMany($images);
        }

        if ($request->detached) {
        	foreach ($request->detached as $detached) {
        		$venue->venue_images()->where('id', $detached)->delete();
        	}
        }      

        return $venue;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return \App\Venue::destroy($id);
    }

    public function saveVenueCover()
    {
    	$file = request()->file;
    	$prefix = 've_c' . \Auth::user()->company->id . '_';
    	$filename = $prefix . $this->unique_hash() . '.' . $file->getClientOriginalExtension();

    	// Make image from file
    	$image = Image::make($file);

    	// Save original file
    	$this->save($image, $filename, '/original/');

    	// Resize to m size
    	$this->resize($image, 300, 160);
    	$this->save($image, $filename);

    	// New image instance. Old one is already resized. Wtf?
    	$image = Image::make($file);
    	// Resize to l size
    	$this->resize($image, 1200, 400);
    	$this->save($image, $filename);

    	return $filename;
    }

    public function saveVenueImage()
    {
    	$file = request()->file;
    	$prefix = 'vi_c' . \Auth::user()->company->id . '_';
    	$filename = $prefix . $this->unique_hash() . '.' . $file->getClientOriginalExtension();

    	// Make image from file
    	$image = Image::make($file);

    	// Save original file
    	$this->save($image, $filename, '/original/');

    	$this->resize($image, 1200, 400);
    	$this->save($image, $filename);

    	return $filename;
    }

    public function imageUpload()
    {
    	return $filename = $this->saveVenueImage(request()->file);
    }
}
