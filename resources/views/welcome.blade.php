<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Google Sheets Form</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <script>
        function submitForm(e) {
            e.preventDefault();
            var form = document.getElementById("myForm");
            var formData = new FormData(form);
            var jsonObject = {};

            // Convert FormData to JSON
            formData.forEach((value, key) => {
                jsonObject[key] = value;
            });

            var fileInput = document.getElementById("image");
            var file = fileInput.files[0];

            if (file) {
                var reader = new FileReader();
                reader.onloadend = function() {
                    jsonObject["image"] = reader.result.split(',')[1]; // Extract Base64 Data
                    sendData(jsonObject);
                };
                reader.readAsDataURL(file);
            } else {
                sendData(jsonObject);
            }
        }

        function sendData(data) {
            fetch("https://script.google.com/macros/s/AKfycbzwCezEAGXeoDH6Mzf6zvD4pdQ6kjOc2dbSOec9vf3r-XynS_fxsFJu9sq3vLZAOTSWKg/exec", {
                    method: "POST",
                    body: JSON.stringify(data),
                    headers: {
                        "Content-Type": "application/json"
                    }
                })
                .then(response => response.text())
                .then(data => {
                    alert("Success: " + data);
                    document.getElementById("myForm").reset();
                })
                .catch(error => console.error('Error:', error));
        }
    </script>

    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f8f9fa;
        }

        .card {
            width: 100%;
            max-width: 450px;
            padding: 20px;
        }
    </style>
</head>

<body>

    <div class="card shadow p-4">
        <h4 class="text-center mb-3">Submit Your Details</h4>
        <form id="myForm" onsubmit="submitForm(event)">
            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Message</label>
                <textarea name="message" class="form-control" rows="3" required></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Upload Image</label>
                <input type="file" id="image" name="image" class="form-control" accept="image/*">
            </div>

            <button type="submit" class="btn btn-primary w-100">Submit</button>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
