// data
const scraped_data = [
  ['id', 'name', 'country', 'age'],
  ['1', 'a', 'america', '13'],
  ['2', 'b', 'latvia', '35'],
  ['3', 'c', 'japan', '13'],
  ['4', 'd', 'america', '19'],
  ['5', 'e', 'latvia', '29'],
  ['6', 'f', 'japan', '23'],
  ['7', 'g', 'america', '35']
];


// title select
function append_titles(section) {
  const select = document.createElement('select');
  select.setAttribute('class', 'form-select mt-1 mb-1');
  select.setAttribute('name', 'title_number')

  for (let i = 0; i < scraped_data[0].length; i++) {
    const option = document.createElement('option');
    option.setAttribute('value', i);
    const option_text = document.createTextNode(scraped_data[0][i]);
    option.appendChild(option_text);
    select.appendChild(option);
  }

  section.appendChild(select);
}


// common functions
function get_btn (textnode, class_, id, function_) {
  const btn = document.createElement('button');
  const text_node = document.createTextNode(textnode);
  btn.appendChild(text_node);
  btn.setAttribute('type', 'button');
  btn.setAttribute('class', class_);
  btn.setAttribute('id', id);
  btn.setAttribute('onclick', function_);
  return btn;
}

function get_input (type, class_, name, placeholder) {
  const input = document.createElement('input');
  input.setAttribute('type', type);
  input.setAttribute('class', class_);
  input.setAttribute('name', name);
  input.setAttribute('placeholder', placeholder);
  return input;
}

function get_label (textnode, class_) {
  const label = document.createElement('label');
  const text_node = document.createTextNode(textnode);
  label.appendChild(text_node);
  label.setAttribute('class', class_);
  return label;
}

function get_tds (elements) {
  const tds = [];

  for (let i = 0; i < elements.length; i++) {
    const td = document.createElement('td');
    td.appendChild(elements[i]);
    tds.push(td);
  }

  return tds;
}

function get_ths (elements) {
  const ths = [];

  for (let i = 0; i < elements.length; i++) {
    const th = document.createElement('th');
    th.appendChild(elements[i]);
    ths.push(th);
  }

  return ths;
}

function get_tr (tds_or_ths) {
  const tr = document.createElement('tr');

  for (let i = 0; i < tds_or_ths.length; i++) {
    tr.appendChild(tds_or_ths[i]);
  }

  return tr;
}

function add_tr_in_thead (elements, thead) {
  const ths = get_ths(elements);
  const tr = get_tr(ths);
  thead.appendChild(tr);
}

function add_tr_in_tbody (elements, tbody) {
  const tds = get_tds(elements);
  const tr = get_tr(tds);
  tbody.appendChild(tr);
}

function get_table(){
  const table = document.createElement('table');
  const thead = document.createElement('thead');
  const tbody = document.createElement('tbody');
  table.setAttribute('class', 'table');
  table.appendChild(thead);
  table.appendChild(tbody);
  return table;
}

function delete_tr (delete_btn) {
  delete_btn.closest('tr').remove();
}

function delete_table (delete_btn) {
  delete_btn.closest('table').remove();
}


// chart form
const group_by_a_column_radio = document.querySelector('#group_by_a_column_radio');
const group_by_a_column_section = document.querySelector('#group_by_a_column_section');
const range_radio = document.querySelector('#range_radio');
const range_section = document.querySelector('#range_section');
const keyword_radio = document.querySelector('#keyword_radio');
const keyword_section = document.querySelector('#keyword_section');


//
group_by_a_column_radio.onchange = function () {
  //
  range_section.innerHTML = '';
  keyword_section.innerHTML = '';

  //
  append_titles(group_by_a_column_section);
}


//
range_radio.onchange = function () {
  //
  group_by_a_column_section.innerHTML = '';
  keyword_section.innerHTML = '';

  //
  append_titles(range_section);

  //
  const add_btn = get_btn('add', 'btn btn-primary mb-1', 'range_add_btn', 'add_range_group()');
  range_section.appendChild(add_btn);

  //
  const min = get_input('number', 'form-control', 'mins[]', 'min');
  const max = get_input('number', 'form-control', 'maxs[]', 'max');
  const delete_btn = get_btn('delete', 'btn btn-danger', '', 'delete_tr(this)');
  const table = get_table();
  range_section.appendChild(table);
  table.querySelector('tbody').setAttribute('id', 'tbody_of_range_group_table');
  const elements_for_tds = [min, max, delete_btn];
  add_tr_in_tbody(elements_for_tds, tbody_of_range_group_table);
}

function add_range_group () {
  const min = get_input('number', 'form-control', 'mins[]', 'min');
  const max = get_input('number', 'form-control', 'maxs[]', 'max');
  const delete_btn = get_btn('delete', 'btn btn-danger', '', 'delete_tr(this)');
  const elements_for_tds = [min, max, delete_btn];
  add_tr_in_tbody(elements_for_tds, tbody_of_range_group_table);
}


//
keyword_radio.onchange = function () {
  //
  group_by_a_column_section.innerHTML = '';
  range_section.innerHTML = '';

  //
  append_titles(keyword_section);

  //
  const add_btn = get_btn('add', 'btn btn-primary mb-1', 'keyword_add_btn', 'add_keyword()');
  keyword_section.appendChild(add_btn);

  //
  const keyword = get_input('text', 'form-control', 'keywords[]', 'keyword');
  const delete_btn = get_btn('delete', 'btn btn-danger', '', 'delete_tr(this)');
  const table = get_table();
  keyword_section.appendChild(table);
  table.querySelector('tbody').setAttribute('id', 'tbody_of_keyword_table');
  const elements_for_tds = [keyword, delete_btn];
  add_tr_in_tbody(elements_for_tds, tbody_of_keyword_table);
}


