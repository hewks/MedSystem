document.getElementById('hw-send-form-button').addEventListener('click', e => {

    e.preventDefault();

    moduleTitle = 'Ingreso';

    validateFormOptions = {
        validateTwoPass: false,
        moduleTitle: moduleTitle,
        sendForm: true,
        passwordHash: true
    };

    sendFormOtions = {
        moduleTitle: moduleTitle,
        sendFormUrl: base_url + 'Login/validate',
        redirectUrl: base_url + 'Back/Administradores',
        sendImages: false,        
    }

    validateForm(validateFormOptions, sendFormOtions);

});