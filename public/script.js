const submit_btn = document.getElementById("submit");
const data_table = document.getElementById("data");

submit_btn.onclick = function (e) {
  e.preventDefault();
  data_table.style.display = "block";

  // Clear table, stay only header
  let table = data_table.getElementsByTagName('table').item(0);
  let tableHeader = table.getElementsByTagName('tr').item(0);
  table.innerHTML = tableHeader.getHTML()

  const form = e.target.parentElement;
  const url = form.action;
  const params = new URLSearchParams(new FormData(form)).toString();

  fetch(url + '?' + params, { method: 'POST' })
    .then(response => response.json())
    .then(data => {
      // Set table header
      data_table.getElementsByTagName('h2').item(0).textContent = data['title'];

      // Fill table
      data['statistics'].forEach(function (row) {
        const tr = document.createElement("tr");
        tr.innerHTML = `<td>${row.month}</td><td>${row.monthly_balance}</td><td>${row.transaction_count}</td>`;

        table.appendChild(tr);
      });
    })
    .catch(() => alert('Error while loading data'));
};
