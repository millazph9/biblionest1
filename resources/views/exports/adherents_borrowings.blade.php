<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Emprunts de {{ $adherent->firstname }} {{ $adherent->lastname }}</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid black; padding: 10px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2>Liste des Emprunts de {{ $adherent->firstname }} {{ $adherent->lastname }}</h2>
    <p><strong>Email:</strong> {{ $adherent->email }}</p>
    <p><strong>Téléphone:</strong> {{ $adherent->phone_number }}</p>
    <p><strong>Adresse:</strong> {{ $adherent->address }}</p>

    <h3>Livres empruntés :</h3>

    @if($adherent->borrowings->isEmpty())
        <p>Aucun emprunt trouvé.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>Livre</th>
                    <th>Date d'emprunt</th>
                    <th>Retour prévu</th>
                    <th>Statut</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($adherent->borrowings as $borrowing)
                    <tr>
                        <td>{{ $borrowing->book->title ?? 'Livre supprimé' }}</td>
                        <td>{{ \Carbon\Carbon::parse($borrowing->borrowed_at)->format('d/m/Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($borrowing->due_date)->format('d/m/Y') }}</td>
                        <td>
                            @if ($borrowing->returned_at)
                                ✅ Rendu le {{ \Carbon\Carbon::parse($borrowing->returned_at)->format('d/m/Y') }}
                            @elseif (\Carbon\Carbon::parse($borrowing->due_date)->isPast())
                                ❌ En retard
                            @else
                                📖 En cours
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</body>
</html>
