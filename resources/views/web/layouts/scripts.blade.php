<script>
(() => {
  const header = document.getElementById('main-header');
  const mobileMenuBtn = document.getElementById('mobile-menu-btn');
  const mobileMenu = document.getElementById('mobile-menu');
  const menuIconOpen = document.querySelector('.menu-icon-open');
  const menuIconClose = document.querySelector('.menu-icon-close');
  const heroSection = document.getElementById('beranda');

  let isMobileMenuOpen = false;

  // Header Scroll Logic
  function updateHeaderScroll() {
    // Jika tidak ada heroSection (di subpage), header harus selalu solid
    if (!heroSection || window.scrollY > 40) {
      header.classList.add('cke-hd--solid');
    } else {
      if (!isMobileMenuOpen) {
        header.classList.remove('cke-hd--solid');
      }
    }
  }

  // Initial check and scroll event
  updateHeaderScroll();
  window.addEventListener('scroll', updateHeaderScroll, { passive: true });

  // Mobile Menu Toggle
  if (mobileMenuBtn && mobileMenu) {
    mobileMenuBtn.addEventListener('click', () => {
      isMobileMenuOpen = !isMobileMenuOpen;
      
      mobileMenu.classList.toggle('hidden');
      
      // Delay opacity transition slightly for smooth effect
      setTimeout(() => {
        mobileMenu.classList.toggle('opacity-0');
        mobileMenu.classList.toggle('opacity-100');
      }, 10);
      
      // Toggle icons
      if (menuIconOpen) menuIconOpen.classList.toggle('hidden');
      if (menuIconClose) menuIconClose.classList.toggle('hidden');

      // Force solid header when mobile menu is open
      if (isMobileMenuOpen) {
        header.classList.add('cke-hd--solid');
      } else {
        updateHeaderScroll();
      }
    });

    // Close when clicking outside
    document.addEventListener('click', (e) => {
      if (!isMobileMenuOpen) return;
      if (!mobileMenu.contains(e.target) && !mobileMenuBtn.contains(e.target)) {
        isMobileMenuOpen = false;
        mobileMenu.classList.add('opacity-0');
        mobileMenu.classList.remove('opacity-100');
        
        setTimeout(() => {
            mobileMenu.classList.add('hidden');
        }, 300); // match transition duration
        
        if (menuIconOpen) menuIconOpen.classList.remove('hidden');
        if (menuIconClose) menuIconClose.classList.add('hidden');
        
        updateHeaderScroll();
      }
    });
  }

  // Desktop Dropdown
  document.querySelectorAll('nav .relative').forEach(parent => {
    const btn = parent.querySelector('button, a');
    const menu = parent.querySelector('.dropdown-menu');

    if (!btn || !menu) return;

    // Hover logic via JS for safety (can also be group-hover)
    parent.addEventListener('mouseenter', () => {
        menu.classList.remove('hidden');
    });
    
    parent.addEventListener('mouseleave', () => {
        menu.classList.add('hidden');
    });
  });

  // Mobile Dropdown
  document.querySelectorAll('.mobile-dropdown-btn').forEach(btn => {
    btn.addEventListener('click', (e) => {
        e.preventDefault();
        const menu = btn.nextElementSibling;
        if(menu && menu.classList.contains('mobile-dropdown-menu')) {
            menu.classList.toggle('hidden');
            const svg = btn.querySelector('svg');
            if (svg) {
              if(menu.classList.contains('hidden')) {
                  svg.style.transform = 'rotate(0deg)';
              } else {
                  svg.style.transform = 'rotate(180deg)';
              }
              svg.style.transition = 'transform 0.3s ease';
            }
        }
    });
  });

  // Auto Scroll to Contact on Success
  const hasFeedback = document.querySelector('.cke-contact__success') || document.querySelector('.cke-danger-bg') || document.querySelector('.bg-green-100') || document.querySelector('.bg-red-100');
  if (hasFeedback) {
    const contactSection = document.getElementById('kontak');
    if (contactSection) {
        setTimeout(() => {
            contactSection.scrollIntoView({ behavior: 'smooth' });
        }, 300);
    }
  }

})();
</script>
