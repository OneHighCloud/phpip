<?php

namespace App\Http\Controllers;

use App\Actor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Response;

class ActorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $Name = $request->input ( 'Name' );
        $Phy_person = $request->input ( 'phy_person' );
        $actor = new Actor ;
        if (! is_null($Name)) {$actor = $actor->where('name','like',$Name.'%');}
        if (! is_null($Phy_person)) {$actor = $actor->where('phy_person',$Phy_person);}
        $actorslist = $actor->with('company')->orderby('name')->get();
        return view('actor.index', compact('actorslist') );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $table = new Actor ;
        //TODO getTableComments is the same as in Rule.php. To render common
        $tableComments = $table->getTableComments('actor');
        return view('actor.create',compact('tableComments'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    	$validator = Validator::make($request->all(), [
			'name' => 'required|max:100',
			'first_name' => 'max:60',
			'display_name' => 'max:30',
			'login' => 'unique:actor|max:16',
			'function' => 'max:45',
			'address' => 'max:256',
			'address_mailing' => 'max:256',
			'address_billing' => 'max:256',
			'phone' => 'max:20',
			'email' => 'email|max:45',
			'legal_form' => 'max:60',
			'registration_no' => 'max:20',
			'VAT_number' => 'max:45'	,		
    	]);
    	$input = $request->all();
    	$to_retain = ['_token', '_method'];
    	if($validator->passes()){
			foreach ($input as $i =>$value) {				
				if (strpos($i, '_new')) {
					array_push($to_retain,$i);
				}
			}
			
			Actor::create($request->except($to_retain));
			return Response::json(['success' => '1']);
		}
		return Response::json(['errors' => $validator->errors()]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Actor  $actor
     * @return \Illuminate\Http\Response
     */
    public function show($n)
    {
		$actor = new Actor ;
        $actorInfo = $actor->with('company',
			'parent',
			'site',
			'droleInfo',
			'countryInfo',
			'country_mailingInfo',
			'country_billingInfo',
			'nationalityInfo')
			->find($n);
        $actorComments = $actor->getTableComments('actor');
        return view('actor.show', compact('actorInfo', 'actorComments') );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Actor  $actor
     * @return \Illuminate\Http\Response
     */
    public function edit(Actor $actor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Actor  $actor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Actor $actor)
    {
   	    	
    	$actor->update($request->except(['_token', '_method']));
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Actor  $actor
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    	$actor = new Actor ;
    	$actor->destroy($id);
    }

}
