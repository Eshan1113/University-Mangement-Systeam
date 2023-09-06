const form = document.querySelector('#RegForm');
const responseDiv = document.querySelector('#response');

form.addEventListener('submit', function(e) {
  e.preventDefault();
  
  // Collect input data from the user
  const formData = new FormData(form);
  
  // Create an Ajax request
  const xhr = new XMLHttpRequest();
  xhr.open('POST', 'lib/functions/register.php');
  xhr.onreadystatechange = function() {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        // Process the response
        const response = JSON.parse(xhr.responseText);
        if (response.status === 'success') {
          responseDiv.textContent = response.message;
          responseDiv.classList.add('success');
        } else {
          responseDiv.textContent = response.message;
          responseDiv.classList.add('error');
        }
      } else {
        console.error('Error:', xhr.statusText);
      }
    }
  };
  
  // Send the input data to the server
  xhr.send(formData);
});