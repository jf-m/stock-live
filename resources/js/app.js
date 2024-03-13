import './bootstrap';
import { createApp } from 'vue';
import StockList from "./components/StockList.vue";

const app = createApp({
    components: {
        StockList
    },
    props: ['stocks']
}).mount('#app');
