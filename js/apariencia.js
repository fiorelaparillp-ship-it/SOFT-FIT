function iniciarApariencia() {

    console.log("Módulo Apariencia iniciado");


    /* =====================================================
       TEMA
    ===================================================== */

    const temas = document.querySelectorAll(".tema-card");

    temas.forEach(tema => {

        tema.addEventListener("click", function() {

            temas.forEach(t => {
                t.classList.remove("selected");
            });

            this.classList.add("selected");

        });

    });


    /* =====================================================
       COLOR PRINCIPAL
    ===================================================== */

    const colores = document.querySelectorAll(".color-option");

    colores.forEach(color => {

        color.addEventListener("click", function() {

            colores.forEach(c => {
                c.classList.remove("selected");
            });

            this.classList.add("selected");

        });

    });


    /* =====================================================
       COLOR DE ACENTO
    ===================================================== */

    const acentos = document.querySelectorAll(".accent-option");

    acentos.forEach(acento => {

        acento.addEventListener("click", function() {

            acentos.forEach(a => {
                a.classList.remove("selected");
            });

            this.classList.add("selected");

        });

    });


    /* =====================================================
       PREVISUALIZACIÓN DEL LOGO
    ===================================================== */

    const inputLogo = document.getElementById("logoGimnasio");

    const preview = document.getElementById("logoPreview");


    if(inputLogo) {

        inputLogo.addEventListener("change", function() {

            const archivo = this.files[0];

            if(!archivo) return;


            /* Validar tamaño */

            if(archivo.size > 2 * 1024 * 1024) {

                Swal.fire({
                    icon: "warning",
                    title: "Archivo demasiado grande",
                    text: "El logo no puede superar los 2 MB.",
                    confirmButtonColor: "#7b2cbf"
                });

                this.value = "";

                return;
            }


            /* Validar formato */

            const tiposPermitidos = [
                "image/png",
                "image/jpeg",
                "image/svg+xml"
            ];


            if(!tiposPermitidos.includes(archivo.type)) {

                Swal.fire({
                    icon: "warning",
                    title: "Formato no permitido",
                    text: "Utiliza PNG, JPG o SVG.",
                    confirmButtonColor: "#7b2cbf"
                });

                this.value = "";

                return;
            }


            /* Mostrar preview */

            const lector = new FileReader();

            lector.onload = function(e) {

                preview.innerHTML =
                    `<img src="${e.target.result}" alt="Vista previa del logo">`;

                preview.style.display = "block";

            };

            lector.readAsDataURL(archivo);

        });

    }


    /* =====================================================
       GUARDAR
    ===================================================== */

    const btnGuardar =
        document.getElementById("btnGuardarApariencia");


    if(btnGuardar) {

        btnGuardar.addEventListener("click", function() {


            const temaSeleccionado =
                document.querySelector(".tema-card.selected");


            const colorPrincipal =
                document.querySelector(".color-option.selected");


            const colorAcento =
                document.querySelector(".accent-option.selected");


            const configuracion = {

                tema:
                    temaSeleccionado
                    ? temaSeleccionado.dataset.theme
                    : "dark",

                colorPrincipal:
                    colorPrincipal
                    ? colorPrincipal.dataset.primary
                    : "#7b2cbf",

                colorAcento:
                    colorAcento
                    ? colorAcento.dataset.accent
                    : "#7b2cbf"

            };


            /* Guardar temporalmente */

            localStorage.setItem(
                "softfit_apariencia",
                JSON.stringify(configuracion)
            );


            Swal.fire({

                toast: true,

                position: "bottom-end",

                icon: "success",

                title: "Apariencia guardada",

                text: "Los cambios fueron guardados correctamente.",

                background: "#1f2937",

                color: "#fff",

                showConfirmButton: false,

                timer: 2000,

                timerProgressBar: true

            });

        });

    }

}