<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PwrGenFORCE - Dashboard</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>

    <header style="padding: 20px 40px; display: flex; justify-content: space-between; align-items: center;">
        <h1 style="font-size: 1.5rem; font-weight: 700; color: #6366f1;">PwrGenFORCE⚡</h1>
        <button class="btn-primary">Novo Treino</button>
    </header>

    <main style="padding: 20px 40px; display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px;">
        
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

    </main>

    <script src="/js/main.js"></script>
</body>
</html>
