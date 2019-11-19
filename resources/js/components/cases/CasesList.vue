<template>
    <div>
        <div>
            <case-container
                    v-for="(record, index) in cases"
                    :key="index"
                    :data="record"
                    @updateCase="updateCase"
                    :case_count="index+1"
            >
            </case-container>

            <div class="col-md-12 pb-5 pt-3 text-center">
                <button class="btn btn-primary btn-sm" @click="addCase">
                    {{cases.length > 0? 'New Case': 'Create Case'}}
                </button>
            </div>

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
            this.sortCases()


            this.$bus.$on('case-deleted', (case_id) => {
                this.removeCase(case_id)
                this.sortCases()
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
                console.log('removeCase=' + id);
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
                console.log('updateCase=' + key);
                console.log(value);
                this.cases[key] = value
                this.sortCases()
            },

            sortCases() {
                let sorted = this.cases.sort((a,b) => {
                    let a_date = this.findFirstValidDate(a)

                    let b_date = this.findFirstValidDate(b)

                    return a_date < b_date? 1 : -1
                })
                this.cases = []
                this.$nextTick(() => {
                    this.cases = sorted
                })
            },

            findFirstValidDate(obj) {

                let fields = ['release_date', 'date_of_disposition', 'date_of_charge', 'arrest_date']
                for(let v of fields.values()) {
                    let d = this.dateParse(obj[v])
                    if(d) {
                        return d
                    }
                }

                return null
            },

            dateParse(date) {
                if(!date) return null

                /// replace all - with /
                date = date.split('-').join( '/')

                if(date.match(/^\d{2}\/\d{2}\/\d{4}$/)) {
                    // mm/dd/yyyy
                    return new Date(date)

                } else if(date.match(/^\d{4}\/\d{2}\/\d{2}$/)) {
                    // yyyy/mm/dd
                    let [y, m, d] = date.split('/')
                    return new Date(y, m -1, d)

                } else if (date.match(/\d{2}\/\d{2}\/\d{2}$/)) {
                    // mm/dd/yy
                    let [m , d, y] = date.split('/');
                    y = y > 20? y+2000 : y+1900
                    return new Date(y, m-1, d)

                } else if(date.match(/^\d{2}\/\d{2,4}$/) && date.length <= 7) {
                    // mm/yy or mm/yyyy
                    let[m, y] = date.split('/')
                    if(y < 1000) {
                        y = y > 20? y+2000 : y+1900
                    }
                    return new Date(y, m-1)

                } else if(date.match(/^\d{4}$/)) {
                    // YYYY year only
                    return new Date(date)

                }

                return null
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
