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
         .then( data => { result(data); })
         .catch( error => {console.log(error);});
    });
 });

 
function result(data){
   let message
   if(data === "Email already in use"){
      message = `
         <p>Email already in use</p>
      `
   }else{
      message = `
           <p>Usuario creado</p>
       `;
   }

    return document.querySelector('#respuesta').innerHTML = message;
}