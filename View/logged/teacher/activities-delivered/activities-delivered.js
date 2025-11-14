const modal = document.querySelector('#activities-delivered-modal-hide');
const btnVisualizar = document.querySelectorAll('.btn-visualizar');
const overlayHide = document.querySelector('#overlay-hide');

btnVisualizar.forEach(btn => {
  btn.addEventListener('click', () => {
    viewActivitie();
  });
});

function viewActivitie() {
  if (!modal && !overlayHide) return;
  overlayHide.classList.add('overlay');
  overlayHide.style.display = 'flex';
  modal.classList.add('activities-delivered-modal');
  modal.style.display = 'flex';
}

function closeModal() {
  if (modal) {
    modal.classList.remove('activities-delivered-modal');
    modal.style.display = 'none';
    overlayHide.classList.remove('overlay');
    overlayHide.style.display = 'none';
  }
}