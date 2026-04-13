(function ($) {

  "use strict";

  var searchPopup = function () {
    // Inline header search is now the primary search method
    // Popup-based search is disabled
  }

  // Search Autocomplete
  var initSearchAutocomplete = function () {
    const searchInput = document.querySelector('.header-search-input');
    const searchDropdown = document.getElementById('search-dropdown');

    if (!searchInput || !searchDropdown) return;

    const dropdownContent = searchDropdown.querySelector('.search-dropdown-content');
    let searchTimeout;

    const clearDropdown = function () {
      dropdownContent.replaceChildren();
    };

    const createResultItem = function (options) {
      const link = document.createElement('a');
      link.className = options.className;
      link.href = options.href;

      if (options.iconClass) {
        const icon = document.createElement('div');
        icon.className = options.iconClass;
        icon.textContent = options.iconText;
        link.appendChild(icon);
      }

      if (options.imageSrc) {
        const wrapper = document.createElement('div');
        wrapper.className = 'search-product-img-wrapper';

        const image = document.createElement('img');
        image.className = 'search-product-img';
        image.src = options.imageSrc;
        image.alt = options.title;
        image.addEventListener('error', function () {
          this.src = '/images/placeholder.png';
        });

        wrapper.appendChild(image);
        link.appendChild(wrapper);
      }

      const info = document.createElement('div');
      info.className = 'search-product-info';

      const title = document.createElement('div');
      title.className = 'search-product-name';
      title.textContent = options.title;
      info.appendChild(title);

      if (options.subtitle) {
        const subtitle = document.createElement('div');
        subtitle.className = 'search-product-price';
        subtitle.textContent = options.subtitle;
        info.appendChild(subtitle);
      }

      link.appendChild(info);
      return link;
    };

    searchInput.addEventListener('input', function () {
      clearTimeout(searchTimeout);
      const query = this.value.trim();

      if (query.length < 1) {
        searchDropdown.style.display = 'none';
        clearDropdown();
        return;
      }

      searchTimeout = setTimeout(function () {
        fetch(`/api/search?q=${encodeURIComponent(query)}`)
          .then(response => response.json())
          .then(data => {
            const products = Array.isArray(data) ? data : (data.products || []);
            const categories = Array.isArray(data) ? [] : (data.categories || []);
            const subcategories = Array.isArray(data) ? [] : (data.subcategories || []);
            const fragment = document.createDocumentFragment();

            if (products.length > 0) {
              const section = document.createElement('div');
              section.className = 'search-dropdown-section';

              const title = document.createElement('div');
              title.className = 'search-section-title';
              title.textContent = 'Products';
              section.appendChild(title);

              products.forEach(product => {
                section.appendChild(createResultItem({
                  className: 'search-dropdown-item',
                  href: `/products/${product.id}`,
                  imageSrc: `/images/${product.image}`,
                  title: String(product.name || '').substring(0, 40),
                  subtitle: `₹${Number.parseFloat(product.price).toFixed(2)}`,
                }));
              });

              fragment.appendChild(section);
            }

            if (categories.length > 0) {
              const section = document.createElement('div');
              section.className = 'search-dropdown-section';

              const title = document.createElement('div');
              title.className = 'search-section-title';
              title.textContent = 'Categories';
              section.appendChild(title);

              categories.forEach(category => {
                section.appendChild(createResultItem({
                  className: 'search-dropdown-item search-dropdown-item--category',
                  href: category.url,
                  iconClass: 'search-category-icon',
                  iconText: 'C',
                  title: category.name,
                  subtitle: 'Category',
                }));
              });

              fragment.appendChild(section);
            }

            if (subcategories.length > 0) {
              const section = document.createElement('div');
              section.className = 'search-dropdown-section';

              const title = document.createElement('div');
              title.className = 'search-section-title';
              title.textContent = 'Subcategories';
              section.appendChild(title);

              subcategories.forEach(category => {
                section.appendChild(createResultItem({
                  className: 'search-dropdown-item search-dropdown-item--category',
                  href: category.url,
                  iconClass: 'search-category-icon search-category-icon--alt',
                  iconText: 'S',
                  title: category.name,
                  subtitle: `${category.parent_name ? `${category.parent_name} / ` : ''}Subcategory`,
                }));
              });

              fragment.appendChild(section);
            }

            clearDropdown();

            if (fragment.childNodes.length === 0) {
              const emptyState = document.createElement('div');
              emptyState.className = 'search-no-results';

              const icon = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
              icon.setAttribute('width', '24');
              icon.setAttribute('height', '24');
              icon.setAttribute('viewBox', '0 0 24 24');
              icon.setAttribute('fill', 'none');
              icon.setAttribute('stroke', '#ccc');
              icon.setAttribute('stroke-width', '1.5');

              const circle = document.createElementNS('http://www.w3.org/2000/svg', 'circle');
              circle.setAttribute('cx', '11');
              circle.setAttribute('cy', '11');
              circle.setAttribute('r', '8');

              const line = document.createElementNS('http://www.w3.org/2000/svg', 'line');
              line.setAttribute('x1', '21');
              line.setAttribute('y1', '21');
              line.setAttribute('x2', '16.65');
              line.setAttribute('y2', '16.65');

              icon.appendChild(circle);
              icon.appendChild(line);

              const label = document.createElement('span');
              label.textContent = 'No matches found';

              emptyState.appendChild(icon);
              emptyState.appendChild(label);
              dropdownContent.appendChild(emptyState);
            } else {
              dropdownContent.appendChild(fragment);
            }
            searchDropdown.style.display = 'block';
          })
          .catch(error => console.error('Search error:', error));
      }, 300);
    });

    // Close dropdown when clicking outside
    document.addEventListener('click', function (e) {
      if (!e.target.closest('.header-search-wrapper')) {
        searchDropdown.style.display = 'none';
      }
    });

    // Allow keyboard navigation
    searchInput.addEventListener('keydown', function (e) {
      if (e.key === 'Escape') {
        searchDropdown.style.display = 'none';
      }
    });
  }

  // Preloader
  var removePreloader = function () {
    $('.preloader-wrapper').fadeOut();
    $('body').removeClass('preloader-site');
  }
  var initPreloader = function () {
    var Body = $('body');
    Body.addClass('preloader-site');
    $(window).on('load', removePreloader);
    setTimeout(removePreloader, 1200);
    setTimeout(removePreloader, 5000);
  }

  // init jarallax parallax
  var initJarallax = function () {
    jarallax(document.querySelectorAll(".jarallax"));

    jarallax(document.querySelectorAll(".jarallax-img"), {
      keepImg: true,
    });
  }

  // Tab Section
  var initTabs = function () {
    const tabs = document.querySelectorAll('[data-tab-target]')
    const tabContents = document.querySelectorAll('[data-tab-content]')

    tabs.forEach(tab => {
      tab.addEventListener('click', () => {
        const target = document.querySelector(tab.dataset.tabTarget)
        tabContents.forEach(tabContent => {
          tabContent.classList.remove('active')
        })
        tabs.forEach(tab => {
          tab.classList.remove('active')
        })
        tab.classList.add('active')
        target.classList.add('active')
      })
    });
  }

  // document ready
  $(document).ready(function () {
    searchPopup();
    initSearchAutocomplete();
    initPreloader();
    initTabs();
    initJarallax();

    $(document).ajaxStart(function () {
      $('body').addClass('preloader-site');
      $('.preloader-wrapper').fadeIn();
    });
    $(document).ajaxStop(function () {
      removePreloader();
    });

    const mobileNavToggle = document.querySelector('.mobile-nav-toggle');
    const mainNav = document.getElementById('main-nav');

    if (mobileNavToggle && mainNav) {
      const closeMainNav = function () {
        mainNav.classList.remove('is-open');
        mobileNavToggle.classList.remove('is-active');
        mobileNavToggle.setAttribute('aria-expanded', 'false');
      };

      mobileNavToggle.addEventListener('click', function () {
        const isOpen = mainNav.classList.toggle('is-open');
        mobileNavToggle.classList.toggle('is-active', isOpen);
        mobileNavToggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
      });

      document.addEventListener('click', function (event) {
        if (!mainNav.contains(event.target) && !mobileNavToggle.contains(event.target)) {
          closeMainNav();
        }
      });

      mainNav.querySelectorAll('a').forEach(function (link) {
        link.addEventListener('click', closeMainNav);
      });

      window.addEventListener('resize', function () {
        if (window.innerWidth > 991) {
          closeMainNav();
        }
      });
    }

    var swiper = new Swiper(".main-swiper", {
      speed: 500,
      loop: true,
      navigation: {
        nextEl: ".button-next",
        prevEl: ".button-prev",
      },
      pagination: {
        el: "#billboard .swiper-pagination",
        clickable: true,
      },
    });

    var swiper = new Swiper(".two-column-swiper", {
      speed: 500,
      loop: true,
      navigation: {
        nextEl: ".button-next",
        prevEl: ".button-prev",
      },
    });

    var swiper = new Swiper("#featured-products .product-swiper", {
      pagination: {
        el: "#featured-products .swiper-pagination",
        clickable: true,
      },
      breakpoints: {
        0: {
          slidesPerView: 1,
          spaceBetween: 30,
        },
        768: {
          slidesPerView: 2,
          spaceBetween: 30,
        },
        999: {
          slidesPerView: 3,
          spaceBetween: 30,
        },
        1299: {
          slidesPerView: 4,
          spaceBetween: 30,
        },
      },
    });

    var swiper = new Swiper("#featured-products .product-swiper-two", {
      pagination: {
        el: "#featured-products .swiper-pagination",
        clickable: true,
      },
      breakpoints: {
        0: {
          slidesPerView: 1,
          spaceBetween: 30,
        },
        768: {
          slidesPerView: 2,
          spaceBetween: 30,
        },
        999: {
          slidesPerView: 4,
          spaceBetween: 30,
        },
        1299: {
          slidesPerView: 5,
          spaceBetween: 30,
        },
      },
    });

    var swiper = new Swiper("#flash-sales .product-swiper", {
      pagination: {
        el: "#flash-sales .product-swiper .swiper-pagination",
        clickable: true,
      },
      breakpoints: {
        0: {
          slidesPerView: 1,
          spaceBetween: 30,
        },
        768: {
          slidesPerView: 2,
          spaceBetween: 30,
        },
        999: {
          slidesPerView: 3,
          spaceBetween: 30,
        },
        1299: {
          slidesPerView: 4,
          spaceBetween: 30,
        },
      },
    });

    var swiper = new Swiper(".testimonial-swiper", {
      loop: true,
      navigation: {
        nextEl: ".next-button",
        prevEl: ".prev-button",
      },
    });

    var thumb_slider = new Swiper(".thumb-swiper", {
      slidesPerView: 1,
    });
    var large_slider = new Swiper(".large-swiper", {
      spaceBetween: 10,
      effect: 'fade',
      thumbs: {
        swiper: thumb_slider,
      },
    });

    // Initialize Isotope
    var $grid = $('.entry-container').isotope({
      itemSelector: '.entry-item',
      layoutMode: 'masonry'
    });
    $grid.imagesLoaded().progress(function () {
      $grid.isotope('layout');
    });

    $(".gallery").colorbox({
      rel: 'gallery'
    });

    $(".youtube").colorbox({
      iframe: true,
      innerWidth: 960,
      innerHeight: 585,
    });

    // Handle quick view
    $('.view-btn').on('click', function (e) {
      e.preventDefault();
      const productItem = $(this).closest('.product-item');
      const productName = productItem.find('.product-title a').text();
      const productPrice = productItem.find('.item-price').text();
      const productImage = productItem.find('.product-image').attr('src');

      $('#quick-view-modal .modal-title').text(productName);
      $('#quick-view-modal .modal-price').text(productPrice);
      $('#quick-view-modal .modal-image').attr('src', productImage);

      $('#quick-view-modal').css('display', 'block');
    });

    $('.close').on('click', function () {
      $('#quick-view-modal').css('display', 'none');
    });

  });

})(jQuery);
