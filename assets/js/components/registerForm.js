document.getElementById('hw-send-form-button').addEventListener('click', e => {

    e.preventDefault();

    moduleTitle = 'Registro';

    validateFormOptions = {
        validateTwoPass: true,
        moduleTitle: moduleTitle,
        sendForm: true,
        passwordHash: true
    };

    sendFormOtions = {
        moduleTitle: moduleTitle,
        sendFormUrl: base_url + 'Login/create',
        redirectUrl: false,
        sendImages: false
    }

    validateForm(validateFormOptions, sendFormOtions);

});

