<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PwrGenFORCE - Dashboard</title>
    <link rel="stylesheet" href="/css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

    <header style="padding: 20px 40px; display: flex; justify-content: space-between; align-items: center;">
        <h1 style="font-size: 1.5rem; font-weight: 700; color: #6366f1;">PwrGenFORCE⚡</h1>
        <button class="btn-primary">Novo Treino</button>
    </header>

    <main style="padding: 20px 40px; display: flex; flex-direction: column; gap: 20px;">
        
        <!-- Cards de Métricas Principais -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px;">
            <div class="card-glass">
                <span style="color: var(--text-secondary); font-size: 0.875rem;">Treinos Concluídos</span>
                <h2 style="font-size: 2rem; margin-top: 8px;">24 <span style="color: var(--success); font-size: 1rem;">+12%</span></h2>
            </div>

            <div class="card-glass">
                <span style="color: var(--text-secondary); font-size: 0.875rem;">Meta de Proteínas</span>
                <h2 style="font-size: 2rem; margin-top: 8px;">160g / 180g</h2>
            </div>

            <div class="card-glass">
                <span style="color: var(--text-secondary); font-size: 0.875rem;">Carga Máxima (Supino)</span>
                <h2 style="font-size: 2rem; margin-top: 8px;">100 kg</h2>
            </div>
        </div>

        <!-- Seção de Ferramentas Interativas (Cronômetro + Calculadora 1RM) -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 20px;">
            
            <!-- Cronômetro de Descanso -->
            <div class="card-glass">
                <h3 style="margin-bottom: 12px; color: var(--text-primary);">⏱️ Timer de Descanso</h3>
                <div style="text-align: center; margin: 15px 0;">
                    <span id="timerDisplay" style="font-size: 2.5rem; font-weight: 700; color: #6366f1;">00:00</span>
                </div>
                <div style="display: flex; gap: 10px; justify-content: center; flex-wrap: wrap;">
                    <button class="btn-primary" onclick="startTimer(30)" style="padding: 8px 16px;">30s</button>
                    <button class="btn-primary" onclick="startTimer(60)" style="padding: 8px 16px;">60s</button>
                    <button class="btn-primary" onclick="startTimer(90)" style="padding: 8px 16px;">90s</button>
                    <button class="btn-primary" onclick="resetTimer()" style="padding: 8px 16px; background: #ef4444;">Parar</button>
                </div>
            </div>

            <!-- Calculadora de 1RM (Carga Máxima) -->
            <div class="card-glass">
                <h3 style="margin-bottom: 12px; color: var(--text-primary);">🏋️ Calculadora de 1RM (Epley)</h3>
                <div style="display: flex; gap: 10px; margin-bottom: 10px;">
                    <input type="number" id="inputPeso" placeholder="Peso (kg)" style="width: 50%; padding: 10px; border-radius: 8px; border: 1px solid var(--border-card); background: rgba(0,0,0,0.3); color: white;">
                    <input type="number" id="inputReps" placeholder="Reps" style="width: 50%; padding: 10px; border-radius: 8px; border: 1px solid var(--border-card); background: rgba(0,0,0,0.3); color: white;">
                </div>
                <button class="btn-primary" onclick="calcular1RM()" style="width: 100%; margin-bottom: 10px;">Calcular Estimativa</button>
                <div style="text-align: center;">
                    <span style="color: var(--text-secondary); font-size: 0.875rem;">1RM Estimado: </span>
                    <strong id="resultado1RM" style="color: var(--success); font-size: 1.2rem;">- kg</strong>
                </div>
            </div>

        </div>

        <!-- Seção do Gráfico Interativo -->
        <div class="card-glass" style="width: 100%;">
            <h3 style="margin-bottom: 16px; color: var(--text-primary);">Evolução de Cargas (Supino Reto)</h3>
            <div style="position: relative; height: 300px; width: 100%;">
                <canvas id="graficoCargas"></canvas>
            </div>
        </div>

    </main>

    <script src="/js/main.js"></script>
</body>
</html>
