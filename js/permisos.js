function iniciarPermisos(){

    document.querySelectorAll(".checkPermiso").forEach(check=>{

        check.onchange=function(){

            let id=this.dataset.id;

            let permitido=this.checked ? 1 : 0;

            fetch("ajax/cambiar_permiso.php",{

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

                        position:"bottom-end",

                        icon:"success",

                        title:"Permiso actualizado",

                        background:"#1f2937",

                        color:"#fff",

                        showConfirmButton:false,

                        timer:1800,

                        timerProgressBar:true

                    });

                }

            });

        };

    });

}