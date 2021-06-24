function reindex() {
    let labels = document.getElementsByTagName('label');
    let inputs = document.querySelectorAll('input[type=text]');
    let spans = document.getElementsByClassName('eg_btt_br');
    let buttons = document.getElementsByClassName('remove_row');

    for(let i=0; i<labels.length; i++) {
        labels[i].innerHTML = i;
        labels[i].setAttribute('for', 'form_grades_' + i);
        inputs[i].id = 'form_grades_' + i;
        inputs[i].name = 'form[grades][' + i + ']';
        spans[i].setAttribute('id', 'form_edgr_' + i);
        buttons[i].setAttribute('value', i);
    }
}
let rem_bts = document.getElementsByClassName('remove_row');

function removeRow() {
    let span = document.getElementById('form_edgr_'+this.value);
    span.remove();
    let fg = document.getElementById('form_grades_'+this.value);
    fg.parentElement.remove();
    reindex();
};
for(let i = 0; i < rem_bts.length; i++) {
    rem_bts[i].addEventListener('click', removeRow);
}

document.getElementById('add_row').addEventListener('click', function() {
    let labels = document.getElementsByTagName('label');
    var row = document.createElement('div');
    var label = document.createElement('label');
    var input = document.createElement('input');
    var button = document.createElement('button');
    var span = document.createElement('span');
    if (labels.length > 0) {
        let next_id = labels[labels.length - 1].innerHTML;
        next_id = Number(next_id);
        next_id += 1;
        label.setAttribute('for', 'form_grades_' + next_id);
        label.setAttribute('class', 'required');
        label.innerHTML = next_id;
        input.setAttribute('type', 'text');
        input.setAttribute('required', 'required');
        input.setAttribute('id', 'form_grades_' + next_id);
        input.setAttribute('name', 'form[grades][' + next_id + ']');
        button.setAttribute('type', 'button');
        button.setAttribute('class', 'remove_row');
        button.setAttribute('value', next_id);
        button.innerHTML = 'Remove';
        button.addEventListener('click', removeRow);
        span.setAttribute('id', 'form_edgr_' + next_id);
        span.setAttribute('class', 'eg_btt_br');
    } else {
        label.setAttribute('for', 'form_grades_0');
        label.setAttribute('class', 'required');
        label.innerHTML = '0';
        input.setAttribute('type', 'text');
        input.setAttribute('required', 'required');
        input.setAttribute('id', 'form_grades_0');
        input.setAttribute('name', 'form[grades][0]');
        button.setAttribute('type', 'button');
        button.setAttribute('class', 'remove_row');
        button.setAttribute('value', 0);
        button.innerHTML = 'Remove';
        button.addEventListener('click', removeRow);
        span.setAttribute('id', 'form_edgr_0');
        span.setAttribute('class', 'eg_btt_br');
    }

    span.appendChild(button);
    span.appendChild(document.createElement('br'));

    row.appendChild(label);
    row.appendChild(input);
    row.appendChild(span);

    let div = document.getElementById('form_save').parentNode;
    let save = document.getElementById('form_save');
    div.insertBefore(row, save);
});

window.addEventListener('load', reindex);
