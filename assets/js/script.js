const swiper = new Swiper('.swiper-container', {
    
    loop: true,

    pagination: {
      el: '.swiper-pagination',
    },

    autoplay: {
      delay: 3000,
      disableOnInteraction: false
    },
  });