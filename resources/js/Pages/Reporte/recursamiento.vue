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
const props = defineProps(['titulo',  'periodo','materia','totalAlumnos']);

import Chart from 'chart.js/auto';
import FormControl from "@/Components/FormControl.vue";
import FormControlV3 from "@/Components/FormControlV3.vue";
const periodofiltro = ref(null);
const datosgrafica = ref(null);
const totalAlumnos = ref(null);
const totalRecursamiento = ref(null);
const grafica = () => {
  const existingChart = Chart.getChart('grafica-circular');
  if (existingChart) {
      existingChart.destroy();
  }
  const ctx = document.getElementById('grafica-circular').getContext('2d');
  new Chart(ctx, {
    type: 'pie',
    data: {
      labels: [datosgrafica.value.materia?.[0]?.nombre ?? 'Vacío',datosgrafica.value.materia?.[1]?.nombre ?? 'Vacío',datosgrafica.value.materia?.[2]?.nombre ?? 'Vacío',datosgrafica.value.materia?.[3]?.nombre ?? 'Vacío',datosgrafica.value.materia?.[4]?.nombre ?? 'Vacío',datosgrafica.value.materia?.[5]?.nombre ?? 'Vacío',datosgrafica.value.materia?.[6]?.nombre ?? 'Vacío',datosgrafica.value.materia?.[7]?.nombre ?? 'Vacío',datosgrafica.value.materia?.[8]?.nombre ?? 'Vacío',datosgrafica.value.materia?.[9]?.nombre ?? 'Vacío'],
      datasets: [{
        label: ["Alumnos"],
        data: [datosgrafica.value.materia?.[0]?.cantidad_alumnos,datosgrafica.value.materia?.[1]?.cantidad_alumnos,datosgrafica.value.materia?.[2]?.cantidad_alumnos,datosgrafica.value.materia?.[3]?.cantidad_alumnos,datosgrafica.value.materia?.[4]?.cantidad_alumnos,datosgrafica.value.materia?.[5]?.cantidad_alumnos,datosgrafica.value.materia?.[6]?.cantidad_alumnos,datosgrafica.value.materia?.[7]?.cantidad_alumnos,datosgrafica.value.materia?.[8]?.cantidad_alumnos,datosgrafica.value.materia?.[9]?.cantidad_alumnos],
        backgroundColor: [
          'rgba(255, 0, 0, 0.5)',    
          'rgba(0, 0, 255, 0.5)',    
          'rgba(0, 255, 0, 0.5)',    
          'rgba(255, 255, 0, 0.5)',  
          'rgba(0, 0, 255, 0.5)',    
          'rgba(255, 0, 0, 0.5)'     
        ],
        borderColor: [
          'rgba(255, 0, 0, 1)',      // Rojo
          'rgba(0, 0, 255, 1)',      // Azul
          'rgba(0, 255, 0, 1)',      // Verde
          'rgba(255, 255, 0, 1)',    // Amarillo
          'rgba(0, 0, 255, 1)',      // Azul
          'rgba(255, 0, 0, 1)'       // Rojo
        ],
        borderWidth: 1
      }]
    },
    options: {
      plugins: {
        title: {
          display: true,
          text: 'Materias en recursamiento'
        }
      },
      aspectRatio: 1, // Mantener una relación de aspecto cuadrada
      responsive: false // Desactivar la respuesta para evitar que se redimensione automáticamente
    }
  });
}

const loadFilteredData = () => {
  axios.get(route(`datosrecursamiento`, {
      periodofiltro: periodofiltro.value
            }))
    .then((response) => {
      datosgrafica.value = response.data;
      totalAlumnos.value = response.data;
   
      grafica();
      console.log(datosgrafica)
    })
    .catch((error) => {
      console.error(error);
    });
};
const downloadPDF = () => {
  const element = document.getElementById('reporte');
  html2pdf().from(element).save('reporte.pdf');
};

onMounted(() => {
  
  loadFilteredData()

});

</script>

<template>

  <Head title="Dashboard" />
  <LayoutDashboard>
    <FormField label="Selecciona un periodo">
      <FormControlV3 v-model="periodofiltro" :options="periodo" @change="loadFilteredData()" />
    </FormField>

    <div>
      <canvas id="grafica-circular" width="500" height="500"></canvas>
    </div>
    <div id="reporte" >
      <h1> Materias en recursamiento</h1>
      <div v-for="Periodo in periodo.filter(item=> item.id === periodofiltro)">
        <h1> En el periodo de {{ Periodo.periodo }} {{ Periodo.año }} se presentan una apertura de {{ totalAlumnos.total_recursamiento}} 
          recursamientos con un total de  {{ totalAlumnos.totalAlumnos }} alumnos
        </h1>  
      </div>
      
      
      <table border="1">
        <thead>
          <tr>
            <th>Nombre de la Materia</th>
            <th>Cantidad de Alumnos</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(materia, index) in datosgrafica?.materia || []" :key="index">
            <td>{{ materia.nombre }} </td>
            <td>{{ materia.cantidad_alumnos }}</td>
          </tr>
        </tbody>
      </table>
    </div>

    <button @click="downloadPDF">Descargar PDF</button>
    {{ materia }}
  </LayoutDashboard>
</template>