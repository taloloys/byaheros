document.addEventListener('DOMContentLoaded', function() {
    loadYears();
    loadPrices();
    fetchUnits('');

    document.addEventListener('click', function(event) {
        if (event.target && event.target.classList.contains('maintenance-button')) {
            event.preventDefault();
            Swal.fire({
                icon: 'info',
                title: 'Maintenance Mode',
                text: 'The selected unit is currently under maintenance.',
                footer: '<a href="#">Learn More</a>'
            });
        }
    });
});

function loadPrices() {
    fetch('price.php')
        .then(response => response.json())
        .then(data => {
            const priceSelect = document.getElementById('priceSelect');
            data.forEach(price => {
                const option = document.createElement('option');
                option.value = price;
                option.textContent = price;
                priceSelect.appendChild(option);
            });
        })
        .catch(error => console.error('Error loading prices:', error));
}

function loadYears() {
    fetch('years.php')
        .then(response => response.json())
        .then(data => {
            const yearSelect = document.getElementById('yearSelect');
            data.forEach(year => {
                const option = document.createElement('option');
                option.value = year;
                option.textContent = year;
                yearSelect.appendChild(option);
            });
        })
        .catch(error => console.error('Error loading years:', error));
}

function applyFilters() {
    const search = document.getElementById('searchInput').value;
    const year = document.getElementById('yearSelect').value;
    const price = document.getElementById('priceSelect').value;

    fetch('filter.php?search=' + encodeURIComponent(search) + '&year=' + year + '&price=' + price)
        .then(response => response.text())
        .then(data => {
            document.getElementById('unitContainer').innerHTML = data;
        })
        .catch(error => console.error('Error applying filters:', error));
}

function fetchUnits(params) {
    fetch(`filter.php${params}`)
        .then(response => response.text())
        .then(data => {
            document.getElementById('unitContainer').innerHTML = data;
        })
        .catch(error => console.error('Error fetching units:', error));
}

function updateSearchSuggestions() {
    const input = document.getElementById('searchInput');
    const dataList = document.getElementById('searchSuggestions');
    dataList.innerHTML = ''; 

    
    fetch('suggestion.php')
        .then(response => response.json())
        .then(suggestions => {
            
            const userInput = input.value.toLowerCase();
            const filteredSuggestions = suggestions.filter(suggestion =>
                suggestion.toLowerCase().includes(userInput)
            );

            
            filteredSuggestions.forEach(suggestion => {
                const option = document.createElement('option');
                option.value = suggestion;
                dataList.appendChild(option);
            });
        })
        .catch(error => console.error('Error fetching suggestions:', error));
}


document.getElementById('searchInput').addEventListener('input', updateSearchSuggestions);
