<script setup>
import { Head } from "@inertiajs/vue3";
import  axios  from "axios";
import { computed, ref, onMounted } from "vue";
import { useMainStore } from "@/stores/main";
import {
  mdiAccountMultiple,
  mdiCartOutline,
  mdiChartTimelineVariant,
  mdiMonitorCellphone,
  mdiReload,
  mdiGithub,
  mdiChartPie,
  mdiViewModule,
} from "@mdi/js";
import * as chartConfig from "@/Components/Charts/chart.config.js";
import LineChart from "@/Components/Charts/LineChart.vue";
import SectionMain from "@/Components/SectionMain.vue";
import html2pdf from 'html2pdf.js'; 

import LayoutDashboard from "@/Layouts/LayoutDashboard.vue";
import SectionTitleLineWithButton from "@/Components/SectionTitleLineWithButton.vue";
import SectionBannerStarOnGitHub from "@/Components/SectionBannerStarOnGitHub.vue";
import ChartComponent from "@/Components/Charts/LineChart.vue";
const props = defineProps(['titulo', 'acumuladas', 'periodo','alumno']);

import Chart from 'chart.js/auto';
import FormControl from "@/Components/FormControl.vue";
import FormControlV3 from "@/Components/FormControlV3.vue";
const downloadPDF = () => {
  const element = document.getElementById('reporte');
  html2pdf().from(element).save('reporte.pdf');
};

</script>

<template>

  <Head title="Dashboard" />
  <LayoutDashboard>
    

  
    <div id="reporte" >
      <h1> Hisorial de materias del Alumno:  {{ props.alumno.name}} {{ props.alumno.apellido_paterno}} {{ props.alumno.apellido_materno }}  </h1>
      
      <table border="1">
        <thead>
          <tr>
            <th>Materia</th>
            <th>Cuatrimestre</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="materia in props.acumuladas">
            <th>{{materia.nombre}}</th>
            <th>{{materia.cuatrimestre}}</th>
            
          </tr>
        </tbody>
        
      </table>
      <div>
        
      </div>
    
    </div>
    <button @click="downloadPDF">Descargar PDF</button>
  </LayoutDashboard>
</template>