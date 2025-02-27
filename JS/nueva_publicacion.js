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

function previewImages(event) {
    const files = event.target.files;
    const container = document.getElementById("edit-carousel-container");
    container.innerHTML = ""; // Limpiar el contenedor

    for (let i = 0; i < files.length; i++) {
        const file = files[i];
        const reader = new FileReader();

        reader.onload = function (e) {
            const slide = document.createElement("div");
            slide.classList.add("carousel-slide");

            if (file.type.startsWith("image/")) {
                const img = document.createElement("img");
                img.src = e.target.result;
                slide.appendChild(img);
            } else if (file.type.startsWith("video/")) {
                const video = document.createElement("video");
                video.controls = true;
                const source = document.createElement("source");
                source.src = e.target.result;
                source.type = file.type;
                video.appendChild(source);
                slide.appendChild(video);
            }

            container.appendChild(slide);
        };

        reader.readAsDataURL(file);
    }
    const buttons = document.querySelector(".buttons-edit-carousel");
    buttons.style.display = "block";
}
