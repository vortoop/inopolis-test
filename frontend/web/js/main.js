$(document).ready(function () {
    /** вызов модалки с подтверждением смены пользовательских данных */
    $('#personal-form').on('submit', function (event) {
        event.preventDefault();
        $('#personal-form-modal').modal();
    });

    /** отправка формы изменения username на странице пользователя после подтверждения изменения */
    $('.js__change-username').on('click', function () {
        $('#personal-form').unbind('submit').submit();
    });
});
