let currentPage = 0;

fetch('../controllers/ShowTests.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ current: currentPage })  
    })
    .then(response => response.text())  
    .then(data => {

        document.getElementById('tests-container').innerHTML += data;
        
        currentPage += 1;
    })
    .catch(error => {
        console.error('Error:', error);
    });

document.getElementById('show-more').addEventListener('click', function() {
    fetch('../controllers/ShowTests.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ current: currentPage })  
    })
    .then(response => response.text())  
    .then(data => {

        document.getElementById('tests-container').innerHTML += data;
        
        currentPage += 1;
    })
    .catch(error => {
        console.error('Error:', error);
    });
});
