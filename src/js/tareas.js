(() => {
    obtenerTareas();
    let tareas = [];
    let filtradas = [];
    // Boton para mostrar el modal de agregar tarea
    const nuevaTareaBtn = document.querySelector('#agregar-tarea');
    nuevaTareaBtn.addEventListener('click', () => {
        mostrarFormulario(false, {});
    });

    // Filtros de búsqueda
    const filtros = document.querySelectorAll('#filtros input[type="radio"]');
    filtros.forEach(filtro => {
        filtro.addEventListener('input', filtrarTareas);
    })

    function filtrarTareas(e) {
        const filtro = e.target.value;

        if (filtro !== '') {
            filtradas = tareas.filter(tarea => tarea.estado === filtro)
        } else {
            filtradas = [];
        }
        mostrarTareas()
    }
    async function obtenerTareas() {
        try {
            const id = obtenerProyecto();
            const url = `${location.origin}/api/tareas?url=${id}`;
            const respuesta = await fetch(url);
            const resultado = await respuesta.json();

            tareas = resultado.tareas;

            mostrarTareas();
        } catch (error) {
            console.log(error);
        }
    }

    function mostrarTareas() {
        limpiarTareas();
        totalPendientes();
        totalCompletadas();
        const arrayTareas = filtradas.length ? filtradas : tareas;
        if (arrayTareas.length === 0) {
            const contenedorTareas = document.querySelector('#listado-tareas');

            const textoNoTareas = document.createElement('LI');
            textoNoTareas.textContent = 'Aun no agregaste tareas para este proyecto';
            textoNoTareas.classList.add('no-tareas');
            contenedorTareas.appendChild(textoNoTareas);
            return;
        }

        const estados = {
            0: 'Pendiente',
            1: 'Completa'
        }

        arrayTareas.forEach(tarea => {
            const contenedorTarea = document.createElement('LI');
            contenedorTarea.dataset.tareaId = tarea.id;
            contenedorTarea.classList.add('tarea');

            const nombreTarea = document.createElement('P');
            nombreTarea.textContent = tarea.nombre;
            nombreTarea.title = 'Doble click para editar';
            nombreTarea.ondblclick = () => {
                mostrarFormulario(editar = true, {...tarea });
            }

            const opcionesDiv = document.createElement('DIV');
            opcionesDiv.classList.add('opciones');

            // Botones
            const btnEstadoTarea = document.createElement('BUTTON');
            btnEstadoTarea.classList.add('estado-tarea');
            btnEstadoTarea.classList.add(`${estados[tarea.estado].toLowerCase()}`)
            btnEstadoTarea.textContent = estados[tarea.estado];
            btnEstadoTarea.dataset.estadoTarea = tarea.estado;

            btnEstadoTarea.ondblclick = () => {
                cambiarEstadoTarea({...tarea });
            }

            const btnEliminarTarea = document.createElement('BUTTON');
            btnEliminarTarea.classList.add('eliminar-tarea');
            btnEliminarTarea.dataset.idTarea = tarea.id;
            btnEliminarTarea.textContent = 'Eliminar';

            btnEliminarTarea.ondblclick = () => {
                confirmarEliminarTarea({...tarea });
            }

            opcionesDiv.appendChild(btnEstadoTarea);
            opcionesDiv.appendChild(btnEliminarTarea);

            contenedorTarea.appendChild(nombreTarea);
            contenedorTarea.appendChild(opcionesDiv);

            const listadoTareas = document.querySelector('#listado-tareas');
            listadoTareas.appendChild(contenedorTarea);
        })
    }

    function totalPendientes() {
        const totalPendientes = tareas.filter(tarea => tarea.estado === "0");
        const pendienteRadio = document.querySelector('#pendientes');

        if (totalPendientes.length === 0) {
            pendienteRadio.disabled = true;
        } else {
            pendienteRadio.disabled = false;
        }
    }

    function totalCompletadas() {
        const totalCompletadas = tareas.filter(tarea => tarea.estado === "1");
        const completadasRadio = document.querySelector('#completadas');

        if (totalCompletadas.length === 0) {
            completadasRadio.disabled = true;
        } else {
            completadasRadio.disabled = false;
        }
    }

    function mostrarFormulario(editar, tarea = {}) {
        const modal = document.createElement('DIV');
        modal.classList.add('modal');
        modal.innerHTML = `
            <form class="formulario nueva-tarea">
                <legend>${editar ? 'Editar tarea' : 'Añade una nueva tarea'}</legend>
                <div class="campo">
                    <label for="tarea">Tarea</label>
                    <input type="text" nombre="tarea" id="tarea" placeholder="${tarea.nombre ? 'Edita la tarea del proyecto' : 'Añadir tarea al proyecto actual'}" autocomplete="off" required value="${tarea.nombre ? tarea.nombre : ''}" />
                </div>
                <div class="opciones">
                    <input type="submit" class="submit-nueva-tarea" value="${tarea.nombre ? 'Editar tarea' : 'Añadir tarea'}"/>
                    <button type="button" class="cerrar-modal">Cancelar</button>
                </div>
            </form> 
        `;

        setTimeout(() => {
            const form = document.querySelector(".formulario");
            form.classList.add('animar');
        }, 0);

        modal.addEventListener('click', (e) => {
            e.preventDefault();

            if (e.target.classList.contains('cerrar-modal')) {
                const form = document.querySelector(".formulario");
                form.classList.add('cerrar');
                setTimeout(() => {
                    modal.remove();
                }, 500);
            }
            if (e.target.classList.contains('submit-nueva-tarea')) {
                const nombreTarea = document.querySelector('#tarea').value.trim();
                if (nombreTarea === '') {
                    // Mostrar alerta de error
                    mostrarAlerta('El nombre de la tarea es obligatorio', 'error', document.querySelector('.formulario legend'));
                    return;
                }

                if (editar) {
                    tarea.nombre = nombreTarea;
                    actualizarTarea(tarea)
                } else {
                    agregarTarea(nombreTarea);
                }

            }

        })
        document.querySelector('.dashboard').appendChild(modal);
    }




    // Muestra un mensaje en la interfaz
    function mostrarAlerta(msg, type, ref) {
        const alertaPrevia = document.querySelector('.alerta');
        if (alertaPrevia) {
            alertaPrevia.remove();
        }
        const alerta = document.createElement('DIV');
        const cerrar = document.createElement("SPAN");
        cerrar.textContent = "X";
        cerrar.classList.add("cerrar");
        cerrar.title = "Cerrar";
        alerta.classList.add('alerta', type);
        alerta.textContent = msg;
        alerta.appendChild(cerrar);
        ref.parentElement.insertBefore(alerta, ref.nextElementSibling);
        cerrar.addEventListener('click', () => {
            const alerta = cerrar.parentNode; //o pudo ser cerrar.closest('.alerta');
            alerta.style.display = "none";
        })
        setTimeout(() => {
            alerta.remove();
        }, 5000);
    }

    // Consultar al servidor para añadir una nueva tarea al proyecto actual
    async function agregarTarea(tarea) {
        // Construir la petición
        const datos = new FormData();
        datos.append('nombre', tarea);
        datos.append('proyectoId', obtenerProyecto());

        try {
            const url = `${location.origin}/api/tarea`;
            const respuesta = await fetch(url, {
                method: 'POST',
                body: datos
            });
            const resultado = await respuesta.json();

            mostrarAlerta(resultado.mensaje, resultado.tipo, document.querySelector('.formulario legend'));

            if (resultado.tipo === 'exito') {
                const modal = document.querySelector('.modal');
                setTimeout(() => {
                    modal.remove();
                }, 5000);

                // Agregar el objeto de tarea al global de tareas
                const tareaObj = {
                    id: String(resultado.id),
                    nombre: tarea,
                    estado: "0",
                    proyectoId: resultado.proyectoId
                }
                tareas = [...tareas, tareaObj];
                mostrarTareas();
            }
        } catch (error) {
            console.log(error);
        }
    }

    function cambiarEstadoTarea(tarea) {
        const nuevoEstado = tarea.estado === "1" ? "0" : "1";
        tarea.estado = nuevoEstado;
        actualizarTarea(tarea);
    }

    async function actualizarTarea(tarea) {
        const { id, estado, nombre, proyectoId } = tarea;
        const datos = new FormData();
        datos.append('id', id);
        datos.append('nombre', nombre);
        datos.append('estado', estado);
        datos.append('proyectoId', obtenerProyecto());


        try {
            const url = `${location.origin}/api/tarea/actualizar`;
            const respuesta = await fetch(url, {
                method: 'POST',
                body: datos
            });
            const resultado = await respuesta.json();
            if (resultado.respuesta.tipo === 'exito') {
                // mostrarAlerta(resultado.respuesta.mensaje, resultado.respuesta.tipo, document.querySelector('.contenedor-nueva-tarea'));
                Swal.fire(
                    'Éxito 😁',
                    resultado.respuesta.mensaje,
                    'success'
                );

                const modal = document.querySelector('.modal');
                if (modal) {
                    modal.remove();
                }

                tareas = tareas.map(tareaMemoria => {
                    if (tareaMemoria.id === id) {
                        tareaMemoria.estado = estado;
                        tareaMemoria.nombre = nombre;
                    }

                    return tareaMemoria;
                });
                mostrarTareas()
            }
        } catch (error) {
            console.log(error);
        }
    }

    function confirmarEliminarTarea(tarea) {
        Swal.fire({
            title: '¿Estas seguro que quieres hacer esto?',
            text: "¡No podrás revertir esto!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#4338ca',
            cancelButtonColor: '#d33',
            confirmButtonText: '¡Sí, bórralo!',
            cancelButtonText: 'Cancelar',
            customClass: {
                actions: 'outnone',
                cancelButton: 'outnone',
                confirmButton: 'outnone',
                denyButton: 'outnone',
            }
        }).then((result) => {
            if (result.isConfirmed) {
                eliminarTarea(tarea);
            }
        })

    }

    async function eliminarTarea(tarea) {
        const { id, estado, nombre } = tarea;
        const datos = new FormData();
        datos.append('id', id);
        datos.append('nombre', nombre);
        datos.append('estado', estado);
        datos.append('proyectoId', obtenerProyecto());


        try {
            const url = `${location.origin}/api/tarea/eliminar`;
            const respuesta = await fetch(url, {
                method: 'POST',
                body: datos
            });
            const resultado = await respuesta.json();
            if (resultado.resultado) {
                // mostrarAlerta(resultado.resultado.mensaje, resultado.resultado.tipo, document.querySelector('.contenedor-nueva-tarea'));
                Swal.fire(
                    '¡Eliminado!',
                    resultado.mensaje,
                    'success'
                )

                tareas = tareas.filter(tareaMemoria => tareaMemoria.id !== tarea.id);

                mostrarTareas()
            }
        } catch (error) {
            console.log(error);
        }
    }

    function obtenerProyecto() {
        const proyectosParams = new URLSearchParams(window.location.search);
        const proyecto = Object.fromEntries(proyectosParams.entries());
        return proyecto.url;
    }

    function limpiarTareas() {
        const listadoTareas = document.querySelector('#listado-tareas');
        while (listadoTareas.firstChild) {
            listadoTareas.removeChild(listadoTareas.firstChild);
        }
    }
})();