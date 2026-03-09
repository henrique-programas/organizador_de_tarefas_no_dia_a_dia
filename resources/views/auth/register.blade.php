<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Cadastro</title>
  <link href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600;700&display=swap" rel="stylesheet"/>
  <link rel="stylesheet" href="{{ asset('css/cadastro.css') }}">
</head>
<body>

<div class="card">

  <div class="logo">
    <div class="logo-circle">
      <svg viewBox="0 0 24 24">
        <path d="M12 2L2 7l10 5 10-5-10-5z"/>
        <path d="M2 17l10 5 10-5"/>
        <path d="M2 12l10 5 10-5"/>
      </svg>
    </div>
  </div>

  <p class="card-label">Crie sua conta</p>
  <h1 class="card-title">Cadastre-se gratuitamente</h1>

  @if ($errors->any())
    <div class="error">
      {{ $errors->first() }}
    </div>
  @endif

  <form action="{{ route('register') }}" method="post">
    @csrf

    <!-- Nome e E-mail lado a lado -->
    <div class="row-2">

      <!-- Campo: Nome -->
      <div class="field" style="animation-delay:.25s">
        <label for="nome">Nome</label>
        <div class="input-wrap">
          <input type="text" name="name" id="nome" placeholder="João" autocomplete="given-name" required/>
          <span class="icon">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <circle cx="12" cy="8" r="4"/>
              <path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/>
            </svg>
          </span>
        </div>
      </div>

      <!-- Campo: E-mail -->
      <div class="field" style="animation-delay:.33s">
        <label for="email">E-mail</label>
        <div class="input-wrap">
          <input type="email" name="email" id="email" placeholder="seuemail@exemplo.com" autocomplete="email" required/>
          <span class="icon">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <rect x="2" y="4" width="20" height="16" rx="2"/>
              <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
            </svg>
          </span>
        </div>
      </div>

    </div>
    <!-- /row-2 -->

    <!-- Campo: Senha com indicador de força -->
    <div class="field" style="animation-delay:.37s">
      <label for="senha">Senha</label>
      <div class="input-wrap">
        <input type="password" name="password" id="senha" placeholder="Mín. 8 caracteres" autocomplete="new-password" oninput="checkStrength(this.value)" required/>
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
      <div class="pw-strength">
        <div class="pw-bar" id="bar1"></div>
        <div class="pw-bar" id="bar2"></div>
        <div class="pw-bar" id="bar3"></div>
      </div>
      <p class="pw-hint" id="pw-hint">Digite sua senha</p>
    </div>

    <!-- Campo: Confirmar Senha -->
    <div class="field" style="animation-delay:.41s">
      <label for="confirma">Confirmar senha</label>
      <div class="input-wrap">
        <input type="password" name="password_confirmation" id="confirma" placeholder="Repita a senha" autocomplete="new-password" required/>
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
    </div>

    <!-- Botões: Já tenho conta (outline) e Cadastrar (primary) -->
    <div class="buttons">
      <button type="button" class="btn btn-outline" onclick="window.location.href='/login'">Já tenho conta</button>
      <button type="submit" class="btn btn-primary">Cadastrar →</button>
    </div>

  </form>

</div>

<script src="{{ asset('js/cadastro.js') }}"></script>
</body>
</html>