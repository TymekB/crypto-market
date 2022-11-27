import {Controller} from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ['quantity', 'price'];

    changeQuantity() {
        let price = this.priceTarget.value;

        this.quantityTarget.value = Math.round(price / this.data.get('rate') * 100000) / 100000;
    }

    changePrice() {
        let quantity = this.quantityTarget.value;

        this.priceTarget.value = Math.round(quantity * this.data.get('rate') * 100) / 100;
    }
}