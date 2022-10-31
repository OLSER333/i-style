$(document).ready(function () {
  let width = window.innerWidth;
  let lastWidth = null;

  lastWidth = changeHtmlsalonPage(width, lastWidth);

  $(window).resize(function (e) {
    let width = e.target.innerWidth

    lastWidth = changeHtmlsalonPage(width, lastWidth);
  });
});

function changeHtmlsalonPage(width, lastWidth) { 
  if ((lastWidth >= 450 || lastWidth == null) && width <= 450) {
    movingContact('.worktime-information', '.salon-page-info');

    let fullOldBlock = '.salon-phones > .phone-button';
    let documents = $(fullOldBlock);

    if (documents.length > 1) {
      $(fullOldBlock)[1].remove();
      $('#hidden_phones').append(documents[1]);
    }

  } else if (lastWidth <= 450 && width > 450) {
    movingContact('.salon-page-info', '.worktime-information');
    
    let fullOldBlock = '#hidden_phones > .phone-button';
    let parentblock = '.salon-phones > .phone-button';

    let documents = $(fullOldBlock);

    if (documents.length > 1 && $(parentblock).length < 2) {
      $(fullOldBlock)[documents.length - 1].remove();
      $('.salon-phones').append(documents[documents.length - 1]);
    }
  }
  
  return width;
}

function movingContact(oldBlock, newBlock) {
  let fullOldBlock = oldBlock + ' .salon-page-social';
  let documents = $(fullOldBlock);

  $(fullOldBlock).remove();
  $(newBlock).append(documents);
}