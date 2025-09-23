// class Sidebar extends HTMLElement {

//     connectedCallback() {
//         this.innerHTML = `
//         <nav id="sidebar">
//         <div id="sidebar_content">
//             <div id="open">
//                 <button id="open_btn">
//                 <i id="open_btn_icon" class="material-symbols-outlined">menu</i>
//             </button>
//             </div>
    
//             <ul id="side_items">
//                 <li class="side-item active">
//                     <a href="#">
//                     <i class="material-symbols-outlined">add_circle</i>
//                         <span class="item-description">
//                             Cadastrar
//                         </span>
//                     </a>
//                 </li>
    
//                 <li class="side-item">
//                     <a href="#">
//                     <i class="material-symbols-outlined">calendar_month</i>
//                         <span class="item-description">
//                             Agenda
//                         </span>
//                     </a>
//                 </li>
    
//                 <li class="side-item">
//                     <a href="#">
//                     <i class="material-symbols-outlined">mail</i>
//                         <span class="item-description">
//                             Comunicados
//                         </span>
//                     </a>
//                 </li>
    
//                 <li class="side-item">
//                     <a href="#">
//                     <i class="material-symbols-outlined">bar_chart_4_bars</i>
//                         <span class="item-description">
//                             Relatórios Gerais
//                         </span>
//                     </a>
//                 </li>
//             </ul>
//         </div>

//         <div id="logout">
//             <button id="logout_btn">
//                 <i class="material-symbols-outlined">logout</i>
//                 <span class="item-description">
//                     Sair
//                 </span>
//             </button>
//         </div>
//     </nav>
//         `;
        
        document.getElementById('open_btn').addEventListener('click', () => {
            document.getElementById('sidebar').classList.toggle('open-sidebar');
        });
//     }
// }

// customElements.define('side-bar', Sidebar);