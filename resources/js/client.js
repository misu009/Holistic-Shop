import "../css/client.css";
import "bootstrap-icons/font/bootstrap-icons.css";
import GLightbox from "glightbox";
import "glightbox/dist/css/glightbox.min.css";
import Swiper from "swiper";
import * as bootstrap from "bootstrap";
import "swiper/swiper-bundle.css";
import $ from "jquery";
import EditorJS from "@editorjs/editorjs";
import { editorJsTools } from "./editorjs/tools";

window.bootstrap = bootstrap;
window.$ = window.jQuery = $;

document.addEventListener("DOMContentLoaded", function () {
    const swiperContainer = document.querySelector(".mySwiper");
    const slides = swiperContainer.querySelectorAll(".swiper-slide");

    // Function to determine if the loop should be enabled based on screen size
    function checkLoop() {
        const windowWidth = window.innerWidth;
        const slidesPerView =
            windowWidth >= 992 ? 3 : windowWidth >= 576 ? 2 : 1; // Using breakpoints logic

        // If we have enough slides for the current slidesPerView, enable loop
        return slides.length > slidesPerView;
    }

    const swiper = new Swiper(".mySwiper", {
        slidesPerView: 1,
        spaceBetween: 16,
        loop: checkLoop(), // Set loop based on the initial check
        autoplay: checkLoop()
            ? {
                  delay: 3000,
                  disableOnInteraction: false,
              }
            : false,
        breakpoints: {
            576: { slidesPerView: 2 },
            992: { slidesPerView: 3 },
        },
    });

    const prevButton = document.querySelector(".custom-prev");
    const nextButton = document.querySelector(".custom-next");

    prevButton.addEventListener("click", () => {
        swiper.slidePrev();
    });

    nextButton.addEventListener("click", () => {
        swiper.slideNext();
    });

    // Update loop and autoplay on window resize
    window.addEventListener("resize", () => {
        const shouldEnableLoop = checkLoop();

        swiper.params.loop = shouldEnableLoop;
        swiper.params.autoplay = shouldEnableLoop
            ? {
                  delay: 3000,
                  disableOnInteraction: false,
              }
            : false;

        swiper.update(); // Update swiper with new parameters
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const lightbox = GLightbox({
        selector: 'a.glightbox[data-gallery="product-gallery"]',
        skin: "clean",
        loop: true,
        zoomable: true,
        draggable: true,
        autoplayVideos: true,
        openEffect: "zoom",
        closeEffect: "fade",
        slideEffect: "slide",
    });
});

document.addEventListener("DOMContentLoaded", () => {
    const savedData = window.editorJsData;
    if (!savedData) return;
    new EditorJS({
        holder: "editorjs-view",
        readOnly: true,
        data: savedData,
        tools: editorJsTools,
    });
});
