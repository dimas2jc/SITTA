import { createApp } from "vue";
import StockPage from "../../views/pages/vue/stockPage.vue";

const Store = window.Store;

createApp(StockPage, { Store }).mount("#stockApp");
