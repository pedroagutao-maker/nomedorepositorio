document.addEventListener('DOMContentLoaded', () => {
    const ctx = document.getElementById('graficoCargas');

    if (ctx) {
        new Chart(ctx, {
            type: 'line', // Tipo: linha
            data: {
                labels: ['Semana 1', 'Semana 2', 'Semana 3', 'Semana 4', 'Semana 5', 'Semana 6'],
                datasets: [{
                    label: 'Carga Máxima (kg)',
                    data: [70, 75, 80, 85, 92, 100],
                    borderColor: '#6366f1', // Cor da linha (var --accent-color)
                    backgroundColor: 'rgba(99, 102, 241, 0.15)', // Sombra abaixo da linha
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4, // Curvatura suave na linha
                    pointBackgroundColor: '#10b981', // Pontos neon
                    pointRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        labels: {
                            color: '#94a3b8' // Cor dos textos de legenda
                        }
                    }
                },
                scales: {
                    x: {
                        ticks: { color: '#94a3b8' },
                        grid: { color: 'rgba(255, 255, 255, 0.05)' }
                    },
                    y: {
                        ticks: { color: '#94a3b8' },
                        grid: { color: 'rgba(255, 255, 255, 0.05)' }
                    }
                }
            }
        });
    }
});
