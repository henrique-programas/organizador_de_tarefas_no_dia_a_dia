<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Recuperar Senha — TaskFlow</title>
  <link href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600;700&display=swap" rel="stylesheet"/>
  <link rel="stylesheet" href="{{ asset('css/recuperacao.css') }}">
</head>
<body>

<div class="card">

  <!-- Barra de progresso visual no envio -->
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

  <p class="card-label">Recuperação de acesso</p>
  <h1 class="card-title">Esqueceu a senha?</h1>
  <p class="card-desc">
    Sem problemas. Digite seu e-mail e enviaremos<br>
    um link para redefinir sua senha.
  </p>

  <!-- Estado de sucesso (oculto até o envio) -->
  <div class="success-state" id="success-state">
    <div class="success-icon">
      <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
    </div>
    <p class="success-msg">
      <strong>E-mail enviado!</strong>
      Verifique sua caixa de entrada e siga as instruções para redefinir sua senha. Não esqueça de checar o spam.
    </p>
  </div>

  <!-- Formulário (visível por padrão) -->
  <div class="form-body" id="form-body">

    <!-- ✅ MUDANÇA 1: adicionado style="display:none;" -->
    <div id="error-box" class="error" style="display:none;">
      @error('email')
          {{ $message }}
      @enderror
    </div>

    <!-- ✅ MUDANÇA 2 e 3: form fechado antes do </div> do form-body -->
    <form id="reset-form" method="POST" action="{{ route('password.email') }}">
      @csrf
      <div class="field">
        <label for="email">Endereço de e-mail</label>
        <div class="input-wrap">
          <input
            type="email"
            id="email"
            name="email"
            placeholder="seuemail@exemplo.com"
            autocomplete="email"
            required
          />
          <span class="icon">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <rect x="2" y="4" width="20" height="16" rx="2"/>
              <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
            </svg>
          </span>
        </div>
        <p class="field-hint">Você receberá um link válido por 60 minutos.</p>
      </div>

      <div class="buttons">
        <button type="button" class="btn btn-primary" id="submit-btn">
          <span id="btn-text">Enviar link de recuperação</span>
          <div class="spinner" id="spinner"></div>
          <svg id="btn-icon" viewBox="0 0 24 24">
            <line x1="5" y1="12" x2="19" y2="12"/>
            <polyline points="12 5 19 12 12 19"/>
          </svg>
        </button>

        <div class="divider">
          <div class="divider-line"></div>
          <span class="divider-text">ou</span>
          <div class="divider-line"></div>
        </div>

        <a href="{{ route('login') }}" class="btn btn-ghost">Voltar para o login</a>
      </div>

    </form> 

  </div>

</div> 

<script>
    const resetRoute = "{{ route('password.email') }}";
</script>
<script src="{{ asset('js/recuperacao.js') }}"></script>

</body>
</html>