var moduleName = 'Clientes';

document.addEventListener("DOMContentLoaded", function (event) {
    tableSection();
});

//Llenar tabla con los datos de la base
function tableSection() {
    var tableColumns = ['id', 'name', 'document', 'documentType', 'actions'];
    var dataTableColumns = [];

    tableColumns.forEach(column => {
        dataTableColumns.push({ data: column });
    });

    var requestOptions = {
        requestUrl: 'Back/' + moduleName + '/data_table',
        moduleName: moduleName,
        requestType: 'all',
        requestContentType: 'application/x-www-form-urlencoded',
        fillTable: true,
        tableColumns: dataTableColumns
    }

    requestTableData(requestOptions);
}

function showCustomerHistories(id) {

    //Consultar a la base de datos las historias por cliente
    var postUrlDataTable = 'Back/Clientes/data_table';
    var req = new XMLHttpRequest();
    var postData = 'id=' + id + '&requestType=histories';
    req.open('POST', base_url + postUrlDataTable, true);
    req.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    req.send(postData);
    req.onreadystatechange = function () {
        if (req.readyState == 4 || req.readyState == 200) {
            var sectionData = JSON.parse(req.responseText);
            if (sectionData[0]['status'] == true) {
                console.log(sectionData[1]);
                fillHistoryModal(sectionData[1]);
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

function fillHistoryModal(modalData) {
    modalString = '';
    modalData['modalData'].forEach(function (history) {
        modalString += '<li><a class="modal-history-link" href="' + base_url + 'Back/Clientes/create_pdf?request=history&customer_id=' + history.user_id + '&history_id=' + history.id + '">Historia clinica (' + history.id + ')</a></li>'
    });
    document.getElementById('customer_id').innerHTML = modalData['id'];
    document.getElementById('modalBodyHistory').innerHTML = modalString;
    $('#historyModal').modal();
}