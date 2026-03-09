<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <meta name="csrf-token" content="{{ csrf_token() }}">  {{-- ✅ PASSO 1 --}}
  <title>Redefinir Senha — TaskFlow</title>
  <link href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600;700&display=swap" rel="stylesheet"/>
  <link rel="stylesheet" href="{{ asset('css/novaSenha.css') }}">
</head>
<body>

<div class="card">

  <div class="progress-bar"><div class="progress-fill" id="progress"></div></div>

  <!-- Logo -->
  <div class="logo">
    <div class="logo-circle">
      <svg viewBox="0 0 24 24">
        <path d="M12 2L2 7l10 5 10-5-10-5z"/>
        <path d="M2 17l10 5 10-5"/>
        <path d="M2 12l10 5 10-5"/>
      </svg>
    </div>
  </div>

  <p class="card-label">Nova senha</p>
  <h1 class="card-title">Redefinir senha</h1>
  <p class="card-desc">Escolha uma senha nova e segura<br>para proteger sua conta.</p>

  <!-- Estado de sucesso -->
  <div class="success-state" id="success-state">
    <div class="success-icon">
      <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
    </div>
    <p class="success-msg">
      <strong>Senha redefinida!</strong>
      Sua senha foi atualizada com sucesso. Você já pode fazer login com sua nova senha.
    </p>
    <button class="btn btn-primary" onclick="window.location.href='/login'" style="margin-top:4px">
      <svg viewBox="0 0 24 24"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
      Ir para o login
    </button>
  </div>

  {{-- ✅ PASSO 2: div virou form com action, @csrf, token e email ocultos --}}
  <form id="form-body" method="POST" action="{{ route('password.store') }}">
    @csrf
    <input type="hidden" name="token" value="{{ $request->route('token') }}">
    <input type="hidden" name="email" value="{{ $request->email }}">

    {{-- ✅ PASSO 3: mostra erros de senha, email e token --}}
    <div id="error-box" class="error" style="display:none;">
      @error('password') {{ $message }} @enderror
      @error('email')   {{ $message }} @enderror
      @error('token')   {{ $message }} @enderror
    </div>

    <!-- Nova senha -->
    <div class="field" style="animation-delay:.3s">
      <label for="senha">Nova senha</label>
      <div class="input-wrap">
        <input
          type="password"
          id="senha"
          name="password"
          placeholder="Mín. 8 caracteres"
          autocomplete="new-password"
          oninput="checkStrength(this.value)"
        />
        <span class="icon">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <rect x="3" y="11" width="18" height="11" rx="2"/>
            <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
          </svg>
        </span>
        <button class="toggle-pw" type="button" onclick="togglePw('senha', this)" aria-label="Mostrar senha">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7z"/>
            <circle cx="12" cy="12" r="3"/>
          </svg>
        </button>
      </div>

      <!-- Barras de força -->
      <div class="pw-strength">
        <div class="pw-bar" id="bar1"></div>
        <div class="pw-bar" id="bar2"></div>
        <div class="pw-bar" id="bar3"></div>
      </div>
      <p class="pw-hint" id="pw-hint">Digite sua senha</p>

      <!-- Requisitos -->
      <div class="req-list">
        <div class="req-item" id="req-len">
          <div class="req-dot"></div>Mínimo de 8 caracteres
        </div>
        <div class="req-item" id="req-upper">
          <div class="req-dot"></div>Letra maiúscula e número
        </div>
        <div class="req-item" id="req-special">
          <div class="req-dot"></div>Caractere especial (!@#$...)
        </div>
      </div>
    </div>

    <!-- Confirmar senha -->
    <div class="field" style="animation-delay:.37s">
      <label for="confirma">Confirmar nova senha</label>
      <div class="input-wrap">
        <input
          type="password"
          id="confirma"
          name="password_confirmation"
          placeholder="Repita a senha"
          autocomplete="new-password"
          oninput="checkMatch()"
        />
        <span class="icon">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
          </svg>
        </span>
        <button class="toggle-pw" type="button" onclick="togglePw('confirma', this)" aria-label="Mostrar senha">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7z"/>
            <circle cx="12" cy="12" r="3"/>
          </svg>
        </button>
      </div>
      <p class="match-hint" id="match-hint">—</p>
    </div>

    <!-- Botões -->
    <div class="buttons">
      <button class="btn btn-primary" type="button" id="submit-btn" onclick="handleSubmit()">
        <span id="btn-text">Redefinir senha</span>
        <div class="spinner" id="spinner"></div>
        <svg id="btn-icon" viewBox="0 0 24 24">
          <rect x="3" y="11" width="18" height="11" rx="2"/>
          <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
        </svg>
      </button>
      <a href="{{ route('login') }}" class="btn btn-ghost">
        <svg viewBox="0 0 24 24">
          <line x1="19" y1="12" x2="5" y2="12"/>
          <polyline points="12 19 5 12 12 5"/>
        </svg>
        Voltar para o login
      </a>
    </div>

  </form>  {{-- ✅ PASSO 4: fechou o form --}}

</div>

{{-- ✅ PASSO 5: rota para o JS --}}
<script>
    const resetRoute = "{{ route('password.store') }}";
</script>
<script src="{{ asset('js/novaSenha.js') }}"></script>

</body>
</html>