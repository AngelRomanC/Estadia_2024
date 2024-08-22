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
        roles: { type: Object, required: true },
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
            form.post(route('usuarios.store'));
        };
        const validateNumericInput = (event) => {
        const value = event.target.value;
        event.target.value = value.replace(/\D/g, ''); 
        form.numero = event.target.value;
        };
        const form = useForm({
            name: '',
            apellido_paterno: '',
            apellido_materno: '',
            numero: '',
            email: '',
            password: '',
            role: 'Admin',
        });

        return { handleSubmit,validateNumericInput, form, mdiBallotOutline, mdiAccount, mdiMail, mdiGithub }
    }
}
</script>

<template>
    <!-- Componente principal LayoutMain con el título dinámico -->
    <LayoutMain :title="titulo">
        
        <!-- Título de sección con línea y botón principal -->
        <SectionTitleLineWithButton :title="titulo" main>
        </SectionTitleLineWithButton>

        <!-- Contenedor de formulario dentro de un CardBox con evento de submit -->
        <CardBox form @submit.prevent="handleSubmit">

            <!-- Campos del formulario con validación de errores y requeridos -->
            <FormField :error="form.errors.name">
                <FormControl v-model="form.name" required placeholder="Nombre" />
            </FormField>
            <FormField :error="form.errors.apellido_paterno">
                <FormControl v-model="form.apellido_paterno" required placeholder="Apellido paterno" />
            </FormField>
            <FormField :error="form.errors.apellido_materno">
                <FormControl v-model="form.apellido_materno" required placeholder="Apellido materno" />
            </FormField>
            <FormField :error="form.errors.numero">
                <FormControl v-model="form.numero" @input="validateNumericInput" required placeholder="Teléfono" />
            </FormField>
            <FormField :error="form.errors.email">
                <FormControl v-model="form.email" required placeholder="Email" />
            </FormField>
            <FormField :error="form.errors.password">
                <FormControl v-model="form.password" required placeholder="Contraseña" />
            </FormField>

            <!-- Botones en el pie del formulario -->
            <template #footer>
                <BaseButtons>
                    <!-- Botón para enviar el formulario -->
                    <BaseButton @click="handleSubmit" type="submit" color="info" label="Crear" />
                    <!-- Botón para cancelar y regresar a la lista de usuarios -->
                    <BaseButton :href="route(`${routeName}index`)" type="reset" color="danger" outline label="Cancelar" />
                </BaseButtons>
            </template>
        </CardBox>
    </LayoutMain>
</template>

