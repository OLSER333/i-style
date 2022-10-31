$(document).ready(function () {
  let width = window.innerWidth;
  let lastWidth = null;
  let links = createArrLinks('.footer-col-2 .footer-links');

  lastWidth = changeHtmlFooter(width, lastWidth, links);

  $(window).resize(function (e) {
    let width = e.target.innerWidth

    lastWidth = changeHtmlFooter(width, lastWidth, links);
  });
});

function changeHtmlFooter(width, lastWidth, links) {
  if ((lastWidth >= 960 || lastWidth == null) && width <= 960) {
    let flag = false;

    movingDocuments('.footer-col-1', '.footer-col-3');
    movingLinks('.footer-col-2 .footer-links', links, flag);

  } else if (lastWidth <= 960 && width > 960) {
    let flag = true;

    movingDocuments('.footer-col-3', '.footer-col-1');
    movingLinks('.footer-col-2 .footer-links', links, flag);
  }

  return width;
}

function movingDocuments(oldBlock, newBlock) {
  let fullOldBlock = oldBlock + ' .footer-links';
  let documents = $(fullOldBlock);

  $(fullOldBlock).remove();
  $(newBlock).append(documents);
}

function movingLinks(block, links, flag) {
  let addDiv = '';

  $(block).empty();

  for (let i = 0; i < links.length; i++) {
    if (flag) {
      addDiv = ' div';
      $(block).append('<div></div>');

      for (let j = 0; j < links[i].length; j++) {
        $(block + addDiv)[i].append(links[i][j]);
      }

    } else {
      for (let j = 0; j < links[i].length; j++) {
        $(block + addDiv).append(links[i][j]);
      }
    }
  }
}

function createArrLinks(selector) {
  links = [];

  $(selector).children('div').each(function (i) {
    links.push([]);

    $(this).children('a').each(function (j, value) {
      links[i].push(value);
    });
  }).empty();

  return links;
}