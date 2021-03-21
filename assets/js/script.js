// Swiper on home page

const swiper = new Swiper('.photo-report__slider', {
    
    loop: true,

    pagination: {
      el: '.swiper-pagination',
    },

    autoplay: {
      delay: 3000,
      disableOnInteraction: false
    },
  });

// Post first letter

const postContent = document.querySelector('.post-content');
const firstParagraph = postContent.querySelector('p');
firstParagraph.classList.add('post-content__first');

// Post gallary swiper
const postGalleries = document.querySelectorAll('.wp-block-gallery');
const postWrappers = document.querySelectorAll('.blocks-gallery-grid');
const postSlides = document.querySelectorAll('.blocks-gallery-item');

postWrappers.forEach(element => {
  element.classList.add('swiper-wrapper');
});

postSlides.forEach(element => {
  element.classList.add('swiper-slide');
});

for(let i = 0; i < postGalleries.length; i++ ) {
  const gallery = postGalleries[i];
  gallery.classList.add('post-gallery-' + i);

  const prev = document.createElement('div');
  prev.classList.add('swiper-button-prev');
  gallery.appendChild(prev);

  const next = document.createElement('div');
  next.classList.add('swiper-button-next');
  gallery.appendChild(next);

  const swiper = new Swiper('.post-gallery-' + i, {
    
    loop: true,
  
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },
  });
}
 
