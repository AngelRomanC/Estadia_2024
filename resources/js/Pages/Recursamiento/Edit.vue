<script setup>
import { ref, defineProps, onMounted } from 'vue';
import { useForm } from '@inertiajs/vue3';
import LayoutMain from '@/layouts/LayoutMain.vue';
import FormField from "@/components/FormField.vue";
import FormControl from "@/components/FormControl.vue";
import FormControlV2 from "@/components/FormControlV2.vue";
import FormControlV3 from "@/components/FormControlV3.vue";
import FormControlV4 from "@/components/FormControlV4.vue";
import BaseDivider from "@/components/BaseDivider.vue";
import BaseButton from "@/components/BaseButton.vue";
import BaseButtons from "@/components/BaseButtons.vue";
import SectionTitleLineWithButton from "@/components/SectionTitleLineWithButton.vue";
import CardBox from "@/components/CardBox.vue";
import Swal from 'sweetalert2';

const props = defineProps(['titulo', 'Recursamiento','periodo','materia','usuarios','profesor','routeName']);
const form = useForm({
    ...props.Recursamiento,
    profesor_id: props.profesor
   
});


const guardar = () => {
    form.put(route("recursamiento.update", props.Recursamiento.id));
};

</script>

<template>
    <LayoutMain :title="titulo">
        <SectionTitleLineWithButton  :title="titulo" main>
           
        </SectionTitleLineWithButton>

        <CardBox form @submit.prevent="guardar">
            <FormField >
                <FormControlV4  v-model="form.materia_id" :showOption="name" :options="materia"/>
            </FormField>
            <FormField >
                <FormControlV3  v-model="form.periodo_id" :showOption="name" :options="periodo"/>
            </FormField>
            <FormField >
                <FormControlV2  v-model="form.profesor_id" :showOption="name" :options="usuarios"/>
            </FormField>
            <FormField >
                <FormControl v-model="form.horarios" placeholder="horarios" />
            </FormField>
            <FormField >
                <FormControl v-model="form.cupo" placeholder="Cupo maximo de estudiantes" />
            </FormField>
            <select v-model="form.estatus" class="border border-gray-700 rounded-lg p-2 mt-2 w-full text-black">
                <option disabled value="">Estatus</option>
                    <option value="1">Activo</option>
                    <option value="0">Inactivo</option>
              </select>
          
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