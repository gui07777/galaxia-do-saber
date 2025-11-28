const modal = document.querySelector('#information-modal-hide');
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
  modal.classList.add('information-modal');
  modal.style.display = 'flex';
}

function closeModal() {
  if (modal) {
    modal.classList.remove('information-modal');
    modal.style.display = 'none';
    overlayHide.classList.remove('overlay');
    overlayHide.style.display = 'none';
  }

}
function editInformation(){
  window.location.href = "../teacher-edit/teacher-edit.php";
}

  if (inputs.length > 0) {
    inputs[0].focus();
  }
