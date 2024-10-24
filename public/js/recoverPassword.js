document.addEventListener("DOMContentLoaded", function() {
     const form = document.querySelector("#form");
     form.addEventListener('submit', function(event){
       event.preventDefault();
       
       const formData = new FormData(form);
       const url = form.action;

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