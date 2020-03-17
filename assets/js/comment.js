// let note = document.getElementById('comment_note');
// let add_note = document.getElementById('add_note');
// let substract_note = document.getElementById('substract_note');


// if (note.value >= -1 || note.value <= 5){
//     add_note.addEventListener("click", function (event){
//         event.preventDefault();
        
//         if(note.value >= 4){
//         add_note.style.display = "none";
//         note.value = 5;
//         }else if(note.value < 5){
//         add_note.style.display = "block";
//         }
//         note.value ++;
        
//     });
//     substract_note.addEventListener("click", function (event){
//         event.preventDefault();
//         if(note.value <= 1){
//         substract_note.style.display = "none";
//         }else if(note.value > 0) {
//         substract_note.style.display = "block";
//         }
//         note.value --;
//     });
// }

///////////////////////////////////////////////////Test AJAX Delete Comment/////////////////////////////

// const commentOptions = document.getElementsByClassName('deleteComment');

// if(commentOptions){
//   commentOptions.addEventListener('click', (event) => {
//       const id = event.target.getAttribute('data-id');
//       const idcomment = event.target.getAttribute('data-idcomment');
//       console.log('deg');
//       fetch(`/pageproduct/${id}/comment/${idcomment}/delete`, {
//         method: 'DELETE'
//       }).then(response => {window.location.reload()});
//   });
// }

//////////////////////////////////////////////////Fin Test Ajax Delete Comment////////////////////////////