let indexCounter = 0;

setLastFormName();

$(document).on('click', '#add-attribute-button', function () {
    let $addForm = $('#addForm');
    let oneForm = $addForm.find('.oneForm');
    $addForm.append(oneForm[0].outerHTML)
    indexCounter++;
    setLastFormName();
})

$(document).on('click', '.delete-attribute-button', function () {
    $(this).parents('.input-group').remove();
})

$(document).on('click', '.send-attribute-button', function () {
    let titleInput = $(this).parents('.input-group').find('input[data-name="title"]');
    let statusDropdown = $(this).parents('.input-group').find('select[data-name="status"]');
    let typeDropdown = $(this).parents('.input-group').find('select[data-name="type"]');
    let sendButton = $(this).parents('.input-group').find('.send-attribute-button');

    sendButton.css('color', '#11ff00');
    titleInput.prop('disabled', true);
    statusDropdown.prop('disabled', true);
    typeDropdown.prop('disabled', true);

    if (!titleInput.val() || !typeDropdown.val()) {
        sendButton.css('color', '#005eff');
        titleInput.prop('disabled', false);
        statusDropdown.prop('disabled', false);
        typeDropdown.prop('disabled', false);
    }

    let categoryId = new URLSearchParams(location.search).get("id");
    let data = {
        title: titleInput.val(),
        status: statusDropdown.val(),
        type_id: typeDropdown.val(),
        category_id: categoryId
    };
    $.ajax({
        url: "/attribute/add-ajax-attribute",         /* Куда отправить запрос */
        method: 'post',             /* Метод запроса (post или get) */
        dataType: 'html',          /* Тип данных в ответе (xml, json, script, html). */
        data: data,     /* Данные передаваемые в массиве */
        success: function (data) {   /* функция которая будет выполнена после успешного запроса.  */
            let jsonData = JSON.parse(data);
            let invalidTitle = titleInput.parents('.input-group').find('div.title-container .help-block').first().css('color', 'red');
            let invalidType = titleInput.parents('.input-group').find('div.type-container .help-block').first().css('color', 'red')
            for (let atr in jsonData) {
                if (!titleInput.val()){
                    invalidTitle.text(jsonData['title'])
                }else {
                    invalidTitle.text('')
                }
                if (!typeDropdown.val()){
                    invalidType.text(jsonData['type_id'])
                }else {
                    invalidType.text('')
                }
            }
        },
        error: function () {

            alert('error')
        }
    });
});


function setLastFormName() {
    let lastForm = $('#addForm .oneForm').last();
    let titleInput = lastForm.find('input[data-name="title"]');
    let statusDropdown = lastForm.find('select[data-name="status"]');
    let typeDropdown = lastForm.find('select[data-name="type"]');

    titleInput.prop('disabled', false);
    statusDropdown.prop('disabled', false);
    typeDropdown.prop('disabled', false);
    $('.input-group').find('.send-attribute-button').last().css('color', '#005eff')

    titleInput.attr('name', 'Attribute[' + indexCounter + '][title]')
    statusDropdown.attr('name', 'Attribute[' + indexCounter + '][status]')
    typeDropdown.attr('name', 'Attribute[' + indexCounter + '][type_id]')
}
