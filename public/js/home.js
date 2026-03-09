function navigate(p){
  document.querySelectorAll('.page').forEach(x=>x.classList.remove('active'));
  document.querySelectorAll('.nav-item').forEach(x=>x.classList.remove('active'));
  document.getElementById('page-'+p).classList.add('active');
  const n=document.getElementById('nav-'+p);
  if(n)n.classList.add('active');
}
document.getElementById('modal').addEventListener('click',function(e){if(e.target===this)this.classList.remove('open');});
document.addEventListener('keydown',e=>{if(e.key==='Escape')document.getElementById('modal').classList.remove('open');});