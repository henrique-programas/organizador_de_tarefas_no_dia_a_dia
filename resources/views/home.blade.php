@auth
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>TaskFlow</title>

  {{-- Carrega o arquivo CSS principal da aplicação via helper do Laravel --}}
  <link rel="stylesheet" href="{{ asset('css/home.css') }}">

  {{-- Importa a fonte Sora do Google Fonts com os pesos: light (300), regular (400),
       medium (500), semibold (600) e bold (700) --}}
  <link href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600;700&display=swap" rel="stylesheet"/>
</head>
<body>


<!-- ════════════════════════════════════════════
     TOPBAR
     Barra de navegação superior, fixada no topo da tela.
     Contém: logotipo do sistema, botão de notificações e avatar do usuário.
════════════════════════════════════════════ -->
<div class="topbar">

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

    <!-- Avatar do usuário exibindo as iniciais (ex: "JS" = João Silva) -->
    <div class="avatar-btn">
      {{ strtoupper(substr(Auth::user()->name,0,2)) }}
    </div>

  </div>
</div>
<!-- /TOPBAR -->


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
      <span class="nav-badge">0</span>
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
    <div class="sidebar-label">Filtros</div>

    <!-- Filtro rápido: exibe somente tarefas diárias -->
    <button class="nav-item">
      <!-- Ícone de relógio -->
      <svg viewBox="0 0 24 24">
        <circle cx="12" cy="12" r="10"/>
        <polyline points="12 6 12 12 16 14"/>
      </svg>
      Diárias
    </button>

    <!-- Filtro rápido: exibe somente tarefas semanais -->
    <button class="nav-item">
      <!-- Ícone de calendário simples -->
      <svg viewBox="0 0 24 24">
        <rect x="3" y="4" width="18" height="18" rx="2"/>
        <line x1="16" y1="2" x2="16" y2="6"/>
        <line x1="8" y1="2" x2="8" y2="6"/>
        <line x1="3" y1="10" x2="21" y2="10"/>
      </svg>
      Semanais
    </button>

    <!-- Filtro rápido: exibe somente tarefas mensais -->
    <button class="nav-item">
      <!-- Ícone de calendário com linha extra de grade -->
      <svg viewBox="0 0 24 24">
        <rect x="3" y="4" width="18" height="18" rx="2"/>
        <line x1="16" y1="2" x2="16" y2="6"/>
        <line x1="8" y1="2" x2="8" y2="6"/>
        <line x1="3" y1="10" x2="21" y2="10"/>
        <line x1="8" y1="14" x2="16" y2="14"/>
      </svg>
      Mensais
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
          <div class="stat-num">—</div>
          <div class="stat-label">Total de Tarefas</div>
        </div>
        <!-- Quantidade de tarefas já concluídas (número em verde) -->
        <div class="stat-box">
          <div class="stat-num" style="color:var(--success)">—</div>
          <div class="stat-label">Concluídas</div>
        </div>
        <!-- Quantidade de tarefas ainda pendentes (número em amarelo) -->
        <div class="stat-box">
          <div class="stat-num" style="color:var(--warn)">—</div>
          <div class="stat-label">Pendentes</div>
        </div>
        <!-- Percentual de conclusão calculado (número em roxo) -->
        <div class="stat-box">
          <div class="stat-num" style="color:#8B5CF6">—%</div>
          <div class="stat-label">Taxa de Conclusão</div>
        </div>
      </div>
      <!-- /stats-strip -->


      <!-- ── Grade de 3 cards com tarefas em destaque ── -->
      <!-- Cada card representa uma periodicidade diferente (diária, semanal, mensal) -->
      <div class="home-top">

        <!-- Card: Tarefa Diária — borda azul no topo via CSS .daily::before -->
        <div class="task-card daily">
          <div class="tc-type">Tarefa Diária</div>           <!-- Rótulo do tipo -->
          <div class="tc-name">Nome da tarefa</div>          <!-- Nome da tarefa -->
          <div class="tc-desc">Descrição da tarefa aparece aqui.</div> <!-- Descrição curta -->
          <div class="tc-footer">
            <!-- Barra de progresso: .prog-fill tem width% definido dinamicamente -->
            <div class="tc-prog">
              <div class="prog-bar">
                <div class="prog-fill"></div>
              </div>
              <div class="prog-pct">0%</div> <!-- Percentual de conclusão -->
            </div>
            <div class="tc-tag">Hoje</div>    <!-- Tag de prazo -->
          </div>
          <!-- Hora/data prevista de conclusão -->
          <div class="tc-conclusion">
            <span>Conclusão:</span><strong>—</strong>
          </div>
        </div>

        <!-- Card: Tarefa Semanal — borda verde no topo via CSS .weekly::before -->
        <div class="task-card weekly">
          <div class="tc-type">Tarefa Semanal</div>
          <div class="tc-name">Nome da tarefa</div>
          <div class="tc-desc">Descrição da tarefa aparece aqui.</div>
          <div class="tc-footer">
            <div class="tc-prog">
              <div class="prog-bar">
                <div class="prog-fill"></div>
              </div>
              <div class="prog-pct">0%</div>
            </div>
            <div class="tc-tag">Esta semana</div>
          </div>
          <div class="tc-conclusion">
            <span>Conclusão:</span><strong>—</strong>
          </div>
        </div>

        <!-- Card: Tarefa Mensal — borda amarela no topo via CSS .monthly::before -->
        <div class="task-card monthly">
          <div class="tc-type">Tarefa Mensal</div>
          <div class="tc-name">Nome da tarefa</div>
          <div class="tc-desc">Descrição da tarefa aparece aqui.</div>
          <div class="tc-footer">
            <div class="tc-prog">
              <div class="prog-bar">
                <div class="prog-fill"></div>
              </div>
              <div class="prog-pct">0%</div>
            </div>
            <div class="tc-tag">Este mês</div>
          </div>
          <div class="tc-conclusion">
            <span>Conclusão:</span><strong>—</strong>
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

          <!-- Navegação entre meses: seta anterior, título do mês e seta próximo -->
          <div class="cal-nav">
            <button class="cal-nav-btn">
              <!-- Seta para o mês anterior -->
              <svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
            </button>
            <!-- Título do mês/ano — preenchido dinamicamente via JS -->
            <span class="cal-nav-title">Mês / Ano</span>
            <button class="cal-nav-btn">
              <!-- Seta para o próximo mês -->
              <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
            </button>
          </div>

          <!-- Grade do calendário: 7 colunas (Dom → Sáb) -->
          <div class="cal-grid">

            <!-- Cabeçalhos dos dias da semana -->
            <div class="cal-h">DOM</div>
            <div class="cal-h">SEG</div>
            <div class="cal-h">TER</div>
            <div class="cal-h">QUA</div>
            <div class="cal-h">QUI</div>
            <div class="cal-h">SEX</div>
            <div class="cal-h">SÁB</div>

            <!-- Dias vazios (.off) do mês anterior para alinhar o dia 1 na coluna correta -->
            <div class="cal-d off"></div>
            <div class="cal-d off"></div>
            <div class="cal-d off"></div>
            <div class="cal-d off"></div>
            <div class="cal-d off"></div>
            <div class="cal-d off"></div>

            <!-- Dias do mês atual (1 a 31) -->
            <!-- O dia atual recebe a classe .today para destaque visual em azul -->
            <div class="cal-d">1</div>
            <div class="cal-d">2</div>
            <div class="cal-d">3</div>
            <div class="cal-d">4</div>
            <div class="cal-d">5</div>
            <div class="cal-d">6</div>
            <div class="cal-d">7</div>
            <div class="cal-d today">8</div> <!-- Dia atual destacado -->
            <div class="cal-d">9</div>
            <div class="cal-d">10</div>
            <div class="cal-d">11</div>
            <div class="cal-d">12</div>
            <div class="cal-d">13</div>
            <div class="cal-d">14</div>
            <div class="cal-d">15</div>
            <div class="cal-d">16</div>
            <div class="cal-d">17</div>
            <div class="cal-d">18</div>
            <div class="cal-d">19</div>
            <div class="cal-d">20</div>
            <div class="cal-d">21</div>
            <div class="cal-d">22</div>
            <div class="cal-d">23</div>
            <div class="cal-d">24</div>
            <div class="cal-d">25</div>
            <div class="cal-d">26</div>
            <div class="cal-d">27</div>
            <div class="cal-d">28</div>
            <div class="cal-d">29</div>
            <div class="cal-d">30</div>
            <div class="cal-d">31</div>

          </div>
          <!-- /cal-grid -->
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
            <!-- Estado vazio: visível enquanto não há atividades registradas -->
            <div class="activity-item">
              <div class="act-dot">
                <!-- Ícone de relógio representando ausência de atividade -->
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
          </div>
        </div>
        <!-- /card atividade recente -->

      </div>
      <!-- /home-bottom -->

    </div>
    <!-- /page-home -->


    <!-- ════════════════════════════════════════════
         PÁGINA: TAREFAS
         Oculta por padrão; ativada pela navegação.
         Seções: toolbar (busca + filtros), lista de pendentes,
         lista de concluídas e botões de ação.
    ════════════════════════════════════════════ -->
    <div class="page" id="page-tarefas">

      <!-- Título e subtítulo da página -->
      <div class="page-header">
        <h1>Página de Tarefas</h1>
        <p>Gerencie e acompanhe todas as suas tarefas.</p>
      </div>

      <!-- ── Barra de ferramentas: busca, filtros e botão de criar ── -->
      <div class="tasks-toolbar">

        <!-- Campo de busca com ícone de lupa decorativo posicionado via CSS -->
        <div class="search-box">
          <svg viewBox="0 0 24 24">
            <circle cx="11" cy="11" r="8"/>
            <line x1="21" y1="21" x2="16.65" y2="16.65"/>
          </svg>
          <input type="text" placeholder="Buscar tarefa..."/>
        </div>

        <!-- Chips de filtro por tipo de periodicidade -->
        <div class="filter-chip active">Todas</div>    <!-- Ativo por padrão -->
        <div class="filter-chip">Diárias</div>
        <div class="filter-chip">Semanais</div>
        <div class="filter-chip">Mensais</div>

        <!-- Botão que abre o modal de criação de nova tarefa -->
        <!-- Adiciona a classe .open ao overlay #modal via JS inline -->
        <button class="btn btn-primary" onclick="document.getElementById('modal').classList.add('open')">
          <!-- Ícone de + (adicionar) -->
          <svg viewBox="0 0 24 24">
            <line x1="12" y1="5" x2="12" y2="19"/>
            <line x1="5" y1="12" x2="19" y2="12"/>
          </svg>
          Adicionar Tarefa
        </button>

      </div>
      <!-- /tasks-toolbar -->


      <!-- ── Seção: Tarefas Pendentes ── -->
      <!-- Badge .count exibe a contagem de itens e é atualizado via JS -->
      <div class="tasks-section-title">
        Tarefas Pendentes <span class="count">0</span>
      </div>
      <!-- Estado vazio: visível quando não há tarefas pendentes cadastradas -->
      <div class="empty-state">
        <svg viewBox="0 0 24 24">
          <path d="M9 11l3 3L22 4"/>
          <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/>
        </svg>
        <p>Nenhuma tarefa pendente.<br>Clique em "Adicionar Tarefa" para começar.</p>
      </div>


      <!-- ── Seção: Tarefas Concluídas ── -->
      <!-- Badge .count.done usa cor verde para diferenciar do badge de pendentes -->
      <div class="tasks-section-title">
        Tarefas Concluídas <span class="count done">0</span>
      </div>
      <!-- Estado vazio: visível quando nenhuma tarefa foi concluída ainda -->
      <div class="empty-state">
        <svg viewBox="0 0 24 24">
          <circle cx="12" cy="12" r="10"/>
          <polyline points="12 6 12 12 16 14"/>
        </svg>
        <p>Nenhuma tarefa concluída ainda.</p>
      </div>


      <!-- ── Ações globais da página de tarefas ── -->
      <div class="tasks-actions">
        <!-- Abre o modal para criar uma nova tarefa -->
        <button class="btn btn-primary" onclick="document.getElementById('modal').classList.add('open')">
          <svg viewBox="0 0 24 24">
            <line x1="12" y1="5" x2="12" y2="19"/>
            <line x1="5" y1="12" x2="19" y2="12"/>
          </svg>
          Adicionar Tarefa
        </button>
        <!-- Marca todas as tarefas pendentes como concluídas de uma só vez -->
        <button class="btn btn-outline">
          <svg viewBox="0 0 24 24">
            <path d="M9 11l3 3L22 4"/>
            <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/>
          </svg>
          Marcar Todas
        </button>
      </div>

    </div>
    <!-- /page-tarefas -->


    <!-- ════════════════════════════════════════════
         PÁGINA: PERFIL
         Oculta por padrão; ativada pela navegação.
         Layout em 2 colunas:
           - Esquerda: dados pessoais, formulário de edição e zona de perigo
           - Direita: gráfico de desempenho, estatísticas e atividade semanal
    ════════════════════════════════════════════ -->
    <div class="page" id="page-perfil">

      <!-- Título e subtítulo da página -->
      <div class="page-header">
        <h1>Página de Perfil</h1>
        <p>Gerencie suas informações e veja seu desempenho.</p>
      </div>

      <!-- Grade de 2 colunas do perfil -->
      <div class="profile-grid">


        <!-- ── COLUNA ESQUERDA: dados pessoais e ações ── -->
        <div class="profile-left">

          <!-- Card: avatar, nome, e-mail e botões de ação rápida -->
          <div class="profile-card card">
            <!-- Círculo com iniciais do usuário — substituído por foto quando disponível -->
            <div class="profile-avatar">—</div>
            <div class="profile-name">{{ Auth::user()->name }}</div>
            <div class="profile-email">{{ Auth::user()->email }}</div>
            <!-- Botões de ação rápida do card de perfil -->
            <div class="profile-btns">
              <!-- Abre o seletor para trocar a foto de perfil -->
              <button class="btn btn-primary">
                <!-- Ícone de câmera fotográfica -->
                <svg viewBox="0 0 24 24" style="width:14px;height:14px;stroke:white;fill:none;stroke-width:2;stroke-linecap:round;stroke-linejoin:round">
                  <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/>
                  <circle cx="12" cy="13" r="4"/>
                </svg>
                Alterar Foto
              </button>
              <!-- Abre o modo de edição do nome de exibição -->
              <button class="btn btn-outline">
                <!-- Ícone de lápis/edição -->
                <svg viewBox="0 0 24 24" style="width:14px;height:14px;stroke:var(--blue-primary);fill:none;stroke-width:2;stroke-linecap:round;stroke-linejoin:round">
                  <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                </svg>
                Alterar Nome
              </button>
            </div>
          </div>
          <!-- /profile-card -->

          <!-- Card: formulário para editar as informações da conta -->
          <div class="card">
            <div class="card-title">
              <!-- Ícone de lápis -->
              <svg viewBox="0 0 24 24">
                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
              </svg>
              Editar Informações
            </div>
            <div class="edit-form">
              <!-- Campo: nome completo do usuário -->
              <div class="form-group">
                <label>Nome completo</label>
                <input type="text" placeholder="Seu nome"/>
              </div>
              <!-- Campo: endereço de e-mail -->
              <div class="form-group">
                <label>E-mail</label>
                <input type="email" placeholder="seu@email.com"/>
              </div>
              <!-- Campo: nova senha (valor oculto com type="password") -->
              <div class="form-group">
                <label>Nova senha</label>
                <input type="password" placeholder="••••••••"/>
              </div>
              <!-- Botão de submissão para salvar as alterações -->
              <button class="btn btn-primary" style="margin-top:4px">Salvar Alterações</button>
            </div>
          </div>
          <!-- /card editar informações -->

          <!-- Bloco de ações destrutivas/irreversíveis da conta -->
          <div class="danger-zone">
            <div class="danger-title">Zona de Perigo</div>
            <div class="danger-desc">Estas ações são irreversíveis. Tenha certeza antes de prosseguir.</div>
            <div style="display:flex;gap:8px;flex-wrap:wrap">
              <!-- Remove permanentemente a conta e todos os dados do usuário -->
              <button class="btn btn-danger">
                <!-- Ícone de lixeira -->
                <svg viewBox="0 0 24 24">
                  <polyline points="3 6 5 6 21 6"/>
                  <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/>
                </svg>
                Excluir Conta
              </button>
            </div>
          </div>
          <!-- /danger-zone -->

        </div>
        <!-- /profile-left -->


        <!-- ── COLUNA DIREITA: gráficos e estatísticas de desempenho ── -->
        <div class="profile-right">

          <!-- Card: gráfico de rosca (donut) com distribuição das tarefas por status -->
          <div class="chart-area">
            <div class="chart-title">Gráfico de Desempenho</div>
            <div class="chart-sub">Distribuição de tarefas por status</div>
            <!-- Wrapper com o SVG do gráfico e a legenda lado a lado -->
            <div class="donut-wrap">

              <!-- Gráfico SVG de rosca — arcos coloridos renderizados dinamicamente via JS -->
              <svg width="160" height="160" viewBox="0 0 160 160">
                <!-- Trilha de fundo cinza (círculo completo sem preenchimento) -->
                <circle cx="80" cy="80" r="60" fill="none" stroke="var(--gray-border)" stroke-width="22"/>
                <!-- Texto central: percentual geral de conclusão -->
                <text x="80" y="76" text-anchor="middle" font-family="Sora,sans-serif" font-size="18" font-weight="700" fill="var(--text-soft)">—%</text>
                <!-- Rótulo descritivo abaixo do percentual -->
                <text x="80" y="94" text-anchor="middle" font-family="Sora,sans-serif" font-size="10" fill="var(--text-soft)">conclusão</text>
              </svg>

              <!-- Legenda do gráfico de rosca -->
              <div class="donut-legend">
                <!-- Item: tarefas concluídas (ponto verde) -->
                <div class="legend-item">
                  <div class="legend-dot" style="background:var(--success)"></div>
                  <div class="legend-text">
                    <strong>Legenda</strong>
                    <span>Concluídas</span>
                  </div>
                </div>
                <!-- Item: tarefas em andamento (ponto azul) -->
                <div class="legend-item">
                  <div class="legend-dot" style="background:var(--blue-primary)"></div>
                  <div class="legend-text">
                    <strong>Legenda</strong>
                    <span>Em andamento</span>
                  </div>
                </div>
                <!-- Item: tarefas atrasadas (ponto amarelo) -->
                <div class="legend-item">
                  <div class="legend-dot" style="background:var(--warn)"></div>
                  <div class="legend-text">
                    <strong>Legenda</strong>
                    <span>Atrasadas</span>
                  </div>
                </div>
              </div>
              <!-- /donut-legend -->

            </div>
            <!-- /donut-wrap -->
          </div>
          <!-- /chart-area -->

          <!-- Card: estatísticas numéricas de desempenho em grade 2×2 -->
          <div class="card">
            <div class="card-title">
              <!-- Ícone de pulso/atividade -->
              <svg viewBox="0 0 24 24">
                <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>
              </svg>
              Estatísticas de Desempenho
            </div>
            <div class="perf-stats">
              <!-- Total de tarefas criadas no mês corrente -->
              <div class="perf-item">
                <div class="perf-num">—</div>
                <div class="perf-label">Tarefas este mês</div>
              </div>
              <!-- Quantidade concluída dentro do prazo (número em verde) -->
              <div class="perf-item">
                <div class="perf-num" style="color:var(--success)">—</div>
                <div class="perf-label">Concluídas no prazo</div>
              </div>
              <!-- Tempo médio gasto por tarefa em horas (número em amarelo) -->
              <div class="perf-item">
                <div class="perf-num" style="color:var(--warn)">—</div>
                <div class="perf-label">Tempo médio/tarefa</div>
              </div>
              <!-- Sequência atual de dias consecutivos com atividade (número em roxo) -->
              <div class="perf-item">
                <div class="perf-num" style="color:#8B5CF6">—</div>
                <div class="perf-label">Dias consecutivos</div>
              </div>
            </div>
          </div>
          <!-- /card estatísticas -->

          <!-- Card: barra de atividade dos últimos 7 dias (streak semanal) -->
          <div class="card">
            <div class="card-title">
              <!-- Ícone de calendário -->
              <svg viewBox="0 0 24 24">
                <rect x="3" y="4" width="18" height="18" rx="2"/>
                <line x1="16" y1="2" x2="16" y2="6"/>
                <line x1="8" y1="2" x2="8" y2="6"/>
                <line x1="3" y1="10" x2="21" y2="10"/>
              </svg>
              Atividade Semanal
            </div>
            <!-- Subtítulo do período exibido -->
            <div style="font-size:11px;color:var(--text-soft);margin-bottom:10px;">Últimos 7 dias</div>
            <!-- Barra de streak: cada bloco = 1 dia da semana
                 Classes aplicadas via JS: .done (ativo), .partial (parcial), sem classe (inativo) -->
            <div class="streak-bar">
              <div class="streak-d">Seg</div>
              <div class="streak-d">Ter</div>
              <div class="streak-d">Qua</div>
              <div class="streak-d">Qui</div>
              <div class="streak-d">Sex</div>
              <div class="streak-d">Sáb</div>
              <div class="streak-d">Dom</div>
            </div>
          </div>
          <!-- /card atividade semanal -->

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


