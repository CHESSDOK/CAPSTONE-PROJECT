<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing Page</title>
    
    <!-- External Stylesheets -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.typekit.net/your-font-kit-id.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/guest_dashbaord.css">

    <!-- Internal Stylesheet -->
    <style>
        .news-embed {
            width: 100%;
            max-width: 30vw;
            height: 50vh;
            border: 1px solid #ccc;
        }
    </style>
</head>

<body>
    <!-- Navigation -->
    <nav>
        <div class="logo">
            <img src="img/logo_peso.png" alt="Logo">
            <a href="#"> PESO-lb.ph</a>
        </div>

        <div class="profile-icons">
            <div class="notif-icon" data-bs-toggle="popover" data-bs-content="Notification" data-bs-placement="bottom">
                <img id="#" src="img/notif.png" alt="Profile Picture" class="rounded-circle">
            </div>
            <div class="profile-icon" data-bs-toggle="popover_index" data-bs-content="Login/Register" data-bs-placement="bottom">
                <img src="img/user-placeholder.png" alt="Profile Picture" class="rounded-circle">
            </div>
        </div>

        <!-- Burger icon -->
        <div class="burger" id="burgerToggle">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </nav>

    <!-- Offcanvas Menu -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasMenu" aria-labelledby="offcanvasMenuLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasMenuLabel">Menu</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <table class="menu">
                <tr>
                    <td><a href="#" class="active nav-link">Home</a></td>
                </tr>
                <tr>
                    <td><a href="html/about.php" class="nav-link">About Us</a></td>
                </tr>
                <tr>
                    <td><a href="html/contact.php" class="nav-link">Contact Us</a></td>
                </tr>
            </table>
        </div>
    </div>

    <!-- Body -->
    <div class="main-container">
        <div class="row">
            <!-- Left Panel -->
            <div class="left-panel">
                <div class="container">
                    <!-- PESO Info -->
                    <div class="row text-center">
                        <div class="col">
                            <div class="d-flex flex-column align-items-center">
                                <div class="d-flex align-items-end">
                                    <label class="txt1 me-1">PESO</label>
                                    <label class="txt2">Los Baños</label>
                                </div>
                                <label class="txt3">Public Employment Service Office</label>
                            </div>
                        </div>
                    </div>

                    <!-- Search -->
                    <div class="d-flex position-relative mt-3">
                        <div class="d-flex position-relative">
                            <!-- Search Input -->
                            <input type="text" id="search-input" name="search" class="form-control ps-5 pe-5" placeholder="Search for a job..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">

                            <!-- Search Icon -->
                            <span class="position-absolute search-icon" style="left: 10px; top: 50%; transform: translateY(-50%);">
                                <i class="fa fa-search"></i>
                            </span>

                            <!-- Clear Icon -->
                            <span class="position-absolute clear-icon" style="right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer;" onclick="clearSearch()">
                                <i class="fa fa-times"></i>
                            </span>
                        </div>

                        <!-- Search Button -->
                        <button type="submit" class="btn btn-primary">Search</button>
                    </div>

                    <!-- Tagline -->
                    <div class="mt-2 text-center">
                        <label class="txt4">YOUR <span class="txt4-highlight">NEW CAREER</span> STARTS HERE!!</label>
                    </div>
                </div>

                    <!-- News Embed -->
                    <iframe class="news-embed news-link mt-2" src="https://www.gmanetwork.com/news/" frameborder="0"></iframe>
                
            </div>

            <!-- Right Panel -->
            <div class="col-md-6 right-panel">
                <div class="container">
                    <div class="row">
                        <!-- Additional Field -->
                        <div class="col-md-6">
                            <div class="container">
                                <h1>Additional Field</h1>
                                <p>This is the additional field on the left.</p>
                            </div>
                        </div>

                        <!-- Stacked Containers -->
                        <div class="col-md-6">
                            <div class="container">
                                <h1>First Container</h1>
                                <p>This is the first container.</p>
                            </div>
                            <div class="container">
                                <h1>Second Container</h1>
                                <p>This is the second container.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Custom Scripts -->
    <script>
        $(document).ready(function() {
            // Initialize popover
            $('.profile-icon').popover({
                trigger: 'click',
                html: true,
                animation: true,
                content: function() {
                    return `
                        <a class="link">Profile</a><br>
                        <a class="link" href="html/combine_login.html" id="link3">Login</a>
                    `;
                }
            });

            // Close popover when clicking outside
            $(document).on('click', function(e) {
                if (!$(e.target).closest('.profile-icon').length) {
                    $('.profile-icon').popover('hide');
                }
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('search-input');
            const clearIcon = document.querySelector('.clear-icon');

            // Show clear icon based on input value
            clearIcon.style.display = searchInput.value ? 'block' : 'none';

            searchInput.addEventListener('input', function() {
                clearIcon.style.display = this.value ? 'block' : 'none';
            });
        });

        function clearSearch() {
            document.getElementById('search-input').value = '';
            document.querySelector('.clear-icon').style.display = 'none';
            document.getElementById('search-input').focus();
        }
    </script>
    <script src="javascript/script.js"></script>
</body>

</html>
