<script setup>
import { ref, defineProps, onMounted } from 'vue';
import { useForm } from '@inertiajs/vue3';
import LayoutMain from '@/layouts/LayoutMain.vue';
import FormField from "@/components/FormField.vue";
import FormControl from "@/components/FormControl.vue";
import BaseDivider from "@/components/BaseDivider.vue";
import BaseButton from "@/components/BaseButton.vue";
import BaseButtons from "@/components/BaseButtons.vue";
import SectionTitleLineWithButton from "@/components/SectionTitleLineWithButton.vue";
import CardBox from "@/components/CardBox.vue";
import Swal from 'sweetalert2';
import FormControlV2 from "@/components/FormControlV2.vue";
import FormControlV3 from "@/components/FormControlV3.vue";

const props = defineProps([
    'titulo',
    'Grupo',
    'usuarios',
    'periodo',
    'routeName']);
const form = useForm({
     ...props.Grupo,
    
    });

const guardar = () => {
    form.put(route("grupo.update", props.Grupo.id));
};

</script>

<template>
    <LayoutMain :title="titulo">
        <SectionTitleLineWithButton  :title="titulo" main>
            <Link :href="route(`${routeName}index`)">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                </svg>
            </Link>
        </SectionTitleLineWithButton>

        <CardBox form @submit.prevent="guardar">
            <FormField label="Nombre">
                <select v-model="form.grado">
                    <option disabled value="">Selecciona el grado</option>
                    <option>1</option> <option>2</option><option>3</option> <option>4</option> <option>5</option><option>6</option>
                    <option>7</option> <option>8</option><option>9</option><option>10</option>
                </select>
                <select v-model="form.grupo">
                    <option disabled value="">Selecciona el grupo</option>
                    <option>A</option> <option>B</option><option>C</option> <option>D</option> <option>E</option><option>F</option>
                  
                </select>
                <FormField >
                    <FormControlV3  v-model="form.periodo_id" :showOption="name" :options="periodo"/>
                </FormField>
                <FormControlV2  v-model="form.profesor_id" :showOption="name" :options="usuarios" />
                
            </FormField>
          
          
            <template #footer>
                <BaseButtons>
                    <BaseButton @click="guardar" type="submit" class="action-button" label="Actualizar" />
                    <BaseButton :href="route(`${routeName}index`)" type="reset" color="danger" outline label="Cancelar" />
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