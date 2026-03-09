<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <title>Login</title>
        <link href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600;700&display=swap" rel="stylesheet"/>
        <link rel="stylesheet" href="{{ asset('css/login.css') }}">
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

            <p class="card-label">Bem-vindo de volta</p>
            <h1 class="card-title">Faça seu login</h1>

            @if ($errors->any())
                <div class="error">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Campo: E-mail -->
                <div class="field" style="animation-delay:.25s">
                    <label for="email">E-mail</label>
                    <div class="input-wrap">
                        <input type="email" id="email" name="email" placeholder="seuemail@exemplo.com">
                        <span class="icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="2" y="4" width="20" height="16" rx="2"/>
                                <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
                            </svg>
                        </span>
                    </div>
                </div>

                <!-- Campo: Senha com toggle de visibilidade -->
                <div class="field" style="animation-delay:.32s">
                    <label for="senha">Senha</label>
                    <div class="input-wrap">
                        <input type="password" id="senha" name="password" placeholder="Senha">
                        <span class="icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="11" width="18" height="11" rx="2"/>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                            </svg>
                        </span>
                        <button class="toggle-pw" type="button" onclick="togglePw(this)" aria-label="Mostrar senha">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7z"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Link esqueceu a senha -->
                <div class="forgot">
                    <a href="{{ route('password.request') }}">Esqueceu a senha?</a>
                </div>

                <!-- Botões: Cadastrar (outline) e Entrar (primary) -->
                <div class="buttons">
                    <a href="{{ route('register') }}" class="btn btn-outline">Cadastrar</a>
                    <button type="submit" class="btn btn-primary">Entrar →</button>
                </div>
            </form>
        </div>

        <!-- Corrigido: era "login,js" (vírgula) → "login.js" (ponto) -->
        <script src="{{ asset('js/login.js') }}"></script>
    </body>
</html>