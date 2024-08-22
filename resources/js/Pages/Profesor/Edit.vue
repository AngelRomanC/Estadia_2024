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

const props = defineProps(['titulo', 'usuario','profesor', 'routeName']);
const form = useForm({ ...props.profesor,...props.usuario });

const guardar = () => {
    form.put(route("profesor.update", props.profesor.id));
};
const validateNumericInput = (event) => {
  const value = event.target.value;
  event.target.value = value.replace(/\D/g, ''); 
  form.numero = event.target.value;
};
</script>

<template>
    <LayoutMain :title="titulo">
        <SectionTitleLineWithButton :title="titulo" main>
            
        </SectionTitleLineWithButton>

        <CardBox form @submit.prevent="guardar">
            <FormField label="Nombre">
                <FormControl v-model="form.name" placeholder="nombre" />
                <FormControl v-model="form.apellido_paterno" placeholder="apellido_paterno" />
                <FormControl v-model="form.apellido_materno" placeholder="apellido_materno" />
                <FormControl v-model="form.numero" @input="validateNumericInput" placeholder="numero" />
                <FormControl v-model="form.email" placeholder="email" />
               
               
            </FormField>
            <FormField :error="form.errors.grado_academico">
                <select v-model="form.grado_academico"  class="w-full">
                    <option disabled value="">Selecciona tu grado academico</option>
                    <option>Educación superior</option> <option>Maestria</option><option>Doctorado</option> 
                </select>
                      
            </FormField>
            <FormField :error="form.errors.area">
                <select v-model="form.area"  class="w-full">
                    <option disabled value="">Selecciona tu area </option>
                    <option>Programación y Desarrollo de Software</option> <option>Redes de Computadoras</option><option>Sistemas Operativos</option> 
                    <option>Bases de Datos</option> <option>Ciberseguridad</option><option>Desarrollo Web</option> 
                    <option>Inteligencia Artificial y Aprendizaje Automático</option> <option>Gestión de Proyectos de TI</option><option>Tecnologías Emergentes</option> 

                </select>    
            </FormField>    
          

          
            <template #footer>
                <BaseButtons>
                    <BaseButton @click="guardar" type="submit" class="action-button" label="Actualizar" />
                    <BaseButton :href="route(`profesor.index`)" type="reset" color="danger" outline label="Cancelar" />
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
