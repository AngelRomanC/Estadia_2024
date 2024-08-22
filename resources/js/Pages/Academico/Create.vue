<script>
import { Link, useForm } from '@inertiajs/vue3';
import { mdiBallotOutline, mdiAccount, mdiMail, mdiGithub } from "@mdi/js";
import LayoutMain from '@/layouts/LayoutMain.vue';
import FormField from "@/components/FormField.vue";
import FormControl from "@/components/FormControl.vue";
import BaseDivider from "@/components/BaseDivider.vue";
import BaseButton from "@/components/BaseButton.vue";
import BaseButtons from "@/components/BaseButtons.vue";
import SectionTitleLineWithButton from "@/components/SectionTitleLineWithButton.vue";
import CardBox from "@/components/CardBox.vue";
import FormControlV2 from "@/components/FormControlV2.vue";
import FormControlV3 from "@/components/FormControlV3.vue";
import FormControlV4 from "@/components/FormControlV4.vue";
import FormControlV6 from "@/components/FormControlV6.vue";
import FormControlV7 from "@/components/FormControlV7.vue";

export default {
    props: {
        titulo: { type: String, required: true },
        version: { type: String, required: true },
        routeName: { type: String, required: true },
        preguntas:{type: Object, required: true},
        periodo:{type: Object, required: true},
        materia:{type: Object, required: true},
        materias:{type: Object, required: true},
        grupo:{type: Object, required: true}, 
        usuarios:{type: Object, required: true},
    },
    components: {
        LayoutMain,
        FormField,
        FormControl,
        BaseDivider,
        BaseButton,
        BaseButtons,
        FormControlV2,
        FormControlV4,
        FormControlV3,
        FormControlV6,
        FormControlV7,
        CardBox,
        SectionTitleLineWithButton
    },
    setup(props) {
        const handleSubmit = () => {
            form.post(route('academico.store'));
        };

        const form = useForm({
            matricula: '',
            profesor_id:'',
            periodo_id:'',
            grupo_id:'',
            materia_id:'',
            formato: '1',
            version: props.version,
            respuestas:[], // Inicializa con un arreglo del tamaño de props.preguntas lleno de undefined
            pregunta_id: [],
            acumuladas: [],
            materias:[],
            
        });
        const generarCamposmaterias = () => {
            const nummaterias = parseInt(form.numeromaterias);
            form.materias = new Array(nummaterias).fill('').map(() => ({ pregunta: '' }));
            console.log(form.materias);

        };

        const guardarRespuesta = (preguntaId) => {
        form.respuestas[preguntaId] = form.respuestas[preguntaId] || ""; // Inicializa con un string vacío si es undefined
        form.pregunta_id[preguntaId] = preguntaId;
        }

        return { handleSubmit,generarCamposmaterias, form, guardarRespuesta, mdiBallotOutline, mdiAccount, mdiMail, mdiGithub }
    }
}
</script>

<template>
    <LayoutMain :title="titulo">
     
        <SectionTitleLineWithButton  :title="titulo" main>
            
        </SectionTitleLineWithButton>
    
        <div>

                <CardBox form @submit.prevent="handleSubmit">

                    <FormField label="Ingresa tu matricula">
                        <FormControl v-model="form.matricula" placeholder="Matrícula"/>     

                    </FormField>

                    <FormField label="Selecciona tu grupo">
                        <FormControlV6  v-model="form.grupo_id" :showOption="name" :options="grupo"/>
                    </FormField>
                    
                    <FormField label="Selecciona tu profesor">
                        <FormControlV2  v-model="form.profesor_id" :showOption="name" :options="usuarios"/>
                    </FormField>
                    <FormField label="Ingresa tu periodo">
                        <FormControlV3  v-model="form.periodo_id" :showOption="name" :options="periodo"/>
                    </FormField>
                    
                    <h1><strong>Selecciona tus materias reprobadas acumuladas</strong></h1>
                    <select v-model="form.acumuladas" multiple class="w-full" >
                        <option v-for="Materia in materias" :value="Materia.id" >{{ Materia.nombre }}</option>
                    </select>
                    
                    <FormField label="Análisis académico individual">
                        <div v-for="pregunta in preguntas.filter(item => item.formato === 1)" :key="pregunta.id">
                            <p><strong>{{ pregunta.pregunta }}</strong></p>
                            <FormControl  v-model="form.respuestas[pregunta.id]" @change="guardarRespuesta(pregunta.id)"/>
                            <br>
                        </div>
                    </FormField>
                    <FormField label="Número de materias a recursar">
                        <FormControl v-model="form.numeromaterias" type="number" placeholder="Ingresa el número de preguntas" @input="generarCamposmaterias" />
                    </FormField>
    
                    <template v-for="(pregunta, index) in form.materias" :key="index" >
                        <CardBox >
                            <FormField label="Materia" >
                                <FormControl v-model="pregunta.pregunta" :placeholder="'Ingresa la materia a recursar ' + (index + 1) + ' y el periodo en que se va a recursar'" />
                            </FormField>
                        </CardBox>
                    </template>
                    
                    <template #footer>
                        <BaseButtons>
                            <BaseButton @click="handleSubmit" type="submit" class="action-button" label="Crear" />
                            <BaseButton :href="route(`${routeName}index`)" type="reset" color="danger" outline
                                label="Cancelar" />
                        </BaseButtons>
                    </template>
                </CardBox>
            

        </div>
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
</style>