<template>
    <div class="well well-lg">
        <div class="container">
            <h4>Total Payment: <span>{{ totalPayment | toCurrencyFormat }}</span></h4>
            <h4>Total Cost: <span>{{ totalCost | toCurrencyFormat }}</span></h4>
            <h4>Balance: <span>{{ balance | toCurrencyFormat }}</span></h4>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['payment'],
        computed: {
            totalPayment() {
                return (this.payment.total_payment !== undefined) ?  this.payment.total_payment : 0;
            },
            totalCost() {
                return (this.payment.total_cost !== undefined) ?  this.payment.total_cost : 0;
            },
            balance() {
                 return this.totalCost - this.totalPayment;
            }
        }
    }



</script>