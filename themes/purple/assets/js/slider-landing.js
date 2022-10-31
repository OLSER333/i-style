$(document).ready(function () {
  let width = window.innerWidth;
  let lastWidth = null;
  let slides = createArrSlides('.landing-best-work-card');

  lastWidth = changeHtmlSliderLanding(width, lastWidth); //, slides);

  $(window).resize(function (e) {
    let width = e.target.innerWidth

    lastWidth = changeHtmlSliderLanding(width, lastWidth); //, slides);
  });

  $('.current-slide').html(1);
  $('.all-slides').html(slides.length);
});

function changeHtmlSliderLanding(width, lastWidth, slides) {
  if (width <= 1240) {
    $('.landing-best-works .slide-images').attr('data-count', 1);
  } else if (width <= 1490) {
    $('.landing-best-works .slide-images').attr('data-count', 3);
  } else if (width > 1490) {
    $('.landing-best-works .slide-images').attr('data-count', 4);
  }

  $('.landing-best-works .slide-images').attr('data-current-slide', 1);

  // if ((lastWidth >= 1240 || lastWidth == null) && width <= 1240) {
  //   let flag = true;
  //   movingSlider('.bottom-section .slide-images', slides, flag);

  //   if (width <= 1240) {
  //     $('.current-slide').html(1);
  //     let countSliders = $('.bottom-section .slide-images .slides-group').length;
  //     $('.all-slides').html(countSliders);
  //   }
  // } else if (lastWidth <= 1240 && width > 1240) {
  //   let flag = false;
  //   movingSlider('.bottom-section .slide-images', slides, flag);
  // }

  return width;
}

// function movingSlider(block, slides, flag) {
//   addDiv = '';
//   let j = 0;

//   $(block).empty();

//   if (flag) {
//     addDiv = ' .slides-group';

//     for (let i = 0; i < slides.length; i++) {
//       if (i % 4 == 0) {
//         j += 1;
//         $(block).append(`<div data-slide="${j}" class="slides-group slide-item"></div>`);
//       }
      
//       $(slides[i]).removeAttr('data-slide');

//       if (j == 1) {
//         $(block + addDiv).append(slides[i]);
//       } else {
//         $(block + addDiv)[j - 1].append(slides[i]);
//       }
//     }

//   } else {
//     for (let i = 0; i < slides.length; i++) {
//       $(slides[i]).addClass('slide-item');
//       $(slides[i]).attr('data-slide', i + 1);
//       $(block + addDiv).append(slides[i]);
//       j = i
//     }

//     j += 1;
//   }
// }

function createArrSlides(selector) {
  slides = [];

  $(selector).each(function (i, value) {
    // $(this).removeClass('slide-item');
    slides.push(value);
  });

  return slides;
}
