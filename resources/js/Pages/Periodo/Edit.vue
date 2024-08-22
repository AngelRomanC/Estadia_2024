<script setup>
import { ref, defineProps, onMounted } from 'vue';
import { useForm } from '@inertiajs/vue3';
import LayoutMain from '@/layouts/LayoutMain.vue';
import FormField   from "@/components/FormField.vue";
import FormControl from "@/components/FormControl.vue";
import BaseDivider from "@/components/BaseDivider.vue";
import BaseButton from "@/components/BaseButton.vue";
import BaseButtons from "@/components/BaseButtons.vue";
import SectionTitleLineWithButton from "@/components/SectionTitleLineWithButton.vue";
import CardBox from "@/components/CardBox.vue";
import Swal from 'sweetalert2';

const props = defineProps(['titulo', 'periodo', 'routeName']);
const form = useForm({ ...props.periodo });

const guardar = () => {
    form.put(route("periodo.update", props.periodo.id));
};

</script>

<template>
    <LayoutMain :title="titulo">
        <SectionTitleLineWithButton  :title="titulo" main>
          
        </SectionTitleLineWithButton>

        <CardBox form @submit.prevent="guardar">
            <FormField label="Perido">
                <FormControl v-model="form.periodo"  placeholder="periodo"/>                
            </FormField>

            <FormField label="Año">
                <FormControl v-model="form.año"  placeholder="año"/>
            </FormField>

            <FormField label="Nomenclatura">
                <FormControl v-model="form.nomenclatura"  placeholder="nomenclatura"/>
                
            </FormField>
           
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