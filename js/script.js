// =================================== 
// PARTE 1: A "Chave Mágica" para o E-mail (Regex) 
// =================================== 

// 'emailRegex' é uma "receita" que o computador usa para saber se algo 
// parece um e-mail. Ela verifica: 
// 1. Algo no começo (o nome de usuário). 
// 2. O símbolo @ (arroba). 
// 3. Algo depois do @ (o domínio, como gmail). 
// 4. Um ponto final (.). 
// 5. Algo no final (o .com, .br, etc.). 

const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/; 

// =================================== 
// PARTE 2: A Função de Verificação 
// =================================== 

/** 
 * Objetivo: Checar se o valor no campo de e-mail é válido. 
 * @param {HTMLElement} campo - O campo de texto do e-mail. 
 * @returns {boolean} - 'true' se for válido, 'false' se não for. 
 */ 

function validarEmail(campo) { 
    const email = campo.value; 

    // Usamos a "receita" (emailRegex) para testar o e-mail. 
    if (emailRegex.test(email)) { 
        // SE VÁLIDO: 
        campo.style.border = '1px solid green'; // Borda verde (OK!) 
        campo.setCustomValidity('');           // Tira qualquer aviso de erro. 

        return true; 

    } else { 
        // SE INVÁLIDO: 
        campo.style.border = '2px solid red';  // Borda vermelha (ERRO!) 

        // Prepara uma mensagem de erro e a mostra ao aluno: 
        const mensagemErro = 'Por favor, insira um endereço de e-mail válido.'; 
        campo.setCustomValidity(mensagemErro); 
        //campo.reportValidity(); // Faz o navegador mostrar a caixa de erro. 

        return false; 
    } 
} 

// =================================== 
// PARTE 3: Onde o Programa Começa a Funcionar 
// =================================== 

// Espera que a página HTML (o 'documento') esteja pronta para começar. 

document.addEventListener('DOMContentLoaded', function() { 

    // Acha o campo de e-mail na página pelo ID 'id_email'. 
    const campoEmail = document.getElementById('id_email'); 

    // --- Ação 1: Checagem Rápida (Saindo do Campo) --- 
    // Sempre que o aluno sai do campo (evento 'blur'), checamos o e-mail. 

    campoEmail.addEventListener('blur', function() { 
        validarEmail(campoEmail); 
    }); 

}); 