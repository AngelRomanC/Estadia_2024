<script>
import { Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import Swal from 'sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
import Pagination from '@/Shared/Pagination.vue';
import LayoutMain from '@/layouts/LayoutMain.vue';
import {
    mdiMonitorCellphone,
    mdiTableBorder,
    mdiTableOff,
    mdiGithub,
    mdiApplicationEdit, mdiTrashCan
} from "@mdi/js";
import TableSampleClients from "@/components/TableSampleClients.vue";
import CardBox from "@/components/CardBox.vue";
import SectionTitleLineWithButton from "@/components/SectionTitleLineWithButton.vue";
import BaseLevel from "@/components/BaseLevel.vue";
import BaseButtons from "@/components/BaseButtons.vue";
import BaseButton from "@/components/BaseButton.vue";
import CardBoxComponentEmpty from "@/components/CardBoxComponentEmpty.vue";
import NotificationBar from "@/components/NotificationBar.vue";
import axios from 'axios' //agregar

export default {
    props: {
        titulo: { type: String, required: true },
        respuestas: { type: Object, required: true},
        Evaluacion: { type: Object, required: true},
        preguntas: { type: Object, required: true},
        version: { type: Object, required: true},
        grupo: { type: Object, required: true},
        Habito: { type: Object, required: true},
        routeName: { type: String, required: true },
        loadingResults: { type: Boolean, required: true, default: true }
    },
    components: {
        Link,
        LayoutMain,
        CardBox,
        TableSampleClients,
        SectionTitleLineWithButton,
        BaseLevel,
        BaseButtons,
        BaseButton,
        CardBoxComponentEmpty,
        Pagination,
        NotificationBar
    },
    setup(props) {
        const versionSeleccionada = ref('');
        const seleccionarVersion = (event) => {
    const seleccion = event.target.value; 
    versionSeleccionada.value = seleccion; // Actualizar el valor de versionSeleccionada
  };
        const form = useForm({
            respuesta: '',
            habito: '',
            evaluacion_id:'',
            version:'',
            formato:2,

            archivoNombre: '',
            
        });

        const formArchivo = useForm({ //agrego
            archivo: null
        })
        
        /*const handleSubmit = (habito) => {
            // Asignar el ID del académico al campo oculto
            form.habito = habito.id;
            form.version =habito.version;
            form.post(route('evaluacion.store'));
        };*/
        const handleSubmit = (habito) => {
    // Asignar el ID del académico y la versión al formulario
    form.habito = habito.id;
    form.version = habito.version;

    if (formArchivo.archivo) {
        // Si se adjunta un archivo, enviar la observación con el archivo adjunto
        actualizarArchivo(null).then((seActualizo) => {
            if (seActualizo) {
                // Archivo adjunto actualizado, enviar observación
                form.archivoNombre = formArchivo.archivo.name; // Actualizar nombre del archivo en el formulario principal
                form.post(route('evaluacion.store')); // Enviar observación con archivo adjunto
            }
        });
    } else {
        // Si no se adjunta archivo, enviar la observación sin archivo
        form.post(route('evaluacion.store'));
    }
};



    /*    const actualizarObservacion = (habito, evaluacion) => {
    
    form.habito = habito.user_id;
    form.respuesta = evaluacion.respuesta;
    form.evaluacion_id =evaluacion.id;
    form.version =habito.version;
    form.put(route('evaluacion.update', evaluacion.id), {
        respuesta: evaluacion.respuesta // Enviar la respuesta actualizada
    }).then(() => {
        // Aquí puedes agregar lógica adicional después de la actualización, como mostrar una notificación de éxito
        console.log('La observación se ha actualizado correctamente.');
    }).catch(error => {
        // Manejar errores si la solicitud de actualización falla
        console.error('Error al actualizar la observación:', error);
    }); 
};*/

//-----------------------------------
const actualizarObservacion = (habito, evaluacion) => {
            // console.log(evaluacion)
            actualizarArchivo(evaluacion.id).then((seActualizo) => {
                if (seActualizo) {
                    form.habito = habito.user_id;
                    form.respuesta = evaluacion.respuesta;
                    form.evaluacion_id = evaluacion.id;
                    form.version = habito.version;

                    form.put(route('evaluacion.update', evaluacion.id), {
                    respuesta: evaluacion.respuesta // Enviar la respuesta actualizada
                    }).then(() => {
                        // Aquí puedes agregar lógica adicional después de la actualización, como mostrar una notificación de éxito
                        console.log('La observación se ha actualizado correctamente.');
                    }).catch(error => {
                        // Manejar errores si la solicitud de actualización falla
                        console.error('Error al actualizar la observación:', error);
                    });
                }
            });        
        };

        const actualizarArchivo = (id) => {
            return new Promise((resolve, reject) => {
                formArchivo.errors.archivo = null
                const formData = new FormData();
                formData.append('evaluacion_id', id);
                formData.append('archivo', formArchivo.archivo);
                axios.post(route('evaluacion.cargarArchivo'),
                    formData,
                    {
                        headers: {
                            "Content-Type": "multipart/form-data",
                        },
                    }
                ).then((response) => {
                    if (response.status === 200) {
                        console.log(response.data.archivoNombre)
                        form.archivoNombre = response.data.archivoNombre
                        resolve(true);
                    }
                }).catch((error) => {
                    if (error.response.status === 500) {
                        Swal.fire({
                            title: "Error",
                            text: "Se produjo un error al actualizar la foto.",
                            icon: "error",
                            confirmButtonColor: "#3085d6",
                            confirmButtonText: "Ok",
                        });
                    } else if (error.response.status === 422) {
                        const { errors } = error.response.data;
                        formArchivo.errors.archivo = errors.archivo?.[0];
                    }
                    resolve(false);
                });

            });
        };
///--------------------------------

        const existeEvaluacionParaHabito = (habito) => {
        return props.Evaluacion.some(evaluacion => evaluacion.user_id === habito.user.id && evaluacion.version === habito.version);
    };
        const togglePreguntasRespuestas = (habito) => {
            habito.mostrarPreguntasRespuestas = !habito.mostrarPreguntasRespuestas;

            // Desplazar el elemento seleccionado hacia arriba después de un breve retraso
            setTimeout(() => {
                const elemento = document.getElementById(`habito_${habito.id}`);
                if (elemento && habito.mostrarPreguntasRespuestas) {
                    elemento.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            }, 100);
        };

        //--------------
        const mimeType = (name) => {
            // Comprobar si el nombre contiene un punto.
            if (name.includes('.')) {
                // Dividir el nombre por el punto y obtener la última parte (la extensión).
                const parts = name.split('.');
                // Devolver la última parte convertida a minúsculas.
                return parts[parts.length - 1].toLowerCase();
            } else {
                // Si no hay un punto, no hay extensión.
                return '';
            }
        };

        

        return {
            mimeType, //agregar
            form,
            versionSeleccionada,
            seleccionarVersion,

            formArchivo,//agregar
            
            mdiMonitorCellphone,
            mdiTableBorder,
            togglePreguntasRespuestas,
            handleSubmit,
            existeEvaluacionParaHabito,
            actualizarObservacion,
            mdiTableOff,
            mdiGithub,
            mdiApplicationEdit,
            mdiTrashCan,
        }
    }
}
</script>

<template>
  <LayoutMain>
      <SectionTitleLineWithButton :title="titulo" main></SectionTitleLineWithButton>
      
      <NotificationBar v-if="$page.props.flash.success" color="success" :icon="mdiInformation" :outline="false">
          {{ $page.props.flash.success }}
      </NotificationBar>
      
      <NotificationBar v-if="$page.props.flash.error" color="danger" :icon="mdiInformation" :outline="false">
          {{ $page.props.flash.error }}
      </NotificationBar>

      <select v-model="versionSeleccionada" class="border border-gray-700 rounded-lg p-2 mt-2 w-full text-black">
        <option value="">Seleccionar versión</option>
        <option v-for="version in version" :value="version">{{ version }}</option>
      </select>
      
      <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-2 xl:grid-cols-2">
        <div v-for="habito in Habito" :key="habito.id" :ref="`habito_${habito.id}`" :class="{ 'lg:col-span-2': habito.mostrarPreguntasRespuestas, 'lg:col-span-1': !habito.mostrarPreguntasRespuestas }">
            <template v-if=" habito.version === versionSeleccionada">
                <div class="border border-gray-300 rounded-lg p-4" :class="{ 'bg-gray-200': habito.mostrarPreguntasRespuestas }">
                    <div >
                        <strong class="centro" > 
                            {{ habito.user.name }} {{ habito.user.apellido_paterno }} {{ habito.user.apellido_materno }}
                        </strong>
                        <div >
                            <div class="fila mt-4">
                                <div class="izquierda">
                                    <strong>Matrícula:</strong> {{ habito.matricula }}
                                </div>
                                <div class="derecha">
                                    <strong>Grado:</strong> {{ habito.grupo.grado }}
                                </div>
                            </div>
                            <div class="fila">
                                <div class="izquierda">
                                    <strong>Grupo:</strong> {{ habito.grupo.grupo }}
                                </div>
                            </div>
                        </div>
                    </div>
    
                    <button @click="togglePreguntasRespuestas(habito)" class="action-button">
                        {{ habito.mostrarPreguntasRespuestas ? 'Ocultar Preguntas y Respuestas' : 'Ver Preguntas y Respuestas' }}
                    </button>
                    <div v-if="habito.mostrarPreguntasRespuestas" class="mt-4">
                        <div v-for="(pregunta, id) in preguntas" :key="id" class="pregunta-contenedor">
                            <template v-if="pregunta.version === habito.version">
                                <div class="pregunta">{{ pregunta.pregunta }}</div>
                                <ul class="respuestas">
                                    <li v-for="respuesta in respuestas.filter(item => item.pregunta_id === pregunta.id && item.user_id === habito.user_id)" :key="respuesta.id">
                                        {{ respuesta.respuesta }}
                                    </li>
                                </ul>
                            </template>
                        </div>
                        <template v-if="existeEvaluacionParaHabito(habito)">
                            <!-- Mostrar la observación de la evaluación existente -->
                            <div v-for="evaluacion in Evaluacion" :key="evaluacion.id">
                                <template v-if="evaluacion.user_id === habito.user.id  && evaluacion.version === habito.version">
                                    <form @submit.prevent="actualizarObservacion(habito, evaluacion)"
                                            enctype="multipart/form-data">
                                    <textarea v-model="evaluacion.respuesta" name="respuesta" class="border border-gray-300 rounded-lg p-2 mt-2 w-full" placeholder="Observación"></textarea>
                                    
                                    <input type="file" @input="formArchivo.archivo = $event.target.files[0]">
                                            <p class="text-red-600 font-semibold" v-if="formArchivo.errors.archivo" >
                                                {{ formArchivo.errors.archivo }}
                                            </p>
                                        
                                            <div
                                                class="bg-slate-100 border-2 border-dotted border-slate-500 justify-center flex items-center h-auto rounded-sm p-10 mb-2 dark:bg-slate-800">
                                                <div class="">
                                                    <div v-if="evaluacion.archivo !== null">
                                                        <div class="font-medium max-md:text-xs">
                                                            Nombre del archivo: {{ evaluacion.archivo }}
                                                        </div>
                                                        <div class="justify-center flex mt-10 mb-5">
                                                            <iframe v-if="mimeType(evaluacion.archivo) === 'pdf'" class="w-full h-96" :src="'/storage/observaciones/' + evaluacion.archivo" />
                                                            <img v-else :src="'/storage/observaciones/' + evaluacion.archivo" alt="" class="max-w-96 max-md:max-w-56">
                                                        </div>
                                                    </div>
                                                    <CardBoxComponentEmpty v-else />
                                                </div>
                                            </div>
                                    
                                    
                                            <button type="submit"
                                                class="bg-yellow-600 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded-full mt-4">
                                                Actualizar Observación
                                            </button>
                                        </form>
                                </template>
                            </div>
                        </template>
                        <!-- Si no hay evaluación, mostrar el formulario para crear una nueva observación -->
                        <template v-else>
                            <form @submit.prevent="handleSubmit(habito)">
                                <!-- Agregar un campo oculto para almacenar el ID del académico -->
                                <input type="hidden" v-model="form.habito" name="habito_id">
                                <textarea v-model="form.respuesta" name="respuesta" class="border border-gray-300 rounded-lg p-2 mt-2 w-full" placeholder="Escribe tu observación aquí"></textarea>
                                
                                <input type="file" @input="formArchivo.archivo = $event.target.files[0]">
                                        <p class="text-red-600 font-semibold" v-if="formArchivo.errors.archivo">
                                            {{ formArchivo.errors.archivo }}
                                        </p>
                                
                                <button type="submit" class="bg-yellow-600 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded-full mt-4">
                                    Enviar Observación
                                </button>
                            </form>
                        </template>
                    </div>
                </div>
            </template>
        </div>
    </div>
    
    
  </LayoutMain>
</template>

  
<style scoped>
.action-button {
    margin-top: 10px;
    margin-left: 20px;
    background-color: #4F1F91; 
    color: #fff;
    text-align: center;
    padding: 10px 20px;
    border-radius: 4px;
    text-decoration: none;
    border: none; 
    cursor: pointer;
  }
  .centro {
    text-align: right;
    font-size: 1.5em; /* Ajusta el tamaño de la letra */
    color: #000; /* Color negro para el texto */
    font-weight: bold; /* Opcional: hace el texto más oscuro */
}
  .action-button:hover {
    background-color: #FBB034; 
  }
.contenedor {
    display: flex;
    flex-direction: column;
    align-items: stretch;
}

.fila {
    display: flex;
    justify-content: space-between;
    margin-bottom: 10px; 
}

.izquierda {
    flex: 1;
    text-align: left;
    margin-left: 100px;
}

.derecha {
    flex: 1;
    text-align: left;
    margin-right: 100px;
}


.contenedor div {
    margin-bottom: 10px; 
}

.contenedor strong {
    margin-right: 5px; 
}
.pregunta-contenedor {
    margin-bottom: 20px; 
}

.pregunta {
    background-color: #efeeee; 
    padding: 10px;
    border: 1px solid #ffffff; 
    border-radius: 5px; 
}

.respuestas {
    margin-top: 10px; 
    padding-left: 20px; 
}

.respuestas li {
    margin-bottom: 5px; 
}

</style>
