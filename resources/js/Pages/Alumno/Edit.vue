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

const props = defineProps(['titulo', 'Alumno','usuario' ,'routeName']);
const form = useForm({ ...props.Alumno,...props.usuario });

const guardar = () => {
    form.put(route("alumno.update", props.Alumno.id));
};
const validateNumericInput = (event) => {
  const value = event.target.value;
  event.target.value = value.replace(/\D/g, ''); 
  form.numero = event.target.value;
};
</script>

<template>
    <LayoutMain :title="titulo">
        <SectionTitleLineWithButton  :title="titulo" main>
         
        </SectionTitleLineWithButton>

        <CardBox form @submit.prevent="guardar">
            <FormField >
                <FormControl v-model="form.name" placeholder="nombre" />
                <FormControl v-model="form.apellido_paterno" placeholder="apellido_paterno" />
                <FormControl v-model="form.apellido_materno" placeholder="apellido_materno" />
                <FormControl v-model="form.numero" @input="validateNumericInput" placeholder="numero" />
                <FormControl v-model="form.email" placeholder="email" />
                <FormControl v-model="form.role" placeholder="role" />
            </FormField>
            <FormField :error="form.errors.cuatrimestre">
                <select v-model="form.cuatrimestre">
                    <option disabled value="">Selecciona el cuatrimestre</option>
                    <option>1</option> <option>2</option><option>3</option> <option>4</option> <option>5</option><option>6</option>
                    <option>7</option> <option>8</option><option>9</option><option>10</option>
                </select>
                <FormField :error="form.errors.matricula">
              
                    <FormControl v-model="form.matricula" placeholder="matricula" />
                    
                </FormField>
            </FormField>

          
            <template #footer>
                <BaseButtons>
                    <BaseButton @click="guardar" type="submit" class="action-button" label="Actualizar" />
                    <BaseButton :href="route(`alumno.index`)" type="reset" color="danger" outline label="Cancelar" />
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
