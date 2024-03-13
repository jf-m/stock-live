<template>
    <div class="grid gap-6 lg:grid-cols-3 lg:gap-8">
        <stock-card :stock="stock" v-for="stock in stocks"/>
    </div>
</template>

<script setup>
import StockCard from "./StockCard.vue";

const props = defineProps(['stocks']);

</script>

<style scoped>

</style>
