function openModal() {
    document.getElementById("myModal").style.display = "block";
}

function closeModal() {
    document.getElementById("myModal").style.display = "none";
}

// Fechar o modal ao clicar fora do conteúdo
window.onclick = function(event) {
    const modal = document.getElementById("myModal");
    if (event.target === modal) {
        modal.style.display = "none";
    }
};
var cidadeViaCep = false;
var inputTag = document.querySelector('input[name="input-custom-dropdown"]')



const cep = document.querySelector("#cep")
cep.addEventListener("keyup",e => {
    let cepDigitado = e.target.value.replace(/\D/g, ''); // Remove todos os caracteres não numéricos
        if (cepDigitado.length === 8) { // Verifica se o CEP tem 8 dígitos
        const url = `https://viacep.com.br/ws/${cepDigitado}/json/`;
        fetch(url, {
            method: 'GET',
        }).then(response => response.json()).then(
            (returneds) => {
                if (!returneds.erro) {
                    document.querySelector("#endereco").value = returneds.logradouro
                    cidadeViaCep = returneds.localidade
                    selecionarPorTexto(returneds.uf,document.querySelector("#estado-form"))
                }
        })
    }
})
function apenasNumeros(event) {
    // Permite apenas números (código 48 a 57)
    const charCode = event.which ? event.which : event.keyCode;
    if (charCode < 48 || charCode > 57) {
        event.preventDefault();
        return false;
    }
    return true;
}

function mascaraCEP(input) {
    let cep = input.value.replace(/\D/g, ''); // Remove qualquer caractere que não seja dígito
    if (cep.length > 5) {
        cep = cep.replace(/^(\d{5})(\d)/, '$1-$2'); // Insere o hífen após o quinto dígito
    }
    input.value = cep;
}

function selecionarPorTexto(nome,select) {
    for (var i = 0; i < select.options.length; i++) {
        var option = select.options[i];
        
        // Verifica se o texto da opção corresponde ao nome fornecido
        if (option.text === nome) {
            select.selectedIndex = i; // Define o índice da opção selecionada
            var event = new Event('change');
            select.dispatchEvent(event);
            break; // Encerra o loop quando a opção é encontrada
        }
    }
}

const estado_form = document.querySelector("#estado-form")
const cidade_form = document.querySelector("#cidade-form")
fetch("../../app/lib/estados.php", {
    method: 'GET',
}).then(response => response.json()).then(
    (returneds) => {
        let options = ""
        returneds.forEach(state => {
            options += `<option value="${state["id"]}">${state["uf"]}</option>`
        })
        estado_form.innerHTML += options
    })

estado_form.addEventListener("change", e => {
    let formData = new FormData()
    formData.append("uf", estado_form.value)
    fetch("../../app/lib/cidades.php", {
        method: 'POST',
        body: formData,
    }).then(response => response.json()).then(
        (returneds) => {
            let options = ""
            returneds.forEach(city => {
                options += `<option value="${city["id"]}">${city["nome"]}</option>`
            })
            cidade_form.innerHTML = options
            if (cidadeViaCep) {
                selecionarPorTexto(cidadeViaCep,document.querySelector("#cidade-form"))
            }
        })
})


fetch("../../app/lib/accessibilidades.php", {
    method: 'GET',
}).then(response => response.json()).then(
    (returneds) => {
    // init Tagify script on the above inputs
    tagify = new Tagify(inputTag, {
        whitelist: returneds.whitelist,
        maxTags: 10,
        dropdown: {
            maxItems: 20,           // <- mixumum allowed rendered suggestions
            classname: 'tags-look', // <- custom classname for this dropdown, so it could be targeted
            enabled: 0,             // <- show suggestions on focus
            closeOnSelect: false    // <- do not hide the suggestions dropdown once an item has been selected
        }
    })
    })

const form = document.querySelector("#form")
form.addEventListener("submit", e => {
    e.preventDefault()
    let data = new FormData(form)
    fetch("../../app/lib/cadastrarLocal.php", {
        method: 'POST',
        body: data
    }).then(response => response.json()).then(
        (returneds) => {
            if (returneds.erro) {
                alert("falha ao cadastrar local")
            } else {
                alert("Local cadastrado com sucesso!")
            }
    })
})