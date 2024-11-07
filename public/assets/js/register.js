const cidade = document.querySelector("#cidade")
fetch("../../app/lib/cidades.php", {
    method: 'GET',
}).then(response => response.json()).then(
    (returneds) => {
        let options = ""
        returneds.forEach(city => {
            options += `<option value="${city["id"]}">${city["nome"]}</option>`
        })
        cidade.innerHTML += options
    })
