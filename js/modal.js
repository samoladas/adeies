// Get references to all link elements with class "modal-link"
var links = document.querySelectorAll('.modal-link');

// Get a reference to the modal element
var modal = document.getElementById('myModal');

// Get a reference to the modal body element
var modalBody = document.getElementById('modal-body');

// Attach an event listener to each link
links.forEach(function(link) {
  link.addEventListener('click', function(event) {
    event.preventDefault(); // Prevent the link from being followed

    // Get the data-value attribute of the link
    var dataValue = link.getAttribute('data-value');

    // Fetch the PHP file with the idleaves parameter
    fetch('confirm.php?idleaves=' + dataValue)
      .then(response => response.text()) // Parse the response as text
      .then(data => {
        // Set the modal content to the response
        modalBody.innerHTML = data;

        // Show the modal
        modal.style.display = 'block';
      })
      .catch(error => console.error(error)); // Handle any errors
  });
});

// Get a reference to the close button
var closeButton = document.getElementById('modal-close');

// Attach an event listener to the close button
closeButton.addEventListener('click', function() {
    console.log('close button clicked');

  // Hide the modal
  modal.style.display = 'none';
  // Delay the page refresh by 500 milliseconds
  setTimeout(function() {
    window.location.reload(true);
  }, 200);

});

// Attach an event listener to the modal window
window.addEventListener('click', function(event) {
  if (event.target == modal) {
    // Hide the modal if the user clicks outside of it
    modal.style.display = 'none';
  }
});
