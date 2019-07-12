var pageCharts = new HwChart;
var requestOptions = {
    responseType: 'diagnosticCases'
}
var chartOptions = {
    canvasPre: 'codeLocation',
    buttonsPre: 'codeLocation',
}

pageCharts.createChartOptions(requestOptions, chartOptions);
pageCharts.requestChartData();