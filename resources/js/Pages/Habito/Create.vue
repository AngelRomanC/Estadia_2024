<script>
import { Link, useForm } from '@inertiajs/vue3';
import { mdiBallotOutline, mdiAccount, mdiMail, mdiGithub } from "@mdi/js";
import LayoutMain from '@/layouts/LayoutMain.vue';
import FormField from "@/components/FormField.vue";
import FormControl from "@/components/FormControl.vue";
import FormControlV2 from "@/components/FormControlV2.vue";
import FormControlV3 from "@/components/FormControlV3.vue";
import BaseDivider from "@/components/BaseDivider.vue";
import BaseButton from "@/components/BaseButton.vue";
import BaseButtons from "@/components/BaseButtons.vue";
import SectionTitleLineWithButton from "@/components/SectionTitleLineWithButton.vue";
import CardBox from "@/components/CardBox.vue";
import FormControlV6 from "@/components/FormControlV6.vue";

export default {
    props: {
        titulo: { type: String, required: true },
        routeName: { type: String, required: true },
        preguntas:{ type: Object, required: true },
        usuarios:{ type: Object, required: true },
        periodo:{ type: Object, required: true },
        version: { type: String, required: true },
        grupo:{type: Object, required: true}, 
    },
    components: {
        LayoutMain,
        FormField,
        FormControl,
        FormControlV2,
        FormControlV3,
        FormControlV6,
        BaseDivider,
        BaseButton,
        BaseButtons,
        CardBox,
        SectionTitleLineWithButton
    },
  
   
    setup(props) {
        const handleSubmit = () => {
            form.post(route('habito.store'));
        };

        const form = useForm({
            matricula: '',
            grupo_id:'',
            profesor_id:'',
            periodo_id:'',
            formato:'2',
            version: props.version,
            respuestas:[], 
            pregunta_id: [],
        });

        return { handleSubmit, form, mdiBallotOutline, mdiAccount, mdiMail, mdiGithub }
    }
}
</script>

<template>
    <LayoutMain :title="titulo">
        <SectionTitleLineWithButton :title="titulo" main>
            
        </SectionTitleLineWithButton>

        <CardBox form @submit.prevent="handleSubmit">


            <FormField label="Información personal">
                <FormControl v-model="form.matricula" placeholder="Matrícula"/>
    
            </FormField>
            <FormField >
                <FormControlV6  v-model="form.grupo_id" :showOption="name" :options="grupo"/>
            </FormField>
            <FormField >
                <FormControlV2  v-model="form.profesor_id" :showOption="name" :options="usuarios"/>
            </FormField>
            <FormField >
                <FormControlV3  v-model="form.periodo_id" :showOption="name" :options="periodo"/>
            </FormField>
           
            
          
            <FormField label="Habitos de estudio">
                <div v-for="pregunta in preguntas" :key="pregunta.id">
                    <template v-if="pregunta.formato === 2">
                        <p style="font-size: 18px; color: #292929; font-weight: 600;">{{ pregunta.pregunta }}</p> 
                        <select v-model="form.respuestas[pregunta.id]" @change="guardarRespuesta(pregunta.id) " class="w-full">
                            <option value="si">Sí</option>
                            <option value="no">No</option>
                        </select>
                        <br>
                    </template>
                </div>
            </FormField>
            <template #footer>
                <BaseButtons>
                    <BaseButton @click="handleSubmit" type="submit" class="action-button" label="Crear" />
                    <BaseButton :href="route(`${routeName}index`)" type="reset" color="danger" outline
                        label="Cancelar" />
                </BaseButtons>
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
</style>