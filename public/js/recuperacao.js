function handleSubmit(e) {
    e.preventDefault(); // evita reload

    const email = document.getElementById('email').value.trim();
    const errorBox = document.getElementById('error-box');
    const btn = document.getElementById('submit-btn');
    const spinner = document.getElementById('spinner');
    const btnText = document.getElementById('btn-text');
    const btnIcon = document.getElementById('btn-icon');
    const progress = document.getElementById('progress');

    // Validação simples
    if (!email) {
        showError('Por favor, insira seu e-mail.');
        document.getElementById('email').focus();
        return;
    }
    if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
        showError('Por favor, insira um e-mail válido.');
        document.getElementById('email').focus();
        return;
    }

    // Oculta erro anterior
    errorBox.style.display = 'none';

    // Estado de loading
    btn.disabled = true;
    btnText.textContent = 'Enviando...';
    btnIcon.style.display = 'none';
    spinner.style.display = 'block';
    progress.style.width = '60%';

    // Envio via fetch para Laravel
    fetch(resetRoute, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "Accept": "application/json",
            "X-CSRF-TOKEN": document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute('content')
        },
        body: JSON.stringify({
            email: email
        })
    })
    .then(async res => {
    
        const data = await res.json();
    
        if (!res.ok) {
            throw new Error(data.message);
        }
    
        return data;
    
    })
    .then(data => {
    
        progress.style.width = '100%';
    
        setTimeout(() => {
        
            document.getElementById('form-body').style.display = 'none';
            document.getElementById('success-state').classList.add('show');
        
        }, 400);
    
    })
    .catch(err => {
    
        showError(err.message || 'Erro ao enviar link.');
    
        btn.disabled = false;
        btnText.textContent = 'Enviar link de recuperação';
        spinner.style.display = 'none';
        btnIcon.style.display = 'block';
        progress.style.width = '0%';
    
    });
}

// Função de erro
function showError(msg) {
    const errorBox = document.getElementById('error-box');
    errorBox.textContent = msg;
    errorBox.style.display = 'block';
}

document.addEventListener("DOMContentLoaded", () => {
    document.getElementById("submit-btn").addEventListener("click", handleSubmit);
});