document.getElementById('addDependency').addEventListener('click', function() {

  const newPair = document.createElement('div');
  newPair.classList.add('form-row', 'mb-3');


  const keyInput = document.createElement('input');
  keyInput.type = 'text';
  keyInput.classList.add('form-control');
  keyInput.name = 'key[]';
  keyInput.placeholder = 'Key';
  keyInput.required = true;


  const valueInput = document.createElement('input');
  valueInput.type = 'text';
  valueInput.classList.add('form-control');
  valueInput.name = 'value[]';
  valueInput.placeholder = 'Value';
  valueInput.required = true;


  const keyCol = document.createElement('div');
  keyCol.classList.add('col');
  keyCol.appendChild(keyInput);

  const valueCol = document.createElement('div');
  valueCol.classList.add('col');
  valueCol.appendChild(valueInput);

  newPair.appendChild(keyCol);
  newPair.appendChild(valueCol);


  document.getElementById('dependencyContainer').appendChild(newPair);
});

document.getElementById('testForm').addEventListener('submit', function(event) {
  event.preventDefault(); 


  const testName = document.getElementById('testName').value;
  const testDescription = document.getElementById('testDescription').value;


  const keys = document.querySelectorAll('input[name="key[]"]');
  const values = document.querySelectorAll('input[name="value[]"]');


  const dependencies = [];
  for (let i = 0; i < keys.length; i++) {
    dependencies.push(keys[i].value, values[i].value);
  }

  const jsonObj = {
    name: testName,
    description: testDescription,
    dependencies: dependencies
  };


  fetch('../controllers/CreationController.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
    },
    body: JSON.stringify(jsonObj) 
  })
  .then(response => response.json()) 
  .then(data => {
    const responseMessage = document.getElementById('responseMessage');
    if (data.status === 'success') {
      responseMessage.innerHTML = '<div class="alert alert-success">Test created successfully!</div>';
    } else {
      responseMessage.innerHTML = '<div class="alert alert-danger">Error: ' + data.message + '</div>';
    }
  })
  .catch(error => {
    console.error('Error:', error);
    responseMessage.innerHTML = '<div class="alert alert-danger">Error ' + '</div>';
  });
});

