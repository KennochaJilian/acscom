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



console.log('Hello');

document.getElementById('add_product_wish').addEventListener("click", function (){
  document.getElementById('number_product_wish').value ++;
});

document.getElementById('add_product_cart').addEventListener("click", function (){
  document.getElementById('number_product_cart').value ++;
});
