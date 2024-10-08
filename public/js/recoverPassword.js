document.addEventListener("DOMContentLoaded", function() {
     const form = document.querySelector("#form");
     form.addEventListener('submit', function(event){
       event.preventDefault();
       console.log('aaa');
       
       const formData = new FormData(form);
       const url = form.action;
       fetch(url, {method: "POST", body: formData})
          .then(response => response.text())
          .then( data => {result(data)})
          .catch( error => {console.log(error);});
     });
  });
 
  
 function result(data){
    console.log(data);
    
    let message = `
       <p>${data}</p>
    `
 
     return document.querySelector('#respuesta').innerHTML = message;
 }