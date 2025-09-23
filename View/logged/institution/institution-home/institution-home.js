class InstitutionHome extends HTMLElement {
    connectedCallback() {
        this.innerHTML = `
            <h1>Essa é a institution-home!</h1>
        `;
    }
}

customElements.define('institution-home', InstitutionHome);