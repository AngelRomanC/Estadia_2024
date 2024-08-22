<script setup>
import { ref, defineProps,watch, onMounted } from 'vue';
import { useForm } from '@inertiajs/vue3';
import LayoutMain from '@/layouts/LayoutMain.vue';
import FormField from "@/components/FormField.vue";
import FormControl from "@/components/FormControl.vue";
import FormControlV2 from "@/components/FormControlV2.vue";
import FormControlV3 from "@/components/FormControlV3.vue";
import FormControlV6 from "@/components/FormControlV6.vue";
import BaseDivider from "@/components/BaseDivider.vue";
import BaseButton from "@/components/BaseButton.vue";
import BaseButtons from "@/components/BaseButtons.vue";
import SectionTitleLineWithButton from "@/components/SectionTitleLineWithButton.vue";
import CardBox from "@/components/CardBox.vue";
import Swal from 'sweetalert2';

const props = defineProps(['titulo', 'habito','preguntas','respuestas','version','grupo' ,'profesor', 'periodo','usuarios','routeName']);

const form = useForm({ 
...props.habito,
...props.grupo,
respuestas:{},
profesor_id: props.profesor,


});

const handleSubmit = () => {
    form.put(route("habito.update", props.habito.id));
};
watch(
    () => form,
    (newValue) => {
        console.log('form:', newValue);
    },
    { deep: true }
);

watch(
    () => props.respuestas,
    (newValue) => {
        console.log('respuestas:', newValue);
    },
    { deep: true }
);
onMounted(() => {
    updateFormWithWatchData();
});
function updateFormWithWatchData() {
    form.respuestas = {};
    props.respuestas.forEach(respuesta => {
        form.respuestas[respuesta.pregunta.id] = respuesta;
    });
}

</script>

<template>
    <LayoutMain :title="titulo">
        <SectionTitleLineWithButton :title="titulo" main>
            
        </SectionTitleLineWithButton>

        <CardBox form @submit.prevent="handleSubmit">
            <FormField label="Matricula">
                <FormControl v-model="form.matricula"  placeholder="Matricula"/>
             </FormField>
             <FormField >
                <FormControlV6  v-model="form.grupo_id" :showOption="name" :options="grupo"/>
            </FormField>
             <FormField >
                <FormControlV2 v-model="form.profesor_id" :showOption="name" :options="usuarios" />
            </FormField>
            <FormField >
                <FormControlV3  v-model="form.periodo_id" :showOption="name" :options="periodo"/>
            </FormField>
             
            <CardBox v-for="pregunta in preguntas" :key="pregunta.id">
                <div>
                    <p style="font-size: 20px; color: #292929; font-weight: 600;">{{ pregunta.pregunta }}</p>
                    <ul>
                        <li v-for="respuesta in respuestas.filter(item => item.pregunta.id === pregunta.id)" :key="respuesta.id" >
                            <select v-model="respuesta.respuesta"  class="w-full">
                                <option value="si">Sí</option>
                                <option value="no">No</option>
                            </select>
                        </li>
                    </ul>
                </div>
            </CardBox>
            
            
            <template #footer>
                <BaseButtons>
                    <BaseButton @click="handleSubmit" type="submit" class="action-button" label="Actualizar" />
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