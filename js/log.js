// const loginForm = document.getElementById('login-form');
// loginForm.addEventListener('submit', (event) => {
//   event.preventDefault(); // Prevent form from submitting

//   // Get form data
//   const formData = new FormData(loginForm);

//   // Send AJAX request
//   const xhr = new XMLHttpRequest();
//   xhr.open('POST', 'login.php');
//   xhr.onload = function() {
//     if (xhr.status === 200) {
//       const response = JSON.parse(xhr.responseText);
//       if (response.success) {
//         // Redirect to dashboard or other page
//         window.location.href = 'dashboard.php';
//       } else {
//         // Show error message
//         const error = document.getElementById('error-message');
//         error.textContent = response.message;
//       }
//     } else {
//       console.error('Error:', xhr.statusText);
//     }
//   };
//   xhr.onerror = function() {
//     console.error('Error:', xhr.statusText);
//   };
//   xhr.send(formData);
// });
