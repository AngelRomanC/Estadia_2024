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

const props = defineProps(['titulo', 'Materia', 'routeName']);
const form = useForm({ ...props.Materia });

const guardar = () => {
    form.put(route("materia.update", props.Materia.id));
};

</script>

<template>
    <LayoutMain :title="titulo">
        <SectionTitleLineWithButton :title="titulo" main>
            <Link :href="route(`${routeName}index`)">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                </svg>
            </Link>
        </SectionTitleLineWithButton>

        <CardBox form @submit.prevent="guardar">
            <FormField label="Nombre">
                <FormControl v-model="form.nombre"  placeholder="nombre"/>
                <FormControl v-model="form.clave" placeholder="clave" />
                <FormControl v-model="form.cuatrimestre" placeholder="cuatrimestre" />
                <FormControl v-model="form.tipo" placeholder="tipo" />
                <FormControl v-model="form.No_horas_presenciales" placeholder="No_horas_presenciales" />
                <FormControl v-model="form.No_horas_no_presenciales" placeholder="No_horas_no_presenciales" />
                <FormControl v-model="form.periodo" placeholder="periodo" />
                <FormControl v-model="form.nivel" placeholder="nivel" />
                <select 
                  v-model="form.status" :class="{ 'is-invalid': form.errors.status }" required
                >
                  <option value="1">Activo</option>
                  <option value="0">No Activo</option>
                </select>
            </FormField>

          
            <template #footer>
                <BaseButtons>
                    <BaseButton @click="guardar" type="submit" color="info" label="Actualizar" />
                    <BaseButton :href="route(`${routeName}index`)" type="reset" color="danger" outline label="Cancelar" />
                </BaseButtons>
            </template>
        </CardBox>
    </LayoutMain>
</template>

