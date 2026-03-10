function navigate(p){
  document.querySelectorAll('.page').forEach(x=>x.classList.remove('active'));
  document.querySelectorAll('.nav-item').forEach(x=>x.classList.remove('active'));
  document.getElementById('page-'+p).classList.add('active');
  const n=document.getElementById('nav-'+p);
  if(n)n.classList.add('active');
}
document.getElementById('modal').addEventListener('click',function(e){if(e.target===this)this.classList.remove('open');});
document.addEventListener('keydown',e=>{if(e.key==='Escape')document.getElementById('modal').classList.remove('open');});

function openEdit(id, title, description, completed, type, priority, dueDate) {
  document.getElementById('edit-title').value = title;
  document.getElementById('edit-type').value = type;
  document.getElementById('edit-description').value = description;
  document.getElementById('edit-completed').checked = completed;
  document.getElementById('edit-priority').value = priority;
  document.getElementById('edit-due_date').value = dueDate ?? '';
  document.getElementById('form-edit').action = '/tasks/' + id;
  document.getElementById('modal-edit').classList.add('open');
}

document.getElementById('modal-edit').addEventListener('click', function(e) {
  if (e.target === this) this.classList.remove('open');
});

// Filtro por chip de tipo
document.querySelectorAll('.filter-chip').forEach(chip => {
  chip.addEventListener('click', function() {
    // Remove active de todos os chips
    document.querySelectorAll('.filter-chip').forEach(c => c.classList.remove('active'));
    // Adiciona active no chip clicado
    this.classList.add('active');

    const text = this.textContent.trim().toLowerCase();
    const filter = text === 'diárias' ? 'diaria' : text === 'semanais' ? 'semanal' : text === 'mensais' ? 'mensal' : 'todas';

    // Mostra ou esconde cada tarefa baseado no tipo
    document.querySelectorAll('.task-item').forEach(item => {
      if (filter === 'todas') {
        item.style.display = '';
      } else {
        const type = item.dataset.type;
        item.style.display = (type === filter) ? '' : 'none';
      }
    });
  });
});

// Busca em tempo real por nome de tarefa
document.querySelector('.search-box input').addEventListener('input', function() {
  const search = this.value.trim().toLowerCase();

  document.querySelectorAll('.task-item').forEach(item => {
    const name = item.querySelector('.ti-name').textContent.toLowerCase();
    item.style.display = name.includes(search) ? '' : 'none';
  });
});

document.addEventListener('DOMContentLoaded', function() {
    const hasProfileStatus = document.querySelector('#page-perfil .profile-status');
    if (hasProfileStatus) {
        navigate('perfil');
    }
});

document.addEventListener('DOMContentLoaded', function () {
    var calendar = new FullCalendar.Calendar(document.getElementById('calendar'), {
        initialView: 'dayGridMonth',
        locale: 'pt-br',
        events: '/tasks/calendar-events',
        eventClick: function(info) {
            alert('Tarefa: ' + info.event.title);
        }
    });
    calendar.render();
});

document.getElementById('avatar-input').addEventListener('change', function() {
    const dt = new DataTransfer();
    dt.items.add(this.files[0]);
    document.getElementById('avatar-file-hidden').files = dt.files;
    document.getElementById('form-avatar').submit();
});

// Menu hambúrguer mobile
const menuToggle = document.getElementById('menu-toggle');
const sidebar    = document.querySelector('.sidebar');
const overlay    = document.getElementById('sidebar-overlay');

function toggleMenu() {
  sidebar.classList.toggle('open');
  overlay.classList.toggle('open');
}

if (menuToggle) menuToggle.addEventListener('click', toggleMenu);
if (overlay)    overlay.addEventListener('click', toggleMenu);

// ── Tema escuro ──
const themeToggle = document.getElementById('theme-toggle');
const themeIcon   = document.getElementById('theme-icon');
const themeLabel  = document.getElementById('theme-label');

const moonSVG = '<path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/>';
const sunSVG  = '<circle cx="12" cy="12" r="5"/><line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/><line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/>';

function applyTheme(dark) {
  if (dark) {
    document.body.classList.add('dark');
    themeIcon.innerHTML = sunSVG;
    themeLabel.textContent = 'Tema Claro';
  } else {
    document.body.classList.remove('dark');
    themeIcon.innerHTML = moonSVG;
    themeLabel.textContent = 'Tema Escuro';
  }
}

// Carregar preferência salva
applyTheme(localStorage.getItem('theme') === 'dark');

themeToggle.addEventListener('click', function() {
  const isDark = document.body.classList.contains('dark');
  localStorage.setItem('theme', isDark ? 'light' : 'dark');
  applyTheme(!isDark);
});
// ── VLibras ──
const vlibrasToggle    = document.getElementById('vlibras-toggle');
const vlibrasLabel     = document.getElementById('vlibras-label');
const vlibrasContainer = document.getElementById('vlibras-container');
let vlibrasIniciado    = false;

function iniciarVLibras() {
  // Cria o script dinamicamente e aguarda carregar para inicializar
  const script = document.createElement('script');
  script.src = 'https://vlibras.gov.br/app/vlibras-plugin.js';
  script.onload = function () {
    new window.VLibras.Widget('https://vlibras.gov.br/app');
    vlibrasIniciado = true;
  };
  document.head.appendChild(script);
}

function applyVLibras(ativo) {
  if (ativo) {
    vlibrasContainer.style.display = 'block';

    if (!vlibrasIniciado) {
      iniciarVLibras();
    }

    vlibrasLabel.textContent = 'VLibras (ativo)';
    vlibrasToggle.style.color = 'var(--blue-primary)';
  } else {
    vlibrasContainer.style.display = 'none';
    vlibrasLabel.textContent = 'VLibras';
    vlibrasToggle.style.color = '';
  }
}

// Carregar preferência salva
applyVLibras(localStorage.getItem('vlibras') === 'on');

vlibrasToggle.addEventListener('click', function () {
  const ativo = localStorage.getItem('vlibras') === 'on';
  localStorage.setItem('vlibras', ativo ? 'off' : 'on');
  applyVLibras(!ativo);
});