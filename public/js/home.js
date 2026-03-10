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