document.addEventListener("DOMContentLoaded", function() {
    const sliderItems = document.querySelectorAll('.slider-item');
    let sliderActive = 0; 

    if (sliderItems.length > 0) {
        sliderItems.forEach((slider, index) => {
            slider.setAttribute("data-show", index === 0 ? "show" : "hidden");
        });

        setInterval(() => {
            sliderItems.forEach((slider, index) => {
                slider.setAttribute("data-show", sliderActive === index ? "show" : "hidden");
            });

            sliderActive = (sliderActive + 1) % sliderItems.length;
        }, 5000);
    }
});
