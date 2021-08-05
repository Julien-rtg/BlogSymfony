const categories = document.querySelector(".js-filter-category");
const content = document.querySelector(".js-filter-content");
const cart = document.querySelector(".js-filter-cart");


// AJAX FOR CATEGORIES
categories.querySelectorAll('a').forEach(a => {
    a.addEventListener('click', e => {
        
        e.preventDefault();
        const url = $(a).attr('href');
        history.replaceState({}, '', url);
        loadContent(url, content);
        
    });
});

// AJAX FOR ADD TO CART
$('.js-filter-content').on('click', "a", function(){
    event.preventDefault();
    const url = $(this).attr('href');
    console.log(url);
    loadContent(url, cart);
});


// AJAX FOR RECALC CART
$('.js-filter-cart').on('click', "a", function(){
    event.preventDefault();
    const url = $(this).attr('href');
    console.log(url);
    loadContent(url, cart);
});

// FUNCTION LOAD AJAX
function loadContent(url, input){
    fetch(url, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    }).then(response => 
        response.json()
    ).then(data => {
        input.innerHTML = data.content;
    })
}