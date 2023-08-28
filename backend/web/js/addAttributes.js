
let indexCounter = 0;

function setLastFormName()
{
 $('#addForm .oneForm').last().each(function() {
  let titleInput = $(this).find('input[data-name="title"]');
  let statusDropdown = $(this).find('select[data-name="status"]');
  let typeDropdown = $(this).find('select[data-name="type"]');

  titleInput.attr('name','Attribute[' + indexCounter + '][title]')
  statusDropdown.attr('name','Attribute[' + indexCounter + '][status]')
  typeDropdown.attr('name','Attribute[' + indexCounter + '][type_id]')
 });
}

setLastFormName();

$('#add-attribute-button').click(function () {
 let lastChild = $('#addForm .oneForm').last();
 if (!lastChild.find('input[data-name="title"]').val()) {
  alert('Поле "Назва атрибуту"є обовязковим ')
 } else if ($('#type_id').val() === '') {
  alert('Поле "Тип атрибуту"є обовязковим ')
 }else {
  let $addForm = $('#addForm');
  let oneForm = $addForm.find('.oneForm');
  $addForm.append(oneForm[0].outerHTML)
  indexCounter++;
  setLastFormName();
 }
})

$('#delete-attribute-button').click(function () {
 $('#addForm .oneForm').last().remove();
})
