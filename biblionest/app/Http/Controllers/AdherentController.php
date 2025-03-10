<?php

namespace App\Http\Controllers;

use App\Models\Adherent;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class AdherentController extends Controller
{
    public function index(Request $request)
    {
        $query = Adherent::withCount('borrowings');

        if ($request->filled('search')) {
            $searchTerm = $request->input('search');
            $query->where('firstname', 'like', "%$searchTerm%")
                  ->orWhere('lastname', 'like', "%$searchTerm%")
                  ->orWhere('email', 'like', "%$searchTerm%");
        }

        $adherents = $query->paginate(10);
        
        return view('adherents.index', compact('adherents'));
    }

    public function create()
    {
        return view('adherents.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|email|unique:adherents',
            'phone_number' => 'required|string|max:15',
            'address' => 'required|string|max:255',
        ]);

        Adherent::create($validatedData);

        return redirect()->route('adherents.index')->with('success', 'Adhérent ajouté avec succès.');
    }

    public function show(Adherent $adherent)
    {
        $adherent->load('borrowings.book'); 
        return view('adherents.show', compact('adherent'));
    }

    public function edit(Adherent $adherent)
    {
        return view('adherents.edit', compact('adherent'));
    }

    public function update(Request $request, Adherent $adherent)
    {
        $validatedData = $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:adherents,email,' . $adherent->id,
            'phone_number' => 'required|string|max:15',
            'address' => 'required|string|max:255',
        ]);
    
        $adherent->update($validatedData);
    
        return redirect()->route('adherents.index')->with('success', 'Adhérent modifié avec succès.');
    }

    public function destroy(Adherent $adherent)
    {
        $adherent->delete();
        return redirect()->route('adherents.index')->with('success', 'Adhérent supprimé avec succès.');
    }

    public function borrowings($id)
    {
        $adherent = Adherent::with('borrowings.book')->findOrFail($id);
        return view('adherents.borrowings', compact('adherent'));
    }

    /**
     * Génération du PDF des emprunts de l'adhérent
     */
    public function exportBorrowingsPDF(Adherent $adherent)
    {
        $adherent->load('borrowings.book');

        if ($adherent->borrowings->isEmpty()) {
            return redirect()->route('adherents.show', $adherent->id)->with('error', 'Aucun emprunt à exporter.');
        }

        $pdf = Pdf::loadView('exports.adherents_borrowings', compact('adherent'));

        return $pdf->download("emprunts_{$adherent->firstname}_{$adherent->lastname}.pdf");
    }
}
