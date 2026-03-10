@auth
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>TaskFlow</title>
  <link rel="stylesheet" href="{{ asset('css/home.css') }}">
  <link rel="stylesheet" href="{{ asset('css/home_responsive.css') }}">
  <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js'></script>
  <link href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600;700&display=swap" rel="stylesheet"/>
</head>
<body>

<!-- Container obrigatório do VLibras -->
<div vw class="enabled" id="vlibras-container" style="display:none">
  <div vw-access-button class="active"></div>
  <div vw-plugin-wrapper>
    <div class="vw-plugin-top-wrapper"></div>
  </div>
</div>


<!-- ════════════════════════════════════════════
     TOPBAR
     Barra de navegação superior, fixada no topo da tela.
     Contém: logotipo do sistema, botão de notificações e avatar do usuário.
════════════════════════════════════════════ -->
<div class="topbar">

  <!-- Botão hambúrguer — visibilidade controlada pelo CSS (só aparece no mobile) -->
  <button id="menu-toggle" class="menu-toggle">
    <svg viewBox="0 0 24 24">
      <line x1="3" y1="6" x2="21" y2="6"/>
      <line x1="3" y1="12" x2="21" y2="12"/>
      <line x1="3" y1="18" x2="21" y2="18"/>
    </svg>
  </button>

  <!-- Logotipo: ícone SVG + nome do sistema -->
  <div class="brand">
    <div class="brand-icon">
      <!-- Ícone de camadas representando o logo do TaskFlow -->
      <svg viewBox="0 0 24 24">
        <path d="M12 2L2 7l10 5 10-5-10-5z"/>
        <path d="M2 17l10 5 10-5"/>
        <path d="M2 12l10 5 10-5"/>
      </svg>
    </div>
    <span>TaskFlow</span>
  </div>

  <!-- Lado direito da topbar -->
  <div class="topbar-right">

    <!-- Botão de notificações com ponto vermelho indicando notificação não lida -->
    <div class="notif-btn">
      <!-- Ícone de sino -->
      <svg viewBox="0 0 24 24">
        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/>
        <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
      </svg>
      <!-- Indicador visual de notificação pendente -->
      <div class="notif-dot"></div>
    </div>

    <!-- Avatar do usuário — exibe foto de perfil se existir, senão as iniciais -->
    <button class="avatar-btn" id="nav-perfil" onclick="navigate('perfil')">
      @if(Auth::user()->avatar)
        <img src="{{ Storage::url(Auth::user()->avatar) }}"
             alt="{{ Auth::user()->name }}"
             style="width:100%;height:100%;object-fit:cover;border-radius:50%;display:block;" />
      @else
        {{ strtoupper(substr(Auth::user()->name,0,2)) }}
      @endif
    </button>

  </div>
</div>
<!-- /TOPBAR -->


<!-- Overlay escuro que aparece atrás da sidebar no mobile -->
<div class="sidebar-overlay" id="sidebar-overlay"></div>

<!-- ════════════════════════════════════════════
     LAYOUT PRINCIPAL
     Wrapper que organiza a sidebar e a área de conteúdo lado a lado.
