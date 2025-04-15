import $ from "jquery";
import * as bootstrap from "bootstrap";
import "./bootstrap";
import "../css/app.css";
// import "../css/admin.css";
import "../css/client.css";
import ClassicEditor from "@ckeditor/ckeditor5-build-classic";
import "bootstrap-icons/font/bootstrap-icons.css";

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

document.addEventListener("DOMContentLoaded", () => {
    const editors = document.querySelectorAll(".ckeditor");
    editors.forEach((textarea) => {
        ClassicEditor.create(textarea).catch((error) => {
            console.error(error);
        });
    });
});

document.addEventListener("DOMContentLoaded", () => {
    if ($(".select2").length) {
        $(".select2").select2({
            allowClear: true,
            placeholder: "",
        });
    }
});
