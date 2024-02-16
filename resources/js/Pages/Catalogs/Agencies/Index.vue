<script setup>
import CardBox from "@/Components/CardBox.vue";
import LayoutMain from "@/Layouts/LayoutMain.vue";
import SectionTitleLineWithButton from "@/Components/SectionTitleLineWithButton.vue";
import { mdiBallotOutline, mdiAccount, mdiMail, mdiInformation, mdiPencil, mdiBroom } from "@mdi/js";
import NotificationBar from "@/Components/NotificationBar.vue";
import BaseButton from "@/Components/BaseButton.vue";
import BaseButtons from "@/Components/BaseButtons.vue";
import CardBoxComponentEmpty from "@/Components/CardBoxComponentEmpty.vue";
import { defineProps } from 'vue';
import { router, Link, Head } from "@inertiajs/vue3";

import Pagination from "@/Shared/Pagination.vue";
import RecordsHelper from "@/Shared/RecordsHelper.vue";
import { computed, onMounted, reactive, ref, watch } from "vue";
import { Inertia } from "@inertiajs/inertia";
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/css/index.css';

const props = defineProps({
    name: 'Index',
    title: {
        type: String,
        required: true
    },
    agencies: {
        type: Object,
        default: () => ({}),
        required: true
    },
    routeName: {
        type: String,
        required: true
    },
    loadingResults: { type: Boolean, required: true, default: true },
    search: { type: String, required: true },
});

const isLoading = ref(false)
const state = reactive({
    filters: {
        page: ref(props.agencies.current_page),
        search: ref(props.search),
        status: ref(props.status ?? 1),
    },
});
const search = () => {
    props.loadingResults = true;
    isLoading.value = true
    router.get(route(`${props.routeName}index`, state.filters));
};
const cleanFilters = () => {
    isLoading.value = true
    router.get(route(`${props.routeName}index`));
}


</script>

<template>
    <Head :title="title" />
    <LayoutMain>
        <SectionTitleLineWithButton :icon="mdiBallotOutline" :title="title" main>
            <BaseButton :href="route(`${routeName}create`)" color="info" label="+ Agregar" />
        </SectionTitleLineWithButton>

        <NotificationBar v-if="$page.props.flash.success" color="success" :icon="mdiInformation" :outline="false">
            {{ $page.props.flash.success }}
        </NotificationBar>

        <NotificationBar v-if="$page.props.flash.error" color="danger" :icon="mdiInformation" :outline="false">
            {{ $page.props.flash.error }}
        </NotificationBar>
        <form class="w-full mb-5">
            <div class="flex flex-col md:flex-row">
                <div class="relative w-full md:w-4/5 mr-1">
                    <input type="search" id="search-dropdown"
                        class="block p-2.5 md:h-11 w-full z-20 text-sm text-gray-900 bg-gray-50 rounded-l-lg md:rounded-l-none rounded-r-lg md:border-l-gray-300 border-l-gray-300 border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-l-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:border-blue-500"
                        placeholder="Ingresa un parametro de busqueda" v-model="state.filters.search" @change="search" />
                    <button type="submit"
                        class="absolute top-0 right-0 p-2.5 text-sm font-medium h-full md:h-11 xl:h-full text-white bg-blue-700 rounded-r-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                        @click.prevent="search">
                        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                        </svg>
                        <span class="sr-only">Search</span>
                    </button>
                </div>

                <BaseButton class="md:w-1/5 md:mt-0 md:h-11 max-xl:mt-4 mr-1" @click="cleanFilters" :icon="mdiBroom"
                    color="danger" label="Limpiar" />
            </div>
        </form>
        <CardBox v-if="agencies.data.length > 0">
            <table>
                <thead>
                    <tr>
                        <th />
                        <th>Zona</th>
                        <th>Descripción</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item in agencies.data" :key="item.id">
                        <td class="align-items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-book-half" viewBox="0 0 16 16">
                                <path
                                    d="M8.5 2.687c.654-.689 1.782-.886 3.112-.752 1.234.124 2.503.523 3.388.893v9.923c-.918-.35-2.107-.692-3.287-.81-1.094-.111-2.278-.039-3.213.492V2.687zM8 1.783C7.015.936 5.587.81 4.287.94c-1.514.153-3.042.672-3.994 1.105A.5.5 0 0 0 0 2.5v11a.5.5 0 0 0 .707.455c.882-.4 2.303-.881 3.68-1.02 1.409-.142 2.59.087 3.223.877a.5.5 0 0 0 .78 0c.633-.79 1.814-1.019 3.222-.877 1.378.139 2.8.62 3.681 1.02A.5.5 0 0 0 16 13.5v-11a.5.5 0 0 0-.293-.455c-.952-.433-2.48-.952-3.994-1.105C10.413.809 8.985.936 8 1.783z" />
                            </svg>
                        </td>
                        <td data-label="Nombre">
                            {{ item.name }}
                        </td>
                        <td data-label="Descripción">
                            {{ item.description.slice(0, 50) }}
                        </td>
                        <td data-label="acciones">
                            <BaseButtons>
                                <BaseButton color="success" :icon="mdiPencil" small
                                    :href="route(`${routeName}edit`, item.id)" />
                            </BaseButtons>
                        </td>

                    </tr>
                </tbody>
            </table>
            <pagination :links="agencies.links" :total="agencies.total" />
        </CardBox>
        <CardBoxComponentEmpty v-else />
        <div class="vl-parent">
            <loading v-model:active="isLoading" :can-cancel="false" :is-full-page="true" />
        </div>
    </LayoutMain>
</template>
