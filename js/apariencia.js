function iniciarApariencia() {

    console.log("Módulo Apariencia iniciado");


    /* =====================================================
       TEMA OSCURO / CLARO
    ===================================================== */

    const temas = document.querySelectorAll(".tema-card");

    temas.forEach(tema => {

        tema.addEventListener("click", function() {

            temas.forEach(t => {
                t.classList.remove("selected");
            });

            this.classList.add("selected");

            const temaSeleccionado = this.dataset.theme;

            aplicarTema(temaSeleccionado);

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


            /* Tamaño máximo */

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


            /* Formatos permitidos */

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


            /* Vista previa */

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
       GUARDAR CONFIGURACIÓN
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


            /* Guardar */

            localStorage.setItem(
                "softfit_apariencia",
                JSON.stringify(configuracion)
            );


            /* Aplicar tema */

            aplicarTema(configuracion.tema);


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


    /* =====================================================
       CARGAR CONFIGURACIÓN GUARDADA
    ===================================================== */

    cargarConfiguracion();

}


/* =========================================================
   APLICAR TEMA
========================================================= */

function aplicarTema(tema) {

    if(tema === "light") {

        document.body.classList.add("light-mode");

    } else {

        document.body.classList.remove("light-mode");

    }

}


/* =========================================================
   CARGAR CONFIGURACIÓN
========================================================= */

function cargarConfiguracion() {

    const guardado =
        localStorage.getItem("softfit_apariencia");


    if(!guardado) {

        aplicarTema("dark");

        return;

    }


    try {

        const configuracion =
            JSON.parse(guardado);


        /* Tema */

        aplicarTema(
            configuracion.tema || "dark"
        );


        /* Seleccionar tarjeta */

        const temaCard =
            document.querySelector(
                `.tema-card[data-theme="${configuracion.tema}"]`
            );


        if(temaCard) {

            document.querySelectorAll(".tema-card")
                .forEach(t => t.classList.remove("selected"));

            temaCard.classList.add("selected");

        }


        /* Color principal */

        if(configuracion.colorPrincipal) {

            const color =
                document.querySelector(
                    `.color-option[data-primary="${configuracion.colorPrincipal}"]`
                );

            if(color) {

                document.querySelectorAll(".color-option")
                    .forEach(c => c.classList.remove("selected"));

                color.classList.add("selected");

            }

        }


        /* Color de acento */

        if(configuracion.colorAcento) {

            const acento =
                document.querySelector(
                    `.accent-option[data-accent="${configuracion.colorAcento}"]`
                );

            if(acento) {

                document.querySelectorAll(".accent-option")
                    .forEach(a => a.classList.remove("selected"));

                acento.classList.add("selected");

            }

        }


    } catch(error) {

        console.error(
            "Error cargando configuración:",
            error
        );

    }

}