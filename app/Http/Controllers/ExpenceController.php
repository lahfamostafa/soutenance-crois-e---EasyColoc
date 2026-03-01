<?php

namespace App\Http\Controllers;

use App\Models\Colocation;
use App\Models\Expence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ExpenceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
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
    public function store(Request $request, Colocation $colocation)
    {
        $isMember = $colocation->memberShips()->where('user_id',Auth::id())->whereNull('left_at')->exists();
        if (!$isMember) {
            return back()->with('error',"Voun n'êtes pas membre actif de cette colocation.");
        }

        $data = $request->validate([
            'title' => ['required','string','max:255'],
            'amount' => ['required','numeric','min:0.01'],
            'expence_date' => ['required','date'],
            'payer_id' => ['required','integer','exists:users,id']
        ]);

        $payerIsMember = $colocation->memberShips()->where('user_id',$data['payer_id'])->whereNull('left_at')->exists();

        if (!$payerIsMember) {
            return back()->with('error',"Le payer choisi n'est pas un membre actif de cette colocation.");
        }

        DB::transaction(function () use ($data,$colocation){
            $expence = Expence::create([
                'colocation_id' => $colocation->id,
                'payer_id' => $data['payer_id'],
                'title' => $data['title'],
                'amount' => $data['amount'],
                'expence_date' => $data['expence_date'],
            ]);

            $members = $colocation->memberShips()->whereNull('left_at')->lockForUpdate()->get();

            $count = $members->count();
            if($count === 0)return;

            $share = $expence->amount / $count;

            foreach ($members as $m) {
                if ((int)$m->user_id === (int)$data['payer_id']) {
                    $m->balance = (float)$m->balance + ((float)$expence->amount - (float)$share);
                }else {
                    $m->balance = (float)$m->balance - (float)$share;
                }
                $m->save();
            }
        });
        return back()->with('success',"Expense ajouté + balances mis à jour.");
    }

    /**
     * Display the specified resource.
     */
    public function show(Expence $expence)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Expence $expence)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Expence $expence)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Expence $expence)
    {
        //
    }
}
