document.addEventListener('DOMContentLoaded', function() {
    var modalLinks = document.querySelectorAll('.modal-link');
    for (var i = 0; i < modalLinks.length; i++) {
        modalLinks[i].addEventListener('click', function(event) {
            event.preventDefault();
            var value = this.dataset.value;
            var modalContent = document.querySelector('.modal-content');
            fetch('insert.php?value=' + value)
                .then(function(response) {
                    if (response.ok) {
                        return response.text();
                    }
                    throw new Error('Network response was not ok');
                })
                .then(function(responseText) {
                    modalContent.innerHTML = 'Done!';
                    var modal = document.querySelector('#myModal');
                    if (modal) {
                        modal.classList.add('is-open');
                    }
                })
                .catch(function(error) {
                    console.error('There was a problem with the fetch operation:', error);
                });
        });
    }
});
