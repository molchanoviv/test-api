$(document).ready(
    function ()
    {
        //confirmation dialog
        $('.confirmation').on(
            'click', function (e)
            {
                var confirmDialog = $('#confirmation-dialog');
                var title = $(this).data('confirm-title');
                if (undefined !== title) {
                    confirmDialog.find('.modal-title').text(title);
                }
                var text = $(this).data('confirm-text');
                if (undefined !== text) {
                    confirmDialog.find('.modal-body').text(text);
                }
                confirmDialog.find('.yes-button').attr('href', $(this).attr('href'));
                confirmDialog.modal('show');
                e.preventDefault();
                return false;
            }
        );
    }
);
