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
    
    // Ajax | Alimentado pagina com dados

    // Selecionando select (data) e aplicando evento change
    $('#competencia').on('change', e => {
        // console.log($(e.target).val());

        // Requisicoes com ajax
        // $.ajax() -> Recebe um objeto (dict)
        // Definir -> método de request, url (ligação com DB), dados (opcional) e fluxo sucesso e erro

        // Valor dinâmico de competencia
        let competencia = $(e.target).val();

        $.ajax(
            {
                type: 'GET',
                url: '../assets/app.php',

                // x-www-form-urlencoded | name (campo) = value (campo)
                // Para informar mais URLSearchParams, use &
                // Exemplo -> competencia=2018-10&x=10&y=20& etc...
                data: `competencia=${competencia}`,

                // Por padrão, requisicoes ajax retorna um objeto text/html
                // Para definirmos o tipo dos dados, basta indicar o dataType
                dataType: 'json',

                // Capturando dados apenas necessários do obt json
                success: dados => {
                    // Alimentando pagina web com respectivos dados
                    $('#numero_vendas').html(dados.numero_vendas);
                    $('#total_vendas').html(dados.total_vendas);
                    $('#clientes_ativos').html(dados.clientes_ativos);
                    $('#clientes_inativos').html(dados.clientes_inativos)
                    $('#reclamacoes').html(dados.reclamacoes);
                    $('#elogios').html(dados.elogios);
                    $('#sugestoes').html(dados.sugestoes);

                    // console.log(dados.numero_vendas, dados.total_vendas);
                },
                error: erro => {
                    console.log(erro);
                },
            }
        );
    });

})