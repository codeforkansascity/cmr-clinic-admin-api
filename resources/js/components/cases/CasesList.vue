<template>
    <div>
        <div>
            <hr>
            <case-container
                    v-for="(record, index) in cases"
                    :key="index"
                    :data="record"
                    @updateCase="updateCase"
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
            applicant_id: {
                type: Number,
                default: 0
            }
        },
        created() {
            Object.keys(this.data).forEach(i =>
                this.$set(this.cases, i, this.data[i])
            );
            this.$bus.$on('case-deleted', (case_id) => {
                this.removeCase(case_id)
            });
        },
        data() {
            return {
                showCases: false,
                cases: []
            }
        },
        methods: {
            addCase() {
                let new_case = {
                    id: 0,
                    applicant_id: this.applicant_id,
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
                    date_of_charge: "",
                    release_date: null
                };
                this.cases.push(new_case);
                this.showCases = true
            },
            toggleCases() {
                this.showCases = !this.showCases
            },
            removeCase(id) {
                console.log('removeCase='+id);
                let filtered = this.cases.filter(c => {
                    return c.id !== id
                });
                this.cases = []
                this.$nextTick(() => {
                    this.cases = filtered
                })
                console.log('removed');
                // this.$forceUpdate();
                // console.log('$forceUpdate');
            },
            updateCase(key, value) {
                console.log('updateCase='+key);
                console.log(value);
                this.cases[key] = value
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
