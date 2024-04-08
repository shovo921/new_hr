<?php

namespace App\Modules\Document\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\Document\Models\Document;


class DocumentController extends Controller
{
    public function __construct(){
        $_SESSION["MenuActive"] = "settings";
    }

    /**
     * Display the module welcome screen
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $_SESSION["SubMenuActive"] = "document";
        
        $documents = Document::all();
        

        return view("Document::index", compact('documents'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $isRequired = array(
            ''=>'-- Please Select --',
            'YES' =>  'YES',
            'NO' => 'NO',
        );
        return view('Document::create',compact('isRequired'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $inputs = $request->all();

        $validator = \Validator::make($inputs, array(
            'document_type'=>'required',
            'is_required'=>'required'
        ));

        if ($validator -> fails()) {
            return Redirect() -> back() -> withErrors($validator) -> withInput();
        }

        $document = new Document();
        $document->fill($inputs)->save();

        return Redirect() -> to('document') -> with('msg_success', 'Document Successfully Created');
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
        $document = Document::findOrFail($id);
        $isRequired = array(
            ''=>'-- Please Select --',
            'YES' =>  'YES',
            'NO' => 'NO',
        );

    	return view('Document::edit',compact('document', 'isRequired'));
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
    	$district = Document::findOrFail($id);

    	$inputs = $request->all();
    	
        $validator = \Validator::make($inputs, array(
            'document_type'=>'required',
            'is_required'=>'required'
        ));

    	if ($validator -> fails()) {
    		return Redirect() -> back() -> withErrors($validator) -> withInput();
    	}

    	$documentInfo['document_type'] = $inputs['document_type'];
    	$documentInfo['is_required'] = $inputs['is_required'];


    	Document::where('id', $id)->update($documentInfo);

		return Redirect() -> to('document') -> with('msg_success', 'Document Successfully Updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    	try {
            Document::destroy($id);
            return Redirect() -> to('document') -> with('msg-success', 'Successfully Deleted.');
    	}
    	catch (\Exception $e) {
            return Redirect() -> to('document') -> with('msg-error', "This item is already used.");
    	}
    }
}
