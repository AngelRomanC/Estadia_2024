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
const props = defineProps(['titulo', 'top_materias', 'periodo', 'grupo']);

import Chart from 'chart.js/auto';
import html2pdf from 'html2pdf.js';
import FormControl from "@/Components/FormControl.vue";
import FormControlV3 from "@/Components/FormControlV3.vue";
import FormControlV6 from "@/Components/FormControlV6.vue";
const periodofiltro = ref(null);
const grupofiltro = ref(null);
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
      labels: [datosgrafica.value?.top_materias?.[0]?.nombre ?? 'Vacío', datosgrafica.value?.top_materias?.[1]?.nombre ?? 'Vacío', datosgrafica.value?.top_materias?.[2]?.nombre ?? 'Vacío'],
      datasets: [{
        label: 'Alumnos',
        data: [datosgrafica.value?.top_materias?.[0]?.cantidad ?? 0, datosgrafica.value?.top_materias?.[1]?.cantidad ?? 0, datosgrafica.value?.top_materias?.[2]?.cantidad ?? 0],
        backgroundColor: [
          'rgba(54, 162, 235, 0.7)',   // Azul claro
          'rgba(255, 159, 64, 0.7)',   // Naranja
          'rgba(75, 192, 192, 0.7)',   // Verde azulado
          'rgba(255, 99, 132, 0.7)',   // Rosa
          'rgba(153, 102, 255, 0.7)',  // Morado
          'rgba(255, 206, 86, 0.7)'    // Amarillo verdoso
        ],
        borderColor: [
          'rgba(54, 162, 235, 1)',    // Azul claro
          'rgba(255, 159, 64, 1)',    // Naranja
          'rgba(75, 192, 192, 1)',    // Verde azulado
          'rgba(255, 99, 132, 1)',    // Rosa
          'rgba(153, 102, 255, 1)',   // Morado
          'rgba(255, 206, 86, 1)'     // Amarillo verdoso
        ],
        borderWidth: 1
      }]
    },
    options: {
      plugins: {
        title: {
          display: true,
          text: 'Top 3 Materias reprobadas '
        }
      },
      aspectRatio: 1, // Mantener una relación de aspecto cuadrada
      responsive: false // Desactivar la respuesta para evitar que se redimensione automáticamente
    }
  });
}

const loadFilteredData = () => {
  axios.get(route(`datostop3`, {
    periodofiltro: periodofiltro.value,
    grupofiltro: grupofiltro.value
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
    <FormField label="Selecciona un grupo">
      <FormControlV6 v-model="grupofiltro" :options="grupo" @change="loadFilteredData()" />
    </FormField>
    <div>
      <canvas id="grafica-circular" width="500" height="500"></canvas>
    </div>
    <div id="reporte">
      <h1> Top 3 de las materias con mayor índice de reprobación</h1>
      <table border="1">
        <thead>
          <tr>
            <th>Nombre de la Materia</th>
            <th>Cantidad de Alumnos</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(materia, index) in datosgrafica?.top_materias || []" :key="index">
            <td>{{ materia.nombre }}</td>
            <td>{{ materia.cantidad }}</td>
          </tr>
        </tbody>
      </table>

      <div v-for="Grupo in grupo.filter(item => item.id === grupofiltro)" :key="Grupo.id" class="mt-4">
        <template v-if="datosgrafica?.top_materias?.length > 0">
          El top 3 Pertenece al grupo {{ Grupo.grado }} {{ Grupo.grupo }},
          <div v-if="datosgrafica.top_materias[0]">
            El primer lugar para la materia {{ datosgrafica.top_materias[0].nombre }} con un total de {{
              datosgrafica.top_materias[0].cantidad }} alumnos.
          </div>
          <div v-if="datosgrafica.top_materias.length > 1 && datosgrafica.top_materias[1]">
            El segundo lugar para la materia {{ datosgrafica.top_materias[1].nombre }} con un total de {{
              datosgrafica.top_materias[1].cantidad }} alumnos.
          </div>
          <div v-if="datosgrafica.top_materias.length > 2 && datosgrafica.top_materias[2]">
            El tercer lugar para la materia {{ datosgrafica.top_materias[2].nombre }} con un total de {{
              datosgrafica.top_materias[2].cantidad }} alumnos.

          </div>
          <div>
            <br>
          </div>
        </template>
        <template v-else>
          No hay datos disponibles para el top 3 de materias.
        </template>
      </div>
    </div>
    <button @click="downloadPDF">Descargar PDF</button>
  </LayoutDashboard>
</template>
