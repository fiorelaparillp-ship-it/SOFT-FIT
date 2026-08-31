<?php
/** @var mysqli $conexion */



$usuarios = mysqli_query(
$conexion,
"SELECT * FROM usuario
ORDER BY id DESC"
);

?>

<div class="apariencia-module">

    <!-- ENCABEZADO -->
    <div class="apariencia-header">

        <div>
            <h2>
                <i class="fa-solid fa-palette"></i>
                Apariencia del Sistema
            </h2>

            <p>
                Elige el tema que prefieras para tu experiencia
                y personaliza la apariencia de SOFT-FIT.
            </p>
        </div>

    </div>


    <!-- TEMA -->
    <div class="apariencia-section">

        <h3>Tema del Sistema</h3>

        <div class="tema-options">

            <!-- MODO OSCURO -->
            <div class="tema-card selected"
                 data-theme="dark">

                <div class="tema-icon">
                    <i class="fa-solid fa-moon"></i>
                </div>

                <strong>Modo Oscuro</strong>

                <div class="radio-circle"></div>

            </div>


            <!-- MODO CLARO -->
            <div class="tema-card"
                 data-theme="light">

                <div class="tema-icon">
                    <i class="fa-solid fa-sun"></i>
                </div>

                <strong>Modo Claro</strong>

                <div class="radio-circle"></div>

            </div>

        </div>

    </div>


    <div class="apariencia-divider"></div>


    <!-- COLOR PRINCIPAL -->
    <div class="apariencia-section">

        <h3>Color principal</h3>

        <p>
            Elige el color principal del sistema.
        </p>

        <div class="color-options">

            <button class="color-option selected"
                    data-primary="#7b2cbf"
                    style="--color:#7b2cbf;">
            </button>

            <button class="color-option"
                    data-primary="#2563eb"
                    style="--color:#2563eb;">
            </button>

            <button class="color-option"
                    data-primary="#16a34a"
                    style="--color:#16a34a;">
            </button>

            <button class="color-option"
                    data-primary="#f97316"
                    style="--color:#f97316;">
            </button>

            <button class="color-option"
                    data-primary="#ef3154"
                    style="--color:#ef3154;">
            </button>

        </div>

    </div>


    <!-- COLOR ACENTO -->
    <div class="apariencia-section">

        <h3>Color de acento</h3>

        <p>
            Color utilizado en botones, enlaces y elementos principales.
        </p>

        <div class="color-options">

            <button class="accent-option selected"
                    data-accent="#7b2cbf"
                    style="--color:#7b2cbf;">
            </button>

            <button class="accent-option"
                    data-accent="#2563eb"
                    style="--color:#2563eb;">
            </button>

            <button class="accent-option"
                    data-accent="#06b6d4"
                    style="--color:#06b6d4;">
            </button>

            <button class="accent-option"
                    data-accent="#ec4899"
                    style="--color:#ec4899;">
            </button>

            <button class="accent-option"
                    data-accent="#eab308"
                    style="--color:#eab308;">
            </button>

        </div>

    </div>


    <!-- LOGO -->
    <div class="apariencia-section logo-section">

        <h3>Logo del Gimnasio</h3>

        <p>
            Sube el logo que deseas utilizar en el sistema.
        </p>

        <div class="logo-upload">

            <div class="upload-icon">
                <i class="fa-solid fa-upload"></i>
            </div>

            <input
                type="file"
                id="logoGimnasio"
                accept=".png,.jpg,.jpeg,.svg"
            >

            <label for="logoGimnasio">
                Seleccionar archivo
            </label>

            <span>
                PNG, JPG o SVG (máx. 2MB)
            </span>

        </div>

        <!-- PREVISUALIZACIÓN -->
        <div id="logoPreview" class="logo-preview"></div>

    </div>


    <div class="apariencia-divider"></div>


    <!-- GUARDAR -->
    <div class="guardar-apariencia">

        <div>

            <h3>Guardar cambios</h3>

            <p>
                Aplica las modificaciones de apariencia al sistema.
            </p>

        </div>

        <button id="btnGuardarApariencia"
                class="btn-guardar-apariencia">

            <i class="fa-solid fa-floppy-disk"></i>

            Guardar Cambios

        </button>

    </div>

</div>