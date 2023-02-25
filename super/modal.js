// Get a reference to the link element
var link = document.getElementById('modal-link');

// Get a reference to the modal element
var modal = document.getElementById('myModal');

// Get a reference to the modal body element
var modalBody = document.getElementById('modal-body');

// Attach an event listener to the link
link.addEventListener('click', function(event) {
  event.preventDefault(); // Prevent the link from being followed

  // Get the data-value attribute of the link
  var dataValue = link.getAttribute('data-value');

  // Fetch the PHP file with the idleaves parameter
  fetch('example.php?idleaves=' + dataValue)
    .then(response => response.text()) // Parse the response as text
    .then(data => {
      // Set the modal content to the response
      modalBody.innerHTML = data;

      // Show the modal
      modal.style.display = 'block';
    })
    .catch(error => console.error(error)); // Handle any errors
});

// Attach an event listener to the modal close button
var closeButton = document.getElementById('modal-close');
closeButton.addEventListener('click', function() {
  // Hide the modal
  modal.style.display = 'none';
});

// Attach an event listener to the modal window
window.addEventListener('click', function(event) {
  if (event.target == modal) {
    // Hide the modal if the user clicks outside of it
    modal.style.display = 'none';
  }
});
