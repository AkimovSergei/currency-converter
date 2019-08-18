<template>

    <div class="container">

        <div class="mt-5">
            <h1>Currency converter app</h1>
        </div>


        <div class="row  justify-content-md-center mt-5">

            <div class="col">
                <div class="mb-2">
                    Amount in {{ converter.from.currency }}
                </div>

                <input type="number"
                       class="form-control"
                       v-model="converter.from.amount"
                       @input="setValue($event.target.value)">
            </div>

            <div class="col">
                <div class="mb-2">
                    Capital
                </div>

                <vue-bootstrap-typeahead
                        v-model="city"
                        :data="options"
                        :serializer="item => item.capital + ', ' + item.country"
                        :min-matching-chars="0"
                        @hit="setToCurrency"
                >
                    <template slot="suggestion" slot-scope="{ data, htmlText }">
                        <div class="row align-items-center">
                            <div class="col">
                                {{ data.code }}
                            </div>
                            <div class="col-9">
                                <div>
                                    {{ data.capital }}
                                </div>
                                <div>
                                    <small>
                                        {{ data.country }}
                                    </small>
                                </div>
                            </div>
                        </div>
                    </template>
                </vue-bootstrap-typeahead>
            </div>

            <div class="col" v-show="converter.to.amount">
                <div class="mb-2">
                    Amount in {{ converter.to.currency }}
                </div>
                <div>
                    <h3>
                        {{ converter.to.amount }} {{ converter.to.currency }}
                    </h3>
                </div>
            </div>

        </div>

        <div class="mt-5">
            <convert-history :history="history"></convert-history>
        </div>

    </div>

</template>

<script>
    import ConvertHistory from "./ConvertHistory";

    export default {
        name: 'App',

        components: {
            ConvertHistory
        },

        data() {
            return {
                converter: {
                    from: {
                        currency: 'PLN',
                        amount: 1000,
                    },
                    to: {
                        currency: null,
                        amount: '',
                    }
                },

                search: {
                    delay: 500,
                    timeout: null,
                },

                options: [],

                city: '',
                autocompleteOption: null,

                history: [],

            };
        },

        mounted() {
            this.fetchHistory();
        },

        methods: {

            validate() {
                if (!this.converter.from.currency) {
                    return false;
                }

                if (!this.converter.from.amount) {
                    return false;
                }

                if (!this.converter.to.currency) {
                    return false;
                }

                return true;
            },

            setValue(value) {
                if (this.search.timeout) {
                    clearTimeout(this.search.timeout);
                }

                this.search.timeout = setTimeout(() => {
                    this.convert();
                }, this.search.delay);
            },

            convert() {
                if (!this.validate()) {
                    return;
                }

                let loader = this.$loading.show();
                this.$axios.post('/convert', Object.assign({}, this.converter, this.autocompleteOption))
                    .then(response => {
                        this.converter.to.amount = response.data.amount.toFixed(2);
                    })
                    .then(() => {
                        this.fetchHistory();
                    })
                    .catch(error => {
                        console.log(error)
                    })
                    .finally(() => {
                        loader.hide();
                    });
            },

            /**
             * Search city
             *
             * @param city
             */
            searchCity(city) {
                this.$axios.get('/search-city', {
                    params: {city},
                })
                    .then(response => this.options = response.data.data)
                    .catch(error => {
                        console.log(error)
                    })
                    .finally(() => {
                    });

            },

            setToCurrency(value) {
                this.converter.to.currency = value.code;
                this.city = value.capital + ', ' + value.country;
                this.autocompleteOption = value;
                this.convert();
            },

            fetchHistory() {
                this.$axios.get('/convert-history')
                    .then(response => this.history = response.data.data)
                    .catch(error => {
                        console.log(error)
                    })
                    .finally(() => {
                    });
            },
        },

        watch: {
            city(city) {
                if (this.search.timeout) {
                    clearTimeout(this.search.timeout);
                }

                this.search.timeout = setTimeout(() => {
                    this.searchCity(city);
                }, 500);
            },
        },

    }
</script>
