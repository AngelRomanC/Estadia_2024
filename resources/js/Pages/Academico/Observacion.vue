<script>
import { Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import Swal from "sweetalert2";
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
import { computed } from 'vue';



export default {
    props: {
        titulo: { type: String, required: true },
        Academico: { type: Object, required: true },
        Habito: { type: Object, required: true },
        Inteligencia: { type: Object, required: true },
        
        grupo:{ type: Object, required: true },
        grupoHabito:{ type: Object, required: true },
        grupoInteligencia:{ type: Object, required: true },
       
        versions:{ type: Object, required: true },
        versionHabito:{ type: Object, required: true },
        versionInteligencia:{ type: Object, required: true },

        preguntas:{ type: Object, required: true },
        preguntasHabito:{ type: Object, required: true },
        preguntasInteligencia:{ type: Object, required: true },

        respuestas: { type: Object, required: true },
        respuestasHabito: { type: Object, required: true },
        respuestasInteligencia: { type: Object, required: true },
        
        Evaluacion:{ type: Object, required: true },
        EvaluacionHabito:{ type: Object, required: true },
        EvaluacionInteligencia:{ type: Object, required: true },
       
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
        const FormatoSeleccionado = ref('');
        const seleccionarFormato = (event) => {
    const seleccion = event.target.value; 
    FormatoSeleccionado.value = seleccion; // Actualizar el valor de versionSeleccionada
  };
        const form = useForm({
            matricula: '',
            tutor:'',
            periodo:'',
            materia_recursar:'',
            pregunta:'',
            formato:'',
            version: '',
        });
        const existeEvaluacionValida = () => {
            return props.Evaluacion.some(evaluacion => evaluacion.version === props.Academico.version);
        };
        
        const evaluacionPorVersion = computed(() => {
            const evaluacionesPorVersion = {};
            props.Evaluacion.forEach(evaluacion => {
                if (!evaluacionesPorVersion[evaluacion.version]) {
                    evaluacionesPorVersion[evaluacion.version] = evaluacion;
                }
            });
            return evaluacionesPorVersion;
        });
        const evaluacionPorVersionHabito = computed(() => {
            const evaluacionesPorVersion = {};
            props.EvaluacionHabito.forEach(evaluacion => {
                if (!evaluacionesPorVersion[evaluacion.version]) {
                    evaluacionesPorVersion[evaluacion.version] = evaluacion;
                }
            });
            return evaluacionesPorVersion;
        });
        const evaluacionPorVersionInteligencia = computed(() => {
            const evaluacionesPorVersion = {};
            props.EvaluacionInteligencia.forEach(evaluacion => {
                if (!evaluacionesPorVersion[evaluacion.version]) {
                    evaluacionesPorVersion[evaluacion.version] = evaluacion;
                }
            });
            return evaluacionesPorVersion;
        });
        const togglePreguntasRespuestas = (academico) => {
            academico.mostrarPreguntasRespuestas = !academico.mostrarPreguntasRespuestas;

            // Desplazar el elemento seleccionado hacia arriba después de un breve retraso
            setTimeout(() => {
                const elemento = document.getElementById(`academico_${academico.id}`);
                if (elemento && academico.mostrarPreguntasRespuestas) {
                    elemento.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            }, 100);
        };

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
            mimeType,
            form,  mdiMonitorCellphone,FormatoSeleccionado,
            mdiTableBorder,
            mdiTableOff, existeEvaluacionValida,
            mdiGithub,togglePreguntasRespuestas,evaluacionPorVersion,evaluacionPorVersionHabito,evaluacionPorVersionInteligencia,
            mdiApplicationEdit, mdiTrashCan,
        }
    },
    


}


</script>

<template>
    
    <LayoutMain>
        <SectionTitleLineWithButton  :title="titulo" main>
        </SectionTitleLineWithButton>
        

        <NotificationBar v-if="$page.props.flash.success" color="success" :icon="mdiInformation" :outline="false">
            {{ $page.props.flash.success }}
        </NotificationBar>

        <NotificationBar v-if="$page.props.flash.error" color="danger" :icon="mdiInformation" :outline="false">
            {{ $page.props.flash.error }}
        </NotificationBar>
        <select v-model="FormatoSeleccionado" class="border border-gray-700 rounded-lg p-2 mt-2 w-full text-black">
            <option value="">Formatos disponibles</option>
                <option value="1">Análisis académico Individual</option>
                <option value="2">Hábitos de estudio</option>
                <option value="3">Inteligencias múltiples</option>
          </select>

       

        <div v-if="FormatoSeleccionado === '1'">
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-2 xl:grid-cols-2">
                <div v-for="academico in Academico" :key="academico.id">
                    <div class="border border-gray-300 rounded-lg p-4" :class="{ 'bg-gray-200': academico.mostrarPreguntasRespuestas }">
                        <div >
                        <strong class="centro" > 
                            {{ academico.user.name }} {{ academico.user.apellido_paterno }} {{ academico.user.apellido_materno }}
                        </strong>
                        <div >
                            <div class="fila mt-4">
                                <div class="izquierda">
                                    <strong>Matrícula:</strong> {{ academico.matricula }}
                                </div>
                                <div class="derecha">
                                    <strong>Grado:</strong> {{ academico.grupo.grado }}
                                </div>
                            </div>
                            <div class="fila">
                                <div class="izquierda">
                                    <strong>Grupo:</strong> {{ academico.grupo.grupo }}
                                </div>
                            </div>
                        </div>
                    </div>
                            <button @click="togglePreguntasRespuestas(academico)" class="action-button">
                                {{ academico.mostrarPreguntasRespuestas ? 'Ocultar Preguntas y Respuestas' : 'Ver Preguntas y Respuestas' }}
                            </button>
                            <div v-if="academico.mostrarPreguntasRespuestas" class="mt-4">
    
                            <div v-for="(pregunta, id) in preguntas" :key="id" class="pregunta-contenedor">
                                <template v-if="pregunta.version === academico.version && pregunta.formato === academico.formato">
                                    <div class="pregunta">{{ pregunta.pregunta }}</div>
                                    <ul class="respuestas">
                                        <li v-for="respuesta in respuestas.filter(item => item.pregunta_id === pregunta.id && item.user_id === academico.user_id)" :key="respuesta.id">
                                            {{ respuesta.respuesta }}
                                        </li>
                                    </ul>
                                </template>
                            </div>
                           
                            
                            <template v-if="evaluacionPorVersion[academico.version]">
                                <textarea readonly v-model="evaluacionPorVersion[academico.version].respuesta" name="respuesta" class="border border-gray-300 rounded-lg p-2 mt-2 w-full" placeholder="Observación"></textarea>
                            </template>
                            <template v-else>
                                <div class="text-red-500">En revisión</div>
                            </template>
                            
                            <div 
                                class="bg-slate-100 border-2 border-dotted border-slate-500 justify-center flex items-center h-auto rounded-sm p-10 mb-2 dark:bg-slate-800">
                                <div class="">
                                    <div v-if="Evaluacion.archivo !== null">
                                        <div class="font-medium max-md:text-xs">
                                            Nombre del archivo:--- {{ Evaluacion[0]?.archivo }}
                                        </div>
                                        <div class="justify-center flex mt-10 mb-5">
                                            <iframe v-if="mimeType(Evaluacion[0]?.archivo) === 'pdf'" class="w-full h-96" :src="'/storage/observaciones/' + Evaluacion[0]?.archivo" />
                                            <img v-else :src="'/storage/observaciones/' + Evaluacion[0]?.archivo" alt="" class="max-w-96 max-md:max-w-56">
                                        </div>
                                    </div>
                                    <CardBoxComponentEmpty v-else />
                                </div>
                            </div>

                            </div>
                        </div>
                </div>
            </div>
        </div>
        <div v-else-if="FormatoSeleccionado === '2'">
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-2 xl:grid-cols-2">
                <div v-for="habito in Habito" :key="habito.id">
                    <div class="border border-gray-300 rounded-lg p-4" :class="{ 'bg-gray-200': habito.mostrarPreguntasRespuestas }">
                        <div class="font-bold text-xl mb-2">Alumno: {{ habito.user.name }} {{ habito.user.apellido_paterno }} {{ habito.user.apellido_materno }}</div>
                        <p class="text-gray-700 text-base">Matrícula: {{ habito.matricula }}</p>
                        <p class="text-gray-700 text-base">Grado: {{ habito.grupo.grado }}</p>
                        <p class="text-gray-700 text-base">Grupo: {{ habito.grupo.grupo }}</p>
            
                        <button @click="togglePreguntasRespuestas(habito)" class="action-button">
                            {{ habito.mostrarPreguntasRespuestas ? 'Ocultar Preguntas y Respuestas' : 'Ver Preguntas y Respuestas' }}
                        </button>
                        <div v-if="habito.mostrarPreguntasRespuestas" class="mt-4">
                            <div v-for="(pregunta, id) in preguntasHabito" :key="id">
                                <template v-if="pregunta.version === habito.version && pregunta.formato === habito.formato">
                                    <strong>{{ pregunta.pregunta }}</strong>
                                    <ul>
                                        <li v-for="respuesta in respuestasHabito.filter(item => item.pregunta_id === pregunta.id && item.user_id === habito.user_id)" :key="respuesta.id">
                                            {{ respuesta.respuesta }}
                                        </li>
                                    </ul>
                                </template>
                            </div>
                            <template v-if="evaluacionPorVersionHabito[habito.version]">
                                <textarea readonly v-model="evaluacionPorVersionHabito[habito.version].respuesta" name="respuesta" class="border border-gray-300 rounded-lg p-2 mt-2 w-full" placeholder="Observación"></textarea>
                            </template>
                            <template v-else>
                                <div class="text-red-500">En revisión</div>
                            </template>


                            <div 
                                class="bg-slate-100 border-2 border-dotted border-slate-500 justify-center flex items-center h-auto rounded-sm p-10 mb-2 dark:bg-slate-800">
                                <div class="">
                                    <div v-if="EvaluacionHabito.archivo !== null">
                                        <div class="font-medium max-md:text-xs">
                                            Nombre del archivo:--- {{ EvaluacionHabito[0]?.archivo }}
                                        </div>
                                        <div class="justify-center flex mt-10 mb-5">
                                            <iframe v-if="mimeType(EvaluacionHabito[0]?.archivo) === 'pdf'" class="w-full h-96" :src="'/storage/observaciones/' + EvaluacionHabito[0]?.archivo" />
                                            <img v-else :src="'/storage/observaciones/' + EvaluacionHabito[0]?.archivo" alt="" class="max-w-96 max-md:max-w-56">
                                        </div>
                                    </div>
                                    <CardBoxComponentEmpty v-else />
                                </div>
                            </div>





                        </div>
                       
                    </div>
                </div>
            </div>
        </div>
        <div v-else-if="FormatoSeleccionado === '3'">
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-2 xl:grid-cols-2">
                <div v-for="inteligencia in Inteligencia" :key="inteligencia.id">
                    <div class="border border-gray-300 rounded-lg p-4" :class="{ 'bg-gray-200': inteligencia.mostrarPreguntasRespuestas }">
                        <div class="font-bold text-xl mb-2">Alumno: {{ inteligencia.user.name }} {{ inteligencia.user.apellido_paterno }} {{ inteligencia.user.apellido_materno }}</div>
                        <p class="text-gray-700 text-base">Matrícula: {{ inteligencia.matricula }}</p>
                        <p class="text-gray-700 text-base">Grado: {{ inteligencia.grupo.grado }}</p>
                        <p class="text-gray-700 text-base">Grupo: {{ inteligencia.grupo.grupo }}</p>
            
                        <button @click="togglePreguntasRespuestas(inteligencia)" class="action-button">
                            {{ inteligencia.mostrarPreguntasRespuestas ? 'Ocultar Preguntas y Respuestas' : 'Ver Preguntas y Respuestas' }}
                        </button>
                        <div v-if="inteligencia.mostrarPreguntasRespuestas" class="mt-4">
                            <div v-for="(pregunta, id) in preguntasInteligencia" :key="id">
                                <template v-if="pregunta.version === inteligencia.version && pregunta.formato === inteligencia.formato">
                                    <div class="pregunta">{{ pregunta.pregunta }}</div>
                                    <ul class="respuestas">
                                        <li v-for="respuesta in respuestasInteligencia.filter(item => item.pregunta_id === pregunta.id && item.user_id === inteligencia.user_id)" :key="respuesta.id">
                                            {{ respuesta.respuesta }}
                                        </li>
                                    </ul>
                                </template>
                            </div>
                            <template v-if="evaluacionPorVersionInteligencia[inteligencia.version]">
                                <textarea readonly v-model="evaluacionPorVersionInteligencia[inteligencia.version].respuesta" name="respuesta" class="border border-gray-300 rounded-lg p-2 mt-2 w-full" placeholder="Observación"></textarea>
                            </template>
                            <template v-else>
                                <div class="text-red-500">En revisión</div>
                            </template>
                        </div>
                    </div>
                </div>
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
