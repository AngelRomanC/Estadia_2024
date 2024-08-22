<script setup>
import { Head } from "@inertiajs/vue3";
import axios from "axios";
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
const props = defineProps(['titulo', 'academico', 'habito', 'inteligencia', 'grupo', 'alumnos', 'cuestionario']);

import Chart from 'chart.js/auto';
import html2pdf from 'html2pdf.js';

import FormControl from "@/Components/FormControl.vue";
import FormControlV3 from "@/Components/FormControlV3.vue";
const periodofiltro = ref(null);
const datosgrafica = ref(null);


onMounted(() => {
  const ctx = document.getElementById('grafica-circular').getContext('2d');


  new Chart(ctx, {
    type: 'pie',
    data: {
      labels: ['Análisis academico Individual', 'Hábitos de estudio ', 'Inteligencias múltiples '],
      datasets: [{
        label: '',
        data: [props.academico, props.habito, props.inteligencia]
        ,backgroundColor: [
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
          text: 'Cuestionarios rewspondidos por alumnos '
        }
      },
      aspectRatio: 1,
      responsive: false
    }
  });
});

const downloadPDF = () => {
  const element = document.getElementById('reporte');
  html2pdf().from(element).save('reporte.pdf');
};

</script>

<template>

  <Head title="Dashboard" />
  <LayoutDashboard>


    <div>
      <canvas id="grafica-circular" width="500" height="500"></canvas>
    </div>
    <div id="reporte" >
      <h1> Cuestionario respondidos por los alumnos del {{ props.grupo.grado }} {{ props.grupo.grupo }} con un total de {{
        alumnos }} alumnos.</h1>
      <h2>
        Con un total de {{ cuestionario[3] }} cuestionarios contestado y faltando {{ cuestionario[4] }} por contestar.
      </h2>

      <table border="1">
        <thead>
          <tr>
            <th>Formato</th>
            <th>Enviados</th>
            <th>No enviados</th>
          </tr>
          <tr>
            <th>Analisís academico</th>
            <th> {{ academico }}</th>
            <th> {{ cuestionario[0] }}</th>
          </tr>
          <tr>

            <th>Habitos de estudio</th>
            <th> {{ habito }}</th>
            <th> {{ cuestionario[1] }}</th>
          </tr>
          <tr>

            <th>Inteligencias múltiples</th>
            <th> {{ inteligencia }}</th>
            <th> {{ cuestionario[2] }}</th>
          </tr>
        </thead>
        <tbody>

        </tbody>

      </table>
      <div>

      </div>

    </div>
    <button @click="downloadPDF">Descargar PDF</button>
  </LayoutDashboard>
</template>