<template>
    <div class="flex items-center bg-white border rounded-sm overflow-hidden shadow">
        <div class="p-4" :class="[isGreen ? 'bg-green-100' : 'bg-red-100']">
            <template v-if="stock.price">
                <svg v-if="isGreen" class="h-12 w-12 text-white" viewBox="0 0 700 700" xmlns="http://www.w3.org/2000/svg">
                    <g transform="translate(20 28.571)">
                        <path d="m-20 670.72c0-1.8584 349.99-699.99 350.57-699.29 1.9455 2.3548 350.07 699.46 349.43 699.72-0.41837 0.16878-79.297-33.691-175.29-75.244l-174.53-75.551-174.24 75.537c-95.833 41.546-174.63 75.537-175.09 75.537-0.46826 0-0.85138-0.32075-0.85138-0.71276z" fill="#0f0"/>
                    </g>
                </svg>
                <svg v-else class="h-12 w-12 text-white" viewBox="0 0 700 700" xmlns="http://www.w3.org/2000/svg">
                    <g transform="translate(20 28.571)">
                        <path d="m680-27.859c0 1.8584-349.99 699.99-350.57 699.29-1.9455-2.3548-350.07-699.46-349.43-699.72 0.41837-0.16878 79.297 33.691 175.29 75.244l174.53 75.551 174.24-75.537c95.833-41.546 174.63-75.537 175.09-75.537s0.85138 0.32075 0.85138 0.71277z" fill="#f00"/>
                    </g>
                </svg>
            </template>
        </div>
        <div class="px-4 text-gray-700 ">
            <h3 class="text-sm tracking-wider">{{ stock.name }} ({{ stock.symbol }})</h3>
            <p v-if="stock.price" class="text-3xl flex items-center" :class="[isGreen ? 'text-green-400' : 'text-red-400']">
                <span>{{symbol}}{{stock.price.percentage_change}}%</span>
                <span class="text-xs  ml-3">{{symbol}}{{priceChange}}$</span>
            </p>
        </div>
    </div>

</template>

<script setup>
import { reactive, computed } from 'vue';

const props = defineProps(['stock']);


const isGreen = computed(() => {
    return props.stock.price && props.stock.price.percentage_change >= 0;
});

const symbol = computed(() => {
    return props.stock.price && props.stock.price.percentage_change >= 0 ? '+' : '';
});

const priceChange = computed(() => {
    return Math.round((props.stock.price.close - props.stock.price.open) * 100)/100;
});

</script>

<style scoped>

</style>
