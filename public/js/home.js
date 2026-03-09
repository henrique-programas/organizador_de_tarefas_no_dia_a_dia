function navigate(p){
  document.querySelectorAll('.page').forEach(x=>x.classList.remove('active'));
  document.querySelectorAll('.nav-item').forEach(x=>x.classList.remove('active'));
  document.getElementById('page-'+p).classList.add('active');
  const n=document.getElementById('nav-'+p);
  if(n)n.classList.add('active');
}
document.getElementById('modal').addEventListener('click',function(e){if(e.target===this)this.classList.remove('open');});
document.addEventListener('keydown',e=>{if(e.key==='Escape')document.getElementById('modal').classList.remove('open');});

function openEdit(id, title, description, completed) {
  document.getElementById('edit-title').value = title;
  document.getElementById('edit-description').value = description;
  document.getElementById('edit-completed').checked = completed;
  document.getElementById('form-edit').action = '/tasks/' + id;
  document.getElementById('modal-edit').classList.add('open');
}

document.getElementById('modal-edit').addEventListener('click', function(e) {
  if (e.target === this) this.classList.remove('open');
});