<template>
    <div>
        <div class="row">
            <div class="col-md-1 text-center" style="padding-left: 1em">
                <dsp-case-badge :data="record"/>
            </div>
            <div class="col-md-11">

                <div class=" charge-container">

                    <case-details v-model="record">

                    </case-details>

                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-md-1">
            </div>
            <div class="col-md-11">
                <charges-show-list
                        :data="this.record.charge"
                        :conviction_id="this.record.id"
                ></charges-show-list>
            </div>
        </div>
    </div>

</template>

<script>
    import CaseDetails from "./CaseDetails";
    import ChargesShowList from "../charges/ChargesShowList";
    import moment from 'moment';

    export default {
        name: "CaseShowContainer",
        components: {
            CaseDetails,
            ChargesShowList
        },
        props: {
            data: {
                type: [Boolean, Object, Array],
                default: false
            },
            case_count: {
                type: [Boolean, Number],
                default: 1
            }
        },
        data() {
            return {
                record: {},
            }
        },
        created() {
            Object.keys(this.data).forEach(i =>
                this.$set(this.record, i, this.data[i])
            );
        }
    }
</script>

