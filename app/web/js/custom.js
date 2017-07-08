$(document).delegate('.js-all-mail', 'click', function () {
    var $checkboxes = $('.js-sent-mail-table .js-mail-item');
    $checkboxes.prop('checked', this.checked);
    setButtonDisabled();
});

$(document).delegate('.js-mail-item', 'click', function () {
    setButtonDisabled();
});

$(document).delegate('.js-delete-mail-button', 'click', function (e) {
    e.preventDefault();
    var ids = $('.js-sent-mail-table .js-mail-item').filter(':checked').map(function () {
        return $(this).data("id");
    }).get().join('_');
    $.get('/site/delete-mail', {ids: ids}, function (data) {
        if ('status' in data && data.status == 1) {
            if ($('#mail-table-pjax').length) {
                $.pjax.reload({container: '#mail-table-pjax', async: false});
            }
        }
    }, 'json');
});

$(document).delegate('.js-link-view', 'click', function (e) {
    e.preventDefault();
    var id = $(this).data('id');
    if (id) {
        $.get('/site/get-mail-data', {id: id}, function (data) {
            if ('status' in data && data.status == 1) {
                var $modal = $('#mail-data');
                $modal.find('.js-modal-body').html(data.html);
                $modal.modal();
            }
        }, 'json');
    }
});


function setButtonDisabled() {
    var $activeCheckboxes = $('.js-sent-mail-table .js-mail-item').filter(':checked');
    var $button = $('.js-delete-mail-button');
    if ($activeCheckboxes.length) {
        $button.removeClass('disabled');
    } else {
        $button.addClass('disabled');
    }
}