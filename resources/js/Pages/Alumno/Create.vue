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
        users: { type: Object, required: true },
        roles: { type: Object, required: true },
        alumno:{ type: Object, required: true },
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
            form.post(route('alumno.store'));
        };
        const validateNumericInput = (event) => {
            const value = event.target.value;
            event.target.value = value.replace(/\D/g, '');
            form.numero = event.target.value;
        };
        const form = useForm({
            cuatrimestre: '',
            matricula: '',
            user_id: null,
            name: '',
            apellido_paterno: '',
            apellido_materno: '',
            numero: '',
            email: '',
            password: '',
            role: 'Alumno',
        });

        return { handleSubmit, validateNumericInput, form, mdiBallotOutline, mdiAccount, mdiMail, mdiGithub }
    }
}
</script>

<template>
    <LayoutMain :title="titulo">
        <SectionTitleLineWithButton :title="titulo" main>

        </SectionTitleLineWithButton>

        <CardBox form @submit.prevent="handleSubmit">

            <FormField :error="form.errors.name">
                <FormControl v-model="form.name" placeholder="Nombre" />
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

            <FormField :error="form.errors.cuatrimestre">
                <select v-model="form.cuatrimestre">
                    <option disabled value="">Selecciona el cuatrimestre</option>
                    <option>1</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4</option>
                    <option>5</option>
                    <option>6</option>
                    <option>7</option>
                    <option>8</option>
                    <option>9</option>
                    <option>10</option>
                </select>
                <FormField :error="form.errors.matricula">

                    <FormControl v-model="form.matricula" placeholder="matricula" />

                </FormField>
            </FormField>

            <template #footer>
                <BaseButtons>
                    <BaseButton @click="handleSubmit" type="submit" color="info" label="Crear" />
                    <BaseButton :href="route(`usuarios.index`)" type="reset" color="danger" outline label="Cancelar" />
                </BaseButtons>
            </template>
        </CardBox>
    </LayoutMain>
</template>
