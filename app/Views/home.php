<?php
// Fallbacks de segurança para evitar avisos caso as variáveis não cheguem do Controller
$totalTreinos = $totalTreinos ?? 0;
$cargaMaxima = $cargaMaxima ?? 0;
$historico = $historico ?? [];
$gruposTrabalhados = $gruposTrabalhados ?? [
    'Peitoral' => false,
    'Pernas'   => false,
    'Costas'   => false,
    'Ombros'   => false,
    'Braços'   => false
];
$labels = $labels ?? '[]';
$cargas = $cargas ?? '[]';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PwrGenFORCE - Dashboard v5.7</title>
    <link rel="stylesheet" href="/css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .nav-tabs { display: flex; gap: 10px; margin-bottom: 20px; border-bottom: 1px solid var(--border-card); padding-bottom: 10px; }
        .tab-btn { background: transparent; border: none; color: var(--text-secondary); padding: 8px 16px; font-weight: 600; cursor: pointer; border-radius: 6px; }
        .tab-btn.active { background: var(--accent); color: white; }
        .tab-content { display: none; }
        .tab-content.active { display: block; }
        .muscle-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 15px; margin-top: 15px; }
        .muscle-card { background: rgba(0,0,0,0.2); border: 1px solid var(--border-card); padding: 15px; border-radius: 8px; text-align: center; }
        .muscle-card.worked { border-color: var(--success); background: rgba(34, 197, 94, 0.1); }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid var(--border-card); }
        th { color: var(--text-secondary); font-size: 0.85rem; }
    </style>
</head>
<body>

    <header style="padding: 20px 40px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;">
        <h1 style="font-size: 1.5rem; font-weight: 700; color: #6366f1;">PwrGenFORCE⚡</h1>
        
        <form method="POST" action="" style="display: flex; gap: 10px; align-items: center; background: rgba(255,255,255,0.05); padding: 8px 12px; border-radius: 8px;">
            <input type="hidden" name="acao" value="novo_treino">
            <select name="exercicio" required style="padding: 6px; border-radius: 4px; border: 1px solid #333; background: #111; color: #fff;">
                <option value="Supino Reto">Supino Reto</option>
                <option value="Agachamento">Agachamento</option>
                <option value="Levantamento Terra">Levantamento Terra</option>
                <option value="Desenvolvimento">Desenvolvimento</option>
            </select>
            <input type="number" step="0.5" name="carga" placeholder="Kg" required style="width: 60px; padding: 6px; border-radius: 4px; border: 1px solid #333; background: #111; color: #fff;">
            <input type="number" name="repeticoes" placeholder="Reps" required style="width: 60px; padding: 6px; border-radius: 4px; border: 1px solid #333; background: #111; color: #fff;">
            <input type="date" name="data" value="<?= date('Y-m-d') ?>" required style="padding: 6px; border-radius: 4px; border: 1px solid #333; background: #111; color: #fff;">
            <button type="submit" class="btn-primary" style="padding: 6px 12px;">Salvar Carga</button>
        </form>
    </header>

    <main style="padding: 0 40px 40px 40px;">
        
        <!-- Navegação por Abas -->
        <div class="nav-tabs">
            <button class="tab-btn active" onclick="switchTab('dashboard')">Painel Geral</button>
            <button class="tab-btn" onclick="switchTab('historico')">Histórico de Treinos</button>
            <button class="tab-btn" onclick="switchTab('anatomia')">Áreas Trabalhadas</button>
        </div>

        <!-- ABA 1: DASHBOARD GERAL -->
        <div id="tab-dashboard" class="tab-content active">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; margin-bottom: 20px;">
                <div class="card-glass">
                    <span style="color: var(--text-secondary); font-size: 0.875rem;">Total de Treinos</span>
                    <h2 style="font-size: 2rem; margin-top: 8px;"><?= $totalTreinos ?></h2>
                </div>
                <div class="card-glass">
                    <span style="color: var(--text-secondary); font-size: 0.875rem;">Carga Máxima (Supino)</span>
                    <h2 style="font-size: 2rem; margin-top: 8px;"><?= $cargaMaxima ?> kg</h2>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 20px; margin-bottom: 20px;">
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

                <div class="card-glass">
                    <h3 style="margin-bottom: 12px; color: var(--text-primary);">🏋️ Calculadora de 1RM</h3>
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

            <div class="card-glass" style="width: 100%;">
                <h3 style="margin-bottom: 16px; color: var(--text-primary);">Evolução de Cargas</h3>
                <div style="position: relative; height: 300px; width: 100%;">
                    <canvas id="graficoCargas"></canvas>
                </div>
            </div>
        </div>

        <!-- ABA 2: HISTÓRICO COMPLETO -->
        <div id="tab-historico" class="tab-content">
            <div class="card-glass">
                <h3 style="margin-bottom: 15px;">Histórico de Registros</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Data</th>
                            <th>Exercício</th>
                            <th>Carga (kg)</th>
                            <th>Repetições</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($historico)): ?>
                            <?php foreach ($historico as $item): ?>
                                <tr>
                                    <td><?= $item['data_formatada'] ?></td>
                                    <td><?= htmlspecialchars($item['exercicio']) ?></td>
                                    <td><?= $item['carga'] ?> kg</td>
                                    <td><?= $item['repeticoes'] ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" style="text-align: center; color: var(--text-secondary);">Nenhum registro encontrado.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- ABA 3: MAPA ANATÔMICO DINÂMICO -->
        <div id="tab-anatomia" class="tab-content">
            <div class="card-glass">
                <h3>Áreas Musculares Trabalhadas</h3>
                <p style="color: var(--text-secondary); margin-top: 5px; font-size: 0.9rem;">Status dinâmico baseado no histórico registrado no sistema:</p>
                
                <div class="muscle-grid">
                    <?php foreach ($gruposTrabalhados as $grupo => $trabalhado): ?>
                        <div class="muscle-card <?= $trabalhado ? 'worked' : '' ?>">
                            <h4><?= $grupo ?></h4>
                            <?php if ($trabalhado): ?>
                                <span style="color: var(--success); font-size: 0.8rem;">✓ Ativo no Histórico</span>
                            <?php else: ?>
                                <span style="color: var(--text-secondary); font-size: 0.8rem;">Sem registro</span>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

    </main>

    <script>
        window.chartLabels = <?= $labels ?>;
        window.chartData = <?= $cargas ?>;

        function switchTab(tabName) {
            document.querySelectorAll('.tab-content').forEach(el => el.classList.remove('active'));
            document.querySelectorAll('.tab-btn').forEach(el => el.classList.remove('active'));
            document.getElementById('tab-' + tabName).classList.add('active');
            event.target.classList.add('active');
        }
    </script>
    <script src="/js/main.js"></script>
</body>
</html>
