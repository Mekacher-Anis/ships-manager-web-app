var expenses = 0;
var income = 0;

$(document).ready(() => {
  showExpensesChart();
  showIncomeChart();
})

function loadData() {
  $("#expenses-chart").empty();
  $("#gain-chart").empty();
  showExpensesChart();
  showIncomeChart();
}

function updateInfo() {
  $("#gain-label").text(income);
  $("#expenses-label").text(expenses);
  $("#net-gain-label").text(income - expenses);
}

function showExpensesChart() {
  let period = 1;
  switch ($("#time-period").val()) {
    case '6 Months':
      period = 6;
      break;
    case '1 Year':
      period = 12;
      break;
  }
  $.getJSON("../includes/get-statistics-data.php?data=expenses&period="+period, function (result) {
    var data = {
      labels: [],
      series: []
    };

    result.forEach(row => {
      data.labels.push(row.Name);
      data.series.push(row.Value);
      expenses += parseFloat(row.Value);
    });

    new Chartist.Pie('#expenses-chart', data);

    updateInfo();
  });
}

function showIncomeChart() {
  let period = 1;
  switch ($("#time-period").val()) {
    case '6 Months':
      period = 6;
      break;
    case '1 Year':
      period = 12;
      break;
  }
  $.getJSON("../includes/get-statistics-data.php?data=gain&period="+period, function (result) {
    var data = {
      labels: [],
      series: [[]]
    };

    result.forEach(row => {
      data.labels.push(row.Arrival);
      data.series[0].push(row.Gain);
      income += parseFloat(row.Gain);
    });

    new Chartist.Line('#gain-chart', data,{
      fullWidth: true,
      responsive: true,
      chartPadding: {
        right: 20,
        left: 20
      }
    });

    updateInfo();
  });
}