function enterGame(game) {
    switch (game) {
        case 'adicao':
            window.location.href = '../html/add.html'
            return;
        case 'subtracao':
            window.location.href = '../html/sub.html'
            return;
        case 'multiplicacao':
            window.location.href = '../html/mult.html'
            return;
        case 'divisao':
            window.location.href = '../html/divisao.html'
            return;
    }
}