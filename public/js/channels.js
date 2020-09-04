var slideIndex = 1;
showSlides(slideIndex);

// Next/previous controls
function plusSlides(n) {
    showSlides(slideIndex += n);
}

function showSlides(n) {
    var i;
    var slides_1 = document.getElementsByClassName("slides-1");
    var slides_2 = document.getElementsByClassName("slides-2");

    if (n > slides_1.length) {slideIndex = 1}
    if (n < 1) {slideIndex = slides_1.length}
    for (i = 0; i < slides_1.length; i++) {
        slides_1[i].style.display = "none";
        slides_2[i].style.display = "none";

    }

    slides_1[slideIndex-1].style.display = "block";
    slides_2[slideIndex-1].style.display = "block";

}
