<?php
$totalTreinos = $totalTreinos ?? 0;
$cargaMaxima = $cargaMaxima ?? 0;
$volumeSemanal = $volumeSemanal ?? 0;
$historico = $historico ?? [];
$fichas = $fichas ?? [];
$historicoPeso = $historicoPeso ?? [];
$gruposTrabalhados = $gruposTrabalhados ?? ['Peitoral' => false, 'Pernas' => false, 'Costas' => false, 'Ombros' => false, 'Braços' => false];
$labels = $labels ?? '[]';
$cargas = $cargas ?? '[]';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PwrGenFORCE⚡ - Fitness Suite</title>
    <link rel="stylesheet" href="/css/style.css">
    <link rel="manifest" href="/manifest.json">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .nav-tabs { display: flex; gap: 10px; margin-bottom: 20px; border-bottom: 1px solid var(--border-card); padding-bottom: 10px; overflow-x: auto; }
        .tab-btn { background: transparent; border: none; color: var(--text-secondary); padding: 8px 16px; font-weight: 600; cursor: pointer; border-radius: 6px; white-space: nowrap; }
        .tab-btn.active { background: #6366f1; color: white; }
        .tab-content { display: none; }
        .tab-content.active { display: block; }
        .muscle-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(140px, 1fr)); gap: 15px; margin-top: 15px; }
        .muscle-card { background: rgba(0,0,0,0.2); border: 1px solid var(--border-card); padding: 15px; border-radius: 8px; text-align: center; }
        .muscle-card.worked { border-color: #22c55e; background: rgba(34, 197, 94, 0.1); }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid var(--border-card); }
        th { color: var(--text-secondary); font-size: 0.85rem; }
        .ficha-card { background: rgba(255,255,255,0.03); border: 1px solid var(--border-card); padding: 15px; border-radius: 8px; margin-bottom: 10px; }

        /* Estilo dos Tooltips explicativos (i) */
        .info-icon {
            display: inline-block;
            width: 18px;
            height: 18px;
            background: #6366f1;
            color: white;
            border-radius: 50%;
            text-align: center;
            font-size: 11px;
            line-height: 18px;
            font-weight: bold;
            cursor: help;
            margin-left: 6px;
            position: relative;
        }
        .info-icon:hover::after {
            content: attr(data-tooltip);
            position: absolute;
            bottom: 125%;
            left: 50%;
            transform: translateX(-50%);
            background: #1e293b;
            color: #f8fafc;
            padding: 8px 12px;
            border-radius: 6px;
            font-size: 0.75rem;
            white-space: normal;
            width: 200px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.5);
            z-index: 100;
            font-weight: normal;
            border: 1px solid #334155;
        }
    </style>
