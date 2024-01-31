
function handleScroll() {
  const header = document.querySelector('header');

  window.addEventListener('scroll', () => {
    if (window.scrollY > 0) {
      header.classList.add('header-hidden');
    } else {
      header.classList.remove('header-hidden');
    }
  });
}

$(document).ready(function() {
  $('.add-button').click(function() {
    var remainingSpaces = parseInt($(this).data('remaining-spaces'));

    if (remainingSpaces > 0 && confirm("Do you really want to join this group? We do not refund money if you cancel.")) {
      var button = $(this);

      setTimeout(function() {
        remainingSpaces--;
        button.data('remaining-spaces', remainingSpaces);
        button.find('.space-placeholder').text('(' + remainingSpaces + ' spaces remaining)');

        if (remainingSpaces === 0) {
          button.prop('disabled', true);
        }

      }, 1000);
    }
  });
});





