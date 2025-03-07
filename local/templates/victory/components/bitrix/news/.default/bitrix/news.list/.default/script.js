document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.btn-delete').forEach(function(button) {
        button.addEventListener('click', function() {
            var elementId = this.getAttribute('data-element-id');
            if (confirm('Вы уверены, что хотите удалить этот элемент?')) {
                // Получаем bitrix_sessid из скрытого поля
                var sessid = document.querySelector('input[name="sessid"]').value;

                fetch('/local/ajax/deleteElement.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'elementId=' + elementId + '&sessid=' + sessid
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Элемент успешно удален');
                            // Удаляем элемент из DOM
                            document.querySelector('.news-item[data-element-id="' + elementId + '"]').remove();
                        } else {
                            alert('Ошибка при удалении элемента: ' + data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Ошибка:', error);
                    });
            }
        });
    });
});