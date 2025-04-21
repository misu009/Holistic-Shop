import $ from "jquery";
import * as bootstrap from "bootstrap";
import "../css/app.css";
import "../css/admin.css";
import "../css/client.css";
import "bootstrap-icons/font/bootstrap-icons.css";
import GLightbox from "glightbox";
import "glightbox/dist/css/glightbox.min.css";

window.$ = window.jQuery = $;
window.bootstrap = bootstrap;

import "select2";
import "/node_modules/select2/dist/css/select2.css";
import select2 from "select2";
select2();

window.togglePasswordVisibility = function (id) {
    const passwordInput = document.getElementById(id);
    const toggleIcon = document.getElementById("toggleIcon");

    if (passwordInput.type === "password") {
        passwordInput.type = "text";
        toggleIcon.classList.remove("bi-eye");
        toggleIcon.classList.add("bi-eye-slash"); // Switch to eye-slash icon
    } else {
        passwordInput.type = "password";
        toggleIcon.classList.remove("bi-eye-slash");
        toggleIcon.classList.add("bi-eye"); // Switch back to eye icon
    }
};

document.addEventListener("DOMContentLoaded", function () {
    const editButtons = document.querySelectorAll(".edit-button");
    const editModal = document.getElementById("editUserModal");

    editButtons.forEach((button) => {
        button.addEventListener("click", function () {
            const userId = this.getAttribute("data-id");
            const userName = this.getAttribute("data-name");
            const userEmail = this.getAttribute("data-email");

            document.getElementById("editUserId").value = userId;
            document.getElementById("editName").value = userName;
            document.getElementById("editEmail").value = userEmail;

            const editUserForm = document.getElementById("editUserForm");
            editUserForm.action = `/admin/users/${userId}`;
        });
    });
});

window.uploadImageCanvas = uploadImageCanvas;

function uploadImageCanvas(id, image_preview_id) {
    const fileInput = document.getElementById(id);
    fileInput.click();
    const imagePreview = document.getElementById(image_preview_id);

    fileInput.addEventListener("change", (event) => {
        const file = event.target.files[0];

        if (file) {
            const reader = new FileReader();

            reader.onload = (e) => {
                imagePreview.src = e.target.result;
            };

            reader.readAsDataURL(file);
        }
    });
}

document.addEventListener("DOMContentLoaded", async () => {
    const { default: ClassicEditor } = await import(
        "@ckeditor/ckeditor5-build-classic"
    );

    // Basic editor (no media)
    document.querySelectorAll("textarea.ckeditor").forEach((textarea) => {
        ClassicEditor.create(textarea)
            .then((editor) => {
                console.log("Basic CKEditor initialized", editor);
            })
            .catch((error) => {
                console.error("Basic CKEditor init error:", error);
            });
    });

    // Media editor
    document.querySelectorAll("textarea.ckeditor-media").forEach((textarea) => {
        ClassicEditor.create(textarea, {
            extraPlugins: [MyCustomUploadAdapterPlugin],
            mediaEmbed: { previewsInData: true },
        })
            .then((editor) => {
                let knownImages = getImageSrcs(editor.getData());

                // Keep knownImages in sync when content changes
                let debounceTimer;
                editor.model.document.on("change:data", () => {
                    clearTimeout(debounceTimer);
                    debounceTimer = setTimeout(() => {
                        const currentImages = getImageSrcs(editor.getData());
                        const removed = knownImages.filter(
                            (src) => !currentImages.includes(src)
                        );

                        if (removed.length > 0) {
                            removed.forEach((url) =>
                                deleteImageFromServer(url)
                            );
                        }

                        knownImages = currentImages;
                    }, 300);
                });

                // Add listener for manual image insertion too (e.g., drag-drop or upload)
                editor.plugins
                    .get("FileRepository")
                    .on("uploadComplete", () => {
                        knownImages = getImageSrcs(editor.getData());
                    });
            })
            .catch((error) => {
                console.error("Media CKEditor init error:", error);
            });
    });

    // Extract all <img src="..."> URLs from editor data
    function getImageSrcs(html) {
        const matches = html.matchAll(/<img[^>]+src="([^">]+)"/g);
        return Array.from(matches, (m) => m[1]);
    }

    // Call backend to delete image
    function deleteImageFromServer(url) {
        fetch("/admin/ckeditor/delete-image", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": document.querySelector(
                    'meta[name="csrf-token"]'
                ).content,
                "Content-Type": "application/json",
            },
            body: JSON.stringify({ url }),
        })
            .then((res) => res.json())
            .then((res) => {
                console.log("Image deleted from server:", url, res);
            })
            .catch((err) => {
                console.error("Image deletion failed:", url, err);
            });
    }

    // Upload adapter with support for Laravel backend
    function MyCustomUploadAdapterPlugin(editor) {
        editor.plugins.get("FileRepository").createUploadAdapter = (loader) => {
            return new MyUploadAdapter(loader);
        };
    }

    class MyUploadAdapter {
        constructor(loader) {
            this.loader = loader;
        }

        upload() {
            return this.loader.file.then((file) => {
                const data = new FormData();
                data.append("upload", file);

                return fetch("/admin/ckeditor/upload", {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector(
                            'meta[name="csrf-token"]'
                        ).content,
                    },
                    body: data,
                })
                    .then((res) => res.json())
                    .then((res) => {
                        if (!res.url) throw new Error("Upload failed");
                        return { default: res.url };
                    });
            });
        }

        abort() {
            // Optional: handle aborts if needed
        }
    }
});

document.addEventListener("DOMContentLoaded", () => {
    if ($(".select2").length) {
        $(".select2").select2({
            allowClear: true,
            placeholder: "",
        });
    }
});

const lightbox = GLightbox({
    selector: ".glightbox", // CSS selector for the elements
    skin: "clean", // Skin type ('clean' or 'minimal')
    closeButton: true, // Show close button
    startAt: 0, // Index to start at in the group
    loop: true, // Loop through images/videos
    zoomable: true, // Allow zoom on images
    draggable: true, // Allow dragging on desktop
    touchNavigation: true, // Swipe to navigate on mobile
    keyboardNavigation: true, // Navigate using arrow keys
    autoplayVideos: true, // Auto-play embedded videos
    openEffect: "zoom", // Animation on open ('zoom', 'fade', 'none')
    closeEffect: "fade", // Animation on close
    slideEffect: "slide", // Animation when navigating slides
});
