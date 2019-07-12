
///////////////////////////////////////////
// General functions
///////////////////////////////////////////

function validateEmail(email) {
    var regex = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return regex.test(email) ? true : false;
}

function validatePassword(password) {
    return (password == null || password == '') ? false : true;
}

function validateText(text) {
    return (text == null || text == '') ? false : true;
}

function getUrlParameterByName(name) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
        results = regex.exec(location.search);
    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}

function quitarTildes(str) {
    return str
        .normalize('NFD')
        .replace(/([^n\u0300-\u036f]|n(?!\u0303(?![\u0300-\u036f])))[\u0300-\u036f]+/gi, "$1")
        .normalize();
}

function removeLoader() {
    document.getElementById('hw-chart-loader').classList.remove('hw-active-loader');
}

///////////////////////////////////////////
// Send and validate forms
///////////////////////////////////////////

function validateForm(validateFormOptions, sendFormOtions, otherForm = null) {

    var form;
    if (otherForm == null) {
        form = document.querySelectorAll('#hw-send-form .hw-form-input');
        if (form.length == 0) {
            form = document.querySelectorAll('#hw-send-form .hw-admin-input');
        }
    } else {
        form = document.querySelectorAll(otherForm);
    }

    var errForm = [];
    var formData = [];
    var errorList = '';

    var formPasswords = {
        'passwordOne': null,
        'passwordTwo': null,
    };

    form.forEach(input => {
        switch (input.type) {
            case 'password':
                if (validatePassword(input.value) == false) { errForm.push(input.dataset.name) }
                else if (input.id != 'passwordTwo') {
                    if (validateFormOptions.passwordHash) {
                        formData.push({ 'name': input.name, 'value': md5(input.value) })
                    } else {
                        formData.push({ 'name': input.name, 'value': input.value })
                    }
                }
                break;
            case 'email':
                if (validateEmail(input.value) == false) { errForm.push(input.dataset.name) }
                else { formData.push({ 'name': input.name, 'value': input.value }) }
                break;
            default:
                if (validateText(input.value) == false) { errForm.push(input.dataset.name) }
                else { formData.push({ 'name': input.name, 'value': input.value }) }
                break;
        }
    });


    if (validateFormOptions.validateTwoPass == true) {
        formPasswords.passwordOne = document.getElementById('passwordOne').value;
        formPasswords.passwordTwo = document.getElementById('passwordTwo').value;
        if (formPasswords.passwordOne != formPasswords.passwordTwo) {
            errForm.push('Las contraseñas son distintas');
        }
    }

    if (errForm.length > 0) {

        errForm.forEach(error => { errorList += error + '\n' });
        PNotify.error({
            title: 'Debes llenar todos los campos',
            text: errorList
        });
    } else {
        if (validateFormOptions.sendForm == true) {
            sendFormData(sendFormOtions, formData);
        } else {
            PNotify.error({
                title: 'Validacion',
                text: 'El formulario se valido correctamente'
            });
        }
    }
}

function sendFormData(sendFormOtions, formData) {

    var request = new XMLHttpRequest();
    var dataObj = new FormData();

    formData.forEach(data => {
        dataObj.append(data.name, data.value);
    });

    request.open("POST", sendFormOtions.sendFormUrl);
    request.send(dataObj);

    request.onreadystatechange = () => {
        if (request.readyState == 200 || request.readyState == 4) {
            var requestResponse = JSON.parse(request.responseText);
            if (requestResponse[0]['status'] == true) {
                if (sendFormOtions.redirectUrl != false) {
                    window.location.href = sendFormOtions.redirectUrl;
                } else {
                    PNotify.success({
                        title: sendFormOtions.moduleTitle,
                        text: requestResponse[0]['response']
                    });
                }
            } else {
                PNotify.error({
                    title: sendFormOtions.moduleTitle,
                    text: requestResponse[0]['response']
                });
            }
        }
    }
}

///////////////////////////////////////////
// Tables
///////////////////////////////////////////

function fillTable(tableData, dataTableColumns) {
    var customerTable = $('#tableSectionTable').DataTable();
    customerTable.destroy();
    var customerTable = $('#tableSectionTable').DataTable({
        data: tableData.tableData,
        columns: dataTableColumns
    });
}

