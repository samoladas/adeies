// Attach an event listener to the form's submit button to prevent the form from submitting normally:
// get a reference to the form and submit button
const form = document.querySelector('form');

//if (!form) {
// console.error('Unable to find form element');
//  return;
//}

const submitBtn = form.querySelector('button[type="submit"]');
const content = document.querySelector('.content');



// attach an event listener to the submit button
submitBtn.addEventListener('click', function (event) {
  // prevent the form from submitting normally
  event.preventDefault();

  /// Get the form data and submit it to a PHP script using fetch:
  // get the form data
  const formData = new FormData(form);

  // configure the request
  const requestOptions = {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: new URLSearchParams(formData)
  };

  fetch('add_new.php', requestOptions)
    .then(response => {
      if (!response.ok) {
        throw new Error('Network response was not ok');
      }
      return response.text();
    })
    .then(data => {
      console.log('Response:', data);
      content.innerHTML = '<p>' + data + '</p>';
    })
    .catch(error => {
      console.error('Error:', error);
      content.innerHTML = '<p>There was an error processing your request. Please try again later.</p>';
    });
});
