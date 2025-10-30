document.addEventListener('DOMContentLoaded', () => {

    const form = document.querySelector('form');
    const inputs = document.querySelectorAll('.code-input');
    const hiddenField = document.getElementById('codigo');

    inputs.forEach((input, idx) => {
        input.addEventListener('input', () => {
            if(input.value.length === 1 && idx < inputs.length - 1){
                inputs[idx + 1].focus();
            }
        });

        input.addEventListener('keydown', (e) => {
            if(e.key === 'Backspace' && input.value.length === 0 && idx > 0){
                inputs[idx - 1].focus();
            }
        });
    });

    form.addEventListener('submit', (e) => {
        hiddenField.value = Array.from(inputs).map(i => i.value).join('');

        if(hiddenField.value.length < inputs.length){
            e.preventDefault();
            alert("Por favor, preencha todos os campos do código.");
        }
        
    });
});