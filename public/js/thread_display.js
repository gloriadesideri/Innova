let box=document.getElementById('thread-comment-box')
let button=document.getElementById('comments');


function displayComments() {
    box.classList.remove('hidden')
    button.onclick=hide;

}

function hide() {


    box.classList.add('hidden')
    button.onclick=displayComments;

}
button.onclick=displayComments;
