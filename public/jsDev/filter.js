const categories = document.querySelector(".js-filter-category");

const content = document.querySelector(".js-filter-content");

categories.querySelectorAll('a').forEach(a => {
    a.addEventListener('click', e => {
        
        e.preventDefault();
        const url = $(a).attr('href');
        fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        }).then(response => 
            response.json()
        ).then(data => {
            content.innerHTML = data.content
        })

    });
});


