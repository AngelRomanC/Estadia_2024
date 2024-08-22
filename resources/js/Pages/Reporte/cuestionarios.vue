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
const props = defineProps(['titulo','periodo','cantidadAcademico','cantidadHabito','cantidadInteligencia','grupo']);
import FormControlV3 from "@/Components/FormControlV3.vue";

import FormControlV6 from "@/Components/FormControlV6.vue";

import Chart from 'chart.js/auto';
const periodofiltro = ref(null);
const grupofiltro = ref(null);
const datosgrafica = ref(null);
const datosacademico= ref(null);

const grafica = () => {
  const existingChart = Chart.getChart('grafica-circular');
  if (existingChart) {
      existingChart.destroy();
  }
  const ctx = document.getElementById('grafica-circular').getContext('2d');
  new Chart(ctx, {
    type: 'pie',
    data: {
      labels: ['Análisis academico','Hábitos de estudio','Inteligencias multiples'] ,
      datasets: [{
        label: 'Alumnos',
        data: [datosgrafica.value.cantidadAcademico?? 0,datosgrafica.value.cantidadHabito?? 0,datosgrafica.value.cantidadInteligencia?? 0],
        backgroundColor: [
          'rgba(255, 99, 132, 0.2)',
          'rgba(54, 162, 235, 0.2)',
          'rgba(255, 206, 86, 0.2)',
          'rgba(75, 192, 192, 0.2)',
          'rgba(153, 102, 255, 0.2)',
          'rgba(255, 159, 64, 0.2)'
        ],
        borderColor: [
          'rgba(255, 99, 132, 1)',
          'rgba(54, 162, 235, 1)',
          'rgba(255, 206, 86, 1)',
          'rgba(75, 192, 192, 1)',
          'rgba(153, 102, 255, 1)',
          'rgba(255, 159, 64, 1)'
        ],
        borderWidth: 1
      }]
    },
    options: {
      plugins: {
        title: {
          display: true,
          text: 'Cuestionarios contestados'
        }
      },
      aspectRatio: 1, 
      responsive: false 
    }
  });
}

const loadFilteredData = () => {
  axios.get(route(`datoscuestionarios`, {
      periodofiltro: periodofiltro.value,
      grupofiltro: grupofiltro.value

            }))
    .then((response) => {
      datosgrafica.value = response.data;
      datosacademico.value = response.data;

      console.log(datosacademico)
      grafica();
      
    })
    .catch((error) => {
      console.error(error);
    });
};
const loadFilteredData2 = () => {
  axios.get(route(`datoscuestionarios`, {
     grupofiltro: grupofiltro.value,
     periodofiltro: periodofiltro.value,

            }))
    .then((response) => {
      datosgrafica.value = response.data;
      datosacademico.value = response.data;
      console.log(datosgrafica)
      grafica();
      
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
    <FormField label="Selecciona un periodo">
      <FormControlV6 v-model="grupofiltro" :options="grupo" @change="loadFilteredData2()" />
    </FormField>
    <div>
      <canvas id="grafica-circular" width="500" height="500"></canvas>
    </div>

    <div id="reporte" >
      <h1> Cuestionarios contestados por los alumnos </h1>
      <div v-for="Periodo in periodo.filter(item=> item.id === periodofiltro)">
        <h1> En el periodo de {{ Periodo.periodo }} {{ Periodo.año }} 
        </h1>  
      </div>
      <table border="1">
        <thead>
          <tr>
            <th>Análisis académico individual</th>
            <th>Habito de estudio</th>
            <th>Inteligencias múltiples</th>
          </tr>
        </thead>
        <tbody>
          <tr v-if="datosgrafica">
            <th>{{datosgrafica.cantidadAcademico}}</th>
            <th>{{datosgrafica.cantidadHabito}}</th>
            <th>{{datosgrafica.cantidadInteligencia}}</th>
          </tr>
        </tbody>
        <tbody>
         
        </tbody>
      </table>
      <h1  v-if="datosgrafica"> Obteniendo un total de {{datosgrafica.cantidadAcademico}} alumnos que contestaron el formato de análisis académico individual </h1>
      <h1  v-if="datosgrafica"> Obteniendo un total de {{datosgrafica.cantidadHabito}} alumnos que contestaron el formato de Hbitos de estudios </h1>
      <h1  v-if="datosgrafica"> Obteniendo un total de {{datosgrafica.cantidadInteligencia}} alumnos que contestaron el formato de Inteligencias múltiples </h1>
      <div>
        
      </div>
    
    </div>
    <button @click="downloadPDF">Descargar PDF</button>
    
  </LayoutDashboard>
</template>