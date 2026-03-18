<?php 

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Penalty;
use App\Models\Borrowing;
use Illuminate\Http\Request;

class PenaltyController extends Controller
{
    public function index(Request $request)
    {
        $query = Penalty::with(['borrowing.user', 'borrowing.book']);
    
        if ($request->filled('user_id')) {
            $query->whereHas('borrowing', function ($q) use ($request) {
                $q->where('user_id', $request->user_id);
            });
        }
    
        if ($request->filled('status')) {
            if ($request->status == 'paid') {
                $query->where('paid', true);
            } elseif ($request->status == 'unpaid') {
                $query->where('paid', false);
            }
        }
    
        $penalties = $query->paginate(10);
        $users = User::all();
    
        return view('penalties.index', compact('penalties', 'users'));
    }
    
    // public function create()
    // {
    //     $borrowings = Borrowing::whereNull('returned_at')->with('book', 'user')->get(); // Récupérer uniquement les emprunts non retournés
    //     return view('penalties.create', compact('borrowings'));
    // }

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'borrowing_id' => 'required|exists:borrowings,id',
    //         'amount' => 'required|numeric|min:1',
    //     ]);

    //     Penalty::create([
    //         'borrowing_id' => $request->borrowing_id,
    //         'amount' => $request->amount,
    //         'paid' => false,
    //     ]);

    //     return redirect()->route('penalties.index')->with('success', 'Pénalité enregistrée.');
    // }

    public function edit(Penalty $penalty)
    {
        return view('penalties.edit', compact('penalty'));
    }

    public function update(Request $request, Penalty $penalty)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'paid' => 'required|boolean',
        ]);

        $penalty->update([
            'amount' => $request->amount,
            'paid' => $request->paid,
            'paid_at' => $request->paid ? now() : null,
        ]);

        return redirect()->route('penalties.index')->with('success', 'Pénalité mise à jour.');
    }

    public function destroy(Penalty $penalty)
    {
        $penalty->delete();
        return redirect()->route('penalties.index')->with('success', 'Pénalité supprimée.');
    }

    public function pay(Penalty $penalty)
    {
        if (!$penalty->paid) {
            $penalty->update([
                'paid' => true,
                'paid_at' => now(),
            ]);
        }

        return redirect()->route('penalties.index')->with('success', 'Pénalité payée.');
    }


    public function mesPenalites()
    {
        $penalties = Penalty::whereHas('borrowing', function ($q) {
            $q->where('user_id', auth()->id());
        })->with('borrowing.book')->latest()->get();

        return view('penalties.mes-penalites', compact('penalties'));
    }



    //         public function __construct()
    // {
    //     $this->middleware('auth');
    //     $this->middleware('can:manage-adherents')->except(['index', 'show']);
    // }

}
