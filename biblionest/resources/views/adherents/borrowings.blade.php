<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Emprunts de {{ $adherent->firstname }} {{ $adherent->lastname }}</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid black; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2>Liste des emprunts de {{ $adherent->firstname }} {{ $adherent->lastname }}</h2>
    <p>Email : {{ $adherent->email }}</p>
    <p>Téléphone : {{ $adherent->phone_number }}</p>

    <table>
        <thead>
            <tr>
                <th>Livre</th>
                <th>Date d'emprunt</th>
                <th>Date de retour prévue</th>
                <th>Statut</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($adherent->borrowings as $borrowing)
                <tr>
                    <td>{{ $borrowing->book->title ?? 'Livre inconnu' }}</td>
                    <td>{{ $borrowing->borrowed_at->format('d/m/Y') }}</td>
                    <td>{{ $borrowing->due_date->format('d/m/Y') }}</td>
                    <td>
                        @if ($borrowing->returned_at)
                            ✅ Rendu le {{ $borrowing->returned_at->format('d/m/Y') }}
                        @elseif ($borrowing->due_date->isPast())
                            ❌ En retard
                        @else
                            📖 En cours
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
