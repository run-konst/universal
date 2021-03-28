let contactsForm = $('.contacts-form');

contactsForm.on('submit', function (event) {
    event.preventDefault();

    var formData = new FormData(this);
    formData.append('action', 'contacts_form')
    
    $.ajax({
        type: "POST",
        url: adminAjax.url,
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {
            alert('Ответ сервера ' + response);    
        }
    });
})