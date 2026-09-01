let timerInterval = null;

// Funções do Cronômetro de Descanso
function startTimer(segundos) {
    clearInterval(timerInterval);
    let tempoRestante = segundos;
    atualizarDisplayTimer(tempoRestante);

    timerInterval = setInterval(() => {
        tempoRestante--;
        atualizarDisplayTimer(tempoRestante);

        if (tempoRestante <= 0) {
            clearInterval(timerInterval);
            document.getElementById('timerDisplay').innerText = "PRONTO! 🔥";
            document.getElementById('timerDisplay').style.color = "#10b981";
        }
    }, 1000);
}

function resetTimer() {
    clearInterval(timerInterval);
    document.getElementById('timerDisplay').innerText = "00:00";
    document.getElementById('timerDisplay').style.color = "#6366f1";
}

function atualizarDisplayTimer(seg) {
    const mins = Math.floor(seg / 60);
    const secs = seg % 60;
    const formatted = `${String(mins).padStart(2, '0')}:${String(secs).padStart(2, '0')}`;
    const display = document.getElementById('timerDisplay');
    display.innerText = formatted;
    display.style.color = "#6366f1";
}

// Função da Calculadora de 1RM (Fórmula de Epley: Peso * (1 + Reps/30))
function calcular1RM() {
    const peso = parseFloat(document.getElementById('inputPeso').value);
    const reps = parseInt(document.getElementById('inputReps').value);

    if (isNaN(peso) || isNaN(reps) || peso <= 0 || reps <= 0) {
        document.getElementById('resultado1RM').innerText = "Preencha os campos!";
        document.getElementById('resultado1RM').style.color = "#ef4444";
        return;
    }

    const umRM = reps === 1 ? peso : Math.round(peso * (1 + reps / 30));
    document.getElementById('resultado1RM').innerText = `${umRM} kg`;
    document.getElementById('resultado1RM').style.color = "#10b981";
}

// Inicialização do Gráfico Chart.js
document.addEventListener('DOMContentLoaded', () => {
    const ctx = document.getElementById('graficoCargas');

    if (ctx) {
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Semana 1', 'Semana 2', 'Semana 3', 'Semana 4', 'Semana 5', 'Semana 6'],
                datasets: [{
                    label: 'Carga Máxima (kg)',
                    data: [70, 75, 80, 85, 92, 100],
                    borderColor: '#6366f1',
                    backgroundColor: 'rgba(99, 102, 241, 0.15)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#10b981',
                    pointRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        labels: { color: '#94a3b8' }
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
