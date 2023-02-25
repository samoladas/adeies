<!DOCTYPE html>
<html>
<head>
    <title>Modal Example</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/purecss@3.0.0/build/pure-min.css"
        integrity="sha384-X38yfunGUhNzHpBaEBsWLO+A0HDYOQi8ufWDkZ0k9e0eXz/tH3II7uKZ9msv++Ls" crossorigin="anonymous">
    <link rel="stylesheet" href="modal.css">
</head>
<body>
    <h1>Modal Example</h1>
    <p>Click the button below to open the modal:</p>
    <button id="modal-button" class="btn">Open Modal</button>

    <!-- The modal -->
    <div id="myModal" class="modal">
        <!-- Modal content -->
        <div class="modal-content">
            <span class="close">&times;</span>
            <p>Are you sure you want to do this?</p>
            <button id="confirm-button" class="btn" data-value="one">OK</button>
        </div>
    </div>

    <script src="modal.js"></script>
</body>
</html>

