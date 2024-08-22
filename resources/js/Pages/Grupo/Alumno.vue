<script>
import { Link, useForm } from '@inertiajs/vue3';
import axios from 'axios';
import Swal from "sweetalert2";
import Pagination from '@/Shared/Pagination.vue';
import LayoutMain from '@/layouts/LayoutMain.vue';
import {
    mdiMonitorCellphone,
    mdiTableBorder,
    mdiTableOff,
    mdiGithub,
    mdiApplicationEdit, mdiTrashCan
} from "@mdi/js";
import TableSampleClients from "@/components/TableSampleClients.vue";
import CardBox from "@/components/CardBox.vue";
import SectionTitleLineWithButton from "@/components/SectionTitleLineWithButton.vue";
import BaseLevel from "@/components/BaseLevel.vue";
import BaseButtons from "@/components/BaseButtons.vue";
import BaseButton from "@/components/BaseButton.vue";
import CardBoxComponentEmpty from "@/components/CardBoxComponentEmpty.vue";
import NotificationBar from "@/components/NotificationBar.vue";
import Button from '@/Components/Button.vue';



export default {
    props: {
        titulo: { type: String, required: true },

        grupos: { type: Object, required: true },
        alumnos: { type: Object, required: true },
        profesor: { type: Object, required: true },
        routeName: { type: String, required: true },
        loadingResults: { type: Boolean, required: true, default: true }
    },
    components: {
        Link,
        LayoutMain,
        CardBox,
        TableSampleClients,
        SectionTitleLineWithButton,
        BaseLevel,
        BaseButtons,
        BaseButton,
        CardBoxComponentEmpty,
        Pagination,
        NotificationBar
    },
    setup() {
        const form = useForm({
            grado: '',
            grupo: '',
            tutor: '',
            materia: ''
        });
    
        function historial(id) {
      return route('historial', {
        id: id,
        });
        }
        function estado(id) {
      return route('estado', {
        id: id,
        });
        }



        return {
            form, historial,estado, mdiMonitorCellphone,
            mdiTableBorder,
            mdiTableOff,
            mdiGithub,
            mdiApplicationEdit, mdiTrashCan,
        }
    }

}
</script>

<template>
    <LayoutMain>
        <SectionTitleLineWithButton :title="titulo" main>
        </SectionTitleLineWithButton>

        <NotificationBar v-if="$page.props.flash.success" color="success" :icon="mdiInformation" :outline="false">
            {{ $page.props.flash.success }}
        </NotificationBar>

        <NotificationBar v-if="$page.props.flash.error" color="danger" :icon="mdiInformation" :outline="false">
            {{ $page.props.flash.error }}
        </NotificationBar>

        <CardBox v-if="grupos.data.length < 1">
            <CardBoxComponentEmpty />
        </CardBox>

        <CardBox v-else class="mb-6" has-table>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-2 xl:grid-cols-2">
                <div v-for="item in grupos.data" :key="item.id"
                    class="max-w-full bg-white border border-gray-200 rounded-lg shadow-md dark:bg-gray-800 dark:border-gray-700">
                    <div class="p-4">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white">
                            {{ item.grado }} °
                            {{ item.grupo }}
                            &nbsp; &nbsp;
                            {{ item.periodo.periodo }}
                            {{ item.periodo.año }}
                        </h3>
                        
                        <p class="text-sm text-gray-500 dark:text-gray-300">
                            Tutor: {{ item.profesor.user.name }} {{ item.profesor.user.apellido_paterno }} {{
                                item.profesor.user.apellido_materno }}
                        </p>


                        <p class="text-sm text-gray-500 dark:text-gray-300">
                            Estudiantes:
                            <span v-for="alumno in item.alumnos" :key="alumno.id">
                                <br> 
                                {{ alumno.user.name }} {{ alumno.user.apellido_paterno }} {{ alumno.user.apellido_materno }} {{ alumno.matricula }}
                                <span class="ml-3">
                                    <a :href="historial(alumno.id)">
                                        <button class="bg-transparent ml-2 dark:text-white dark:border-white hover:bg-blue-500 dark:hover:text-yellow-700 text-yellow-700 font-semibold hover:text-black py-2 px-4 border border-yellow-500 dark:hover:border-transparent hover:border-transparent rounded">
                                            Historial
                                        </button>
                                    </a>
                                    
                                </span>
                            </span>
                        </p>
                        
                        
                        
                        <br>
                        <a :href="estado(item.id)">
                            <button class="bg-transparent ml-2 dark:text-white dark:border-white hover:bg-blue-500 dark:hover:text-yellow-700 text-yellow-700 font-semibold hover:text-black py-2 px-4 border border-yellow-500 dark:hover:border-transparent hover:border-transparent rounded">
                                Estado
                            </button>
                        </a>
                    </div>

                </div>
            </div>
            
        </CardBox>

    </LayoutMain>
</template>
