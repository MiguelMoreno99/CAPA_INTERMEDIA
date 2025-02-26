let currentSlide = 0;

function changeSlide(direction, postIndex) {
    const carousels = document.querySelectorAll(".carousel-container");
    const totalSlides = carousels[postIndex].children.length;

    currentSlide += direction;

    if (currentSlide < 0) {
        currentSlide = totalSlides - 1;
    } else if (currentSlide >= totalSlides) {
        currentSlide = 0;
    }

    const translateValue = -currentSlide * 100 + "%";
    carousels[postIndex].style.transform = "translateX(" + translateValue + ")";
}
