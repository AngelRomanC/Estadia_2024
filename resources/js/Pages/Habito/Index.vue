<script>
import { Link, useForm } from '@inertiajs/vue3';
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



export default {
    props: {
        titulo: { type: String, required: true },
        preguntas:{ type: Object, required: true },
        Habito: { type: Object, required: true },
        habitoId: { type: String, required: true },
        respuestas:{ type: Object, required: true },
        profesor:{ type: Object, required: true },
        periodo:{ type: Object, required: true },
        version_habilitada:{ type: Object, required: true },
        version:{ type: Object, required: true },
        grupo:{ type: Object, required: true },
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
    setup() {
        const form = useForm({
            matricula: '',
            tutor:'',
            periodo:'',
            formato:'',
            pregunta:'',
            version: '',
        });
        const buscarformato = () => {
            if (form.version) {
                const url = route('habito.create', { version: form.version.version });
        window.location.href = url;
                }
        };
        const eliminar = (id) => {
            Swal.fire({
                title: "¿Esta seguro?",
                text: "Esta acción no se puede revertir",
                icon: "warning",
                showCancelButton: true,
                cancelButtonColor: "#d33",
                confirmButtonColor: "#3085d6",
                confirmButtonText: "Si!, eliminar registro!",
            }).then((res) => {
                if (res.isConfirmed) {
                    form.delete(route("habito.destroy", id));
                }
            });
        };

        return {
            form, eliminar, mdiMonitorCellphone,buscarformato,
            mdiTableBorder,
            mdiTableOff,
            mdiGithub,
            mdiApplicationEdit, mdiTrashCan,
        }
    }

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
        
        <form @submit.prevent="buscarformato">
            <select v-model="form.version">
                <option value="">Formatos disponibles</option>
                <option v-for="version in version_habilitada" :key="version.id" :value="version">
                    <!-- Aquí se aplica la validación del estatus -->
                    <template v-if="version.estatus === 1">
                        {{ version.version }}
                    </template>
                </option>
            </select>
            <button type="submit" class="action-button">Contestar formato</button>
        </form>
        
        <CardBox v-for="habito in Habito" :key="habito.id">
            <template v-if="habito.estatus === 1">
            <div>
                <div class="contenedor">
                    <div class="fila">
                        <div class="izquierda">
                            <strong>Matrícula:</strong> {{ habito.matricula }}
                        </div>
                        <div class="derecha">
                            <strong>Grupo:</strong> {{ grupo.grado }} °{{ grupo.grupo }}
                        </div>
                    </div>
                    <div class="fila">
                        <div class="izquierda">
                            <strong>Tutor:</strong> {{ profesor.name }} {{ profesor.apellido_paterno }} {{ profesor.apellido_materno }}
                        </div>
                        <div class="derecha">
                            <strong>Periodo:</strong> {{ periodo.periodo }} {{ periodo.año }}
                        </div>
                    </div>
                </div>
                <div v-for="(pregunta, index) in preguntas" :key="index" class="pregunta-contenedor">
                    <template v-if="pregunta.version === habito.version">
                        <div class="pregunta">
                            {{ index + 1 }}. {{ pregunta.pregunta }}
                        </div>
                        <ul class="respuestas">
                            <li v-for="respuesta in respuestas.filter(item => item.pregunta_id === pregunta.id)" :key="respuesta.id">
                                <strong>{{ respuesta.respuesta }}</strong>
                            </li>
                        </ul>
                    </template>
                </div>
              
                <BaseButton :href="`habito/${habito.id}/edit/${habito.version}`" class="action-button" label="Modificar formato"  style="float: right;"/>

            </div>
            </template>
            </CardBox>
    </LayoutMain>
</template>
<style scoped>
.action-button {
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