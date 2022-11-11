import {createApp} from 'vue';
import CryptoCurrencyConverter from "./components/CryptoCurrencyConverter";

import './styles/app.scss';
import 'bootstrap';

createApp({
    components: {
        CryptoCurrencyConverter
    }
}).mount("#app");
