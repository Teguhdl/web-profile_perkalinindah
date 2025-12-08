<script>
/*
  Universal dropdown handler (works with the dynamic menu markup).
  - Detects desktop dropdowns: any .relative container that has a child dropdown div.
  - Detects mobile dropdowns: any button inside #mobile-menu whose nextElementSibling is the submenu block.
  - Keeps existing behavior for mobile menu toggle, header color switch, hero intersection observer.
  - Safely guards when elements aren't present.
*/

(() => {
  const mobileMenuBtn = document.getElementById('mobile-menu-btn');
  const mobileMenu = document.getElementById('mobile-menu');
  const header = document.getElementById('main-header');
  const logo = document.getElementById('main-logo');
  const navLinks = document.querySelectorAll('.nav-link');
  const mobileButtonIcon = document.getElementById('mobile-menu-icon');

  // Hero auto detect
  const heroSection = document.querySelector('.hero-bg');

  let isMobileMenuOpen = false;

  function updateColors(color) {
    navLinks.forEach(link => {
      link.classList.remove('text-white', 'text-black');
      link.classList.add(`text-${color}`);
    });

    if (mobileButtonIcon) {
      mobileButtonIcon.classList.remove('text-white', 'text-black');
      mobileButtonIcon.classList.add(`text-${color}`);
    }
  }

  function setHeaderTransparent() {
    if (!header) return;
    header.classList.remove('bg-white', 'shadow-lg');
    header.classList.add('bg-transparent');
    updateColors("white");
    if (logo) logo.src = "{{ asset('assets/web/logo/logo.png') }}";
  }

  function setHeaderWhite() {
    if (!header) return;
    header.classList.add('bg-white', 'shadow-lg');
    header.classList.remove('bg-transparent');
    updateColors("black");
    if (logo) logo.src = "{{ asset('assets/web/logo/logo_black.png') }}";
  }

  // Intersection observer only if hero exists
  if (heroSection && 'IntersectionObserver' in window) {
    const observer = new IntersectionObserver(
      (entries) => {
        if (isMobileMenuOpen) return; // don't override when mobile menu open
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
    observer.observe(heroSection);
  } else {
    // fallback: start white
    setHeaderWhite();
  }

  // MOBILE MENU TOGGLE (kept behavior)
  if (mobileMenuBtn && mobileMenu) {
    mobileMenuBtn.addEventListener('click', () => {
      mobileMenu.classList.toggle('hidden');
      mobileMenu.classList.toggle('opacity-0');
      mobileMenu.classList.toggle('opacity-100');

      isMobileMenuOpen = !isMobileMenuOpen;

      if (isMobileMenuOpen) {
        setHeaderWhite();
      } else {
        if (heroSection) {
          const heroRect = heroSection.getBoundingClientRect();
          if (heroRect.top < 0) {
            setHeaderWhite();
          } else {
            setHeaderTransparent();
          }
        } else {
          setHeaderWhite();
        }
      }
    });

    // Close mobile menu when clicking outside
    document.addEventListener('click', (e) => {
      if (!isMobileMenuOpen) return;
      if (!mobileMenu.contains(e.target) && !mobileMenuBtn.contains(e.target)) {
        mobileMenu.classList.add('hidden', 'opacity-0');
        mobileMenu.classList.remove('opacity-100');
        isMobileMenuOpen = false;

        // restore header state based on hero
        if (heroSection) {
          const heroRect = heroSection.getBoundingClientRect();
          if (heroRect.top < 0) setHeaderWhite();
          else setHeaderTransparent();
        } else {
          setHeaderWhite();
        }
      }
    });
  }

  // --- DESKTOP DROPDOWN: automatic toggle for parent .relative elements ---
  // Finds <div class="relative"> elements that contain a dropdown <div> (the submenu)
  document.querySelectorAll('nav .relative').forEach(parent => {
    const btn = parent.querySelector('button, a'); // the clickable label
    const menu = Array.from(parent.children).find(c => c !== btn && c.tagName.toLowerCase() === 'div');

    if (!btn || !menu) return;

    // Ensure menu starts hidden (safe)
    menu.classList.add('hidden');

    // Toggle on click
    btn.addEventListener('click', (ev) => {
      ev.stopPropagation();
      // close other open desktop dropdowns
      document.querySelectorAll('nav .relative').forEach(p => {
        const m = Array.from(p.children).find(c => c !== (p.querySelector('button, a')) && c.tagName.toLowerCase() === 'div');
        if (m && m !== menu) m.classList.add('hidden');
      });

      menu.classList.toggle('hidden');
    });
  });

  // Close any open desktop dropdown if click outside nav
  document.addEventListener('click', (e) => {
    // if click inside nav, ignore
    const insideNav = e.target.closest('nav');
    if (!insideNav) {
      document.querySelectorAll('nav .relative').forEach(parent => {
        const menu = Array.from(parent.children).find(c => c !== (parent.querySelector('button, a')) && c.tagName.toLowerCase() === 'div');
        if (menu) menu.classList.add('hidden');
      });
    }
  });

  // Also close desktop dropdowns on Escape key
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
      document.querySelectorAll('nav .relative').forEach(parent => {
        const menu = Array.from(parent.children).find(c => c !== (parent.querySelector('button, a')) && c.tagName.toLowerCase() === 'div');
        if (menu) menu.classList.add('hidden');
      });
      if (isMobileMenuOpen && mobileMenu) {
        mobileMenu.classList.add('hidden', 'opacity-0');
        mobileMenu.classList.remove('opacity-100');
        isMobileMenuOpen = false;
      }
    }
  });

  // --- MOBILE DROPDOWN HANDLER: buttons with submenu (next sibling is the submenu div) ---
  const mobileRoot = document.getElementById('mobile-menu');
  if (mobileRoot) {
    // find buttons inside mobile menu whose nextElementSibling is the submenu block (we detect by checking for 'border-l-2' or 'pl-4' class)
    mobileRoot.querySelectorAll('button').forEach(btn => {
      const next = btn.nextElementSibling;
      if (!next) return;

      const isSubMenu = next.classList && (next.classList.contains('border-l-2') || next.classList.contains('pl-4') || next.classList.contains('ml-1'));
      if (!isSubMenu) return;

      // ensure hidden by default
      next.classList.add('hidden');

      btn.addEventListener('click', (ev) => {
        ev.stopPropagation();
        next.classList.toggle('hidden');

        // handle icon rotation if there's an <svg> inside button
        const svg = btn.querySelector('svg');
        if (svg) {
          svg.classList.toggle('rotate-180');
        }
      });
    });

    // close mobile submenus when clicking outside mobileRoot
    document.addEventListener('click', (e) => {
      if (!mobileRoot.contains(e.target)) {
        mobileRoot.querySelectorAll(':scope > .px-6 .hidden, :scope > .px-6 div').forEach(node => {
          // we only want to close submenu blocks (which have border-l-2 etc). Safer to re-hide any submenu blocks inside mobileRoot
          if (node.classList && (node.classList.contains('pl-4') || node.classList.contains('border-l-2') || node.classList.contains('ml-1'))) {
            node.classList.add('hidden');
          }
        });
      }
    });
  }

})();
</script>