════════════════════════════════════════════ -->
<div class="layout">


  <!-- ════════════════════════════════════════════
       SIDEBAR
       Menu lateral fixo com links de navegação entre páginas
       e filtros rápidos por tipo de tarefa.
  ════════════════════════════════════════════ -->
  <div class="sidebar">

    <!-- Rótulo da seção principal de navegação -->
    <div class="sidebar-label">Menu</div>

    <!-- Link: Página Inicial — ativo por padrão ao carregar -->
    <!-- O onclick chama navigate('home') para exibir #page-home -->
    <button class="nav-item active" id="nav-home" onclick="navigate('home')">
      <!-- Ícone de casa -->
      <svg viewBox="0 0 24 24">
        <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
        <polyline points="9 22 9 12 15 12 15 22"/>
      </svg>
      Página Inicial
    </button>

    <!-- Link: Página de Tarefas -->
    <!-- Badge .nav-badge exibe o número de tarefas pendentes (preenchido via JS) -->
    <button class="nav-item" id="nav-tarefas" onclick="navigate('tarefas')">
      <!-- Ícone de checkbox com check -->
      <svg viewBox="0 0 24 24">
        <path d="M9 11l3 3L22 4"/>
        <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/>
      </svg>
      Tarefas
      <!-- Contador de tarefas pendentes atualizado dinamicamente -->
      <span class="nav-badge">{{ $pendentes }}</span>
    </button>

    <!-- Link: Página de Perfil do usuário -->
    <button class="nav-item" id="nav-perfil" onclick="navigate('perfil')">
      <!-- Ícone de pessoa/usuário -->
      <svg viewBox="0 0 24 24">
        <circle cx="12" cy="8" r="4"/>
        <path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/>
      </svg>
      Perfil
    </button>

    <!-- Rótulo da seção de filtros rápidos -->
    <div class="sidebar-label">Configurações</div>

    <!-- Botão de alternar tema claro/escuro -->
    <button class="theme-toggle" id="theme-toggle">
      <svg id="theme-icon" viewBox="0 0 24 24">
        <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/>
      </svg>
      <span id="theme-label">Tema Escuro</span>
    </button>

    <!-- Botão de ativar/desativar VLibras -->
    <button class="theme-toggle" id="vlibras-toggle">
      <svg id="vlibras-icon" viewBox="0 0 24 24">
        <path d="M18 8h1a4 4 0 0 1 0 8h-1"/>
        <path d="M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"/>
        <line x1="6" y1="1" x2="6" y2="4"/>
        <line x1="10" y1="1" x2="10" y2="4"/>
        <line x1="14" y1="1" x2="14" y2="4"/>
      </svg>
      <span id="vlibras-label">VLibras</span>
    </button>

    <!-- Rodapé da sidebar: botão de logout destacado em vermelho -->
    <div class="sidebar-bottom">
      <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit" class="nav-item" style="color:#EF4444">
              Sair
          </button>
      </form>
    </div>

  </div>
  <!-- /SIDEBAR -->


  <!-- ════════════════════════════════════════════
       ÁREA DE CONTEÚDO PRINCIPAL
       Contém as três páginas do sistema: Home, Tarefas e Perfil.
       Apenas a página com a classe .active fica visível por vez.
       A alternância é feita pela função navigate() no JS.
  ════════════════════════════════════════════ -->
  <div class="main">


    <!-- ════════════════════════════════════════════
         PÁGINA: HOME — Página Inicial
         Exibida por padrão (possui .active).
         Seções: resumo estatístico, cards de tarefas destaque,
         calendário mensal e feed de atividade recente.
    ════════════════════════════════════════════ -->
    <div class="page active" id="page-home">

      <!-- Título e subtítulo da página -->
      <div class="page-header">
        <h1>Página Inicial</h1>
        <p>Bem-vindo de volta! Veja o resumo das suas tarefas.</p>
      </div>

      <!-- ── Faixa de 4 cards com estatísticas rápidas ── -->
      <div class="stats-strip">
        <!-- Total geral de tarefas cadastradas -->
        <div class="stat-box">
          <div class="stat-num">{{ $total }}</div>
          <div class="stat-label">Total de Tarefas</div>
        </div>
        <!-- Quantidade de tarefas já concluídas (número em verde) -->
        <div class="stat-box">
          <div class="stat-num" style="color:var(--success)">{{ $concluidas }}</div>
          <div class="stat-label">Concluídas</div>
        </div>
        <!-- Quantidade de tarefas ainda pendentes (número em amarelo) -->
        <div class="stat-box">
          <div class="stat-num" style="color:var(--warn)">{{ $pendentes }}</div>
          <div class="stat-label">Pendentes</div>
        </div>
        <!-- Percentual de conclusão calculado (número em roxo) -->
        <div class="stat-box">
          <div class="stat-num" style="color:#8B5CF6">{{ $taxa }}%</div>
          <div class="stat-label">Taxa de Conclusão</div>
        </div>
      </div>
      <!-- /stats-strip -->


      <!-- ── Grade de 3 cards com tarefas em destaque ── -->
      <!-- Cada card representa uma periodicidade diferente (diária, semanal, mensal) -->
      <div class="home-top">

        <!-- Card: Tarefa Diária — borda azul no topo via CSS .daily::before -->
        <div class="task-card daily">
          <div class="tc-type">Tarefa Diária</div>
          <div class="tc-name">{{ $tarefaDiaria?->title ?? 'Nenhuma tarefa' }}</div>
          <div class="tc-desc">{{ $tarefaDiaria?->description ?? 'Nenhuma tarefa diária cadastrada.' }}</div>
          <div class="tc-footer">
            <div class="tc-prog">
              <div class="prog-bar">
                <div class="prog-fill" style="width:{{ $taxaDiaria }}%"></div>
              </div>
              <div class="prog-pct">{{ $taxaDiaria }}%</div>
            </div>
            <div class="tc-tag">Hoje</div>
          </div>
          <div class="tc-conclusion">
            <span>Status:</span>
            <strong>{{ $tarefaDiaria?->completed ? 'Concluída' : 'Pendente' }}</strong>
          </div>
        </div>

        <!-- Card: Tarefa Semanal — borda verde no topo via CSS .weekly::before -->
        <div class="task-card weekly">
          <div class="tc-type">Tarefa Semanal</div>
          <div class="tc-name">{{ $tarefaSemanal?->title ?? 'Nenhuma tarefa' }}</div>
          <div class="tc-desc">{{ $tarefaSemanal?->description ?? 'Nenhuma tarefa semanal cadastrada.' }}</div>
          <div class="tc-footer">
            <div class="tc-prog">
              <div class="prog-bar">
                <div class="prog-fill" style="width:{{ $taxaSemanal }}%"></div>
              </div>
              <div class="prog-pct">{{ $taxaSemanal }}%</div>
            </div>
            <div class="tc-tag">Esta semana</div>
          </div>
          <div class="tc-conclusion">
            <span>Status:</span>
            <strong>{{ $tarefaSemanal?->completed ? 'Concluída' : 'Pendente' }}</strong>
          </div>
        </div>

        <!-- Card: Tarefa Mensal — borda amarela no topo via CSS .monthly::before -->
        <div class="task-card monthly">
          <div class="tc-type">Tarefa Mensal</div>
          <div class="tc-name">{{ $tarefaMensal?->title ?? 'Nenhuma tarefa' }}</div>
          <div class="tc-desc">{{ $tarefaMensal?->description ?? 'Nenhuma tarefa mensal cadastrada.' }}</div>
          <div class="tc-footer">
            <div class="tc-prog">
              <div class="prog-bar">
                <div class="prog-fill" style="width:{{ $taxaMensal }}%"></div>
              </div>
              <div class="prog-pct">{{ $taxaMensal }}%</div>
            </div>
            <div class="tc-tag">Este mês</div>
          </div>
          <div class="tc-conclusion">
            <span>Status:</span>
            <strong>{{ $tarefaMensal?->completed ? 'Concluída' : 'Pendente' }}</strong>
          </div>
        </div>

      </div>
      <!-- /home-top -->


      <!-- ── Linha inferior: Calendário + Atividade Recente em 2 colunas ── -->
      <div class="home-bottom">

        <!-- Card: Calendário mensal de tarefas -->
        <div class="card">
          <div class="card-title">
            <!-- Ícone de calendário -->
            <svg viewBox="0 0 24 24">
              <rect x="3" y="4" width="18" height="18" rx="2"/>
              <line x1="16" y1="2" x2="16" y2="6"/>
              <line x1="8" y1="2" x2="8" y2="6"/>
              <line x1="3" y1="10" x2="21" y2="10"/>
            </svg>
            Calendário de Tarefas
          </div>
          <div id="calendar"></div>
        </div>
        <!-- /card calendário -->

        <!-- Card: Feed de atividade recente do usuário -->
        <div class="card">
          <div class="card-title">
            <!-- Ícone de pulso/atividade -->
            <svg viewBox="0 0 24 24">
              <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>
            </svg>
            Atividade Recente
          </div>
          <!-- Lista de eventos/ações recentes — itens inseridos dinamicamente via JS -->
          <div class="activity-list">
            @forelse($atividadesRecentes as $ativ)
              <div class="activity-item">
                <div class="act-dot" style="background:{{ $ativ['cor'] }}1a;color:{{ $ativ['cor'] }}">
                  <svg viewBox="0 0 24 24">
                    <path d="M9 11l3 3L22 4"/>
                    <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/>
                  </svg>
                </div>
                <div class="act-text">
                  <strong>{{ $ativ['titulo'] }}</strong>
                  <span>{{ $ativ['acao'] }}</span>
                </div>
                <div class="act-time">{{ $ativ['tempo'] }}</div>
              </div>
            @empty
              <div class="activity-item">
                <div class="act-dot">
                  <svg viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10"/>
                    <polyline points="12 6 12 12 16 14"/>
                  </svg>
                </div>
                <div class="act-text">
                  <strong>Sem atividades ainda</strong>
                  <span>As atividades aparecerão aqui</span>
                </div>
                <div class="act-time">—</div>
              </div>
            @endforelse
          </div>
        </div>
        <!-- /card atividade recente -->

      </div>
      <!-- /home-bottom -->

    </div>
    <!-- /page-home -->


    <!-- ════════════════════════════════════════════
         PÁGINA: TAREFAS
    ════════════════════════════════════════════ -->
    <div class="page" id="page-tarefas">

      <div class="page-header">
        <h1>Página de Tarefas</h1>
        <p>Gerencie e acompanhe todas as suas tarefas.</p>
      </div>

      @if(session('success'))
        <div style="background:#D1FAE5;color:#065F46;padding:12px 16px;border-radius:10px;margin-bottom:16px;font-size:13px;">
          {{ session('success') }}
        </div>
      @endif

      <!-- ── Barra de ferramentas: busca, filtros e botão de criar ── -->
      <div class="tasks-toolbar">

        <div class="search-box">
          <svg viewBox="0 0 24 24">
            <circle cx="11" cy="11" r="8"/>
            <line x1="21" y1="21" x2="16.65" y2="16.65"/>
          </svg>
          <input type="text" placeholder="Buscar tarefa..."/>
        </div>

        <!-- Chips de filtro em wrapper com scroll horizontal no mobile -->
        <div class="filter-chips-row">
          <div class="filter-chip active">Todas</div>
          <div class="filter-chip">Diárias</div>
          <div class="filter-chip">Semanais</div>
          <div class="filter-chip">Mensais</div>
        </div>

        <button type="button" class="btn btn-primary" onclick="document.getElementById('modal').classList.add('open')">
          <svg viewBox="0 0 24 24">
            <line x1="12" y1="5" x2="12" y2="19"/>
            <line x1="5" y1="12" x2="19" y2="12"/>
          </svg>
          Adicionar Tarefa
        </button>

      </div>
      <!-- /tasks-toolbar -->


      <!-- ── Seção: Tarefas Pendentes ── -->
      <div class="tasks-section-title">
        Tarefas Pendentes <span class="count">{{ $pendentes }}</span>
      </div>
      @if($tasks->where('completed', false)->count() > 0)
        <div class="tasks-grid">
          @foreach($tasks->where('completed', false) as $task)
            <div class="task-item priority-{{ $task->priority }}" data-type="{{ $task->type }}">
              <div class="ti-top">
                <div class="ti-name">{{ $task->title }}</div>
                <form action="{{ route('tasks.update', $task) }}" method="POST">
                  @csrf @method('PUT')
                  <input type="hidden" name="title" value="{{ $task->title }}">
                  <input type="hidden" name="description" value="{{ $task->description }}">
                  <input type="hidden" name="completed" value="1">
                  <input type="hidden" name="type" value="{{ $task->type }}">
                  <input type="hidden" name="priority" value="{{ $task->priority }}">
                  <button type="submit" class="ti-check" title="Marcar como concluída">
                    <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                  </button>
                </form>
              </div>
              <div class="ti-desc">{{ $task->description ?? 'Sem descrição' }}</div>
              <div style="display:flex;gap:6px;margin-bottom:8px;">
                @if($task->priority === 'alta')
                  <span style="font-size:10px;font-weight:600;padding:2px 8px;border-radius:20px;background:#FEE2E2;color:#DC2626;">Alta</span>
                @elseif($task->priority === 'media')
                  <span style="font-size:10px;font-weight:600;padding:2px 8px;border-radius:20px;background:#FEF3C7;color:#D97706;">Média</span>
                @else
                  <span style="font-size:10px;font-weight:600;padding:2px 8px;border-radius:20px;background:#D1FAE5;color:#059669;">Baixa</span>
                @endif
              </div>
              <div class="ti-footer">
                <span class="ti-due">{{ $task->created_at->format('d/m/Y') }}</span>
                <div style="display:flex;gap:6px">
                  <button type="button"
                    onclick="openEdit({{ $task->id }}, '{{ addslashes($task->title) }}', '{{ addslashes($task->description) }}', {{ $task->completed ? 'true' : 'false' }}, '{{ $task->type }}', '{{ $task->priority }}', '{{ $task->due_date }}')"
                    style="font-size:11px;color:var(--blue-primary);background:none;border:none;cursor:pointer;">
                    Editar
                  </button>
                  <form action="{{ route('tasks.destroy', $task) }}" method="POST">
                    @csrf @method('DELETE')
                    <button type="submit" style="font-size:11px;color:#EF4444;background:none;border:none;cursor:pointer;">Excluir</button>
                  </form>
                </div>
              </div>
            </div>
          @endforeach
        </div>
      @else
        <div class="empty-state">
          <svg viewBox="0 0 24 24"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
          <p>Nenhuma tarefa pendente.<br>Clique em "Adicionar Tarefa" para começar.</p>
        </div>
      @endif


      <!-- ── Seção: Tarefas Concluídas ── -->
      <div class="tasks-section-title">
        Tarefas Concluídas <span class="count done">{{ $concluidas }}</span>
      </div>
      @if($tasks->where('completed', true)->count() > 0)
        <div class="tasks-grid">
          @foreach($tasks->where('completed', true) as $task)
            <div class="task-item done priority-{{ $task->priority }}" data-type="{{ $task->type }}">
              <div class="ti-top">
                <div class="ti-name">{{ $task->title }}</div>
                <span style="font-size:10px;font-weight:600;padding:2px 8px;border-radius:20px;background:var(--blue-xlight);color:var(--blue-primary);">
                  {{ ucfirst($task->type) }}
                </span>
                <form action="{{ route('tasks.update', $task) }}" method="POST">
                  @csrf @method('PUT')
                  <input type="hidden" name="title" value="{{ $task->title }}">
                  <input type="hidden" name="description" value="{{ $task->description }}">
                  <input type="hidden" name="type" value="{{ $task->type }}">
                  <input type="hidden" name="priority" value="{{ $task->priority }}">
                  <button type="submit" class="ti-check checked" title="Desmarcar tarefa">
                    <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                  </button>
                </form>
              </div>
              <div class="ti-desc">{{ $task->description ?? 'Sem descrição' }}</div>
              <div style="display:flex;gap:6px;margin-bottom:8px;">
                <span style="font-size:10px;font-weight:600;padding:2px 8px;border-radius:20px;background:var(--blue-xlight);color:var(--blue-primary);">
                  {{ ucfirst($task->type) }}
                </span>
                @if($task->priority === 'alta')
                  <span style="font-size:10px;font-weight:600;padding:2px 8px;border-radius:20px;background:#FEE2E2;color:#DC2626;">Alta</span>
                @elseif($task->priority === 'media')
                  <span style="font-size:10px;font-weight:600;padding:2px 8px;border-radius:20px;background:#FEF3C7;color:#D97706;">Média</span>
                @else
                  <span style="font-size:10px;font-weight:600;padding:2px 8px;border-radius:20px;background:#D1FAE5;color:#059669;">Baixa</span>
                @endif
              </div>
              <div class="ti-footer">
                <span class="ti-due">{{ $task->created_at->format('d/m/Y') }}</span>
                <form action="{{ route('tasks.destroy', $task) }}" method="POST">
                  @csrf @method('DELETE')
                  <button type="submit" style="font-size:11px;color:#EF4444;background:none;border:none;cursor:pointer;">Excluir</button>
                </form>
              </div>
            </div>
          @endforeach
        </div>
      @else
        <div class="empty-state">
          <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
          <p>Nenhuma tarefa concluída ainda.</p>
        </div>
      @endif


      <!-- ── Ações globais da página de tarefas ── -->
      <div class="tasks-actions">
        <button class="btn btn-primary" onclick="document.getElementById('modal').classList.add('open')">
          <svg viewBox="0 0 24 24">
            <line x1="12" y1="5" x2="12" y2="19"/>
            <line x1="5" y1="12" x2="19" y2="12"/>
          </svg>
          Adicionar Tarefa
        </button>
        <form method="POST" action="{{ route('tasks.completeAll') }}">
          @csrf
          <button type="submit" class="btn btn-outline">
            <svg viewBox="0 0 24 24">
              <path d="M9 11l3 3L22 4"/>
              <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/>
            </svg>
            Marcar Todas
          </button>
        </form>
        <form method="POST" action="{{ route('tasks.destroyAll') }}" onsubmit="return confirm('Tem certeza? Isso apagará todas as tarefas!')">
          @csrf @method('DELETE')
          <button type="submit" class="btn btn-danger">
            <svg viewBox="0 0 24 24">
              <polyline points="3 6 5 6 21 6"/>
              <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/>
            </svg>
            Excluir Todas
          </button>
        </form>
      </div>

    </div>
    <!-- /page-tarefas -->


    <!-- ════════════════════════════════════════════
         PÁGINA: PERFIL
    ════════════════════════════════════════════ -->
    <div class="page" id="page-perfil">

      @if($errors->any())
        <div class="profile-status" style="background:#FEE2E2;color:#DC2626;padding:12px 16px;border-radius:10px;margin-bottom:16px;font-size:13px;">
          @foreach($errors->all() as $error)
            <div>{{ $error }}</div>
          @endforeach
        </div>
      @endif

      @if(session('status') === 'profile-updated')
        <div class="profile-status" style="background:#D1FAE5;color:#065F46;padding:12px 16px;border-radius:10px;margin-bottom:16px;font-size:13px;">
          Perfil atualizado com sucesso!
        </div>
      @endif

      @if(session('status') === 'password-updated')
        <div class="profile-status" style="background:#D1FAE5;color:#065F46;padding:12px 16px;border-radius:10px;margin-bottom:16px;font-size:13px;">
          Senha alterada com sucesso!
        </div>
      @endif

      <div class="page-header">
        <h1>Página de Perfil</h1>
        <p>Gerencie suas informações e veja seu desempenho.</p>
      </div>

      <div class="profile-grid">

        <!-- ── COLUNA ESQUERDA ── -->
        <div class="profile-left">

          <div class="profile-card card">
            <div class="profile-avatar">
              @if(Auth::user()->avatar)
                <img src="{{ Storage::url(Auth::user()->avatar) }}"
                     style="width:100%;height:100%;object-fit:cover;border-radius:50%;" />
              @else
                {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
              @endif
            </div>
            <div class="profile-name">{{ Auth::user()->name }}</div>
            <div class="profile-email">{{ Auth::user()->email }}</div>
            <div class="profile-btns">
              <label for="avatar-input" class="btn btn-primary" style="cursor:pointer;">
                <svg viewBox="0 0 24 24" style="width:14px;height:14px;stroke:white;fill:none;stroke-width:2;stroke-linecap:round;stroke-linejoin:round">
                  <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/>
                  <circle cx="12" cy="13" r="4"/>
                </svg>
                Alterar Foto
              </label>
              <input type="file" id="avatar-input" name="avatar" accept="image/*" style="display:none;"
                onchange="document.getElementById('form-avatar').submit()"/>
              <form id="form-avatar" method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" style="display:none;">
                @csrf @method('PATCH')
                <input type="hidden" name="name" value="{{ Auth::user()->name }}">
                <input type="hidden" name="email" value="{{ Auth::user()->email }}">
                <input type="file" name="avatar" id="avatar-file-hidden"/>
              </form>
            </div>
          </div>

          <div class="card">
            <div class="card-title">
              <svg viewBox="0 0 24 24">
                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
              </svg>
              Editar Informações
            </div>
            <div class="edit-form">
              <form method="POST" action="{{ route('profile.update') }}">
                @csrf @method('PATCH')
                <div class="form-group">
                  <label>Nome completo</label>
                  <input type="text" name="name" value="{{ Auth::user()->name }}" required/>
                </div>
                <div class="form-group">
                  <label>E-mail</label>
                  <input type="email" name="email" value="{{ Auth::user()->email }}" required/>
                </div>
                <button type="submit" class="btn btn-primary" style="margin-top:4px">Salvar Alterações</button>
              </form>

              <form method="POST" action="{{ route('password.update') }}" style="margin-top:16px">
                @csrf @method('PUT')
                <div class="form-group">
                  <label>Senha Atual</label>
                  <input type="password" name="current_password" placeholder="••••••••"/>
                </div>
                <div class="form-group">
                  <label>Nova Senha</label>
                  <input type="password" name="password" placeholder="••••••••"/>
                </div>
                <div class="form-group">
                  <label>Confirmar Nova Senha</label>
                  <input type="password" name="password_confirmation" placeholder="••••••••"/>
                </div>
                <button type="submit" class="btn btn-primary" style="margin-top:4px">Alterar Senha</button>
              </form>
            </div>
          </div>

          <div class="danger-zone">
            <div class="danger-title">Zona de Perigo</div>
            <div class="danger-desc">Estas ações são irreversíveis. Tenha certeza antes de prosseguir.</div>
            <form method="POST" action="{{ route('profile.destroy') }}" onsubmit="return confirm('Tem certeza? Sua conta e todos os dados serão apagados permanentemente!')">
              @csrf @method('DELETE')
              <div class="form-group" style="margin-bottom:12px">
                <label>Confirme sua senha para excluir</label>
                <input type="password" name="password" placeholder="••••••••" required/>
              </div>
              <button type="submit" class="btn btn-danger">
                <svg viewBox="0 0 24 24">
                  <polyline points="3 6 5 6 21 6"/>
                  <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/>
                </svg>
                Excluir Conta
              </button>
            </form>
          </div>

        </div>
        <!-- /profile-left -->


        <!-- ── COLUNA DIREITA ── -->
        <div class="profile-right">

          <div class="chart-area">
            <div class="chart-title">Gráfico de Desempenho</div>
            <div class="chart-sub">Distribuição de tarefas por status</div>
            <div class="donut-wrap">
              <svg width="160" height="160" viewBox="0 0 160 160">
                @if($total > 0)
                  <circle cx="80" cy="80" r="60" fill="none"
                    stroke="#3B82F6"
                    stroke-width="22"
                    stroke-dasharray="376.99 0"/>
                  <circle cx="80" cy="80" r="60" fill="none"
                    stroke="#10B981"
                    stroke-width="22"
                    stroke-dasharray="{{ round(($concluidas / $total) * 376.99) }} 376.99"
                    transform="rotate(-90 80 80)"/>
                @else
                  <circle cx="80" cy="80" r="60" fill="none" stroke="var(--gray-border)" stroke-width="22"/>
                @endif
                <text x="80" y="76" text-anchor="middle" font-family="Sora,sans-serif" font-size="18" font-weight="700" fill="var(--text-soft)">{{ $taxa }}%</text>
                <text x="80" y="94" text-anchor="middle" font-family="Sora,sans-serif" font-size="10" fill="var(--text-soft)">conclusão</text>
              </svg>
              <div class="donut-legend">
                <div class="legend-item">
                  <div class="legend-dot" style="background:var(--success)"></div>
                  <div class="legend-text">
                    <strong>{{ $concluidas }}</strong>
                    <span>Concluídas</span>
                  </div>
                </div>
                <div class="legend-item">
                  <div class="legend-dot" style="background:var(--blue-primary)"></div>
                  <div class="legend-text">
                    <strong>{{ $pendentes }}</strong>
                    <span>Pendentes</span>
                  </div>
                </div>
                <div class="legend-item">
                  <div class="legend-dot" style="background:var(--warn)"></div>
                  <div class="legend-text">
                    <strong>{{ $total }}</strong>
                    <span>Total</span>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="card">
            <div class="card-title">
              <svg viewBox="0 0 24 24">
                <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>
              </svg>
              Estatísticas de Desempenho
            </div>
            <div class="perf-stats">
              <div class="perf-item">
                <div class="perf-num">{{ $tarefasEsteMes }}</div>
                <div class="perf-label">Tarefas este mês</div>
              </div>
              <div class="perf-item">
                <div class="perf-num" style="color:var(--success)">{{ $concluidasNoPrazo }}</div>
                <div class="perf-label">Concluídas no prazo</div>
              </div>
              <div class="perf-item">
                <div class="perf-num" style="color:#8B5CF6">{{ $streak }}</div>
                <div class="perf-label">Dias consecutivos</div>
              </div>
            </div>
          </div>

          <div class="card">
            <div class="card-title">
              <svg viewBox="0 0 24 24">
                <rect x="3" y="4" width="18" height="18" rx="2"/>
                <line x1="16" y1="2" x2="16" y2="6"/>
                <line x1="8" y1="2" x2="8" y2="6"/>
                <line x1="3" y1="10" x2="21" y2="10"/>
              </svg>
              Atividade Semanal
            </div>
            <div style="font-size:11px;color:var(--text-soft);margin-bottom:10px;">Últimos 7 dias</div>
            <div class="streak-bar">
              @foreach($atividadeSemanal as $dia)
                <div class="streak-d {{ $dia['status'] === 'completo' ? 'done' : ($dia['status'] === 'parcial' ? 'partial' : '') }}">
                  {{ $dia['dia'] }}
                </div>
              @endforeach
            </div>
          </div>

        </div>
        <!-- /profile-right -->

      </div>
      <!-- /profile-grid -->

    </div>
    <!-- /page-perfil -->


  </div>
  <!-- /main -->

</div>
<!-- /layout -->


<!-- ════ MODAL — Nova Tarefa ════ -->
<div class="modal-overlay" id="modal">
  <div class="modal">
    <div class="modal-header">
      <h3>Nova Tarefa</h3>
      <button class="modal-close" onclick="document.getElementById('modal').classList.remove('open')">
        <svg viewBox="0 0 24 24">
          <line x1="18" y1="6" x2="6" y2="18"/>
          <line x1="6" y1="6" x2="18" y2="18"/>
        </svg>
      </button>
    </div>
    <form method="POST" action="{{ route('tasks.store') }}" class="modal-form">
      @csrf
      <div class="form-group">
        <label>Nome da Tarefa</label>
        <input type="text" name="title" placeholder="Ex: Revisar relatório mensal" required/>
      </div>
      <div class="form-group">
        <label>Descrição</label>
        <textarea name="description" placeholder="Descreva os detalhes da tarefa..."></textarea>
      </div>
      <div class="modal-row">
        <div class="form-group">
          <label>Tipo</label>
          <select name="type" id="create-type">
            <option value="diaria">Diária</option>
            <option value="semanal">Semanal</option>
            <option value="mensal">Mensal</option>
          </select>
        </div>
        <div class="form-group">
          <label>Prioridade</label>
          <select name="priority" id="create-priority">
            <option value="alta">Alta</option>
            <option value="media">Média</option>
            <option value="baixa">Baixa</option>
          </select>
        </div>
      </div>
      <div class="form-group">
        <label>Data de Conclusão</label>
        <input type="date" name="due_date"/>
      </div>
      <div class="modal-actions">
        <button type="button" class="btn btn-outline" onclick="document.getElementById('modal').classList.remove('open')">
          Cancelar
        </button>
        <button type="submit" class="btn btn-primary">
          <svg viewBox="0 0 24 24">
            <line x1="12" y1="5" x2="12" y2="19"/>
            <line x1="5" y1="12" x2="19" y2="12"/>
          </svg>
          Criar Tarefa
        </button>
      </div>
    </form>
  </div>
</div>

<!-- ════ MODAL — Editar Tarefa ════ -->
<div class="modal-overlay" id="modal-edit">
  <div class="modal">
    <div class="modal-header">
      <h3>Editar Tarefa</h3>
      <button type="button" class="modal-close" onclick="document.getElementById('modal-edit').classList.remove('open')">
        <svg viewBox="0 0 24 24">
          <line x1="18" y1="6" x2="6" y2="18"/>
          <line x1="6" y1="6" x2="18" y2="18"/>
        </svg>
      </button>
    </div>
    <form method="POST" id="form-edit" class="modal-form">
      @csrf @method('PUT')
      <div class="form-group">
        <label>Nome da Tarefa</label>
        <input type="text" name="title" id="edit-title" required/>
      </div>
      <div class="form-group">
        <label>Descrição</label>
        <textarea name="description" id="edit-description"></textarea>
      </div>
      <div class="form-group">
        <label>Tipo</label>
        <select name="type" id="edit-type">
          <option value="diaria">Diária</option>
          <option value="semanal">Semanal</option>
          <option value="mensal">Mensal</option>
        </select>
      </div>
      <div class="form-group">
        <label>Prioridade</label>
        <select name="priority" id="edit-priority">
          <option value="alta">Alta</option>
          <option value="media">Média</option>
          <option value="baixa">Baixa</option>
        </select>
      </div>
      <div class="form-group">
        <label>Data de Conclusão</label>
        <input type="date" name="due_date" id="edit-due_date"/>
      </div>
      <div class="form-group" style="flex-direction:row;align-items:center;gap:8px;">
        <input type="checkbox" name="completed" id="edit-completed">
        <label for="edit-completed" style="text-transform:none;font-size:13px;">Marcar como concluída</label>
      </div>
      <div class="modal-actions">
        <button type="button" class="btn btn-outline" onclick="document.getElementById('modal-edit').classList.remove('open')">Cancelar</button>
        <button type="submit" class="btn btn-primary">
          <svg viewBox="0 0 24 24">
            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
          </svg>
          Salvar
        </button>
      </div>
    </form>
  </div>
</div>

<script src="{{ asset('js/home.js') }}"></script>

</body>
</html>
@endauth