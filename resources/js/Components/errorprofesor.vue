<template>
    <div v-if="error" class="error-box">{{ error }}</div>
    <!-- Otro contenido de tu componente -->
</template>

<script>
    export default {
        props: {
            error: String
        }
    }
</script>

<style>
    .error-box {
        background-color: #ffe6e6;
        color: #cc0000;
        border: 1px solid #cc0000;
        padding: 10px;
        border-radius: 5px;
        margin-bottom: 10px;
    }
</style>
