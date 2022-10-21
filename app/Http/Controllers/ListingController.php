<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ListingController extends Controller
{   
    //Get and Show All Listings
    public function index(){
        //As we have Request helper we can use this as function
        //dd(request('tag'));
        //dd(Listing::latest()->filter(request(['tag','search']))->get());
        return view('listings.index',[
            //get() will give all            
            //'listings'=> Listing::latest()->filter(request(['tag','search']))->get()
            //This will paginate it
            'listings'=> Listing::latest()->filter(request(['tag','search']))->paginate(4)
        ]);
    }

    //Show Single Listing
    public function show(Listing $listing){
        return view('listings.show',[
            'listing' => $listing
        ]);
    }

    //Create Single Listing
    public function create(){
        return view('listings.create',[
            'listing' => "hi"
        ]);
    }

    //Edit Listing - Form
    public function edit(Listing $listing){
        //dd($listing);
        return view('listings.edit',['listing' => $listing]);
    }


    //Store New Data
    public function store(Request $request){
        //dd($request->all());
        $formFields = $request->validate([
            'title' => 'required',
            'company' => ['required',Rule::unique('listings','company')],
            'logo' => 'required',
            'location' => 'required',
            'website' => 'required',
            'email' => ['required','email'],
            'tags' => 'required',
            'description' => 'required'
        ]);

        //File Process
        if($request->hasFile('logo')){
            $formFields['logo'] = $request->file('logo')->store('logos','public');
        }

        $formFields['user_id'] = auth()->id();

        Listing::create($formFields);

        return redirect('/')->with('message','Listing created successfully!');
    }

    //Update Data
    public function update(Request $request,Listing $listing){
        //dd($request->all());

        //Prevent only created users to delete their Listings
        if($listing->user_id != auth()->id()){
            abort(403,'Unauthorized Action');
        }


        $formFields = $request->validate([
            'title' => 'required',
            'company' => 'required',
            //'logo' => 'required',
            'location' => 'required',
            'website' => 'required',
            'email' => ['required','email'],
            'tags' => 'required',
            'description' => 'required'
        ]);

        //File Process
        if($request->hasFile('logo')){
            $formFields['logo'] = $request->file('logo')->store('logos','public');
        }

        $listing->update($formFields);

        return back()->with('message','Listing updated successfully!');
    }

    //Delete Listing
    public function delete(Listing $listing){

        //Prevent only created users to delete their Listings
        if($listing->user_id != auth()->id()){
            abort(403,'Unauthorized Action');
        }

        $listing->delete();
        return redirect('/')->with('message','Listing deleted successfully!');
    }

    //Manage Listing
    public function manage(){
        return view('listings.manage',[
            'listings' => auth()->user()->listings()->get()
        ]);
    }

}
