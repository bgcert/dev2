<?php

namespace App\Http\Controllers\Publishers;

use Illuminate\Http\Request;
use App\Http\Requests\CompanyRequest;
use App\Http\Controllers\Controller;
use App\Traits\ResizableImage;
use Illuminate\Support\Facades\Validator;

class DashboardController extends Controller
{
	use ResizableImage;

    public function index()
    {
    	$company = \Auth::user()->company;
    	return ($company) ? view('dashboard', compact($company)) : abort(404);
    }

    public function getCompany()
    {
    	return \App\Company::where('user_id', \Auth::id())->first();
    }

    public function saveCompany(CompanyRequest $request)
    {
    	$company = \App\Company::where('user_id', \Auth::id())->first();
    	$company->update($request->all());
    	$this->moveImage($request->logo);
    	return $company;
    }

    public function saveImage()
    {
    	$validator = request()->validate(['file' => 'image|mimes:jpeg,png,gif|max:3600']);

    	if (!$validator)
    	{
    		return $validator; // Automatically returns error 422 with messages!
        } else
        {
        	$file = request()->file;
        	$path = \Storage::disk('s3')->put('/temp', $file);
        	$filename = ltrim($path, 'temp/');
        	return $filename;
        }
    }
}
