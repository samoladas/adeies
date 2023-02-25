// Get the modal
var modal = document.getElementById("myModal");

// Get the button that opens the modal
var btn = document.getElementById("modal-button");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// Get the OK button inside the modal
var confirmButton = document.getElementById("confirm-button");


//const value = this.getAttribute("data-value");


// When the user clicks the button, open the modal 
btn.onclick = function() {
    modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}

// When the user clicks the OK button, make a request to insert.php
confirmButton.onclick = function() {
    // Get the value from the link's data-value attribute
    
    // var value = confirmButton.dataset.value;
    const value = document.getElementById("modal-link").getAttribute("data-value");
    
    // Make a request to insert.php with the value as a parameter
    fetch("confirm.php?value=" + value)
        .then(function(response) {
            // Check if the request was successful
            if (response.ok) {
                console.log("Insert successful!");
            } else {
                console.log("Insert failed!");
            }
        })
        .catch(function(error) {
            console.log(error);
        });

    // Close the modal
    modal.style.display = "none";
}
