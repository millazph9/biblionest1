<x-app-layout>
    <div class="container mx-auto">
        <h1 class="text-2xl font-bold mb-6">📊 Tableau de Bord</h1>

        <div class="grid grid-cols-2 md:grid-cols-3 gap-6">
            <div class="bg-white shadow p-4 rounded">
                <h2 class="text-lg font-semibold">📚 Total Livres</h2>
                <p class="text-2xl font-bold">{{ $totalBooks }}</p>
            </div>

            <div class="bg-white shadow p-4 rounded">
                <h2 class="text-lg font-semibold">👥 Nombre d'Utilisateurs</h2>
                <p class="text-2xl font-bold">{{ $totalUsers }}</p>
            </div>

            <div class="bg-white shadow p-4 rounded">
                <h2 class="text-lg font-semibold">📖 Emprunts Actifs</h2>
                <p class="text-2xl font-bold">{{ $totalBorrowings }}</p>
            </div>

            <div class="bg-white shadow p-4 rounded">
                <h2 class="text-lg font-semibold text-red-600">❌ Emprunts en Retard</h2>
                <p class="text-2xl font-bold text-red-600">{{ $totalLateBorrowings }}</p>
            </div>

            <div class="bg-white shadow p-4 rounded">
                <h2 class="text-lg font-semibold text-red-500">💰 Pénalités Impayées</h2>
                <p class="text-2xl font-bold text-red-500">{{ $totalUnpaidPenalties }} €</p>
            </div>
        </div>
    </div>

    <canvas id="borrowingsChart" class="mt-8"></canvas>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var ctx = document.getElementById('borrowingsChart').getContext('2d');
    var borrowingsChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($formattedMonths) !!},
            datasets: [{
                label: 'Emprunts par Mois',
                data: {!! json_encode($formattedData) !!},
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
</script>

</x-app-layout>
