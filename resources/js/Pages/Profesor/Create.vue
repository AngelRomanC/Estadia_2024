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

export default {
    props: {
        titulo: { type: String, required: true },
        routeName: { type: String, required: true },
        usuarios: { type: String, required: true },
        users:{type: Object, required: true},
        roles:{type: Object, required: true}
    },
    components: {
        LayoutMain,
        FormField,
        FormControl,
        BaseDivider,
        BaseButton,
        BaseButtons,
        CardBox,
        SectionTitleLineWithButton
    },
    setup() {

        const handleSubmit = () => {
            form.post(route('profesor.store'));
        };
        const validateNumericInput = (event) => {
        const value = event.target.value;
        event.target.value = value.replace(/\D/g, ''); 
        form.numero = event.target.value;
        };
        const form = useForm({
            grado_academico: '',
            area:'',
            user_id: null,
            name: '',
            apellido_paterno: '',
            apellido_materno: '',
            numero:'',
            email:'',
            password:'',
            role:'Tutor',
        });

        return { handleSubmit,validateNumericInput, form, mdiBallotOutline, mdiAccount, mdiMail, mdiGithub }
    }
}
</script>

<template>
    <LayoutMain :title="titulo">
        <SectionTitleLineWithButton  :title="titulo" main>
            
        </SectionTitleLineWithButton>

        <CardBox form @submit.prevent="handleSubmit">
            <FormField :error="form.errors.name">
                <FormControl v-model="form.name"  placeholder="Nombre" />
            </FormField>
            <FormField :error="form.errors.apellido_paterno">
                <FormControl v-model="form.apellido_paterno" placeholder="Apellido paterno" />
            </FormField>
            <FormField :error="form.errors.apellido_materno">
                <FormControl v-model="form.apellido_materno" placeholder="Apellido materno" />
            </FormField>
            <FormField :error="form.errors.numero">
                <FormControl v-model="form.numero" @input="validateNumericInput" placeholder="Teléfono" />
            </FormField>
            <FormField :error="form.errors.email">
                <FormControl v-model="form.email" placeholder="email" />
            </FormField>
            <FormField :error="form.errors.password">
                <FormControl v-model="form.password" placeholder="password" />
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
                    <BaseButton @click="handleSubmit" type="submit" class="action-button" label="Crear" />
                    <BaseButton :href="route(`usuarios.index`)" type="reset" color="danger" outline
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