<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat logs</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <link rel="stylesheet" href="../../css/modal-form.css">
    <link rel="stylesheet" href="../../css/admin_ofw.css">
    <link rel="stylesheet" href="../../css/nav_float.css">
</head>
<body>

<!-- Navigation -->
<nav>
    <div class="logo">
        <img src="../../img/logo_peso.png" alt="Logo">
        <a href="#"> PESO-lb.ph</a>
    </div>

    <header>
      <h1 class="ofw-h1">Admin Chat Page</h1>
    </header>

    <div class="profile-icons">
        <div class="notif-icon" data-bs-toggle="popover" data-bs-content="#" data-bs-placement="bottom">
            <img id="#" src="../../img/notif.png" alt="Profile Picture" class="rounded-circle">
        </div>
        
        <div class="profile-icon-admin" data-bs-toggle="popover" data-bs-placement="bottom">
    <?php if (!empty($row['photo'])): ?>
        <img id="preview" src="php/applicant/images/<?php echo $row['photo']; ?>" alt="Profile Image" class="circular--square">
    <?php else: ?>
        <img src="../../img/user-placeholder.png" alt="Profile Picture" class="rounded-circle">
    <?php endif; ?>
    </div>


    </div>

    <!-- Burger icon -->
    <div class="burger" id="burgerToggle">
        <span></span>
        <span></span>
        <span></span>
    </div>

    <!-- Offcanvas Menu -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasMenu" aria-labelledby="offcanvasMenuLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasMenuLabel">Menu</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <table class="menu">
                <tr><td><a href="admin_home.php" class="nav-link">Home</a></td></tr>
                <tr><td><a href="employer_list.php" class="nav-link">Employer List</a></td></tr>
                <tr><td><a href="course_list.php" class="nav-link">Course List</a></td></tr>
                <tr><td><a href="ofw_case.php" class="active nav-link">OFW Cases</a></td></tr>
            </table>
        </div>
    </div>
</nav>

<nav class="bcrumb-container d-flex justify-content-between align-items-center" aria-label="breadcrumb">
    <div>
      <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="admin_home.php">Home</a></li>
        <li class="breadcrumb-item"><a href="ofw_case.php">OFW Cases</a></li>
        <li class="breadcrumb-item active" aria-current="page">Chat Logs</li>
      </ol>
    </div>
    <a href="javascript:history.back()" class="return me-2">
      <i class="fas fa-reply"></i> Back
    </a>
</nav>

<h1>Customer Messages</h1>
<table class="table table-borderless">
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
        <button class="btn btn-primary" onclick="sendReply()">Send Reply</button>
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

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../../javascript/script.js"></script> 
</body>
</html>
