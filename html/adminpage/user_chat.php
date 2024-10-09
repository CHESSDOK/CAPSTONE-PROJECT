<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat logs</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="../../css/modal-form.css">
    <link rel="stylesheet" href="../../css/admin_ofw.css">
    <link rel="stylesheet" href="../../css/nav_float.css">
        <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }
        #chat {
            display: none;
            margin-top: 20px;
        }
        .message {
            margin: 5px 0;
        }
        .user-message {
            color: blue;
        }
        .admin-reply {
            color: green;
        }
    </style>
</head>
<body>

<!-- Navigation -->
<nav>
    <div class="logo">
        <img src="../../img/logo_peso.png" alt="Logo">
        <a href="#"> PESO-lb.ph</a>
    </div>
    <!-- Other navigation elements -->
</nav>

<nav class="bcrumb-container" aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="admin_home.php">Home</a></li>
    <li class="breadcrumb-item"><a href="ofw_case.php">OFW Cases</a></li>
    <li class="breadcrumb-item active" aria-current="page">Chat Logs</li>
  </ol>
</nav>

<h1>Customer Messages</h1>
<table>
    <thead>
        <tr>
            <th>Customer Name</th>
            <th>Message Count</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody id="customerTable"></tbody>
</table>

<div id="chat" class="modal">
    <div class="modal-content">
        <span class="closeBtn">&times;</span>
        <h3 id="chatTitle"></h3>
        <div id="messageList"></div>
        <input type="text" id="replyMessage" placeholder="Type your reply here...">
        <button onclick="sendReply()">Send Reply</button>
    </div>
</div>
</div>

<script>
    let selectedCustomerId = null; // To hold the ID of the selected customer

    function fetchCustomers() {
        fetch('get_customers.php')
            .then(response => response.json())
            .then(data => {
                const tableBody = document.getElementById('customerTable');
                tableBody.innerHTML = ''; // Clear existing data
                data.forEach(customer => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${customer.first_name}</td>
                        <td>${customer.message_count}</td>
                        <td><button onclick="viewMessages(${customer.user_id}, '${customer.first_name}')">View Messages</button></td>
                    `;
                    tableBody.appendChild(row);
                });
            });
    }

    function viewMessages(customerId, customerName) {
        selectedCustomerId = customerId;
        document.getElementById('chat').style.display = 'block';
        document.getElementById('chatTitle').innerText = `Messages from ${customerName}`;
        fetch(`get_messages.php?customer_id=${customerId}`)
            .then(response => response.json())
            .then(data => {
                const messageList = document.getElementById('messageList');
                messageList.innerHTML = ''; // Clear existing messages
                data.forEach(msg => {
                    const messageDiv = document.createElement('div');
                    messageDiv.className = 'message';
                    
                    if (msg.sender === 'user') {
                        messageDiv.innerHTML = `<span class="user-message">${msg.message} (User)</span>`;
                    } else {
                        messageDiv.innerHTML = `<span class="admin-reply">${msg.message} (Admin)</span>`;
                    }

                    messageList.appendChild(messageDiv);
                });
            });
    }

    function sendReply() {
        const replyMessage = document.getElementById('replyMessage').value;

        if (replyMessage && selectedCustomerId) {
            fetch('send_reply.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `customer_id=${selectedCustomerId}&message=${encodeURIComponent(replyMessage)}`
            })
            .then(response => response.text())
            .then(() => {
                document.getElementById('replyMessage').value = ''; // Clear input
                // Refresh messages to include the reply
                viewMessages(selectedCustomerId, document.getElementById('chatTitle').innerText.split(' ')[2]);
            });
        }
    }

    fetchCustomers(); // Fetch customers on page load
    const closeBtn = document.querySelector('.closeBtn');
    closeBtn.addEventListener('click', function() {
        document.getElementById('chat').style.display = 'none';
    });
    window.addEventListener('click', function(event) {
        if (event.target === document.getElementById('chat')) {
            document.getElementById('chat').style.display = 'none';
        }
    });
</script>
</body>
</html>