function requestTableData(requestOptions) {
    var postUrlDataTable = requestOptions.requestUrl;
    var req = new XMLHttpRequest();
    var postData = 'requestType=' + requestOptions.requestType;
    req.open('POST', base_url + postUrlDataTable, true);
    req.setRequestHeader('Content-Type', requestOptions.requestContentType);
    req.send(postData);
    req.onreadystatechange = function () {
        if (req.readyState == 4 || req.readyState == 200) {
            var sectionData = JSON.parse(req.responseText);
            if (sectionData[0]['status'] == true) {
                if (requestOptions.fillTable == true) {
                    fillTable(sectionData[1], requestOptions.tableColumns);
                } else {
                    PNotify.info({
                        title: moduleName,
                        text: sectionData[0]['response']
                    });
                }
            } else {
                PNotify.error({
                    title: moduleName,
                    text: sectionData[0]['response']
                });
            }
        }
    }
}

///////////////////////////////////////////
// Table Buttons
///////////////////////////////////////////

function sectionAction(moduleName, id, action) {

    var postUrlDataTable = 'Back/' + moduleName + '/' + action;
    var req = new XMLHttpRequest();
    var postData = 'id=' + id;
    req.open('POST', base_url + postUrlDataTable, true);
    req.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    req.send(postData);
    req.onreadystatechange = function () {
        if (req.readyState == 4 || req.readyState == 200) {
            var sectionData = JSON.parse(req.responseText);
            if (sectionData[0]['status'] == true) {
                tableSection();
                PNotify.success({
                    title: moduleName,
                    text: sectionData[0]['response']
                });
            } else {
                PNotify.error({
                    title: moduleName,
                    text: sectionData[0]['response']
                });
            }
        }
    }

}

///////////////////////////////////////////
// Chart Class
///////////////////////////////////////////

class hwChart {

    createChart(newChartData, newChartLabels, chartId) {

        Chart.defaults.global.animationSteps = 50;
        Chart.defaults.global.tooltipYPadding = 16;
        Chart.defaults.global.tooltipCornerRadius = 4;
        Chart.defaults.global.tooltipTitleFontStyle = "normal";
        Chart.defaults.global.tooltipFillColor = "rgba(50,160,200,0.8)";
        Chart.defaults.global.animationEasing = "easeOutBounce";
        Chart.defaults.global.responsive = true;
        Chart.defaults.global.scaleLineColor = "black";
        Chart.defaults.global.scaleFontSize = 16;

        var lineChartData = {
            labels: newChartLabels,
            datasets: [{
                fillColor: "rgba(151,187,205,0)",
                strokeColor: "rgba(151,187,205,1)",
                pointColor: "rgba(151,187,205,1)",
                data: newChartData
            }]

        }

        if (window.LineChart) {
            window.LineChart.destroy();
        }

        var ctx = document.getElementById(chartId).getContext("2d");
        window.LineChart = new Chart(ctx).Line(lineChartData, {
            bezierCurve: false,
        });

    }

    refactChartData(chartData, time, hwChartId) {

        var min = 1;
        var max = 0;
        var newChartData = [];
        var newChartLabels = [];

        switch (time) {
            case 'month':
                max = 31;
                break;
            case 'year':
                max = 12;
        }

        for (var count = min; count <= max; count++) {
            newChartData[count - 1] = 0;
            newChartLabels[count - 1] = count;
        }

        chartData.forEach(function (data) {
            for (var count = min; count <= max; count++) {
                if (count == data.month) {
                    newChartData[count - 1] += parseInt(data.price);
                }
            }
        });

        this.createChart(newChartData, newChartLabels, hwChartId);

    }

    requestChartData(table, time, hwChartId) {
        var request = new XMLHttpRequest();

        var postData = 'requestType=chart&table=' + table + '&time=' + time;

        request.open("POST", base_url + 'Back/' + moduleName + '/data_table');
        request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        request.send(postData);

        request.onreadystatechange = () => {
            if (request.readyState == 200 || request.readyState == 4) {
                var requestResponse = JSON.parse(request.responseText);
                if (requestResponse[0]['status'] == true) {
                    this.refactChartData(requestResponse[1]['chartData'], time, hwChartId);
                } else {
                    console.log(requestResponse[0]['response']);
                }
            }
        }
    }
}

///////////////////////////////////////////
// HW Chart Class
///////////////////////////////////////////

class HwChart {

    createChartOptions(requestOptions, chartOptions) {
        this.requestOptions = requestOptions;
        this.chartOptions = chartOptions;
    }

    requestChartData() {
        var request = new XMLHttpRequest();
        var postData = 'requestType=' + this.requestOptions.responseType;

        request.open("POST", base_url + 'Main/chart_request');
        request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        request.send(postData);

        request.onreadystatechange = () => {
            if (request.readyState == 200 || request.readyState == 4) {
                var requestResponse = JSON.parse(request.responseText);
                if (requestResponse['status'] == true) {
                    PNotify.success({
                        title: 'Charts',
                        text: 'Todos los datos se hallaron correctamente'
                    });
                    var charts = [];
                    requestResponse['charts'].forEach((chart) => {
                        charts.push(chart);
                    });
                    this.fillChartData(charts);
                } else {
                    PNotify.error({
                        title: 'Charts',
                        text: 'Error en la busqueda de datos'
                    });
                }
            }
        }
    }

