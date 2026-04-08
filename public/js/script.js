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

    searchInput.addEventListener('input', function () {
      clearTimeout(searchTimeout);
      const query = this.value.trim();

      if (query.length < 1) {
        searchDropdown.style.display = 'none';
        return;
      }

      searchTimeout = setTimeout(function () {
        fetch(`/api/search?q=${encodeURIComponent(query)}`)
          .then(response => response.json())
          .then(products => {
            if (products.length === 0) {
              dropdownContent.innerHTML = '<div class="search-no-results"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ccc" stroke-width="1.5"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg><span>No products found</span></div>';
            } else {
              dropdownContent.innerHTML = products.map(product => `
                <a href="/products/${product.id}" class="search-dropdown-item">
                  <div class="search-product-img-wrapper">
                    <img src="/images/${product.image}" alt="${product.name}" class="search-product-img" onerror="this.src='/images/placeholder.png'">
                  </div>
                  <div class="search-product-info">
                    <div class="search-product-name">${product.name.substring(0, 40)}</div>
                    <div class="search-product-price">$${parseFloat(product.price).toFixed(2)}</div>
                  </div>
                </a>
              `).join('');
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

    jQuery(document).ready(function ($) {
      jQuery('.stellarnav').stellarNav({
        position: 'right'
      });
    });

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
