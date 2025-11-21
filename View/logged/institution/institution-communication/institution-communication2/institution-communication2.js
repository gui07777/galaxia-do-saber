const btnAdd = document.getElementById('btn-add');
inpTitle.focus();
function closeModal(){
modal.setAttribute('aria-hidden','true');
}


btnAdd.addEventListener('click', openModal);
cancel.addEventListener('click', closeModal);


save.addEventListener('click', () => {
const t = inpTitle.value.trim();
const d = inpDesc.value.trim();
if(!t){
alert('Por favor, preencha o assunto.');
inpTitle.focus();
return;
}
const obj = {title: t, desc: d};
items.push(obj);
renderList();
closeModal();
selectItem(items.length - 1);
});


function renderList(){
listEl.innerHTML = '';
if(items.length === 0){
noItems.style.display = 'block';
} else {
noItems.style.display = 'none';
}
items.forEach((it, idx) =>{
const li = document.createElement('li');
li.textContent = it.title;
li.addEventListener('click', () => selectItem(idx));
if(idx === selectedIndex) li.classList.add('active');
listEl.appendChild(li);
});
}


function selectItem(idx){
if(idx < 0 || idx >= items.length) return;
selectedIndex = idx;
const it = items[idx];
viewTitle.textContent = it.title;
viewDesc.textContent = it.desc || '';

Array.from(listEl.children).forEach((li,i)=> li.classList.toggle('active', i===idx));
}



window.addEventListener('keydown', (e)=>{
if(e.key === 'Escape') closeModal();
});


renderList();