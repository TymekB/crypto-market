<template>
    <div class="mb-3">
        <label for="crypto_currency_quantity" class="form-label required">Quantity</label>
        <input type="number" id="crypto_currency_quantity" name="crypto_currency_form[quantity]"
               v-model.number="quantity" v-on:input="changePrice" step="any" class="form-control">
    </div>
    <div class="mb-3">
        <label for="crypto_currency_price"
               class="form-label required">
            Price
        </label>
        <div class="input-group">
            <span class="input-group-text">€</span>
            <input type="number" id="crypto_currency_price" v-model.number="price" v-on:input="changeQuantity"
                   class="form-control" step="any">
        </div>
    </div>
</template>

<script>
export default {
    name: 'CryptoCurrencyConverter',
    props: {
        cryptoCurrencyPrice: Number
    },
    data() {
        return {
            quantity: 0,
            price: 0,
        }
    },

    methods: {
        changePrice() {
            this.price = Math.round(this.quantity * this.cryptoCurrencyPrice * 100) / 100;
        },
        changeQuantity() {
            this.quantity = Math.round(this.price / this.cryptoCurrencyPrice * 100000) / 100000;
        }
    },

    created() {
        console.log("test");
        console.log(this.cryptoCurrencyPrice)
    }
}
</script>

<style scoped>

</style>