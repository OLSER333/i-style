$(document).ready(function () {
  let width = window.innerWidth;
  let lastWidth = null;

  lastWidth = changeHtmlsalonCard(width, lastWidth);

  $(window).resize(function (e) {
    let width = e.target.innerWidth

    lastWidth = changeHtmlsalonCard(width, lastWidth);
  });
});

function changeHtmlsalonCard(width, lastWidth) {
  if ((lastWidth >= 1260 || lastWidth == null) && width <= 1260) {
    $('.landing-best-salons__card').each(function () {
      movingRating(this, '.salon-card-footer', '.salon-card-header__name', ' .salon-card-footer__stars');
    });

  } else if (lastWidth <= 1260 && width > 1260) {
    $('.landing-best-salons__card').each(function () {
      movingRating(this, '.salon-card-header__name', '.salon-card-footer', ' .salon-card-footer__stars');
    });
  }

  if ((lastWidth >= 670 || lastWidth == null) && width <= 670) {
    $('.salon-card').each(function () {
      movingRating(this, '.salon-card-info', '.salon-card-header__name', ' .salon-rating');
    });

  } else if (lastWidth <= 670 && width > 670) {
    $('.salon-card').each(function () {
      movingRating(this, '.salon-card-header__name', '.salon-card-info', ' .salon-rating');
    });
  }

  return width;
}

let movingRating = (thisEl, oldBlock, newBlock, className) => {
  let fullOldBlock = oldBlock + className;
  let documents = $(thisEl).find(fullOldBlock);

  $(thisEl).find(fullOldBlock).remove();
  $(thisEl).find(newBlock).append(documents);
}
