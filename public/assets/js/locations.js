const estado = document.querySelector("#estado")
const cidade = document.querySelector("#cidade")
const search = document.querySelector("#search")
const tbody = document.querySelector("#tbody")
fetch("../../app/lib/estados.php", {
    method: 'GET',
}).then(response => response.json()).then(
    (returneds) => {
        let options = ""
        returneds.forEach(state => {
            options += `<option value="${state["id"]}">${state["uf"]}</option>`
        })
        estado.innerHTML += options
    })

estado.addEventListener("change", e => {
    let formData = new FormData()
    formData.append("uf", estado.value)
    fetch("../../app/lib/cidades.php", {
        method: 'POST',
        body: formData,
    }).then(response => response.json()).then(
        (returneds) => {
            let options = ""
            returneds.forEach(city => {
                options += `<option value="${city["id"]}">${city["nome"]}</option>`
            })
            cidade.innerHTML = options
        })
})

const pesquisa = document.querySelector("#pesquisa")
pesquisa.addEventListener("click", () => {
    if (!cidade.value) {
        alert("Selecione uma cidade para realizar a pesquisa!")
        return
    }
    let formData = new FormData()
    formData.append("cidade", cidade.value)
    formData.append("search", search.value)
    fetch("../../app/lib/getLocais.php", {
        method: 'POST',
        body: formData,
    }).then(response => response.json()).then(
        (returneds) => {
            let options = ""
            returneds.forEach(location => {
                let tags = ""
                location.acessibilidades.forEach(acessibilidade => {
                    tags += `<span class="accessible">${acessibilidade["acessibilidade"]}</span>` 
                })
                options += `
                <tr>
                    <td>
                        ${location["nome"]}
                    </td>
                    <td>
                        ${location["endereco"]}
                    </td>
                    <td colspan="2" class="tags">
                        <div class="accessibles">
                              ${tags}
                        </div>
                    </td>
                </tr>
                `
            })
            tbody.innerHTML = options
        })
})