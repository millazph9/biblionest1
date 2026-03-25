<x-app-layout> 
    <div class="container mx-auto px-4">
        <h1 class="text-2xl font-bold mb-6 text-center">📊 Tableau de Bord</h1>

        <!-- 📌 Statistiques -->
        <div class="grid grid-cols-2 md:grid-cols-3 gap-6 mb-8">
            <x-dashboard-card title="📚 Total Livres" :value="$totalBooks" />
            <x-dashboard-card title="👥 Nombre d'utilisateurs" :value="$totalUsers" />
            <x-dashboard-card title="📖 Emprunts Actifs" :value="$totalBorrowings" />
            <x-dashboard-card title="❌ Retards" :value="$totalLateBorrowings" class="text-red-600" />
            <x-dashboard-card title="💰 Pénalités Impayées" :value="$totalUnpaidPenalties . ' €'" class="text-red-500" />
        </div>

        <!-- 📈 Graphique -->
        <div class="bg-white p-6 rounded shadow mb-8">
            <h2 class="text-lg font-semibold mb-4">📈 Emprunts par Mois</h2>
            <div style=" height:300px">
                <canvas id="borrowingsChart"></canvas>

            </div>
        </div>

        <!-- 🔄 Derniers adhérents -->
        <div class="bg-white p-6 rounded shadow mb-8 overflow-x-auto">
            <h2 class="text-lg font-semibold mb-4">👤 Derniers Adhérents</h2>
            <table class="min-w-full text-sm text-left text-gray-600">
                <thead class="bg-gray-100 text-xs uppercase">
                    <tr>
                        <th class="py-2 px-4">Nom</th>
                        <th class="py-2 px-4">Email</th>
                        <th class="py-2 px-4">Date d'inscription</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($latestUsers as $user)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-2 px-4 font-medium">{{ $user->name }}</td>
                            <td class="py-2 px-4">{{ $user->email }}</td>
                            <td class="py-2 px-4">{{ $user->created_at->format('d/m/Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="py-2 px-4 text-center text-gray-500">Aucun adhérent trouvé.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- 📚 Livres les plus empruntés -->
        <div class="bg-white p-6 rounded shadow mb-8 overflow-x-auto">
            <h2 class="text-lg font-semibold mb-4">📚 Livres les plus empruntés</h2>
            <table class="min-w-full text-sm text-left text-gray-600">
                <thead class="bg-gray-100 text-xs uppercase">
                    <tr>
                        <th class="py-2 px-4">Titre</th>
                        <th class="py-2 px-4">Nombre d'emprunts</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($topBooks as $book)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-2 px-4">{{ $book->title }}</td>
                            <td class="py-2 px-4">{{ $book->borrowings_count }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="py-2 px-4 text-center text-gray-500">Aucun livre emprunté.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- ⏰ Derniers retards -->
        <div class="bg-white p-6 rounded shadow overflow-x-auto">
            <h2 class="text-lg font-semibold mb-4">⏰ Derniers Emprunts en Retard</h2>
            <table class="min-w-full text-sm text-left text-gray-600">
                <thead class="bg-gray-100 text-xs uppercase">
                    <tr>
                        <th class="py-2 px-4">Livre</th>
                        <th class="py-2 px-4">Utilisateur</th>
                        <th class="py-2 px-4">Date de retour prévue</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentLateBorrowings as $borrowing)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-2 px-4 font-medium">
                                {{ $borrowing->book?->title ?? 'Livre inconnu' }}
                            </td>
                            <td class="py-2 px-4">
                                {{ $borrowing->user?->name ?? 'Utilisateur inconnu' }}
                            </td>
                            <td class="py-2 px-4">
                                {{ optional($borrowing->due_date)->format('d/m/Y') ?? 'Date non définie' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="py-2 px-4 text-center text-gray-500">Aucun emprunt en retard.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const ctx = document.getElementById('borrowingsChart');
            const labels = @json($months);
            const data = @json($counts);


            if(ctx){
                new Chart(ctx, {
                    type : 'bar',
                    data : {
                        labels : labels,
                        datasets : [{
                            label : 'Emprunts par mois',
                            data : data,
                            backgroundColor: 'rgba(59, 130, 246, 0.5)',
                            borderColor: 'rgba(59, 130, 246, 1)',
                            borderWidth : 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: { beginAtZero: true }
                        }
                    }
                });
            }
        });
    </script>
</x-app-layout>
