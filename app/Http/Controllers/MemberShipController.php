<?php

namespace App\Http\Controllers;

use App\Models\Colocation;
use App\Models\MemberShip;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class MemberShipController extends Controller
{
    public function quit(Colocation $colocation){
        $userID = Auth::id();
        if($colocation->owner_id === $userID){
            return back()->with('error',"L'owner ne peux pas quiter la colocation !");
        }

        if($colocation->status !== 'active'){
            return back()->with('error','Cette colocation est inactive');
        }

        $memberShip = MemberShip::where('colocation_id',$colocation->id)
            ->where('user_id',$userID)
            ->whereNull('left_at')->first();

        if(!$memberShip){
            return back()->with('error',"Vous n'etes pas membre active de cette colocation");
        }

        $memberShip->update([
            'left_at' => now(),
            'is_active' => false,
        ]);

        return redirect()->route('dashboard')->with('success','Vous avez quité la colocation');
    }


    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(MemberShip $memberShip)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MemberShip $memberShip)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MemberShip $memberShip)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MemberShip $memberShip)
    {
        //
    }
}
