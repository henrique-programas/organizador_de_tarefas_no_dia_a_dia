function navigate(p){
  document.querySelectorAll('.page').forEach(x=>x.classList.remove('active'));
  document.querySelectorAll('.nav-item').forEach(x=>x.classList.remove('active'));
  document.getElementById('page-'+p).classList.add('active');
  const n=document.getElementById('nav-'+p);
  if(n)n.classList.add('active');
}
document.getElementById('modal').addEventListener('click',function(e){if(e.target===this)this.classList.remove('open');});
document.addEventListener('keydown',e=>{if(e.key==='Escape')document.getElementById('modal').classList.remove('open');});

function openEdit(id, title, description, completed, type) {
  document.getElementById('edit-title').value = title;
  document.getElementById('edit-type').value = type;
  document.getElementById('edit-description').value = description;
  document.getElementById('edit-completed').checked = completed;
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