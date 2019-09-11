<template>
    <div class="row">
        <div class="col-md-2">
            <std-form-group
                label="Citation"
                label-for="citation"
                :errors="errors.citation"
            >
                <autocomplete
                    v-model="citation"
                    :items="statute_numbers"
                ></autocomplete>
            </std-form-group>
        </div>

        <div class="col-md-10">
            <std-form-group
                label="Charge"
                label-for="charge"
                :errors="errors.charge"
            >
                <fld-input name="charge" v-model="charge"/>
            </std-form-group>
        </div>
    </div>
</template>

<script>
    export default {
        name: "statute-selection",
        props: {
            citation: {
                type: String,
                required: false,
                default: () => '',
            },
            charge: {
                type: String,
                required: false,
                default: () => '',
            },
            errors: {
                type: Object|Array,
                default: () => {
                    return {
                        citation: null,
                        charge: null
                    }

                }
            }
        },

        data() {
            return {
                isOpen: false,
                results: [],
                search: '',
                isLoading: false,
                arrowCounter: 0,
                selected: false,
                statutes: [],
                statute_numbers: [],
            };
        },
        mounted() {
          this.getStatutes()
        },
        methods: {
            getStatutes() {
                axios.get('/statutes/all')
                    .then(res => {
                        if(res.data) {
                            this.statutes = res.data
                            this.statute_numbers = this.statutes.map(s => s.number)
                        }
                    })
                    .catch(e => {console.error(e)})
            }
        }
    }
</script>

<style scoped>

</style>
