<script>
import { Link, useForm } from '@inertiajs/vue3';
import { mdiBallotOutline, mdiAccount, mdiMail, mdiGithub } from "@mdi/js";
import LayoutMain from '@/layouts/LayoutMain.vue';
import FormField from "@/components/FormField.vue";
import FormControl from "@/components/FormControl.vue";
import FormControlV2 from "@/components/FormControlV2.vue";
import FormControlV3 from "@/components/FormControlV3.vue";
import BaseDivider from "@/components/BaseDivider.vue";
import BaseButton from "@/components/BaseButton.vue";
import BaseButtons from "@/components/BaseButtons.vue";
import SectionTitleLineWithButton from "@/components/SectionTitleLineWithButton.vue";
import CardBox from "@/components/CardBox.vue";

export default {
    props: {
        titulo: { type: String, required: true },
        profesor: { type: Object, required: true },
        periodo:{ type: Object, required: true },
        usuarios: { type: Object, required: true },
        routeName: { type: String, required: true },
    },
    components: {
        LayoutMain,
        FormField,
        FormControl,
        FormControlV2,
        FormControlV3,
        BaseDivider,
        BaseButton,
        BaseButtons,
        CardBox,
        SectionTitleLineWithButton
    },
  
   
    setup() {
        const handleSubmit = () => {
            form.post(route('grupo.store'));
        };

        const form = useForm({
            grado: '',
            grupo: '',
            profesor_id: '',
            periodo_id: '',
            
        });

     
        return { handleSubmit, form, mdiBallotOutline, mdiAccount, mdiMail, mdiGithub }
    }
}
</script>

<template>
    <LayoutMain :title="titulo">
        <SectionTitleLineWithButton :title="titulo" main>
           
        </SectionTitleLineWithButton>

        <CardBox form @submit.prevent="handleSubmit">
            <FormField>
           
            <FormField :error="form.errors.grado" >
                
                <select v-model="form.grado" class="w-full">
                    <option disabled value="">Selecciona el grado</option>
                    <option>1</option> <option>2</option><option>3</option> <option>4</option> <option>5</option><option>6</option>
                    <option>7</option> <option>8</option><option>9</option><option>10</option>
                </select>
            </FormField>
            <FormField :error="form.errors.grupo">
        
                <select v-model="form.grupo"  class="w-full">
                    <option disabled value="">Selecciona el grupo</option>
                    <option>A</option> <option>B</option><option>C</option> <option>D</option> <option>E</option><option>F</option>
                  
                </select>
            </FormField>
            <FormField >
                <FormControlV3  v-model="form.periodo_id" :showOption="name" :options="periodo"/>
            </FormField>
            <FormField :error="form.errors.profesor_id">
                
                    <FormControlV2  v-model="form.profesor_id" :showOption="name" :options="usuarios"/>
             </FormField>
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