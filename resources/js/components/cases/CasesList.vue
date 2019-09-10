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
            cases: {
                type: [Boolean, Object, Array],
                default: false
            },
            conviction_id: {
                type: Number,
                default: 0
            }
        },
        created() {
            this.$bus.$on('case-deleted', (case_id, conviction_id) => {
                if (conviction_id === this.conviction_id) {
                    this.removeCase(case_id)
                }
            })

        },
        data() {
            return {
                showCases: false
            }
        },
        methods: {
            addCase() {
                let new_case = {
                    id: 0,
                    client_id: 0,
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

                for (let i in this.cases) {
                    if (this.cases[i].id === id) {
                        this.cases.splice(id, 1)
                    }
                }
                // we get a warning if we try to use filter
                // this.cases = this.cases.filter(case => {
                //     return case.id !== id
                // })
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
