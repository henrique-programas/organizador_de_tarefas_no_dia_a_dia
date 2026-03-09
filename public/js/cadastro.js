function togglePw(id, btn) {
    const input = document.getElementById(id);
    const isHidden = input.type === 'password';
    input.type = isHidden ? 'text' : 'password';
    btn.innerHTML = isHidden
      ? `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>`
      : `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7z"/><circle cx="12" cy="12" r="3"/></svg>`;
  }

  function checkStrength(val) {
    const bars  = [document.getElementById('bar1'), document.getElementById('bar2'), document.getElementById('bar3')];
    const hint  = document.getElementById('pw-hint');

    bars.forEach(b => b.className = 'pw-bar');
    hint.className = 'pw-hint';

    if (!val) { hint.textContent = 'Digite sua senha'; return; }

    let score = 0;
    if (val.length >= 8)                    score++;
    if (/[A-Z]/.test(val) && /[0-9]/.test(val)) score++;
    if (/[^A-Za-z0-9]/.test(val))          score++;

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
  }