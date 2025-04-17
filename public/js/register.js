document.getElementById('registerform').addEventListener('submit', function (e) {
  e.preventDefault();

  const data = {
    name: document.getElementById('name').value,
    email: document.getElementById('email').value,
    password: document.getElementById('password').value
  };

  const conn = new XMLHttpRequest();
  conn.open('POST', 'http://localhost:8000/api/register', true);
  conn.setRequestHeader('Content-Type', 'application/json');
  conn.setRequestHeader('Accept', 'application/json');

  conn.onreadystatechange = function () {
    if (conn.readyState === 4) {
      const messageDiv = document.getElementById('message');
      try {
        const response = JSON.parse(conn.responseText);
        if (conn.status === 201) {
          messageDiv.innerText = response.message;
        }
        if (response.errors) {
          messageDiv.innerHTML = '';
        
          for (const key in response.errors) {
            response.errors[key].forEach(error => {
              const p = document.createElement('p');
              p.style.color = 'red';
              p.innerText = error;
              messageDiv.appendChild(p);
            });
          }
        } else {
          messageDiv.innerText = response.message || 'An error occurred.';
        }
      } catch (error) {
        console.error('Parsing error:', error);
        messageDiv.innerText = 'An unexpected error occurred.';
      }
    }
  };

  conn.send(JSON.stringify(data));
});