    fillChartData(charts) {
        charts.forEach((chart) => {
            this.fillTopLabels(chart.labels);
            this.createChartCanvas(chart.labels, chart.data)
        });
    }

    fillTopLabels(labels) {
        var topButtons = document.getElementById(this.chartOptions.buttonsPre + '-hw-top-chart-buttons');
        labels.forEach((label) => {
            topButtons.innerHTML += '<button class="hw-chart-button" data-chart="' + quitarTildes(label.toLowerCase().replace(/ /g, "")) + '">' + label + '</button>';
        });
    }

    createChartCanvas(labels, data) {
        var canvasBody = document.getElementById(this.chartOptions.canvasPre + '-hw-chart-body');

        var allIds = [];

        labels.forEach((label) => {
            var chart = quitarTildes(label.toLowerCase().replace(/ /g, ""));
            canvasBody.innerHTML += '<canvas class="hw-page-chart hw-pt-10" id="' + chart + '"></canvas>';
            allIds.push(chart);
        });

        this.createAllCharts(allIds, labels, data);
    }

    createAllCharts(ids, labels, data) {
        ids.forEach(function (id, index) {
            var chartObj = new HwChart;
            chartObj.createChart(id, labels[index], data[index]);
        });
        var charts = document.querySelectorAll('.hw-page-chart');
        var firstChart = document.querySelectorAll('.hw-page-chart')[0];
        var firstButton = document.querySelectorAll('.hw-chart-button')[0];
        var buttons = document.querySelectorAll('.hw-chart-button');
        charts.forEach(function (chart) {
            chart.classList.remove('hw-active-chart');
            chart.classList.add('hw-deactivate-chart');
        });
        buttons.forEach(function (chart) {
            chart.classList.remove('hw-active-btn');
            chart.classList.add('hw-deactivate-btn');
        });
        firstChart.classList.add('hw-active-chart');
        firstChart.classList.remove('hw-deactivate-chart');
        firstButton.classList.add('hw-active-btn');
        firstButton.classList.remove('hw-deactivate-btn');
        this.activateButtonsDinamic();
    }

    createChart(chartId, chartLabels, chartData) {

        Chart.defaults.global.animationSteps = 50;
        Chart.defaults.global.tooltipYPadding = 16;
        Chart.defaults.global.tooltipCornerRadius = 4;
        Chart.defaults.global.tooltipTitleFontStyle = "normal";
        Chart.defaults.global.tooltipFillColor = "rgba(50,160,200,0.8)";
        Chart.defaults.global.animationEasing = "easeOutBounce";
        Chart.defaults.global.responsive = true;
        Chart.defaults.global.scaleLineColor = "black";
        Chart.defaults.global.scaleFontSize = 10;
        
        var codes = chartData.codes;
        var tempLabels = Object.keys(codes);
        var tempData = Object.values(codes);

        var chartDataBar = {
            labels: tempLabels,
            datasets: [{
                data: tempData,
                fillColor: "rgba(151,187,205,1)",
                strokeColor: "rgba(151,187,205,1)",
                pointColor: "rgba(151,187,205,1)",
            }]
        }

        var ctx = document.getElementById(chartId).getContext("2d");
        new Chart(ctx).Bar(chartDataBar, {
            bezierCurve: false
        });
    }

    activateButtonsDinamic() {
        var chartButtons = document.querySelectorAll('.hw-chart-button');
        chartButtons.forEach(function (btn) {
            btn.addEventListener('click', function () {
                var activeButton = document.querySelectorAll('.hw-active-btn')[0];
                activeButton.classList.add('hw-deactivate-btn');
                activeButton.classList.remove('hw-active-btn');
                var activeChart = document.querySelectorAll('.hw-active-chart')[0];
                activeChart.classList.add('hw-deactivate-chart');
                activeChart.classList.remove('hw-active-chart');

                this.classList.add('hw-active-btn');
                this.classList.remove('hw-deactivate-btn');
                var activateChart = document.getElementById(btn.dataset.chart);
                activateChart.classList.remove('hw-deactivate-chart');
                activateChart.classList.add('hw-active-chart');
            });
            setTimeout(() => {
                removeLoader();
            }, 6000);
        });
    }
}