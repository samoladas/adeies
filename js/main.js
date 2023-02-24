var menuLinks = document.querySelectorAll('.pure-menu-item a');

menuLinks.forEach(function (link) {
    link.addEventListener('click', function (e) {
        e.preventDefault();
        var page = this.getAttribute('href');

        fetch(page)
            .then(response => response.text())
            .then(html => {
                var contentDiv = document.querySelector('.content');
                contentDiv.innerHTML = html;
            })
            .catch(error => console.log(error));
    });
});

/*function updateContent() {
    fetch('my-script.js')
        .then(response => response.text())
        .then(scriptText => {
            var script = document.createElement('script');
            script.textContent = scriptText;
            document.head.appendChild(script);

            var contentDiv = document.querySelector('.content');
            contentDiv.innerHTML = '<p>New content here</p>';
        })
        .catch(error => console.error(error));
}*/