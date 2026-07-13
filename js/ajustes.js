document.addEventListener("DOMContentLoaded", ()=>{

    const menu = document.querySelectorAll(".menu-item");

    const contenido = document.getElementById("settingsContent");

    menu.forEach(item=>{

        item.addEventListener("click",()=>{

            menu.forEach(x=>x.classList.remove("active"));

            item.classList.add("active");

            const modulo = item.dataset.modulo;

            fetch("cargar_modulo.php?modulo="+modulo)

            .then(r=>r.text())

            .then(html=>{

    contenido.innerHTML = html;

    // Inicializar eventos del módulo Usuarios
    if(modulo=="usuarios" && typeof iniciarUsuarios==="function"){
        iniciarUsuarios();
    }

    // Inicializar eventos del módulo Permisos
    if(modulo=="permisos" && typeof iniciarPermisos==="function"){
        iniciarPermisos();
    }

});

        });

    });

});
document.addEventListener("click",(e)=>{

if(e.target.id==="btnNuevoUsuario"){

document.getElementById("modalUsuario").style.display="flex";

}

if(e.target.id==="cerrarModal"){

document.getElementById("modalUsuario").style.display="none";

}

});

// ==============================
// GUARDAR PERMISOS
// ==============================

document.addEventListener("change",function(e){

    if(!e.target.classList.contains("checkPermiso")) return;

    let id = e.target.dataset.id;
    let permitido = e.target.checked ? 1 : 0;

    fetch("ajax/guardar_permiso.php",{

        method:"POST",

        headers:{
            "Content-Type":"application/x-www-form-urlencoded"
        },

        body:"id="+id+"&permitido="+permitido

    })

    .then(r=>r.text())

    .then(res=>{

        if(res=="ok"){

            Swal.fire({

                toast:true,
                position:'bottom-end',
                icon:'success',
                title:'Permiso actualizado',
                background:'#1f2937',
                color:'#fff',
                showConfirmButton:false,
                timer:1800,
                timerProgressBar:true

            });

        }

    });

});