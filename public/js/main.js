const API_URL = '/api/';

let responseBodyFromPaySys = {
    "pay_form": {
        "token": "xxx",
        "design_name": "des1"
    },
    "transactions": {},
    "order": {},
    "transaction": {}
};

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
            <button type="button" class="btn btn-success" @click="sendToCallback('success')">Success Request</button>
            <button type="button" class="btn btn-danger" @click="sendToCallback('fail')">Fail Request</button>
        </form>
    `,
    data() {
        return {
            orderId: null,
            amount: null,
            currency: null,
            redirectUrl: null,
            paymentData: responseBodyFromPaySys
        };
    },
    methods: {
        async sendToCallback(status) {
            const idSlag1 = Math.floor(Math.random() * 1000);
            const idSlag2 = Math.floor(Math.random() * 10000);
            this.orderId = idSlag1 + '-' + idSlag2;

            this.paymentData.transactions[this.orderId] = {
                "id": this.orderId,
                "operation": "pay",
                "status": status,
                "descriptor": "FAKE_PSP",
                "amount": this.amount,
                "currency": this.currency,
                "fee": {
                    "amount": 0,
                    "currency": "USD"
                },
                "card": {
                    "bank": "CITIZENS STATE BANK",
                }
            };

            this.paymentData.transaction = {
                "id": this.orderId,
                "operation": "pay",
                "status": status
            };

            this.paymentData.order = {
                "order_id": this.orderId,
                "status": status === "success" ? "accepted" : "declined",
                "amount": this.amount,
                "refunded_amount": status === "success" ? this.amount : 0,
                "currency": this.currency,
                "marketing_amount": this.amount,
                "marketing_currency": this.currency,
                "processing_amount": this.amount,
                "processing_currency": this.currency,
                "descriptor": "FAKE_PSP",
                "fraudulent": false,
                "total_fee_amount": 0,
                "fee_currency": "USD"
            }

            if (status === 'fail') {
                this.paymentData.error = {
                    "code": "6.01",
                    "messages": [
                        "Unknown decline code"
                    ],
                    "recommended_message_for_user": "Unknown decline code"
                }
            }

            const requestOptions = {
                method: "PATCH",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify(this.paymentData)
            };
            const response = await fetch(API_URL + "callback", requestOptions);
            const callbackResponse = await response.json();

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
