function verifySamePassword(){
   const pass = document.querySelector('#password')
   const confirm_pass = document.querySelector('#confirmPass')
   
   if(pass.value === confirm_pass.value){
      return true
   }

   let message = `
         <p>Passwords doesn't match.</p>
   `
   document.querySelector('#respuesta').innerHTML = message;
   return false;
}

document.addEventListener("DOMContentLoaded", function() {
    const form = document.querySelector("#form");
    form.addEventListener('submit', function(event){
      event.preventDefault();
      
      const formData = new FormData(form);
      const url = form.action;

      if (!verifySamePassword()) {
        return;  
     }

      fetch(url, {method: "POST", body: formData})
         .then(response => response.json())
         .then( data => {
           if (data.status === 'success') {
              window.location.href = data.redirect;
          } else {
              result(data);
          }
         })
         .catch( error => {
           
           console.log(error);});
    });
 });

 
function result(data){
   console.log(data);
   
   let message = `
      <p>${data}</p>
   `

    return document.querySelector('#respuesta').innerHTML = message;
}