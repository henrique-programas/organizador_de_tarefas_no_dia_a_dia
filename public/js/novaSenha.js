 // Toggle visibilidade da senha
  function togglePw(id, btn) {
    const input = document.getElementById(id);
    const hidden = input.type === 'password';
    input.type = hidden ? 'text' : 'password';
    btn.innerHTML = hidden
      ? `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>`
      : `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7z"/><circle cx="12" cy="12" r="3"/></svg>`;
  }

  // Verificador de força da senha
  function checkStrength(val) {
    const bars = [document.getElementById('bar1'), document.getElementById('bar2'), document.getElementById('bar3')];
    const hint = document.getElementById('pw-hint');
    const reqLen     = document.getElementById('req-len');
    const reqUpper   = document.getElementById('req-upper');
    const reqSpecial = document.getElementById('req-special');

    // Reseta
    bars.forEach(b => b.className = 'pw-bar');
    hint.className = 'pw-hint';

    // Requisitos visuais
    reqLen.classList.toggle('ok',     val.length >= 8);
    reqUpper.classList.toggle('ok',   /[A-Z]/.test(val) && /[0-9]/.test(val));
    reqSpecial.classList.toggle('ok', /[^A-Za-z0-9]/.test(val));

    if (!val) { hint.textContent = 'Digite sua senha'; return; }

    let score = 0;
    if (val.length >= 8)                         score++;
    if (/[A-Z]/.test(val) && /[0-9]/.test(val)) score++;
    if (/[^A-Za-z0-9]/.test(val))               score++;

    if (score === 1) {
      bars[0].classList.add('weak');
      hint.classList.add('weak');
      hint.textContent = 'Senha fraca';
    } else if (score === 2) {
      bars[0].classList.add('medium'); bars[1].classList.add('medium');
      hint.classList.add('medium');
      hint.textContent = 'Senha média';
    } else if (score === 3) {
      bars.forEach(b => b.classList.add('strong'));
      hint.classList.add('strong');
      hint.textContent = 'Senha forte ✓';
    }

    // Reavalia o match ao digitar nova senha
    checkMatch();
  }

  // Verificador de correspondência das senhas
  function checkMatch() {
    const senha    = document.getElementById('senha').value;
    const confirma = document.getElementById('confirma').value;
    const hint     = document.getElementById('match-hint');
    if (!confirma) { hint.className = 'match-hint'; hint.textContent = '—'; return; }
    if (senha === confirma) {
      hint.className = 'match-hint match';
      hint.textContent = 'Senhas conferem ✓';
    } else {
      hint.className = 'match-hint no-match';
      hint.textContent = 'As senhas não coincidem';
    }
  }

  // Envio do formulário
  function handleSubmit() {
    const senha    = document.getElementById('senha').value;
    const confirma = document.getElementById('confirma').value;
    const errorBox = document.getElementById('error-box');
    const btn      = document.getElementById('submit-btn');
    const spinner  = document.getElementById('spinner');
    const btnText  = document.getElementById('btn-text');
    const btnIcon  = document.getElementById('btn-icon');
    const progress = document.getElementById('progress');

    // Validações
    if (!senha) { return showError('Por favor, crie uma nova senha.'); }
    if (senha.length < 8) { return showError('A senha deve ter pelo menos 8 caracteres.'); }
    if (senha !== confirma) { return showError('As senhas não coincidem. Verifique e tente novamente.'); }

    // Oculta erro anterior
    errorBox.style.display = 'none';

    // Estado de loading
    btn.disabled = true;
    btnText.textContent = 'Redefinindo...';
    btnIcon.style.display = 'none';
    spinner.style.display = 'block';
    progress.style.width = '65%';

    // ✅ Submete o form de verdade para o Laravel
    document.getElementById('form-body').submit();
  }

  function showError(msg) {
    const errorBox = document.getElementById('error-box');
    errorBox.textContent = msg;
    errorBox.style.display = 'block';
    // Shake no card
    const card = document.querySelector('.card');
    ['-6px','6px','-4px','4px','0'].forEach((x, i) => {
      setTimeout(() => card.style.transform = `translateX(${x})`, i * 70);
    });
  }

  // Enter no confirmar submete
  document.getElementById('confirma').addEventListener('keydown', e => {
    if (e.key === 'Enter') handleSubmit();
  });
  document.addEventListener('DOMContentLoaded', () => {
    const errorBox = document.getElementById('error-box');
    if (errorBox && errorBox.textContent.trim() !== '') {
        errorBox.style.display = 'block';
    }
  });