cat << 'EOF' > app/Views/home.php
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PwrGenFORCE — Monitoramento de Treinos</title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <style>
        body { font-family: Arial, sans-serif; background: #121212; color: #fff; margin: 0; padding: 20px; }
        .container { max-width: 900px; margin: 0 auto; }
        h1, h2 { color: #00ff88; }
        .card { background: #1e1e1e; padding: 20px; border-radius: 8px; margin-bottom: 20px; }
        .grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; }
        .metric { background: #2a2a2a; padding: 15px; border-radius: 6px; text-align: center; }
        .metric h3 { margin: 0; color: #aaa; font-size: 0.9rem; }
        .metric p { margin: 10px 0 0; font-size: 1.5rem; font-weight: bold; color: #00ff88; }
        form { display: grid; gap: 15px; }
        .form-group { display: flex; flex-direction: column; }
        label { margin-bottom: 5px; color: #ccc; }
        input { padding: 10px; border-radius: 4px; border: 1px solid #444; background: #2a2a2a; color: #fff; }
        button { background: #00ff88; color: #000; padding: 12px; border: none; border-radius: 4px; font-weight: bold; cursor: pointer; }
        button:hover { background: #00cc66; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { padding: 10px; border-bottom: 1px solid #333; text-align: left; }
        th { color: #00ff88; }
    </style>
</head>
<body>
    <div class="container">
        <h1>PwrGenFORCE ⚡</h1>

        <!-- Métricas Rápidas -->
        <div class="grid margin-bottom">
            <div class="metric">
                <h3>Total de Treinos</h3>
                <p><?= $totalTreinos ?? 0 ?></p>
            </div>
            <div class="metric">
                <h3>Carga Máx. (Supino)</h3>
                <p><?= $cargaMaxima ?? 0 ?> kg</p>
            </div>
            <div class="metric">
                <h3>Volume Semanal</h3>
                <p><?= $volumeSemanal ?? 0 ?> kg</p>
            </div>
        </div>

        <!-- Formulário Crítico de Novo Treino -->
        <div class="card">
            <h2>Registrar Novo Treino</h2>
            <form method="POST" action="">
                <input type="hidden" name="acao" value="salvar_treino">

                <div class="form-group">
                    <label for="exercicio">Exercício</label>
                    <input type="text" id="exercicio" name="exercicio" required placeholder="Ex: Supino Reto">
                </div>

                <div class="form-group">
                    <label for="carga">Carga (kg)</label>
                    <input type="number" step="0.5" id="carga" name="carga" required placeholder="Ex: 80">
                </div>

                <div class="form-group">
                    <label for="repeticoes">Repetições</label>
                    <input type="number" id="repeticoes" name="repeticoes" required placeholder="Ex: 10">
                </div>

                <div class="form-group">
                    <label for="data">Data do Registro</label>
                    <input type="date" id="data" name="data" value="<?= date('Y-m-d') ?>" required>
                </div>

                <button type="submit">Salvar Treino</button>
            </form>
        </div>

        <!-- Histórico de Treinos -->
        <div class="card">
            <h2>Histórico de Registros</h2>
            <?php if (!empty($historico)): ?>
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
                        <?php foreach ($historico as $item): ?>
                            <tr>
                                <td><?= date('d/m/Y', strtotime($item['data_registro'])) ?></td>
                                <td><?= htmlspecialchars($item['exercicio']) ?></td>
                                <td><?= number_format($item['carga'], 1, ',', '.') ?> kg</td>
                                <td><?= $item['repeticoes'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p style="color: #aaa;">Nenhum registro de treino encontrado.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
EOF
