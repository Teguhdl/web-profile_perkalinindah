<script>
    const mobileMenuBtn = document.getElementById('mobile-menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');
    const header = document.getElementById('main-header');
    const logo = document.getElementById('main-logo');
    const navLinks = document.querySelectorAll('.nav-link');
    const mobileButtonIcon = document.getElementById('mobile-menu-icon');

    const dropdownBtnDesktop = document.getElementById('dropdown-btn-desktop');
    const dropdownMenuDesktop = document.getElementById('dropdown-menu-desktop');

    const dropdownBtnMobile = document.getElementById('dropdown-btn-mobile');
    const dropdownMenuMobile = document.getElementById('dropdown-menu-mobile');
    const dropdownIconMobile = document.getElementById('dropdown-icon-mobile');

    // hero auto detect
    const heroSection = document.querySelector('.hero-bg');

    let isMobileMenuOpen = false;

    function updateColors(color) {
        navLinks.forEach(link => {
            link.classList.remove('text-white', 'text-black');
            link.classList.add(`text-${color}`);
        });

        mobileButtonIcon.classList.remove('text-white', 'text-black');
        mobileButtonIcon.classList.add(`text-${color}`);
    }

    function setHeaderTransparent() {
        header.classList.remove('bg-white', 'shadow-lg');
        header.classList.add('bg-transparent');
        updateColors("white");
        logo.src = "{{ asset('assets/web/logo.png') }}";
    }

    function setHeaderWhite() {
        header.classList.add('bg-white', 'shadow-lg');
        header.classList.remove('bg-transparent');
        updateColors("black");
        logo.src = "{{ asset('assets/web/logo_black.png') }}";
    }

    // INTERSECTION OBSERVER
    const observer = new IntersectionObserver(
        (entries) => {
            if (isMobileMenuOpen) return; // Jangan override jika menu mobile terbuka

            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    setHeaderTransparent();
                } else {
                    setHeaderWhite();
                }
            });
        },
        { threshold: 0.2 }
    );

    if (heroSection) observer.observe(heroSection);


    // MOBILE MENU TOGGLE
    mobileMenuBtn.addEventListener('click', () => {
        mobileMenu.classList.toggle('hidden');
        mobileMenu.classList.toggle('opacity-0');
        mobileMenu.classList.toggle('opacity-100');

        isMobileMenuOpen = !isMobileMenuOpen;

        if (isMobileMenuOpen) {
            setHeaderWhite();
        } else {
            const heroRect = heroSection.getBoundingClientRect();

            if (heroRect.top < 0) {
                setHeaderWhite();
            } else {
                setHeaderTransparent();
            }
        }
    });


    // DESKTOP DROPDOWN
    if (dropdownBtnDesktop) {
        dropdownBtnDesktop.addEventListener('click', () => {
            dropdownMenuDesktop.classList.toggle('hidden');
        });
    }

    // MOBILE DROPDOWN
    if (dropdownBtnMobile) {
        dropdownBtnMobile.addEventListener('click', () => {
            dropdownMenuMobile.classList.toggle('hidden');
            dropdownIconMobile.classList.toggle('rotate-180');
        });
    }
</script>
