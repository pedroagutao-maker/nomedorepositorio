const refreshButton = document.querySelector('#refreshButton');
const usuarioList = document.querySelector('#usuarioList');

async function loadUsuarios() {
    usuarioList.innerHTML = '<li>Carregando...</li>';

    try {
        const response = await fetch('/usuario');
        const usuarios = await response.json();

        if (!Array.isArray(usuarios)) {
            usuarioList.innerHTML = '<li>Erro ao carregar usuários.</li>';
            return;
        }

        usuarioList.innerHTML = usuarios
            .map(
                (usuario) =>
                    `<li><strong>${usuario.nome}</strong> — ${usuario.email}<br><small>${usuario.meta_nutricional}</small></li>`
            )
            .join('');
    } catch (error) {
        usuarioList.innerHTML = '<li>Falha na requisição.</li>';
    }
}

refreshButton.addEventListener('click', loadUsuarios);
loadUsuarios();
