document.addEventListener("DOMContentLoaded", function() {
    const form = document.querySelector("#form");
    form.addEventListener('submit', function(event){
      event.preventDefault();
      const formData = new FormData(form);
      const url = form.action;
      fetch(url, {method: "POST", body: formData})
         .then(response => response.json())
         .then( data => { mostrarResultados(data); })
         .catch( error => {console.log(error);});
    });
 });