<!-- ════════════════════════════════════════════
     MODAL — Nova Tarefa
     Sobrepõe a tela com fundo escuro desfocado (backdrop blur).
     Visibilidade controlada pela classe .open no elemento #modal:
       - Abrir:  document.getElementById('modal').classList.add('open')
       - Fechar: document.getElementById('modal').classList.remove('open')
     Também pode ser fechado clicando fora da janela do modal
     ou pressionando a tecla Escape (tratado no home.js).
════════════════════════════════════════════ -->
<div class="modal-overlay" id="modal">
  <div class="modal">

    <!-- Cabeçalho do modal: título + botão X de fechar -->
    <div class="modal-header">
      <h3>Nova Tarefa</h3>
      <!-- Fecha o modal removendo a classe .open do overlay -->
      <button class="modal-close" onclick="document.getElementById('modal').classList.remove('open')">
        <!-- Ícone de X (fechar) -->
        <svg viewBox="0 0 24 24">
          <line x1="18" y1="6" x2="6" y2="18"/>
          <line x1="6" y1="6" x2="18" y2="18"/>
        </svg>
      </button>
    </div>

    <!-- Corpo do formulário de criação de tarefa -->
    <div class="modal-form">

      <!-- Campo: nome/título da tarefa (obrigatório) -->
      <div class="form-group">
        <label>Nome da Tarefa</label>
        <input type="text" placeholder="Ex: Revisar relatório mensal"/>
      </div>

      <!-- Campo: descrição detalhada (textarea com resize vertical habilitado via CSS) -->
      <div class="form-group">
        <label>Descrição</label>
        <textarea placeholder="Descreva os detalhes da tarefa..."></textarea>
      </div>

      <!-- Linha com dois selects em colunas iguais -->
      <div class="modal-row">
        <!-- Select: tipo de periodicidade da tarefa -->
        <div class="form-group">
          <label>Tipo</label>
          <select>
            <option>Diária</option>
            <option>Semanal</option>
            <option>Mensal</option>
          </select>
        </div>
        <!-- Select: nível de prioridade da tarefa -->
        <div class="form-group">
          <label>Prioridade</label>
          <select>
            <option>Alta</option>
            <option>Média</option>
            <option>Baixa</option>
          </select>
        </div>
      </div>
      <!-- /modal-row -->

      <!-- Campo: data limite para conclusão da tarefa -->
      <div class="form-group">
        <label>Data de Conclusão</label>
        <input type="date"/>
      </div>

      <!-- Ações do modal: cancelar (descarta) ou criar (salva) -->
      <div class="modal-actions">
        <!-- Fecha o modal sem salvar nenhuma informação -->
        <button class="btn btn-outline" onclick="document.getElementById('modal').classList.remove('open')">
          Cancelar
        </button>
        <!-- Confirma a criação da tarefa — lógica de submit tratada no home.js -->
        <button class="btn btn-primary">
          <!-- Ícone de + -->
          <svg viewBox="0 0 24 24">
            <line x1="12" y1="5" x2="12" y2="19"/>
            <line x1="5" y1="12" x2="19" y2="12"/>
          </svg>
          Criar Tarefa
        </button>
      </div>

    </div>
    <!-- /modal-form -->

  </div>
</div>
<!-- /modal -->


{{-- Carrega o JavaScript principal via helper do Laravel.
     O arquivo home.js contém: navigate(), filtros de chip, busca em tempo real,
     toggle de tarefas (pendente/concluída), abertura/fechamento do modal
     por clique externo e tecla Escape, e demais interações da página. --}}
<script src="{{ asset('js/home.js') }}"></script>


</body>
</html>
@endauth