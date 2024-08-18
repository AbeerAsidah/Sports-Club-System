<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Club Information & Subscription</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            text-align: center;
        }
        .container {
            width: 80%;
            margin: 20px auto;
            background: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        h1 {
            color: #333;
        }
        p {
            color: #555;
            line-height: 1.6;
        }
        form {
            margin-top: 20px;
        }
        label {
            display: block;
            margin: 10px 0 5px;
            text-align: left;
        }
        input, select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }
        button {
            padding: 10px 20px;
            background-color: #28a745;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #218838;
        }
        .message {
            margin-top: 20px;
            font-size: 16px;
            color: green;
        }
        .error {
            color: red;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Welcome to Our Club</h1>
        <p>
            Our club offers a variety of activities and services to our members. 
            Whether you're interested in fitness, sports, or social events, we have something for everyone. 
            Join us today and become a part of our community!
        </p>

        <h2>Subscription Application Form</h2>
        <form id="subscriptionForm">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="phone">Phone:</label>
            <input type="tel" id="phone" name="phone">

            <label for="address">Address:</label>
            <input type="text" id="address" name="address">

            <label for="subscription_type">Subscription Type:</label>
            <select id="subscription_type" name="subscription_type" required>
                <option value="monthly">Monthly</option>
                <option value="quarterly">Quarterly</option>
                <option value="yearly">Yearly</option>
            </select>

            <button type="submit">Subscribe</button>
        </form>

        <div class="message" id="message"></div>
    </div>

    <script>
        document.getElementById('subscriptionForm').addEventListener('submit', function(event) {
            event.preventDefault();

            // Gather form data
            const formData = new FormData(this);

            // Prepare data for API
            const data = {
                name: formData.get('name'),
                email: formData.get('email'),
                phone: formData.get('phone'),
                address: formData.get('address'),
                subscription_type: formData.get('subscription_type')
            };

            // Send data to server using fetch API
            fetch('/api/subscriptions', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('message').textContent = 'Subscription successful!';
                } else {
                    document.getElementById('message').textContent = 'Subscription failed. Please try again.';
                    document.getElementById('message').classList.add('error');
                }
            })
            .catch((error) => {
                console.error('Error:', error);
                document.getElementById('message').textContent = 'An error occurred. Please try again later.';
                document.getElementById('message').classList.add('error');
            });
        });
    </script>

</body>
</html>
