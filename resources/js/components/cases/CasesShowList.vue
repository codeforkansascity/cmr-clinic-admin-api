<template>
    <div>
        <case-show-container
                v-for="(record, index) in cases"
                :key="index"
                :data="record"
                :case_count="index+1"
        >
        </case-show-container>
    </div>
</template>

<script>
    import CaseShowContainer from "../cases/CaseShowContainer";


    export default {
        name: "CasesShowList",
        components: {

            CaseShowContainer
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
        },
        data() {
            return {
                showCases: false,
                cases: []
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
