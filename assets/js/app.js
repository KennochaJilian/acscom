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
//AXIOS// AJAX // AJOUT AU PANIER
  let addCartLinks = document.getElementsByClassName("js_addCartLink");

  function onClickAddCart(event){
    event.preventDefault();

    const url = this.href;

    axios.get(url).then(function(response){
      console.log(response.data.code);
      if (response.data.code == 200){
        addToast(response.data.message)
        addPill(response.data.quantity); 
      } 
    });

  } 

  function addToast(message){

    let containerToast = document.querySelector('#js_containerToast');
    containerToast.style.position="fixed"; 
    containerToast.style.top = "0"; 
    containerToast.style.right = "0";
    let toast = document.getElementById("toastModel"); 
    let newToast = toast.cloneNode(containerToast); 
    console.log(newToast);
    newToast.querySelector('.toast-body').innerText = `Le produit ${message} a bien été ajouté au panier`;
    containerToast.appendChild(newToast); 
    
    $(newToast).toast('show');


  }



  function addPill(quantity){
    let pillCart = document.getElementById('js_pillCart'); 
    pillCart.innerText = quantity; 
  }

  if(addCartLinks.length != 0){

    addCartLinks.forEach(function(link){
      link.addEventListener('click', onClickAddCart)
    })
  }
///////////////////// Commande : date de livraison interactive ////

let selectDeliveryOrder = document.getElementById('orders_deliveryOption'); 
if (selectDeliveryOrder != null){
  selectDeliveryOrder.addEventListener("change", function(event){

    console.log(event.target.value);
    if(event.target.value == "Pigeon voyageur" ){
      document.getElementById('js_poste').classList.add('d-none');
      document.getElementById('js_pigeon').classList.remove('d-none'); 
    }
  
    if(event.target.value == "La Poste"){
      document.getElementById('js_poste').classList.remove('d-none');
      document.getElementById('js_pigeon').classList.add('d-none'); 
  
    }
  })
}




});



