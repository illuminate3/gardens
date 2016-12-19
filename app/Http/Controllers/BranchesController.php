<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Branch;
use App\NewBranch;


class BranchesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $newbranches = NewBranch::doesntHave('oldbranch')->get();
        echo "<h1>New Branches</h1>";
        foreach ($newbranches as $newbranch)
        {
            echo $newbranch->branch_id . " " . $newbranch->BranchName ."<br />";
        }
        $closedBranches = Branch::doesntHave('matching')->get();
        echo "<h1>Closed Branches</h1>";
        foreach ($closedBranches as $newbranch)
        {
            echo $newbranch->branch_id . " " . $newbranch->BranchName ."<br />";
        }

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
        //
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
