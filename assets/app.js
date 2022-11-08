import {createApp} from 'vue';
import './styles/app.scss';
import CryptoCurrencyConverter from "./components/CryptoCurrencyConverter";

createApp({
    components: {
        CryptoCurrencyConverter
    }
}).mount("#app");
