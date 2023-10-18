let divAttrs = $('#goods-attributes')
$(document).on('change', '#goods-category', function () {
    let categoryId = $(this).val()
    $.ajax({
        url: "/attribute/get-by-category?categoryId=" + categoryId,         /* Куда отправить запрос */
        method: 'get',             /* Метод запроса (post или get) */
        //  data: data,     /* Данные передаваемые в массиве */
        success: function (response) {

            createAttributeInputs(response)
        },

        error: function () {
            divAttrs.children().remove()
        }
    });

});

function createAttributeInputs(attributes) {

    for (let attr in attributes) {
        let attribute = attributes[attr]
        switch (attribute.type_id) {
            case 1:
                createTextInput(attribute)
                break
            case 2:
                createIntInput(attribute)
                break
            case 3:
                createFloatInput(attribute)
                break
            case 4:
                createCheckBox(attribute)
                break
            case 5:
                createDictSelect(attribute)
                break
            default:
                console.log('undefined')
        }
    }
}

function createTextInput(attribute) {
    let $inputLabel = $("<label></label>")
        .text(attribute.title)
        .attr('for', 'attr' + '[' + attribute.id + ']')
        .addClass('label')
    divAttrs.append($inputLabel)

    let $input = $('<input>')
        .attr('type', 'text')
        .attr('id', 'attr' + '[' + attribute.id + ']')
        .attr('name', 'Attributes' + '[' + attribute.id + ']')
        .addClass('text-input form-control')
    divAttrs.append($input)
}

function createIntInput(attribute) {
    let $inputLabel = $("<label></label>")
        .text(attribute.title)
        .attr('for', 'attr' + '[' + attribute.id + ']')
        .addClass('label')
    divAttrs.append($inputLabel)

    let $input = $('<input>')
        .attr('type', 'number')
        .attr('id', 'attr' + '[' + attribute.id + ']')
        .attr('name', 'Attributes' + '[' + attribute.id + ']')
        .addClass('int-input form-control')
    divAttrs.append($input)
}

function createFloatInput(attribute) {

    let $inputLabel = $("<label></label>")
        .text(attribute.title)
        .attr('for', 'attr' + '[' + attribute.id + ']')
        .addClass('label')
    divAttrs.append($inputLabel)

    let $input = $('<input>')
        .attr('type', 'number')
        .attr('step', 'any')
        .attr('name', 'Attributes' + '[' + attribute.id + ']')
        .attr('id', 'attr' + '[' + attribute.id + ']')
        .addClass('float-input form-control')
    divAttrs.append($input)
}

function createCheckBox(attribute) {

    let $divCheckBox = $("<div></div>").addClass('check-box')

    let $inputLabel = $("<label></label>")
        .text(attribute.title + ':')
        .attr('for', 'attr' + '[' + attribute.id + ']')
        .addClass('label mr-1')
    divAttrs.append($divCheckBox)
    $divCheckBox.append($inputLabel)


    let $input = $('<input>').val('1')
        .attr('type', 'checkbox')
        .attr('id', 'attr' + '[' + attribute.id + ']')
        .attr('title', 'check')
        .attr('name', 'Attributes' + '[' + attribute.id + ']')
        .addClass('check-bool js-form-element span4  mt-3 mr-3')

    divAttrs.append($divCheckBox)
    $divCheckBox.append($input)
}

function createDictSelect(attribute) {

    let $inputLabel = $("<label></label>")
        .text(attribute.title)
        .attr('for', 'attr' + '[' + attribute.id + ']')
        .addClass('label')
    divAttrs.append($inputLabel)

    let $select = $('<select></select>')
        .addClass('dict-select form-control')
        .attr('name', 'Attributes' + '[' + attribute.id + ']')
        .attr('id', 'attr' + '[' + attribute.id + ']')

    let $placeholderOption = $('<option disabled selected value="">Введіть значення...</option>');
    $select.append($placeholderOption);

    divAttrs.append($select)
    for (let value in attribute.attrValue) {
        let $option = $('<option></option>')
            .text(attribute.attrValue[value].title)
            .val(attribute.attrValue[value].id)
        $select.append($option);
    }
}
