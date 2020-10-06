const formulariosAjax = document.querySelectorAll(".FormularioAjax");

//prevenimos la redireccion a una misma pagina al enviar datos del formulario
function enviarFormularioAjax(e){
    e.preventDefault();

    let data = new FormData(this);
    let method = this.getAttribute("method");
    let action = this.getAttribute("action");
    let tipo = this.getAttribute("data-form");

    let encabezados = new Headers();

    let config = {
        method: method,
        headers: encabezados,
        mode: 'cors',
        cache: 'no-cache',
        body: data
    }

    let textoAlerta;
    if(tipo==="save"){
        textoAlerta = "Los datos serán guardados en el sistema.";
    }
    else if(tipo==="delete"){
        textoAlerta = "¡Los datos serán eliminados del sistema!";
    }
    else if(tipo==="update"){
        textoAlerta = "Los datos serán actualizados en el sistema.";
    }
    else if(tipo==="search"){
        textoAlerta = "Se va a borrar la búsqueda realizada.";
    }
    else if(tipo==="loans"){
        textoAlerta = "¿Desea remover los datos seleccionados?";
    }
    else{
        textoAlerta = "¿Quiere realizar la operación?";
    }
    Swal.fire({
        title: '¿Esta seguro/a?',
        text: textoAlerta,
        type: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Aceptar',
        cancelButtonText: 'Cancelar'
      }).then((result) => {
        if (result.value) {
            fetch(action,config)
            .then(respuesta => respuesta.json())
            .then (respuesta => {
                return alertasAjax(respuesta);
            });
        }
      });
}

formulariosAjax.forEach(formularios => {
    formularios.addEventListener("submit", enviarFormularioAjax);
});

function alertasAjax(alerta){
    if(alerta.Alerta==="simple"){
        Swal.fire({
            title: alerta.Titulo,
            text: alerta.Texto,
            type: alerta.Tipo,
            confirmButtonText: 'Aceptar'
          });
    }
    else if(alerta.Alerta==="recargar"){
        Swal.fire({
            title: alerta.Titulo,
            text: alerta.Texto,
            type: alerta.Tipo,
            confirmButtonText: 'Aceptar'
          }).then((result) => {
            if (result.value) {
                location.reload();
            }
          });
    }
    else if(alerta.Alerta==="limpiar"){
        Swal.fire({
            title: alerta.Titulo,
            text: alerta.Texto,
            type: alerta.Tipo,
            confirmButtonText: 'Aceptar'
          }).then((result) => {
            if (result.value) {
                document.querySelector(".FormularioAjax").reset();
            }
          });
    }
    else if(alerta.Alerta==="redireccionar"){
        window.location.href=alerta.URL;
    }
}