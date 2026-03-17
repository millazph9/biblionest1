<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Adherent;
use App\Models\Category;
use Barryvdh\DomPDF\Facade\Pdf;

class AdherentController extends Controller
{
    public function index(Request $request)
    {
        // Ajout de la recherche
        $query = Adherent::query();

        if ($request->filled('search')) {
            $searchTerm = $request->input('search');
            $query->where('firstname', 'like', "%$searchTerm%")
                  ->orWhere('lastname', 'like', "%$searchTerm%")
                  ->orWhere('email', 'like', "%$searchTerm%");
        }

        // Pagination
        $adherents = $query->paginate(10);

        return view('adherents.index', compact('adherents'));
    }

    public function create()
    {
        $categories = Category::all(); // Récupère toutes les catégories
        return view('adherents.create', compact('categories'));
    }

public function store(Request $request)
{
    $validatedData = $request->validate([
        'firstname' => 'required|string|max:255',
        'lastname' => 'required|string|max:255',
        'email' => 'required|email|unique:adherents,email',
        'phone_number' => ['required', 'regex:/^(\\+33|0)[1-9]\\d{8}$/'],
        'address' => 'required|string|max:255',
    ]);

    Adherent::create($validatedData);

    return redirect()->route('adherents.index')->with('success', 'Adhérent ajouté avec succès.');
}


    public function show(Adherent $adherent)
    {
        return view('adherents.show', compact('adherent'));
    }

    public function edit(Adherent $adherent)
    {
        $categories = Category::all(); // Récupérer les catégories aussi dans edit
        return view('adherents.edit', compact('adherent', 'categories'));
    }

    public function update(Request $request, Adherent $adherent)
    {
        // Validation des données avant mise à jour
        $validatedData = $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|email|unique:adherents,email,' . $adherent->id,
            'phone_number' => ['required', 'regex:/^(\\+33|0)[1-9]\\d{8}$/'],
            'address' => 'required|string|max:255',
        ]);

        $adherent->update($validatedData);

        return redirect()->route('adherents.index')->with('success', 'Adhérent mis à jour avec succès.');
    }

    public function destroy(Adherent $adherent)
    {
        $adherent->delete();
        return redirect()->route('adherents.index')->with('success', 'Adhérent supprimé avec succès.');
    }

    /**
     * Exporter les emprunts d'un adhérent en PDF.
     */
    public function exportBorrowingsPDF(Adherent $adherent)
    {
        $adherent->load('borrowings.book'); // Charge les emprunts liés à l'adhérent

        if ($adherent->borrowings->isEmpty()) {
            return redirect()->route('adherents.show', $adherent->id)
                ->with('error', 'Aucun emprunt à exporter.');
        }

        $pdf = Pdf::loadView('exports.adherents_borrowings', compact('adherent'));

        return $pdf->download("emprunts_{$adherent->firstname}_{$adherent->lastname}.pdf");
    }
}
