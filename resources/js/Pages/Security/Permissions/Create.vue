<script setup>
import CardBox from "@/Components/CardBox.vue";
import LayoutMain from "@/Layouts/LayoutMain.vue";
import SectionTitleLineWithButton from "@/Components/SectionTitleLineWithButton.vue";
import { mdiBallotOutline, mdiInformation, mdiPlus, mdiPencil, mdiTrashCan, mdiContentSave, mdiClose } from "@mdi/js";
import NotificationBar from "@/Components/NotificationBar.vue";
import BaseButton from "@/Components/BaseButton.vue";
import BaseButtons from "@/Components/BaseButtons.vue";

import { defineProps } from 'vue';
import { Link, Head } from "@inertiajs/vue3";

import JetInput from "@/Components/Input.vue";
import JetInputError from "@/Components/InputError.vue";
import JetButton from "@/Components/Button.vue";
import { useForm } from "@inertiajs/vue3";
import FormField from "@/Components/FormField.vue";
import FormControl from "@/Components/FormControl.vue";
import { provide, watchEffect } from "@vue/runtime-core";

const props = defineProps({
    name: 'Create',
    title: {
        type: String,
        required: true
    },
    modules: { type: Object, required: true },

    routeName: {
        type: String,
        required: true
    },
});
const form = useForm({ name: '', guard_name: 'web', description: '', module_key: "" });
const guardar = () => {
    form.post(route(`${props.routeName}store`));
};
watchEffect(() => {
    if (form.module_key) {
        form.name = form.module_key + '.';
    }
});


</script>

<template>
    <Head :title="title" />
    <LayoutMain>
        <SectionTitleLineWithButton :icon="mdiPlus" :title="title" main>
            <a :href="route(`${routeName}index`)">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-x"
                    viewBox="0 0 16 16">
                    <path
                        d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                </svg>
            </a>
        </SectionTitleLineWithButton>

        <CardBox form @submit.prevent="guardar">
            <FormField label="Nombre del módulo:" :required="true" help="Selecciona un módulo disponible"
                :error="form.errors.module_key">
                <FormControl v-model="form.module_key" :options="modules" valueSelect="key" />
            </FormField>
            <FormField label="Nombre del permiso:" help="Ejemplos: nombre_modulo.index, nombre_modulo.store,
                    nombre_modulo.update, nombre_modulo.delete" :required="true" :error="form.errors.name">
                <FormControl v-model="form.name" placeholder="Nombre del permiso" />
            </FormField>
            <FormField label="Descripción:" help="Ejemplos: index=Leer Registros, store=Crear Registros,
                    update=Actualizar Registros, delete=Eliminar Registros" :required="true" :error="form.errors.description">
                <FormControl v-model="form.description" placeholder="Descripción" />
            </FormField>
            <template #footer>
                <BaseButtons>
                    <BaseButton :href="route(`${routeName}index`)" :icon="mdiClose" color="danger" label="Cancelar" />
                    <BaseButton @click="guardar" :icon="mdiContentSave" type="submit" color="info" label="Guardar" />
                </BaseButtons>
            </template>
        </CardBox>
    </LayoutMain>
</template>
