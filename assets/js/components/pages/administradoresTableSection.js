var moduleName = 'Administradores';

document.addEventListener("DOMContentLoaded", function (event) {
    tableSection();
});

document.getElementById('hw-send-form-button').addEventListener('click', e => {

    e.preventDefault();

    validateFormOptions = {
        validateTwoPass: true,
        moduleTitle: moduleName,
        sendForm: true,
        passwordHash: true
    };

    sendFormOtions = {
        moduleTitle: moduleName,
        sendFormUrl: base_url + 'Back/' + moduleName + '/add',
        redirectUrl: false,
        sendImages: false,
    }

    validateForm(validateFormOptions, sendFormOtions);
    tableSection();

});

function tableSection() {
    var tableColumns = ['id', 'username', 'email','name','lastname', 'actions'];
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

function editSection() {

    validateFormOptions = {
        validateTwoPass: false,
        moduleTitle: moduleName,
        sendForm: true,
        passwordHash: false
    };

    sendFormOtions = {
        moduleTitle: moduleName,
        sendFormUrl: base_url + 'Back/' + moduleName + '/edit',
        redirectUrl: false,
        sendImages: false,
    }

    validateForm(validateFormOptions, sendFormOtions, '#editModal .hw-admin-input');
    tableSection();

}

function requestEditData(moduleName, id) {
    var request = new XMLHttpRequest();

    var postData = 'requestType=one&id=' + id;

    request.open("POST", base_url + 'Back/' + moduleName + '/data_table');
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    request.send(postData);

    request.onreadystatechange = () => {
        if (request.readyState == 200 || request.readyState == 4) {
            var requestResponse = JSON.parse(request.responseText);
            if (requestResponse[0]['status'] == true) {
                fillEditModal(requestResponse[1]['tableData']);
            } else {
                PNotify.error({
                    title: moduleName,
                    text: requestResponse[0]['response']
                });
            }
        }
    }
}

function fillEditModal(data) {
    var editForm = document.querySelectorAll('#editModal .hw-admin-input');
    editForm.forEach(input => {
        switch (input.name) {
            case 'username': input.value = data.username; break;
            case 'email': input.value = data.email; break;
            case 'name': input.value = data.name; break;
            case 'lastname': input.value = data.lastname; break;
            case 'id': input.value = data.id; break;
        }
    });
    $('#editModal').modal();
}


