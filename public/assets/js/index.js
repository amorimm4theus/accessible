const register_local = document.querySelector("#register-local")
const search_local  = document.querySelector("#search-local")

register_local.addEventListener("click",e => {
    window.location = "app/locations/?register=1"
})
search_local.addEventListener("click",e => {
    window.location = "app/locations/"
})