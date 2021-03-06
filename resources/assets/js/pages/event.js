$('#image-replace-button').click(() => {
    $('#image-view-button').hide();
    $('#image-replace-button').hide();
    $('#image-break').hide();

    $('#image-upload').removeClass('d-none');
});

/**
 * Updates the event page from data that the carousel has.
 *
 * @param {object} event jQuery event for the carousel.
 * @param {boolean} updateHistory Should we update the history state.
 */
function updateEvent(event = {}, updateHistory = true)
{
    let item = $(event.relatedTarget);

    let itemID = item.attr('data-id');

    let title = item.find('input[name="title"]').val();
    let body = item.find('input[name="body"]').val();
    let event_at = item.find('input[name="event_at"]').val();

    $('#title').html(title);
    $('#body').html(body);
    $('#event_at').html(event_at);

    $('#breadcrumb-active').html(title);

    document.title = title;

    let pushed = false;

    if (updateHistory)
    {
        if (pushed)
        {
            window.history.replaceState('event', title, `/event/${itemID}`);
        }
        else
        {
            window.history.pushState('event', title, `/event/${itemID}`);
        }
    }
}

let isPopStateDriven = false;

$('#eventCarousel').on('slide.bs.carousel', event => {
    if (isPopStateDriven)
    {
        updateEvent(event, false);
    }
    else
    {
        updateEvent(event);
    }
});

window.onpopstate = () => {
    let id = document.location.href.split('/')[4];

    let item = $('div[class="carousel-item active"]');

    let wantedItem = item.parent().find(`div[data-id="${id}"]`);

    let wantedItemIndex = wantedItem.index();

    isPopStateDriven = true;

    $('#eventCarousel').carousel(wantedItemIndex);

    isPopStateDriven = false;
};
