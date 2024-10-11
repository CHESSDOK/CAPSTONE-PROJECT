// Get elements
const burgerToggle = document.getElementById('burgerToggle');
const offcanvasMenu = new bootstrap.Offcanvas(document.getElementById('offcanvasMenu'));

// Toggle burger class and offcanvas menu
burgerToggle.addEventListener('click', function() {
    // Toggle burger active class for animation
    burgerToggle.classList.toggle('active');

    // Open or close the offcanvas menu
    if (offcanvasMenu._isShown) {
        offcanvasMenu.hide();
    } else {
        offcanvasMenu.show();
    }
});

$(document).ready(function(){
    // Initialize popover with multiple links in the content
    $('.profile-icon-admin').popover({
        trigger: 'click', 
        html: true, // Allow HTML content
        animation: true, // Enable animation
        content: function() {
            return `
                <a class="link" href="admin_profile.php"  id="emprof">Profile</a><br>
                <a class="link" href="logout.php">Logout</a>
            `;
        }
    });
// Close popover when clicking outside
$(document).on('click', function (e) {
    const target = $(e.target);
    if (!target.closest('.profile-icon').length) {
        $('.profile-icon').popover('hide');
    }
});
});

$(document).ready(function(){
    // Initialize popover with multiple links in the content
    $('.profile-icon').popover({
        trigger: 'click', 
        html: true, // Allow HTML content
        animation: true, // Enable animation
        content: function() {
            return `
                <a class="link" href="html/applicant/a_profile.php"  id="emprof">Profile</a><br>
                <a class="link" href="logout.php">Logout</a>
            `;
        }
    });
// Close popover when clicking outside
$(document).on('click', function (e) {
    const target = $(e.target);
    if (!target.closest('.profile-icon').length) {
        $('.profile-icon').popover('hide');
    }
});
});

$(document).ready(function(){
    // Initialize popover with multiple links in the content
    $('.profile-icon-employer').popover({
        trigger: 'click', 
        html: true, // Allow HTML content
        animation: true, // Enable animation
        content: function() {
            return `
                <a class="link" href="employer_profile.php"  id="emprof">Profile</a><br>
                <a class="link" href="logout.php">Logout</a>
            `;
        }
    });
// Close popover when clicking outside
$(document).on('click', function (e) {
    const target = $(e.target);
    if (!target.closest('.profile-icon-employer').length) {
        $('.profile-icon-employer').popover('hide');
    }
});
});

document.getElementById("loginButton").addEventListener("click", function (event) {
    event.preventDefault(); // Prevent default link behavior

    // Change the URL after the transition ends
    setTimeout(function () {
        window.location.href = "html/login.html";
    }, 300); // Adjust the delay according to your transition duration

    // Adding the class to initiate the fade-in and slide-up animation
    document.body.classList.add('fade-in');
});

document.getElementById("signup").addEventListener("click", function (event) {
    event.preventDefault(); // Prevent default link behavior

    // Change the URL after the transition ends
    setTimeout(function () {
        window.location.href = "../html/register.html";
    }, 300); // Adjust the delay according to your transition duration

    // Adding the class to initiate the fade-in and slide-up animation
    document.body.classList.add('fade-in');
});

//applicant search
const searchInput = document.getElementById('search-input');
const clearBtn = document.getElementById('clear-btn');

// Show the clear button when there's input
searchInput.addEventListener('input', function() {
  clearBtn.style.display = this.value ? 'block' : 'none';
});

// Clear the input when the clear button is clicked
clearBtn.addEventListener('click', function() {
  searchInput.value = '';
  clearBtn.style.display = 'none';
  searchInput.focus();
});