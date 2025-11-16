import { createApp } from "vue";
import TrackingPage from "../../views/pages/vue/trackingPage.vue";

const Store = window.Store;

createApp(TrackingPage, { Store }).mount("#trackingApp");
