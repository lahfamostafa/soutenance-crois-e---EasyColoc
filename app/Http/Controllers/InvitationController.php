<?php

namespace App\Http\Controllers;

use App\Models\Colocation;
use App\Models\Invitation;
use App\Models\MemberShip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\InvitationMail;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;


class InvitationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('invitation.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function store(Request $request , Colocation $colocation)
    {
        $user = Auth::user();
        abort_unless($colocation->owner_id === $user->id , 403);

        $request->validate([
            "invited_email" => ["required",'email'],
        ]);

        if(strtolower($request->invited_email) === strtolower($user->email)){
            return back()->with('error','Vous ne pouvez pas inviter vous-même .');
        }

        $exists = Invitation::where('colocation_id',$colocation->id)
            ->where('invited_email',$request->invited_email)
            ->where('status','pending')->exists();

        if ($exists) {
            return back()->with('error', 'Une invitation est déjà en attente pour cet email.');
        }

        $token = Str::random(40);

        $invitation = Invitation::create([
            'invited_email' => strtolower($request->invited_email),
            'colocation_id' => $colocation->id,
            'token' => $token,
            'status' => 'pending',
            'sent_by' => $user->id,
            'expire_at' => now()->addMinutes(2),
        ]);

        $invitation->load(['colocation','sender']);

        Mail::to($invitation->invited_email)->send(new InvitationMail($invitation));

        return back()->with('success','Invitation envoyée avec succes .');
    }

    /**
     * Display the specified resource.
     */
    public function show($token)
    {
        $invitation = Invitation::with(['colocation','sender'])->where('token',$token)->firstOrFail();

        return view("invitations.show",compact('invitation'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function accept($token)
    {
        $user = Auth::user();
        $invitation = Invitation::where('token',$token)->firstOrFail();

        if($invitation->expire_at && now()->greaterThan($invitation->expire_at)){
            $invitation->update(['status' => 'expired']);

            return redirect()->route('dashboard')->with('error','Invitation expiré !');
        }

        if($invitation->status !== 'pending'){
            return redirect()->route('dashboard')->with('error',"L'invitaion déja traitée .");
        }

        $isActive = MemberShip::where('user_id',$user->id)->whereNull('left_at')->exists();

        if($isActive){
            return redirect()->route('dashboard')->with('error','Vous avez déja une colocation active .');
        }

        DB::transaction(function() use ($invitation ,$user){
            MemberShip::create([
                'user_id' => $user->id,
                'colocation_id' => $invitation->colocation_id,
                'role' => 'membre',
                'joined_at' => now(),
            ]);

            $invitation->update([
                'status' => 'accepted',
            ]);
        });

        return redirect()->route('colocations.show',$invitation->colocation_id)->with('success','Invitation accepté , Bienvenue !');
    }

    public function refuse($token)
    {
        $user = Auth::user();
        $invitation = Invitation::where('token',$token)->firstOrFail();

        if($invitation->status !== 'pending'){
            return redirect()->route('dashboard')->with('error',"L'invitaion déja traitée .");
        }

        $invitation->update([
            'status' => 'refused',
        ]);

        return redirect()->route('colocations.show',$invitation->colocation_id)->with('success','Invitation refusée .');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Invitation $invitation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invitation $invitation)
    {
        //
    }

    public function create(Colocation $colocation){
        abort_unless($colocation->owner_id === Auth::id() , 403);
        abort_unless($colocation->status === 'active' , 403);

        $colocation->load(['invitations' => fn($q) => $q->where('status','pending')]);

        return view('invitations.create',compact('colocation'));
    }
}
