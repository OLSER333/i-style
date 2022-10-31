$(document).ready(function () {
  let width = window.innerWidth;
  let lastWidth = null;

  lastWidth = changeHtmlCatalog(width, lastWidth);

  $(window).resize(function (e) {
    let width = e.target.innerWidth

    lastWidth = changeHtmlCatalog(width, lastWidth);
  });

  $(document).on('click', '.display-categories-button', function (e) {
    e.preventDefault();
    let click = $(this).attr('data-click');;

    if (click == '1') {
      $(this).attr('data-click-categories', '0');
      movingButtonUp('.catalog-categories', '.hidden-block-categories > .second-button');

    } else {
      $(this).attr('data-click-categories', '1');
      movingButtonDown('.hidden-block-categories', '.catalog-categories > .second-button', 5);
    }
  });
});



function changeHtmlCatalog(width, lastWidth) {
  if ((lastWidth >= 1020 || lastWidth == null) && width <= 1020) {
    movingFilter('.align-start', '.catalog-sort-filter-recommendation');
    movingCheckboxSalonOrMaster('.catalog-sort-filter-recommendation', '.catalog-filters');

  } else if (lastWidth <= 1020 && width > 1020) {
    movingFilter('.catalog-sort-filter-recommendation', '.align-start');
    movingCheckboxSalonOrMaster('.catalog-filters', '.catalog-sort-filter-recommendation');
  }

  if ((lastWidth >= 770 || lastWidth == null) && width <= 770) {
    movingButtonDown('.hidden-block-categories', '.catalog-categories > .second-button', 5);

  } else if (lastWidth <= 770 && width > 770) {
    movingButtonUp('.catalog-categories', '.hidden-block-categories > .second-button');
  }

  if ((lastWidth >= 650 || lastWidth == null) && width <= 650) {
    movingButtonDown('.hidden-recommendation', '.recommendation-list > .sort-item', 1);

  } else if (lastWidth <= 650 && width > 650) {
    movingButtonUp('.recommendation-list', '.hidden-recommendation > .sort-item');
  }

  return width;
}


function movingButtonDown(appendBlock, oldBlock, intactCount) {
  let fullOldBlock = oldBlock;
  let documents = $(fullOldBlock);

  if (documents.length > intactCount) {
    for (let i = intactCount; i < documents.length; i++) {
      $(appendBlock).append(documents[i]);

      if ($(fullOldBlock).length > intactCount) {
        $(fullOldBlock)[intactCount].remove();
      }
    }
  }
}

function movingButtonUp(appendBlock, oldBlock) {
  let fullOldBlock = oldBlock;

  let documents = $(fullOldBlock);

  if (documents.length > 1) {
    for (let i = 0; i < documents.length; i++) {
      $(appendBlock).append(documents[i]);

      if ($(fullOldBlock).length > 0) {
        $(fullOldBlock)[0].remove();
      }
    }
  }
}

function movingFilter(oldBlock, newBlock) {
  let fullOldBlock = oldBlock + ' .catalog-filters';
  let documents = $(fullOldBlock);

  $(fullOldBlock).remove();
  $(newBlock).append(documents);
}

function movingCheckboxSalonOrMaster(oldBlock, newBlock) {
  let fullOldBlock = oldBlock + ' .filter-master-salon';
  let documents = $(fullOldBlock);

  $(fullOldBlock).remove();
  $(newBlock).append(documents);
}
