console.log("usuarios.js cargado");

function iniciarUsuarios(){

    const formulario = document.getElementById("formUsuario");

    if (!formulario) {
        console.log("No se encontró el formulario");
        return;
    }

    formulario.addEventListener("submit", function (e) {

        e.preventDefault();

        console.log("Formulario enviado");

        let datos = new FormData(formulario);

        fetch("ajax/guardar_usuario.php", {
            method: "POST",
            body: datos
        })
        .then(r => r.text())
        .then(res => {

    console.log("Respuesta:", res);

    if(res=="ok"){

        Swal.fire({
            toast:true,
            position:'bottom-end',
            icon:'success',
            title:'Usuario guardado',
            background:'#1f2937',
            color:'#fff',
            showConfirmButton:false,
            timer:2000,
            timerProgressBar:true
        });

        document.getElementById("modalUsuario").style.display="none";

        formulario.reset();

        setTimeout(()=>{
            location.reload();
        },700);

    }else if(res=="existe"){

        Swal.fire({
            toast:true,
            position:'bottom-end',
            icon:'error',
            title:'Ese usuario ya existe',
            background:'#1f2937',
            color:'#fff',
            showConfirmButton:false,
            timer:2000,
            timerProgressBar:true
        });

    }

});

    });

;
  }
  document.addEventListener("DOMContentLoaded",function(){

    iniciarUsuarios();

});
// ==============================
// EDITAR USUARIO
// ==============================

document.addEventListener("click", function(e){

    if(e.target.classList.contains("editar")){

        e.preventDefault();

        let id = e.target.dataset.id;

        fetch("ajax/obtener_usuario.php?id="+id)
        .then(r=>r.json())
        .then(usuario=>{

            document.getElementById("tituloModal").innerText = "Editar Usuario";

            document.getElementById("idUsuario").value = usuario.id;
            document.getElementById("usuario").value = usuario.usuario;
            document.getElementById("nombre").value = usuario.nombre;
            document.getElementById("rol").value = usuario.rol;
            document.getElementById("estado").value = usuario.estado;

            document.getElementById("password").value = "";

            document.getElementById("modalUsuario").style.display="flex";

        });

    }

});
// ==============================
// ACTIVAR / INACTIVAR USUARIO
// ==============================

document.addEventListener("click", function(e){

    if(e.target.classList.contains("estado")){

        e.preventDefault();

        let boton = e.target;

        let id = boton.dataset.id;
        let estado = boton.dataset.estado;

        fetch("ajax/cambiar_estado_usuario.php",{
            method:"POST",
            headers:{
                "Content-Type":"application/x-www-form-urlencoded"
            },
            body:"id="+id+"&estado="+estado
        })
        .then(r=>r.text())
        .then(res=>{

    let nuevoEstado = res.trim();
    let estadoTexto = document.getElementById("estado-"+id);

    // 🔥 ACTUALIZAR DATASET CORRECTO
    boton.dataset.estado = nuevoEstado;

    // 🔥 CAMBIAR ICONO SEGÚN ESTADO REAL
    if(nuevoEstado == "Activo"){
        boton.innerHTML = "🔒";
    } else {
        boton.innerHTML = "🔓";
    }

    // 🔥 ACTUALIZAR TEXTO EN TABLA
    if(estadoTexto){
        estadoTexto.innerText = nuevoEstado;

        if(nuevoEstado == "Activo"){
            estadoTexto.classList.add("activo");
            estadoTexto.classList.remove("inactivo");
        } else {
            estadoTexto.classList.add("inactivo");
            estadoTexto.classList.remove("activo");
        }
    }

    Swal.fire({
        toast:true,
        position:'bottom-end',
        icon:'success',
        title:'Estado actualizado',
        showConfirmButton:false,
        timer:1500
    });

});

    }

});
// ==============================
// ELIMINAR USUARIO
// ==============================

document.querySelectorAll(".btn-mini.eliminar").forEach(boton=>{

    boton.addEventListener("click",function(e){

        e.preventDefault();

        let id = this.dataset.id;

        Swal.fire({

            title:"¿Eliminar usuario?",

            text:"Esta acción no se puede deshacer.",

            icon:"warning",

            showCancelButton:true,

            confirmButtonText:"Sí, eliminar",

            cancelButtonText:"Cancelar",

            confirmButtonColor:"#dc3545",

            cancelButtonColor:"#6c757d"

        }).then((result)=>{

            if(result.isConfirmed){

                fetch("ajax/eliminar_usuario.php",{

                    method:"POST",

                    headers:{
                        "Content-Type":"application/x-www-form-urlencoded"
                    },

                    body:"id="+id

                })

                .then(r=>r.text())

                .then(res=>{

                    if(res=="ok"){

                        Swal.fire({

                            toast:true,

                            position:'bottom-end',

                            icon:'success',

                            title:'Usuario eliminado',

                            background:'#1f2937',

                            color:'#fff',

                            showConfirmButton:false,

                            timer:2000,

                            timerProgressBar:true

                        });

                        setTimeout(()=>{
                            document.addEventListener("click", function(e){

    if(e.target.classList.contains("eliminar")){

        e.preventDefault();

        let id = e.target.dataset.id;

        Swal.fire({
            title:"¿Eliminar usuario?",
            icon:"warning",
            showCancelButton:true,
            confirmButtonText:"Sí, eliminar"
        }).then((result)=>{

            if(result.isConfirmed){

                fetch("ajax/eliminar_usuario.php",{
                    method:"POST",
                    headers:{
                        "Content-Type":"application/x-www-form-urlencoded"
                    },
                    body:"id="+id
                })
                .then(r=>r.text())
                .then(res=>{

                    if(res=="ok"){

                        document.getElementById("fila-"+id).remove();

                        Swal.fire({
                            toast:true,
                            icon:'success',
                            title:'Usuario eliminado',
                            timer:1500,
                            showConfirmButton:false
                        });

                    }

                });

            }

        });

    }

});
                        },2100);

                    }else if(res=="admin"){

                        Swal.fire({

                            icon:"error",

                            title:"No permitido",

                            text:"No puedes eliminar el administrador principal."

                        });

                    }

                });

            }

        });

    });

});