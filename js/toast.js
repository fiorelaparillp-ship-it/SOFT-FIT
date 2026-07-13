function mostrarToast(mensaje,tipo="success"){

    let toast=document.createElement("div");

    toast.className="toast-success";

    toast.innerHTML=`

        <div class="toast-icon">

            ✔

        </div>

        <div class="toast-content">

            <h4>${mensaje}</h4>

        </div>

    `;

    document.body.appendChild(toast);

    setTimeout(()=>{

        toast.style.animation="toastOut .35s forwards";

    },2500);

    setTimeout(()=>{

        toast.remove();

    },2850);

}