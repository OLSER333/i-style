$(document).ready(function () {
  let width = window.innerWidth;
  let lastWidth = null;

  lastWidth = changeHtmlSearchPanel(width, lastWidth);

  $(window).resize(function (e) {
    let width = e.target.innerWidth

    lastWidth = changeHtmlSearchPanel(width, lastWidth);
  });
});

function changeHtmlSearchPanel(width, lastWidth) {
  if ((lastWidth >= 680 || lastWidth == null) && width <= 680) {
    movingCheckbox('.landing-service-search__form-container', '.landing-service-search__filter');

  } else if (lastWidth <= 680 && width > 680) {
    movingCheckbox('.landing-service-search__filter', '.landing-service-search__form-container');
  }

  return width;
}

function movingCheckbox(oldBlock, newBlock) {
  let fullOldBlock = oldBlock + ' .landing-service-search__filter-type';
  let documents = $(fullOldBlock);

  $(fullOldBlock).remove();
  $(newBlock).append(documents);
}
