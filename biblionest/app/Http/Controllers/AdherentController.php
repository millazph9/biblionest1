<?php

namespace App\Http\Controllers;

use App\Models\Adherent;
use App\Http\Requests\AdherentRequest; // ✅ Import de AdherentRequest
use Barryvdh\DomPDF\Facade\Pdf;

class AdherentController extends Controller
{
    public function index(AdherentRequest $request)
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

    public function store(AdherentRequest $request) // ✅ Utilisation de AdherentRequest
    {
        Adherent::create($request->validated());

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

    public function update(AdherentRequest $request, Adherent $adherent) // ✅ Utilisation de AdherentRequest
    {
        $adherent->update($request->validated());

        return redirect()->route('adherents.index')->with('success', 'Adhérent mis à jour avec succès.');
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

    // public function __construct()
    // {
    //     $this->middleware('auth');
    //     $this->middleware('can:manage-adherents')->except(['index', 'show']);
    // }
}
