function increaseInput() {
    this.style.backgroundColor = "yellow";
    this.style.width = "12em";
}

function decreaseInput() {
    this.style.backgroundColor = "";
    this.style.width = "6em";
}
let form_id = [];
for(let i = 0; i < 11; i++) {
    form_id.push('mo'+i);
    form_id.push('tu'+i);
    form_id.push('we'+i);
    form_id.push('th'+i);
    form_id.push('fr'+i);
}
for(let i = 0; i < form_id.length; i++) {
    let form = document.getElementById(form_id[i]);
    form.addEventListener('focusin', increaseInput);
    form.addEventListener('focusout', decreaseInput);
}
