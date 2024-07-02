$(document).ready(() => {
    // Substituindo conteudo da página principal com evento click

    // load() -> Carrega uma URL e seu conteúdo
    // Por padrão, faz requisição GET

    $('#documentacao').on('click', () => {
        // $('#pagina').load('../pages/documentacao.html');

        // $.get() -> Faz uma requisição GET ao servidor
        // param 1 -> url
        // param 2 -> função
        // $.get('../pages/documentacao.html', data => {
        //     $('#pagina').html(data);
        // });

        // $.get() -> Faz uma requisição GET ao servidor
        // param 1 -> url
        // param 2 -> função
        $.post('../pages/documentacao.html', data => {
            $('#pagina').html(data);
        });

    });

    $('#suporte').on('click', () => {
        // $('#pagina').load('../pages/suporte.html');

        // $.get('../pages/suporte.html', data => {
        //     $('#pagina').html(data);
        // });

        $.post('../pages/suporte.html', data => {
            $('#pagina').html(data);
        });
    });
    
})