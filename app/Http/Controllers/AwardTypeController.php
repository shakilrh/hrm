<?php

namespace App\Http\Controllers;

use App\AwardType;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;

class AwardTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $awardTypes = AwardType::all();
        return view('award.type.index', compact('awardTypes'));
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
        $this->validate($request, [
            'type_name' => 'required|unique:award_types,name'
        ]);
        $awardType = new AwardType();
        $awardType->name = $request->type_name;
        $awardType->slug = str_slug($request->type_name);
        $awardType->save();
        Toastr::success('Award Type Successfully Added', 'Success');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\AwardType  $awardType
     * @return \Illuminate\Http\Response
     */
    public function show(AwardType $awardType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\AwardType  $awardType
     * @return \Illuminate\Http\Response
     */
    public function edit(AwardType $awardType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\AwardType  $awardType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $awardType = AwardType::findOrFail($id);
        $this->validate($request, [
            'type_name' => 'required|unique:award_types,name,'.$awardType->id
        ]);
        $awardType->name = $request->type_name;
        $awardType->slug = str_slug($request->type_name);
        $awardType->save();
        Toastr::success('Award Type Successfully Updated', 'Success');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\AwardType  $awardType
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $awardType = AwardType::findOrFail($id);
        $awardType->delete();
        Toastr::success('Award Type Successfully Deleted', 'Success');
        return redirect()->back();
    }
}
