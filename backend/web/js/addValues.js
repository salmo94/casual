let indexCounter = 0;

setLastFormName();

$(document).on('click', '#add-value-button', function () {
    let $addForm = $('#addForm');
    let oneForm = $addForm.find('.oneForm');
    $addForm.append(oneForm[0].outerHTML)
    indexCounter++;
    setLastFormName();


})

$(document).on('click', '.delete-value-button', function () {
    $(this).parents('.input-group').remove();
})

$(document).on('click', '.send-value-button', function () {
    let titleInput = $(this).parents('.input-group').find('input[data-name="title"]');
    let statusDropdown = $(this).parents('.input-group').find('select[data-name="status"]');
    let sendButton = $(this).parents('.input-group').find('.send-value-button');

    sendButton.css('color', '#11ff00');
    titleInput.prop('disabled', true);
    statusDropdown.prop('disabled', true);


    if (!titleInput.val()) {
        sendButton.css('color', '#005eff');
        titleInput.prop('disabled', false);
        statusDropdown.prop('disabled', false);
    }

    let attributeId = new URLSearchParams(location.search).get("id");
    let data = {
        title: titleInput.val(),
        status: statusDropdown.val(),
        attribute_id: attributeId
    };
    $.ajax({
        url: "/attribute-value/add-ajax-value",         /* Куда отправить запрос */
        method: 'post',             /* Метод запроса (post или get) */
        dataType: 'html',          /* Тип данных в ответе (xml, json, script, html). */
        data: data,     /* Данные передаваемые в массиве */
        success: function (data) {   /* функция которая будет выполнена после успешного запроса.  */
            let jsonData = JSON.parse(data);
            let invalidTitle = titleInput.parents('.input-group').find('div.title-container .help-block').first().css('color', 'red');
            for (let val in jsonData) {
                if (!titleInput.val()){
                    invalidTitle.text(jsonData['title'])
                }else {
                    invalidTitle.text('')
                }
            }
        },
        error: function (jqXHR, exception) {
            if (jqXHR.status === 0) {
                alert('Not connect. Verify Network.');
            } else if (jqXHR.status === 404) {
                alert('Requested page not found (404).');
            } else if (jqXHR.status === 500) {
                alert('Internal Server Error (500).');
            } else if (exception === 'parsererror') {
                alert('Requested JSON parse failed.');
            } else if (exception === 'timeout') {
                alert('Time out error.');
            } else if (exception === 'abort') {
                alert('Ajax request aborted.');
            } else {
                alert('Uncaught Error. ' + jqXHR.responseText);
            }
        }
    });
});


function setLastFormName() {
    let lastForm = $('#addForm .oneForm').last();
    let titleInput = lastForm.find('input[data-name="title"]');
    let statusDropdown = lastForm.find('select[data-name="status"]');

    titleInput.prop('disabled', false);
    statusDropdown.prop('disabled', false);
    $('.input-group').find('.send-value-button').last().css('color', '#005eff')

    titleInput.attr('name', 'Value[' + indexCounter + '][title]')
    statusDropdown.attr('name', 'Value[' + indexCounter + '][status]')
}