function add_keyword () {
  const keyword = get_input('text', 'form-control', 'keywords[]', 'keyword');
  const delete_btn = get_btn('delete', 'btn btn-danger', '', 'delete_tr(this)');
  const elements_for_tds = [keyword, delete_btn];
  add_tr_in_tbody(elements_for_tds, tbody_of_keyword_table);
}


// chart section
const chart_form = document.getElementById('chart_form');
const see_chart_btn = document.getElementById('see_chart_btn');

see_chart_btn.onclick = function () {
  const title_number = parseInt(document.querySelector('select[name="title_number"]').value);

  if (group_by_a_column_radio.checked) {
    const scraped_data_for_title_number = [];
    let total = 0;

    for (let i = 1; i < scraped_data.length; i++) {
      scraped_data_for_title_number.push(scraped_data[i][title_number]);
      total++;
    }

    // get distinct data
    const counted_data = {};

    for(let i = 0; i < scraped_data_for_title_number.length; i++){
      var key = scraped_data_for_title_number[i];

      if (counted_data[key] == undefined) {
        counted_data[key] = 0;
      }

      counted_data[key]++;
    }

    // get keys from counted_data
    let keys = [];

    for (key in counted_data){
      keys.push(key);
    }

    // get values from counted_data
    let values = [];

    for (key in counted_data){
      values.push(counted_data[key]);
    }

    display_chart(keys, values, title_number, total)
  } else if (range_radio.checked) {
    const mins = document.getElementsByName('mins[]');
    const maxs = document.getElementsByName('maxs[]');

    if (mins.length != 0 && maxs.length != 0) {
      let empty_check_flag;

      for (let i = 0; i < mins.length; i++) {
        if (mins[i].value == '' || maxs[i].value == '') {
          alert('fill in blanks');
          empty_check_flag = false;
          break;
        }

        empty_check_flag = true
      }

      if (empty_check_flag == true) {
        //
        let range_group_names = [];
        let range_groups = [];

        for (let i = 0; i < mins.length; i++) {
          const range_group_name = mins[i].value + ' - ' + maxs[i].value;
          range_group_names.push(range_group_name);

          let range_group = [];
          range_groups.push(range_group);
        }

        //
        let unsorted_scraped_data = [];
        let total = 0;

        for (let i = 1; i < scraped_data.length; i++) {
          unsorted_scraped_data.push(scraped_data[i]);
          total++;
        }

        //
        for (let i = 0; i < range_groups.length; i++) {
          for (let j = 0; j < unsorted_scraped_data.length; j++) {
            if (unsorted_scraped_data[j][title_number] >= parseFloat(mins[i].value) && unsorted_scraped_data[j][title_number] <= parseFloat(maxs[i].value)) {
              range_groups[i].push(unsorted_scraped_data[j]);
              unsorted_scraped_data.splice(j, 1);
              j--;
            }
          }
        }

        if (unsorted_scraped_data.length != 0) {
          range_group_names.push('the other');
          range_groups.push(unsorted_scraped_data);
        }

        const keys = range_group_names;
        let values = [];

        range_groups.forEach(function(element){
          values.push(element.length);
        })

        display_chart(keys, values, title_number, total);
      }
    }
  } else if (keyword_radio.checked) {
    const keywords = document.getElementsByName('keywords[]');

    if (keywords.length != 0) {
      let empty_check_flag;

      for (let i = 0; i < keywords.length; i++) {
        if (keywords[i].value == '') {
          alert('fill in blanks');
          empty_check_flag = false;
          break;
        }

        empty_check_flag = true
      }

      if (empty_check_flag == true) {
        //
        let keyword_group_names = [];
        let keyword_groups = [];

        for (let i = 0; i < keywords.length; i++) {
          const keyword_group_name = keywords[i].value;
          keyword_group_names.push(keyword_group_name);

          let keyword_group = [];
          keyword_groups.push(keyword_group);
        }

        //
        let unsorted_scraped_data = [];
        let total = 0;

        for (let i = 1; i < scraped_data.length; i++) {
          unsorted_scraped_data.push(scraped_data[i]);
          total++;
        }

        //
        for (let i = 0; i < keyword_groups.length; i++) {
          for (let j = 0; j < unsorted_scraped_data.length; j++) {
            if (unsorted_scraped_data[j][title_number].includes(keyword_group_names[i])) {
              keyword_groups[i].push(unsorted_scraped_data[j]);
              unsorted_scraped_data.splice(j, 1);
              j--;
            }
          }
        }

        if (unsorted_scraped_data.length != 0) {
          keyword_group_names.push('the other');
          keyword_groups.push(unsorted_scraped_data);
        }

        const keys = keyword_group_names;
        let values = [];

        keyword_groups.forEach(function(element){
          values.push(element.length);
        })

        display_chart(keys, values, title_number, total);
      }
    }
  }
}


//
const chart_section = document.getElementById('chart_section');

function display_chart(keys, values, title_number, total) {
  chart_section.innerHTML = '';
  const canvas = document.createElement('canvas');
  canvas.setAttribute('id', 'chart');
  chart_section.appendChild(canvas);

  var chart = new Chart(canvas, {
    type: 'pie',
    data: {
      labels: keys,
      datasets: [{
        backgroundColor: background_colors,
        data: values
      }]
    },
    options: {
      title: {
        display: true,
        text: scraped_data[0][title_number] + ` (total ${total})`
      }
    }
  });

  chart_section.scrollIntoView();
}
