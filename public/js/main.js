const API_URL = '/api/';

let CreatePaymentForm = Vue.component('create-payment-form', {
    name: 'create-payment-form',
    template: `
        <form>
            <div class="mb-3">
                <label for="amount" class="form-label">Amount</label>
                <input type="email" class="form-control" id="amount" v-model="amount">
            </div>
            <div class="mb-3">
                <label for="currency" class="form-label">Currency</label>
                <select class="form-control" id="currency" v-model="currency">
                    <option value="usd">USD</option>
                    <option value="eur">EUR</option>
                </select>
            </div>
            <button type="button" class="btn btn-success" @click="createPayment('success')">Success Request</button>
            <button type="button" class="btn btn-danger" @click="createPayment('fail')">Fail Request</button>
        </form>
    `,
    data() {
        return {
            amount: null,
            currency: null,
            redirectUrl: null
        };
    },
    methods: {
        async createPayment(status) {
            const requestOptions = {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({
                    amount: this.amount,
                    currency: this.currency,
                    processStatus: status,
                    paymentSystem: "awesomePay"
                })
            };
            const response = await fetch(API_URL + "create_payment", requestOptions);
            const data = await response.json();

            this.sendToCallback(data)
        },

        async sendToCallback(data) {
            const requestOptions = {
                method: "PATCH",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify(data)
            };
            const response = await fetch(API_URL + "callback", requestOptions);
            const callbackResponse = await response.json();
            //console.log(callbackResponse.redirectUrl);
            window.location.href = callbackResponse.redirectUrl;
        },
    }
});

new Vue({
    el: "#app",
    components: {
        'create-payment-form': CreatePaymentForm
    },
});