</head>
<body>

    <header style="padding: 20px 40px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;">
        <h1 style="font-size: 1.5rem; font-weight: 700; color: #6366f1;">PwrGenFORCE⚡</h1>
        
        <form method="POST"  style="display: flex; gap: 8px; align-items: center; background: rgba(255,255,255,0.05); padding: 8px 12px; border-radius: 8px; flex-wrap: wrap;">
            <input type="hidden" name="acao" value="novo_treino">
            <select name="exercicio" required style="padding: 6px; border-radius: 4px; border: 1px solid #333; background: #111; color: #fff;">
                <option value="Supino Reto">Supino Reto</option>
                <option value="Agachamento">Agachamento</option>
                <option value="Levantamento Terra">Levantamento Terra</option>
                <option value="Desenvolvimento">Desenvolvimento</option>
                <option value="Rosca Direta">Rosca Direta</option>
                <option value="Tríceps Pulley">Tríceps Pulley</option>
            </select>
            <input type="number" step="0.5" name="carga" placeholder="Kg" required style="width: 60px; padding: 6px; border-radius: 4px; border: 1px solid #333; background: #111; color: #fff;">
            <input type="number" name="repeticoes" placeholder="Reps" required style="width: 60px; padding: 6px; border-radius: 4px; border: 1px solid #333; background: #111; color: #fff;">
            <input type="date" name="data" value="<?= date('Y-m-d') ?>" required style="padding: 6px; border-radius: 4px; border: 1px solid #333; background: #111; color: #fff;">
            <button type="submit" style="padding: 6px 12px; background: #6366f1; color: white; border: none; border-radius: 4px; cursor: pointer;">Salvar Carga</button>
        </form>
    </header>

    <main style="padding: 0 40px 40px 40px;">
        
        <div class="nav-tabs">
            <button class="tab-btn active" onclick="switchTab('dashboard')">Painel Geral</button>
            <button class="tab-btn" onclick="switchTab('fichas')">Fichas (ABC)</button>
            <button class="tab-btn" onclick="switchTab('peso')">Peso Corporal</button>
            <button class="tab-btn" onclick="switchTab('historico')">Histórico</button>
            <button class="tab-btn" onclick="switchTab('anatomia')">Áreas Trabalhadas</button>
        </div>

        <!-- ABA 1: DASHBOARD -->
        <div id="tab-dashboard" class="tab-content active">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 20px; margin-bottom: 20px;">
                <div class="card-glass" style="background: rgba(255,255,255,0.03); padding: 20px; border-radius: 12px; border: 1px solid #222;">
                    <span style="color: #aaa; font-size: 0.875rem;">Total de Treinos</span>
                    <span class="info-icon" data-tooltip="Número total de séries/registros salvos no sistema.">i</span>
                    <h2 style="font-size: 2rem; margin-top: 8px;"><?= $totalTreinos ?></h2>
                </div>
                <div class="card-glass" style="background: rgba(255,255,255,0.03); padding: 20px; border-radius: 12px; border: 1px solid #222;">
                    <span style="color: #aaa; font-size: 0.875rem;">Carga Máx. (Supino)</span>
                    <span class="info-icon" data-tooltip="Maior peso (kg) já registrado para o Supino Reto.">i</span>
                    <h2 style="font-size: 2rem; margin-top: 8px;"><?= $cargaMaxima ?> kg</h2>
                </div>
                <div class="card-glass" style="background: rgba(255,255,255,0.03); padding: 20px; border-radius: 12px; border: 1px solid #222;">
                    <span style="color: #aaa; font-size: 0.875rem;">Volume Semanal</span>
                    <span class="info-icon" data-tooltip="Tonagem total levantada nos últimos 7 dias (Carga x Repetições / 1000).">i</span>
                    <h2 style="font-size: 2rem; margin-top: 8px; color: #22c55e;"><?= $volumeSemanal ?> t</h2>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px; margin-bottom: 20px;">
                <div class="card-glass" style="background: rgba(255,255,255,0.03); padding: 20px; border-radius: 12px; border: 1px solid #222;">
                    <h3 style="margin-bottom: 12px;">⏱️ Timer de Descanso <span class="info-icon" data-tooltip="Cronômetro regressivo para controlar o descanso entre séries.">i</span></h3>
                    <div style="text-align: center; margin: 15px 0;">
                        <span id="timerDisplay" style="font-size: 2.5rem; font-weight: 700; color: #6366f1;">00:00</span>
                    </div>
                    <div style="display: flex; gap: 8px; justify-content: center; flex-wrap: wrap;">
                        <button onclick="startTimer(30)" style="padding: 6px 12px; border-radius: 4px; border: none; background: #333; color: white; cursor: pointer;">30s</button>
                        <button onclick="startTimer(60)" style="padding: 6px 12px; border-radius: 4px; border: none; background: #333; color: white; cursor: pointer;">60s</button>
                        <button onclick="startTimer(90)" style="padding: 6px 12px; border-radius: 4px; border: none; background: #333; color: white; cursor: pointer;">90s</button>
                        <button onclick="resetTimer()" style="padding: 6px 12px; border-radius: 4px; border: none; background: #ef4444; color: white; cursor: pointer;">Parar</button>
                    </div>
                </div>

                <div class="card-glass" style="background: rgba(255,255,255,0.03); padding: 20px; border-radius: 12px; border: 1px solid #222;">
                    <h3 style="margin-bottom: 12px;">🏋️ Calculadora de 1RM <span class="info-icon" data-tooltip="Estimativa da carga máxima para 1 repetição pela Fórmula de Epley: Carga x (1 + Reps/30).">i</span></h3>
                    <div style="display: flex; gap: 10px; margin-bottom: 10px;">
                        <input type="number" id="inputPeso" placeholder="Peso (kg)" style="width: 50%; padding: 8px; border-radius: 4px; border: 1px solid #333; background: #111; color: white;">
                        <input type="number" id="inputReps" placeholder="Reps" style="width: 50%; padding: 8px; border-radius: 4px; border: 1px solid #333; background: #111; color: white;">
                    </div>
                    <button onclick="calcular1RM()" style="width: 100%; padding: 8px; background: #6366f1; color: white; border: none; border-radius: 4px; cursor: pointer;">Calcular Estimativa</button>
                    <div style="text-align: center; margin-top: 10px;">
                        <span style="color: #aaa; font-size: 0.875rem;">1RM Estimado: </span>
                        <strong id="resultado1RM" style="color: #22c55e; font-size: 1.2rem;">- kg</strong>
                    </div>
                </div>
            </div>

            <div class="card-glass" style="background: rgba(255,255,255,0.03); padding: 20px; border-radius: 12px; border: 1px solid #222;">
                <h3 style="margin-bottom: 16px;">Evolução de Cargas (Supino Reto) <span class="info-icon" data-tooltip="Gráfico com a progressão histórica da carga no Supino Reto ao longo do tempo.">i</span></h3>
                <div style="position: relative; height: 260px; width: 100%;">
                    <canvas id="graficoCargas"></canvas>
                </div>
            </div>
        </div>

        <!-- ABA 2: FICHAS DE TREINO -->
        <div id="tab-fichas" class="tab-content">
            <div class="card-glass" style="background: rgba(255,255,255,0.03); padding: 20px; border-radius: 12px; border: 1px solid #222;">
                <h3>Rotina de Treinos Pré-Definida <span class="info-icon" data-tooltip="Divisão de treinos por fichas (ABC) para facilitar o acompanhamento na academia.">i</span></h3>
                <p style="color: #aaa; margin-bottom: 15px; font-size: 0.9rem;">Escolha sua ficha do dia e acompanhe os exercícios recomendados:</p>
                <?php if (!empty($fichas)): ?>
                    <?php foreach ($fichas as $f): ?>
                        <div class="ficha-card">
                            <h4 style="color: #6366f1; font-size: 1.1rem;"><?= htmlspecialchars($f['nome_ficha']) ?></h4>
                            <p style="color: #ddd; margin-top: 5px; font-size: 0.95rem;">📋 <strong>Exercícios:</strong> <?= htmlspecialchars($f['exercicios']) ?></p>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p style="color: #aaa;">Nenhuma ficha cadastrada.</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- ABA 3: PESO CORPORAL -->
        <div id="tab-peso" class="tab-content">
            <div class="card-glass" style="background: rgba(255,255,255,0.03); padding: 20px; border-radius: 12px; border: 1px solid #222;">
                <h3>Registrar Peso Corporal <span class="info-icon" data-tooltip="Acompanhe sua evolução corporal (massa muscular / perda de gordura).">i</span></h3>
                <form method="POST"  style="display: flex; gap: 10px; margin: 15px 0; flex-wrap: wrap;">
                    <input type="hidden" name="acao" value="novo_peso">
                    <input type="number" step="0.1" name="peso_corporal" placeholder="Peso atual (kg)" required style="padding: 8px; border-radius: 4px; border: 1px solid #333; background: #111; color: white;">
                    <input type="date" name="data_peso" value="<?= date('Y-m-d') ?>" required style="padding: 8px; border-radius: 4px; border: 1px solid #333; background: #111; color: white;">
                    <button type="submit" style="padding: 8px 16px; background: #22c55e; color: white; border: none; border-radius: 4px; cursor: pointer;">Salvar Peso</button>
                </form>

                <h4 style="margin-top: 20px;">Histórico de Peso</h4>
                <table>
                    <thead>
                        <tr><th>Data</th><th>Peso (kg)</th></tr>
                    </thead>
                    <tbody>
                        <?php foreach ($historicoPeso as $p): ?>
                            <tr><td><?= $p['data'] ?></td><td><?= $p['peso'] ?> kg</td></tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- ABA 4: HISTÓRICO COMPLETO -->
        <div id="tab-historico" class="tab-content">
            <div class="card-glass" style="background: rgba(255,255,255,0.03); padding: 20px; border-radius: 12px; border: 1px solid #222;">
                <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px; margin-bottom: 15px;">
                    <h3>Histórico de Registros <span class="info-icon" data-tooltip="Todos os registros individuais de carga salvos no banco de dados.">i</span></h3>
                    <button onclick="exportarCSV()" style="padding: 8px 16px; background: #6366f1; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: 600;">📥 Baixar Histórico (CSV)</button>
                </div>
                <table id="tabelaHistorico">
                    <thead>
                        <tr><th>Data</th><th>Exercício</th><th>Carga (kg)</th><th>Repetições</th></tr>
                    </thead>
                    <tbody>
                        <?php foreach ($historico as $item): ?>
                            <tr>
                                <td><?= $item['data_formatada'] ?></td>
                                <td><?= htmlspecialchars($item['exercicio']) ?></td>
                                <td><?= $item['carga'] ?> kg</td>
                                <td><?= $item['repeticoes'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- ABA 5: ÁREAS TRABALHADAS -->
        <div id="tab-anatomia" class="tab-content">
            <div class="card-glass" style="background: rgba(255,255,255,0.03); padding: 20px; border-radius: 12px; border: 1px solid #222;">
                <h3>Áreas Musculares Trabalhadas <span class="info-icon" data-tooltip="Identifica dinamicamente se o grupo muscular foi exercitado com base nos seus registros.">i</span></h3>
                <div class="muscle-grid">
                    <?php foreach ($gruposTrabalhados as $grupo => $trabalhado): ?>
                        <div class="muscle-card <?= $trabalhado ? 'worked' : '' ?>">
                            <h4><?= $grupo ?></h4>
                            <span style="color: <?= $trabalhado ? '#22c55e' : '#888' ?>; font-size: 0.8rem;"><?= $trabalhado ? '✓ Ativo' : 'Sem registro' ?></span>
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

        let timerInterval;
        function startTimer(seconds) {
            clearInterval(timerInterval);
            let time = seconds;
            updateDisplay(time);
            timerInterval = setInterval(() => {
                time--;
                updateDisplay(time);
                if (time <= 0) {
                    clearInterval(timerInterval);
                    alert("⏰ Descanso Finalizado!");
                }
            }, 1000);
        }
        function resetTimer() { clearInterval(timerInterval); updateDisplay(0); }
        function updateDisplay(s) {
            let m = Math.floor(s / 60);
            let sec = s % 60;
            document.getElementById('timerDisplay').innerText = `${m.toString().padStart(2, '0')}:${sec.toString().padStart(2, '0')}`;
        }

        function calcular1RM() {
            let w = parseFloat(document.getElementById('inputPeso').value);
            let r = parseInt(document.getElementById('inputReps').value);
            if (!w || !r) return;
            let rm = Math.round(w * (1 + r / 30));
            document.getElementById('resultado1RM').innerText = rm + ' kg';
        }

        function exportarCSV() {
            let rows = [["Data", "Exercicio", "Carga (kg)", "Repeticoes"]];
            let trs = document.querySelectorAll("#tabelaHistorico tbody tr");
            trs.forEach(tr => {
                let tds = tr.querySelectorAll("td");
                if (tds.length === 4) {
                    rows.push([
                        `"${tds[0].innerText}"`,
                        `"${tds[1].innerText}"`,
                        `"${tds[2].innerText.replace(' kg', '')}"`,
                        `"${tds[3].innerText}"`
                    ]);
                }
            });
            let csvContent = "data:text/csv;charset=utf-8," + rows.map(e => e.join(",")).join("\n");
            let encodedUri = encodeURI(csvContent);
            let link = document.createElement("a");
            link.setAttribute("href", encodedUri);
            link.setAttribute("download", "historico_treinos_pwrgenforce.csv");
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }

        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register('/sw.js');
        }
    </script>
    <script src="/js/main.js"></script>
</body>
</html>
