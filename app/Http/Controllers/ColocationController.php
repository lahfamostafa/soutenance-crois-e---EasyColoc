<?php

namespace App\Http\Controllers;

use App\Models\Colocation;
use App\Models\MemberShip;
use GrahamCampbell\ResultType\Success;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ColocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $colocations = Colocation::query()->where(function ($q) use ($user){
            $q->where('owner_id',$user->id)
                ->orWhereHas('memberShips',fn($m) => $m->where('user_id',$user->id)->whereNull('left_at'));
        })
        ->withCount([
            'memberShips as active_members_count' => fn($q) => $q->whereNull('left_at'),
            'invitations as pending_invitations_count' => fn($q) => $q->where('status','pending')
        ])->latest()->get();

        return view('colocations.index',compact('colocations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $hasActive = MemberShip::where('user_id',Auth::id())
            ->whereNull('left_at')
            ->whereHas('colocation',function ($q){
                $q->where('status','active');
        })->exists();

        if($hasActive){
            return redirect()->route('colocations.index')->with('error', 'Vous avez déjà une colocation active.');
        }

        return view('colocations.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $hasActive = MemberShip::where('user_id',Auth::id())->whereNull('left_at')->whereHas('colocation', function ($q){
            $q->where('status','active');
        })->exists();

        if($hasActive){
            return redirect()->route('colocations.index')->with('error', 'Vous avez déjà une colocation active.');
        }

        $colocation = Colocation::create([
            'name' => $request->name,
            'owner_id' => Auth::id(),
        ]);

        MemberShip::create([
            'user_id' => Auth::id(),
            'colocation_id' =>$colocation->id,
            'role' => 'owner',
            'joined_at' => now(),
        ]);

        return redirect()->route('colocations.show',$colocation);
    }

    /**
     * Display the specified resource.
     */
    public function show(Colocation $colocation)
    {
        $colocation->load(['owner','memberShips.user','invitations.sender']);

        $stats = [
            'members_active' => $colocation->memberShips->whereNull('left_at')->count(),
            'pending_inv' => $colocation->invitations->whereNull('status','pending')->count(),
            'is_owner' => Auth::id() ===  $colocation->owner_id,
            'is_active' => $colocation->status === 'active'
        ];

        return view('colocations.show',compact('colocation','stats'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Colocation $colocation)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Colocation $colocation)
    {
        $this->authorizeOwner($colocation);

        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $colocation->update([
            'name' => $request->name,
        ]);

        return back()->with("succes",'Colocation mise à jour .');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Colocation $colocation)
    {
        $this->authorizeOwner($colocation);

        $colocation->update([
            'status' => 'inactive',
        ]);

        return redirect()->route('dashboard')->with('success','Colocation annulé');
    }

    private function authorizeOwner(Colocation $colocation){
        if($colocation->owner_id !== Auth::id()){
            abort(403);
        }
    }
}
