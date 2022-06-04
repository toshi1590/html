const number_list = document.getElementById('number_list');

for (let i = 0; i < 4; i++) {
  const p = document.createElement('p');
  const text_node = document.createTextNode(i);
  p.appendChild(text_node);
  number_list.appendChild(p);
}
