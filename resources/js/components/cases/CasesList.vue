<template>
    <div>
        <div>
            <hr>

            <case-container
                    v-for="(record, index) in cases"
                    :key="index"
                    :record="record"
                    :case_count="index+1"
            >
            </case-container>

            <div class="row">
                <div class="col-md-12 pb-5 pt-3">
                    <button class="btn btn-primary btn-sm float-right" @click="addCase">
                        {{cases.length > 0? 'New Case': 'Create Case'}}
                    </button>
                </div>
            </div>
            <hr>
        </div>
    </div>
</template>

<script>
    import CaseContainer from "../cases/CaseContainer";
    import DoubleChevronToggle from "../controls/DoubleChevronToggle";

    export default {
        name: "CaseList",
        components: {
            DoubleChevronToggle,
            CaseContainer
        },
        props: {
            data: {
                type: [Boolean, Object, Array],
                default: false
            },
            client_id: {
                type: Number,
                default: 22
            }
        },
        created() {
            this.$bus.$on('case-deleted', (case_id) => {
                this.removeCase(case_id)
            })
            this.cases = this.data

        },
        data() {
            return {
                showCases: false,
                cases: {}
            }
        },
        methods: {
            addCase() {
                let new_case = {
                    id: 0,
                    client_id: this.client_id,
                    name: "",
                    arrest_date: "",
                    case_number: "",
                    agency: "",
                    court_name: "",
                    court_city_county: "",
                    judge: "",
                    record_name: "",
                    release_status: "",
                    release_date_text: "",
                    notes: "",
                    approximate_date_of_charge: "",
                    release_date: null
                };
                this.cases.push(new_case);
                this.showCases = true
            },
            toggleCases() {
                this.showCases = !this.showCases
            },
            removeCase(id) {
                console.log('remove-case ' + id)

                this.cases = this.cases.filter(c => {
                    return c.id !== id
                })
            }
        },
    }
</script>

<style scoped>
    .pull-right {
        margin: auto;
        float: right;
    }

    .pad-30 {
        padding-bottom: 30px;
    }
</style>
