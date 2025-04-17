document.getElementById('loginform').addEventListener('submit', async (e) => {
  e.preventDefault();
  const data = {
      email: document.getElementById('email').value,
      password: document.getElementById('password').value
  }
  
  const conn = new XMLHttpRequest();
  conn.open('POST', 'http://127.0.0.1:8000/api/login', true);
  conn.setRequestHeader('Content-Type', 'application/json');
  conn.setRequestHeader('Accept', 'application/json');

  conn.onreadystatechange = function(){
      if(conn.readyState === 4){
          const messageDiv = document.getElementById('message');
          
          try{
              const response = JSON.parse(conn.responseText);
              if (conn.status === 201) {
                  localStorage.setItem('token', response.token);
                  messageDiv.innerText = response.message;

                  if(response.user.is_admin){
                      window.location.href = '/dashboard';
                  }else{
                      window.location.href = '/films';
                  }
              }
          }
              catch (error) {
                  console.error('Parsing error:', error);
                  messageDiv.innerText = 'An unexpected error occurred.';
          }
      } 
  }
  
  conn.send(JSON.stringify(data));
});