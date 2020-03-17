/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import '../css/app.css';
import "bootstrap";

// Need jQuery? Install it with "yarn add jquery", then uncomment to import it.
// import $ from 'jquery';



//AXIOS// AJAX // AJOUT AU PANIER

window.addEventListener("DOMContentLoaded", function(){

  let addCartLinks = document.getElementsByClassName("js_addCartLink");

  function onClickAddCart(event){
    event.preventDefault();

    const url = this.href;

    axios.get(url).then(function(response){
      console.log(response.data.code);
      if (response.data.code == 200){
        addToast(response.data.message)
      } 
    });

  } 

  function addToast(message){

    let containerToast = document.querySelector('#js_containerToast');
    let toast = document.getElementById("toastModel"); 
    let newToast = toast.cloneNode(containerToast); 
    console.log(newToast);
    newToast.querySelector('.toast-body').innerText = `Le produit ${message} a bien été ajouté au panier`;
    containerToast.appendChild(newToast)
    newToast.classList.add("show");


  }

  if(addCartLinks.length != 0){

    addCartLinks.forEach(function(link){
      link.addEventListener('click', onClickAddCart)
    })
  }

});



