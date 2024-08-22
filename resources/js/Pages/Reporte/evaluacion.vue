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

import LayoutDashboard from "@/Layouts/LayoutDashboard.vue";
import SectionTitleLineWithButton from "@/Components/SectionTitleLineWithButton.vue";
import SectionBannerStarOnGitHub from "@/Components/SectionBannerStarOnGitHub.vue";
import ChartComponent from "@/Components/Charts/LineChart.vue";
const props = defineProps(['titulo',  'periodo','materia','recursamiento']);
import html2pdf from 'html2pdf.js'; 
import Chart from 'chart.js/auto';
import FormControl from "@/Components/FormControl.vue";
import FormControlV3 from "@/Components/FormControlV3.vue";
import FormControlV4 from "@/Components/FormControlV4.vue";
const materiafiltro = ref(null);
const periodofiltro = ref(null);
const datosgrafica = ref(null);

const grafica = () => {
  const existingChart = Chart.getChart('grafica-circular');
  if (existingChart) {
      existingChart.destroy();
  }
  const ctx = document.getElementById('grafica-circular').getContext('2d');
  new Chart(ctx, {
    type: 'pie',
    data: {
      labels: ['Fácil','Normal','Difícil'],
      datasets: [{
        label: ["Alumnos"],
        data: [datosgrafica.value.Recursamiento.facil,datosgrafica.value.Recursamiento.normal,datosgrafica.value.Recursamiento.dificil],
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
  axios.get(route(`datosevaluacion`, {
      periodofiltro: periodofiltro.value,
      materiafiltro: materiafiltro.value
            }))
    .then((response) => {
      datosgrafica.value = response.data;
      grafica();
      console.log(datosgrafica)
    })
    .catch((error) => {
      console.error(error);
    });
};
const loadFilteredData2 = () => {
  axios.get(route(`datosevaluacion`, {
      materiafiltro: materiafiltro.value,
      periodofiltro: periodofiltro.value
            }))
    .then((response) => {
      datosgrafica.value = response.data;
      grafica();
      console.log(datosgrafica)
    })
    .catch((error) => {
      console.error(error);
    });
};
onMounted(() => {
  
  loadFilteredData(),
  loadFilteredData2()

});

const downloadPDF = () => {
  const element = document.getElementById('reporte');
  html2pdf().from(element).save('reporte.pdf');
};
</script>

<template>

  <Head title="Dashboard" />
  <LayoutDashboard>
    <FormField label="Selecciona un periodo">
      <FormControlV4 v-model="materiafiltro" :options="materia" @change="loadFilteredData2()" />
    </FormField>
    <FormField label="Selecciona un periodo">
      <FormControlV3 v-model="periodofiltro" :options="periodo" @change="loadFilteredData()" />
    </FormField>

    <div>
      <canvas id="grafica-circular" width="500" height="500"></canvas>
    </div>
    <table border="1">
      <thead>
        <tr>
          <th>Fácil</th>
          <th>Normal</th>
          <th>Difícil</th>
        </tr>
      </thead>
      <tbody>
        <tr v-if="datosgrafica">
          <th>{{datosgrafica}}</th>
          
        </tr>
      </tbody>
      <tbody>
       
      </tbody>
    </table>
      <div>
      
    </div>
  

  <button @click="downloadPDF">Descargar PDF</button>
  </LayoutDashboard>
</template>