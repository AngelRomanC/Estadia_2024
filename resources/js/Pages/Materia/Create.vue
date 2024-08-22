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
            form.post(route('materia.store'));
        };

        const form = useForm({
            nombre: '',
            clave: '',
            cuatrimestre: '',
            tipo:'',
            No_horas_presenciales:'',
            No_horas_no_presenciales:'',
            periodo:'',
            nivel:'',
            status: 1
        });

        return { handleSubmit, form, mdiBallotOutline, mdiAccount, mdiMail, mdiGithub }
    }
}
</script>

<template>
    <LayoutMain :title="titulo">
        <SectionTitleLineWithButton  :title="titulo" main>
            
        </SectionTitleLineWithButton>

        <CardBox form @submit.prevent="handleSubmit">
            <FormField :error="form.errors.nombre">
                <FormControl v-model="form.nombre"  placeholder="Nombre"/>
            </FormField>   
            <FormField :error="form.errors.cuatrimestre">
                <FormControl v-model="form.cuatrimestre" placeholder="Cuatrimestre" type="number"/>
            </FormField>

            <FormField :error="form.errors.tipo">
                <FormControl v-model="form.tipo" placeholder="Tipo" />
            </FormField>
            <FormField :error="form.errors.clave">
                <FormControl v-model="form.clave" placeholder="Clave" />
            </FormField>
            <FormField :error="form.errors.No_horas_presenciales">
                <FormControl v-model="form.No_horas_presenciales" placeholder="Numero de horas presenciales" type="number" />
            </FormField>
            <FormField :error="form.errors.No_horas_no_presenciales">
                <FormControl v-model="form.No_horas_no_presenciales" placeholder="Numero de horas no presenciales" type="number" />
            </FormField>
            <FormField :error="form.errors.periodo">
                <select v-model="form.periodo" class="w-full">
                    <option disabled value="">Selecciona el periodo cuatrimestral</option>
                    <option>Sep-Dic</option> <option>Ene-Abr</option><option>May-Ago</option> 
                </select>  
            </FormField>  
               
            <FormField :error="form.errors.nivel">
                <FormControl v-model="form.nivel" placeholder="Nivel" />
            </FormField>

            <template #footer>
                <BaseButtons>
                    <BaseButton @click="handleSubmit" type="submit" class="action-button" label="Crear" />
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