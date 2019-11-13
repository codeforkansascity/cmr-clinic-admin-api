<template>
    <div class=" charge-container">
        <div v-if="view === 'summary'">
            <!--<button class="btn btn-dark" @click="setView('details')">Show Details</button>-->
            <charge-summary v-model="record">
                <chevron-toggle class="float-right"
                                :show="false"
                                @click="setView('details')"/>
            </charge-summary>
        </div>
        <div v-if="view === 'details'">
            <charge-details v-model="record">
                <chevron-toggle class="float-right"
                                :show="true"
                                @click="setView('summary')"/>
                <pencil-control
                        height="25"
                        @click="setView('edit')"/>
            </charge-details>
        </div>
        <div v-if="view === 'edit'">
            <charge-edit v-model="record" @input="update">
                <delete-control class="float-right"
                                height="30"
                                @click="setView('summary')"

                />
            </charge-edit>
        </div>
    </div>
</template>

<script>
    import ChargeDetails from "./ChargeDetails";
    import ChargeSummary from "./ChargeSummary";
    import ChargeEdit from "./ChargeEdit";
    import PencilControl from "../controls/PencilControl";
    import ChevronToggle from "../controls/ChevronToggle";
    import DeleteControl from "../controls/DeleteControl";

    export default {
        name: "ChargeContainer",
        components: {
            DeleteControl,
            ChargeEdit,
            ChargeSummary,
            ChargeDetails,
            PencilControl,
            ChevronToggle
        },
        props: {
            data: {
                type: [Boolean, Object, Array],
                default: false
            },
            case_count: {
                type: [Boolean, Number],
                default: 1
            },

        },
        data() {
            return {
                record: {},
                view: 'summary'
            }
        },
        methods: {
            setView(view) {
                this.view = view
            },
            update(v) {
                this.$emit('updateCharge', this.$vnode.key, v);
            }
        },
        created() {
            Object.keys(this.data).forEach(i =>
                this.$set(this.record, i, this.data[i])
            );
            if (this.record.id == 0) {
                this.view = 'edit'
            }
            this.$bus.$on('minimize-charge', (id) => {
                if (id === this.record.id) this.setView('summary')
            })
        },
    }
</script>

