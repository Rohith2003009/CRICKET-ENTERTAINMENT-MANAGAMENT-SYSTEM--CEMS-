document.addEventListener('DOMContentLoaded', function () {
    const dropdowns = document.querySelectorAll('.dropdown');
    const navbar = document.querySelector('.navbar');

    // Handle dropdown menu toggling
    dropdowns.forEach(function (dropdown) {
        const toggle = dropdown.querySelector('.dropdown-toggle');
        const menu = dropdown.querySelector('.dropdown-menu');

        toggle.addEventListener('click', function (event) {
            event.stopPropagation();

            // Toggle current dropdown
            const isDropdownOpen = menu.classList.toggle('show');
            const arrow = this.querySelector('.arrow i');
            if (arrow) {
                arrow.style.transform = isDropdownOpen ? 'rotate(180deg)' : 'rotate(0deg)';
            }

            // Expand the navbar if any dropdown is opened
            const anyDropdownOpen = Array.from(dropdowns).some(d => d.querySelector('.dropdown-menu').classList.contains('show'));
            if (anyDropdownOpen) {
                navbar.classList.add('expanded');
            } else {
                navbar.classList.remove('expanded');
            }

            // Close other dropdowns
            dropdowns.forEach(function (d) {
                const otherMenu = d.querySelector('.dropdown-menu');
                if (d !== dropdown) {
                    otherMenu.classList.remove('show');
                    const otherArrow = d.querySelector('.arrow i');
                    if (otherArrow) {
                        otherArrow.style.transform = 'rotate(0deg)';
                    }
                }
            });
        });
    });

    // Close dropdowns when clicking outside
    document.addEventListener('click', function (event) {
        dropdowns.forEach(function (dropdown) {
            const menu = dropdown.querySelector('.dropdown-menu');
            if (menu.classList.contains('show') && !dropdown.contains(event.target)) {
                menu.classList.remove('show');
                const arrow = dropdown.querySelector('.arrow i');
                if (arrow) {
                    arrow.style.transform = 'rotate(0deg)';
                }
            }
        });

        // Collapse navbar if no dropdowns are open
        if (navbar.classList.contains('expanded') && !Array.from(dropdowns).some(d => d.querySelector('.dropdown-menu').classList.contains('show'))) {
            navbar.classList.remove('expanded');
        }
    });
});
