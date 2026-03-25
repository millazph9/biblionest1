<?php 

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Adherent;
use App\Models\Penalty;
use App\Models\Borrowing;
use Illuminate\Http\Request;

class PenaltyController extends Controller
{
    public function index(Request $request)
    {
        $query = Penalty::with(['borrowing.adherent', 'borrowing.book']);
    
        if ($request->filled('adherent_id')) {
            $query->whereHas('borrowing', function ($q) use ($request) {
                $q->where('adherent_id', $request->adherent_id);
            });
        }
    
        if ($request->filled('status')) {
            if ($request->status == 'paid') {
                $query->where('paid', true);
            } elseif ($request->status == 'unpaid') {
                $query->where('paid', false);
            }
        }
    
        $penalties = $query->latest()->paginate(6);
        $adherents = Adherent::all();
    
        return view('penalties.index', compact('penalties', 'adherents'));
    }
    


    //public function destroy(Penalty $penalty)
    //{
      //  $penalty->delete();
        //return redirect()->route('penalties.index')->with('success', 'Pénalité supprimée.');
    //}

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





    //         public function __construct()
    // {
    //     $this->middleware('auth');
    //     $this->middleware('can:manage-adherents')->except(['index', 'show']);
    // }

}
