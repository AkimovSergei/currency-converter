<template>

    <div v-show="history.length > 0">
        <div>
            <h4>History</h4>
            <table class="table">
                <thead>
                    <tr>
                        <th>From</th>
                        <th>To</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item in history">
                        <td class="text-right">
                            {{ item.amountFrom | number }}
                            {{ item.currencyFrom }}
                        </td>
                        <td class="text-right">
                            {{ item.amountTo | number }}
                            {{ item.currencyTo }}
                        </td>
                        <td>
                            {{ item.capital }}<span v-show="item.country">, {{ item.country }}</span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</template>

<script>
    export default {
        name: "ConvertHistory",

        props: {
            history: {
                type: Array,
                default: () => ([]),
            },
        },

        filters: {
            number(value) {
                return Number(value).toFixed(2);
            }
        },

    }
</script>

<style scoped>

</style>
